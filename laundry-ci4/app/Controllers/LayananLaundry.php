<?php

namespace App\Controllers;

use App\Models\LayananLaundryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class LayananLaundry extends BaseController
{
    protected $layananModel;

    public function __construct()
    {
        $this->layananModel = new LayananLaundryModel();
    }

    
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        
        if (!empty($keyword)) {
            $layananList = $this->layananModel->like('nama_layanan', $keyword)
                                              ->orLike('tipe_satuan', $keyword)
                                              ->orLike('harga', $keyword)
                                              ->orLike('estimasi_waktu', $keyword)
                                              ->findAll();
        } else {
            $layananList = $this->layananModel->orderBy('created_at', 'DESC')->findAll();
        }

        
        $totalLayanan = count($layananList);
        
        $hargaArray = array_column($layananList, 'harga');
        $averageHarga = 0;
        $maxLayanan = null;
        $minLayanan = null;

        if ($totalLayanan > 0) {
            $averageHarga = array_sum($hargaArray) / $totalLayanan;
            
            
            usort($layananList, function($a, $b) {
                return $b['harga'] <=> $a['harga'];
            });
            $maxLayanan = $layananList[0];

            
            usort($layananList, function($a, $b) {
                return $a['harga'] <=> $b['harga'];
            });
            $minLayanan = $layananList[0];
            
            
            if (empty($keyword)) {
                usort($layananList, function($a, $b) {
                    return strtotime($b['created_at']) <=> strtotime($a['created_at']);
                });
            } else {
                
                
                $layananList = $this->layananModel->like('nama_layanan', $keyword)
                                                  ->orLike('tipe_satuan', $keyword)
                                                  ->orLike('harga', $keyword)
                                                  ->orLike('estimasi_waktu', $keyword)
                                                  ->orderBy('created_at', 'DESC')
                                                  ->findAll();
            }
        }

        $data = [
            'title'         => 'Dashboard & Layanan Laundry - Clean • Fresh • Shine',
            'layanan'       => $layananList,
            'totalLayanan'  => $totalLayanan,
            'averageHarga'  => $averageHarga,
            'maxLayanan'    => $maxLayanan,
            'minLayanan'    => $minLayanan,
            'keyword'       => $keyword
        ];

        return view('layanan/index', $data);
    }

    
    public function tambah()
    {
        $data = [
            'title'      => 'Tambah Layanan Laundry - Clean • Fresh • Shine',
            'validation' => session()->getFlashdata('validation') ?? []
        ];

        return view('layanan/tambah', $data);
    }

    
    public function simpan()
    {
        $data = [
            'nama_layanan'   => $this->request->getPost('nama_layanan'),
            'tipe_satuan'    => $this->request->getPost('tipe_satuan'),
            'harga'          => $this->request->getPost('harga'),
            'estimasi_waktu' => $this->request->getPost('estimasi_waktu'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
        ];

        if (!$this->layananModel->insert($data)) {
            return redirect()->back()->withInput()->with('validation', $this->layananModel->errors())->with('modal_open', 'tambah_layanan');
        }

        return redirect()->to('layanan')->with('success', 'Layanan laundry baru berhasil ditambahkan!');
    }

    
    public function edit($id)
    {
        $layanan = $this->layananModel->find($id);

        if (!$layanan) {
            throw PageNotFoundException::forPageNotFound("Layanan laundry dengan ID {$id} tidak ditemukan.");
        }

        $data = [
            'title'      => 'Edit Layanan Laundry - Clean • Fresh • Shine',
            'layanan'    => $layanan,
            'validation' => session()->getFlashdata('validation') ?? []
        ];

        return view('layanan/edit', $data);
    }

    
    public function update($id)
    {
        $layanan = $this->layananModel->find($id);

        if (!$layanan) {
            throw PageNotFoundException::forPageNotFound("Layanan laundry dengan ID {$id} tidak ditemukan.");
        }

        $data = [
            'nama_layanan'   => $this->request->getPost('nama_layanan'),
            'tipe_satuan'    => $this->request->getPost('tipe_satuan'),
            'harga'          => $this->request->getPost('harga'),
            'estimasi_waktu' => $this->request->getPost('estimasi_waktu'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
        ];

        if (!$this->layananModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('validation', $this->layananModel->errors());
        }

        return redirect()->to('layanan')->with('success', 'Detail layanan laundry berhasil diperbarui!');
    }

    
    public function hapus($id)
    {
        $layanan = $this->layananModel->find($id);

        if (!$layanan) {
            throw PageNotFoundException::forPageNotFound("Layanan laundry dengan ID {$id} tidak ditemukan.");
        }

        $this->layananModel->delete($id);

        return redirect()->to('layanan')->with('success', 'Layanan laundry berhasil dihapus!');
    }
}
