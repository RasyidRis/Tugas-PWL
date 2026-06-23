<?php

namespace App\Controllers;

use App\Models\KeuanganModel;

class Keuangan extends BaseController
{
    protected $keuanganModel;

    public function __construct()
    {
        $this->keuanganModel = new KeuanganModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        
        $logs = $this->keuanganModel->orderBy('created_at', 'DESC')->findAll();

        
        $totalMasuk = $db->table('keuangan')
                         ->where('tipe', 'masuk')
                         ->selectSum('jumlah')
                         ->get()->getRow()->jumlah ?? 0;

        $totalKeluar = $db->table('keuangan')
                          ->where('tipe', 'keluar')
                          ->selectSum('jumlah')
                          ->get()->getRow()->jumlah ?? 0;

        $saldo = $totalMasuk - $totalKeluar;

        $data = [
            'title'       => 'Laporan Keuangan - Clean • Fresh • Shine',
            'logs'        => $logs,
            'totalMasuk'  => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'saldo'       => $saldo,
            'validation'  => session()->getFlashdata('validation') ?? []
        ];

        return view('keuangan/index', $data);
    }

    public function simpan()
    {
        $data = [
            'tipe'       => $this->request->getPost('tipe'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal'    => $this->request->getPost('tanggal') ?? date('Y-m-d'),
        ];

        if (!$this->keuanganModel->insert($data)) {
            return redirect()->back()->withInput()->with('validation', $this->keuanganModel->errors());
        }

        return redirect()->to('keuangan')->with('success', 'Transaksi keuangan baru berhasil dicatat!');
    }
}
