<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        
        $totalAntrian = $db->table('transaksi')->where('status !=', 'Diambil')->countAllResults();
        $dalamProses = $db->table('transaksi')->whereIn('status', ['Cuci', 'Dalam Proses'])->countAllResults();
        
        $omsetHariIni = $db->table('keuangan')
                           ->where('tanggal', date('Y-m-d'))
                           ->where('tipe', 'masuk')
                           ->selectSum('jumlah')
                           ->get()->getRow()->jumlah ?? 0;

        $totalMember = $db->table('members')->countAllResults();

        
        $antrianList = $db->table('transaksi')
                          ->select('transaksi.*, members.nama as member_nama')
                          ->join('members', 'members.id = transaksi.member_id')
                          ->where('transaksi.status !=', 'Diambil')
                          ->orderBy('transaksi.created_at', 'DESC')
                          ->limit(5)
                          ->get()->getResultArray();

        foreach ($antrianList as &$antrian) {
            $details = $db->table('transaksi_detail')
                         ->select('transaksi_detail.jumlah, layanan_laundry.nama_layanan, layanan_laundry.tipe_satuan')
                         ->join('layanan_laundry', 'layanan_laundry.id = transaksi_detail.layanan_id')
                         ->where('transaksi_detail.transaksi_id', $antrian['id'])
                         ->get()->getResultArray();

            $itemParts = [];
            foreach ($details as $det) {
                
                $qty = number_format($det['jumlah'], 2, '.', ',');
                $itemParts[] = "{$det['nama_layanan']} ({$qty} {$det['tipe_satuan']})";
            }
            $antrian['detail_text'] = implode(', ', $itemParts);
        }

        $data = [
            'title'        => 'Dashboard - Clean • Fresh • Shine',
            'totalAntrian' => $totalAntrian,
            'dalamProses'  => $dalamProses,
            'omsetHariIni' => $omsetHariIni,
            'totalMember'  => $totalMember,
            'antrian'      => $antrianList
        ];

        return view('dashboard/index', $data);
    }
}
