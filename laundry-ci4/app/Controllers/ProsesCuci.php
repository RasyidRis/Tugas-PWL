<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProsesCuci extends BaseController
{
    protected $transaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        $activeWashing = $db->table('transaksi')
                            ->select('transaksi.*, members.nama as member_nama, members.telepon as member_telepon')
                            ->join('members', 'members.id = transaksi.member_id')
                            ->whereIn('transaksi.status', ['Cuci', 'Dalam Proses'])
                            ->orderBy('transaksi.no_antrian', 'ASC')
                            ->get()->getResultArray();

        foreach ($activeWashing as &$tx) {
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

        $data = [
            'title'   => 'Proses Cuci Aktif - Clean • Fresh • Shine',
            'antrian' => $activeWashing
        ];

        return view('proses_cuci/index', $data);
    }

    public function selesaikan($id)
    {
        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            throw PageNotFoundException::forPageNotFound("Antrian dengan ID {$id} tidak ditemukan.");
        }

        $this->transaksiModel->update($id, [
            'status'       => 'Selesai',
            'completed_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('proses-cuci')->with('success', "Antrian cuci {$transaksi['no_antrian']} telah selesai diproses!");
    }
}
