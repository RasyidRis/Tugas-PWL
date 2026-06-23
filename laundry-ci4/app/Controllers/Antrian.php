<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use App\Models\MemberModel;
use App\Models\LayananLaundryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Antrian extends BaseController
{
    protected $transaksiModel;
    protected $transaksiDetailModel;
    protected $memberModel;
    protected $layananModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->transaksiDetailModel = new TransaksiDetailModel();
        $this->memberModel = new MemberModel();
        $this->layananModel = new LayananLaundryModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $db = \Config\Database::connect();

        $builder = $db->table('transaksi')
                      ->select('transaksi.*, members.nama as member_nama, members.telepon as member_telepon')
                      ->join('members', 'members.id = transaksi.member_id');

        if (!empty($keyword)) {
            $builder->like('transaksi.no_antrian', $keyword)
                    ->orLike('members.nama', $keyword)
                    ->orLike('transaksi.status', $keyword);
        }

        $transaksiList = $builder->orderBy('transaksi.created_at', 'DESC')->get()->getResultArray();

        foreach ($transaksiList as &$tx) {
            $details = $db->table('transaksi_detail')
                         ->select('transaksi_detail.jumlah, layanan_laundry.nama_layanan, layanan_laundry.tipe_satuan')
                         ->join('layanan_laundry', 'layanan_laundry.id = transaksi_detail.layanan_id')
                         ->where('transaksi_detail.transaksi_id', $tx['id'])
                         ->get()->getResultArray();

            $itemParts = [];
            foreach ($details as $det) {
                $qty = number_format($det['jumlah'], 2, '.', ',');
                $itemParts[] = "{$det['nama_layanan']} ({$qty} {$det['tipe_satuan']})";
            }
            $tx['detail_text'] = implode(', ', $itemParts);
        }

        $members = $this->memberModel->orderBy('nama', 'ASC')->findAll();
        $services = $this->layananModel->orderBy('nama_layanan', 'ASC')->findAll();

        $data = [
            'title'     => 'Kelola Antrian - Clean • Fresh • Shine',
            'transaksi' => $transaksiList,
            'keyword'   => $keyword,
            'members'   => $members,
            'services'  => $services
        ];

        return view('antrian/index', $data);
    }

    public function tambah()
    {
        $members = $this->memberModel->orderBy('nama', 'ASC')->findAll();
        $services = $this->layananModel->orderBy('nama_layanan', 'ASC')->findAll();

        $data = [
            'title'    => 'Buat Antrian Baru - Clean • Fresh • Shine',
            'members'  => $members,
            'services' => $services
        ];

        return view('antrian/tambah', $data);
    }

    public function simpan()
    {
        $memberId = $this->request->getPost('member_id');
        $layananIds = $this->request->getPost('layanan_id');
        $jumlahs = $this->request->getPost('jumlah');
        $bayar = intval($this->request->getPost('bayar') ?? 0);

        if (empty($memberId) || empty($layananIds)) {
            return redirect()->back()->withInput()->with('error', 'Silakan pilih pelanggan dan minimal satu jenis layanan laundry.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        
        if ($memberId === 'new_customer') {
            $customerName = trim($this->request->getPost('customer_name') ?? '');
            $customerPhone = trim($this->request->getPost('customer_phone') ?? '');

            if (empty($customerName)) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', 'Nama pelanggan baru wajib diisi.');
            }

            $db->table('members')->insert([
                'nama'       => $customerName,
                'telepon'    => $customerPhone,
                'alamat'     => '-',
                'poin'       => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $memberId = $db->insertID();
        }

        
        $lastTx = $db->table('transaksi')
                     ->orderBy('id', 'DESC')
                     ->limit(1)
                     ->get()->getRowArray();
        
        if ($lastTx) {
            $parts = explode('-', $lastTx['no_antrian']);
            $lastNum = intval(end($parts));
            $nextNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNum = '001';
        }
        $noAntrian = "Q-{$nextNum}";

        
        $totalHarga = 0;
        $detailItems = [];

        foreach ($layananIds as $index => $layananId) {
            $layanan = $this->layananModel->find($layananId);
            if (!$layanan) continue;

            $qty = floatval($jumlahs[$index]);
            $subtotal = intval($layanan['harga'] * $qty);
            $totalHarga += $subtotal;

            $detailItems[] = [
                'layanan_id' => $layananId,
                'jumlah'     => $qty,
                'subtotal'   => $subtotal
            ];
        }

        
        $statusBayar = 'Belum Lunas';
        if ($bayar >= $totalHarga) {
            $statusBayar = 'Lunas';
        }

        
        $transData = [
            'no_antrian'   => $noAntrian,
            'member_id'    => $memberId,
            'status'       => 'Cuci', 
            'total_harga'  => $totalHarga,
            'bayar'        => $bayar,
            'status_bayar' => $statusBayar,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        $db->table('transaksi')->insert($transData);
        $transaksiId = $db->insertID();

        
        foreach ($detailItems as &$item) {
            $item['transaksi_id'] = $transaksiId;
            $db->table('transaksi_detail')->insert($item);
        }

        
        $addedPoints = floor($totalHarga / 10000);
        if ($addedPoints > 0) {
            $db->table('members')->where('id', $memberId)->increment('poin', $addedPoints);
        }

        
        if ($bayar > 0) {
            $amountReceived = ($bayar >= $totalHarga) ? $totalHarga : $bayar;
            $db->table('keuangan')->insert([
                'transaksi_id' => $transaksiId,
                'tipe'         => 'masuk',
                'jumlah'       => $amountReceived,
                'keterangan'   => "Pembayaran Awal Antrian {$noAntrian}",
                'tanggal'      => date('Y-m-d'),
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]);
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat membuat transaksi antrian.');
        }

        $db->transCommit();
        return redirect()->to('antrian/detail/' . $transaksiId)->with('success', 'Antrian baru berhasil dibuat!');
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();
        
        $transaksi = $db->table('transaksi')
                        ->select('transaksi.*, members.nama as member_nama, members.telepon as member_telepon, members.alamat as member_alamat')
                        ->join('members', 'members.id = transaksi.member_id')
                        ->where('transaksi.id', $id)
                        ->get()->getRowArray();

        if (!$transaksi) {
            throw PageNotFoundException::forPageNotFound("Antrian dengan ID {$id} tidak ditemukan.");
        }

        $details = $db->table('transaksi_detail')
                     ->select('transaksi_detail.*, layanan_laundry.nama_layanan, layanan_laundry.harga as harga_satuan, layanan_laundry.tipe_satuan, layanan_laundry.estimasi_waktu')
                     ->join('layanan_laundry', 'layanan_laundry.id = transaksi_detail.layanan_id')
                     ->where('transaksi_detail.transaksi_id', $id)
                     ->get()->getResultArray();

        $data = [
            'title'     => "Detail Antrian {$transaksi['no_antrian']} - Clean • Fresh • Shine",
            'transaksi' => $transaksi,
            'details'   => $details
        ];

        return view('antrian/detail', $data);
    }

    public function updateStatus($id)
    {
        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            throw PageNotFoundException::forPageNotFound("Antrian dengan ID {$id} tidak ditemukan.");
        }

        $status = $this->request->getPost('status');
        if (!in_array($status, ['Hold', 'Cuci', 'Dalam Proses', 'Selesai', 'Diambil'])) {
            return redirect()->back()->with('error', 'Status cuci tidak valid.');
        }

        
        if ($status === 'Diambil' && $transaksi['status_bayar'] !== 'Lunas') {
            return redirect()->back()->with('error', 'Antrian harus dilunasi terlebih dahulu sebelum status diubah menjadi Diambil.');
        }

        $updateData = ['status' => $status];
        if (in_array($status, ['Selesai', 'Diambil'])) {
            if (empty($transaksi['completed_at'])) {
                $updateData['completed_at'] = date('Y-m-d H:i:s');
            }
        } else {
            $updateData['completed_at'] = null;
        }

        $this->transaksiModel->update($id, $updateData);

        return redirect()->back()->with('success', "Status antrian {$transaksi['no_antrian']} berhasil diperbarui menjadi {$status}!");
    }

    public function bayar($id)
    {
        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            throw PageNotFoundException::forPageNotFound("Antrian dengan ID {$id} tidak ditemukan.");
        }

        if ($transaksi['status_bayar'] === 'Lunas') {
            return redirect()->back()->with('error', 'Antrian ini sudah lunas.');
        }

        $bayar = intval($this->request->getPost('bayar') ?? 0);
        $kekurangan = $transaksi['total_harga'] - $transaksi['bayar'];

        if ($bayar < $kekurangan) {
            
            $newBayar = $transaksi['bayar'] + $bayar;
            $this->transaksiModel->update($id, [
                'bayar' => $newBayar
            ]);
            
            
            $db = \Config\Database::connect();
            $db->table('keuangan')->insert([
                'transaksi_id' => $id,
                'tipe'         => 'masuk',
                'jumlah'       => $bayar,
                'keterangan'   => "Cicilan Pembayaran Antrian {$transaksi['no_antrian']}",
                'tanggal'      => date('Y-m-d'),
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]);

            return redirect()->back()->with('success', 'Pembayaran cicilan berhasil dicatat!');
        } else {
            
            $this->transaksiModel->update($id, [
                'bayar'        => $transaksi['total_harga'],
                'status_bayar' => 'Lunas'
            ]);

            
            $db = \Config\Database::connect();
            $db->table('keuangan')->insert([
                'transaksi_id' => $id,
                'tipe'         => 'masuk',
                'jumlah'       => $kekurangan,
                'keterangan'   => "Pelunasan Pembayaran Antrian {$transaksi['no_antrian']}",
                'tanggal'      => date('Y-m-d'),
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]);

            return redirect()->back()->with('success', 'Pembayaran antrian berhasil dilunasi!');
        }
    }
}
