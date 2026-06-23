<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananLaundryModel extends Model
{
    protected $table            = 'layanan_laundry';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_layanan',
        'tipe_satuan',
        'harga',
        'estimasi_waktu',
        'deskripsi'
    ];

    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    
    protected $validationRules      = [
        'nama_layanan'   => 'required|min_length[3]|max_length[100]',
        'tipe_satuan'    => 'required|in_list[Kg,Pcs,Meter]',
        'harga'          => 'required|integer|greater_than_equal_to[0]',
        'estimasi_waktu' => 'required|min_length[2]|max_length[50]',
        'deskripsi'      => 'permit_empty|string',
    ];
    
    protected $validationMessages   = [
        'nama_layanan' => [
            'required'   => 'Nama layanan wajib diisi.',
            'min_length' => 'Nama layanan minimal 3 karakter.',
            'max_length' => 'Nama layanan maksimal 100 karakter.',
        ],
        'tipe_satuan' => [
            'required'   => 'Tipe satuan wajib dipilih.',
            'in_list'    => 'Tipe satuan harus salah satu dari: Kg, Pcs, Meter.',
        ],
        'harga' => [
            'required'               => 'Harga wajib diisi.',
            'integer'                => 'Harga harus berupa angka bulat.',
            'greater_than_equal_to'  => 'Harga tidak boleh negatif.',
        ],
        'estimasi_waktu' => [
            'required'   => 'Estimasi waktu pengerjaan wajib diisi.',
            'min_length' => 'Estimasi waktu minimal 2 karakter.',
            'max_length' => 'Estimasi waktu maksimal 50 karakter.',
        ],
    ];
    
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
