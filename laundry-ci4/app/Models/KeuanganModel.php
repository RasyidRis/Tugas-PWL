<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganModel extends Model
{
    protected $table            = 'keuangan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'transaksi_id',
        'tipe',
        'jumlah',
        'keterangan',
        'tanggal'
    ];

    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    
    protected $validationRules = [
        'tipe'       => 'required|in_list[masuk,keluar]',
        'jumlah'     => 'required|integer|greater_than[0]',
        'keterangan' => 'required|string',
        'tanggal'    => 'required|valid_date[Y-m-d]',
    ];

    protected $validationMessages = [
        'tipe' => [
            'required' => 'Tipe transaksi wajib dipilih.',
            'in_list'  => 'Tipe transaksi harus masuk atau keluar.',
        ],
        'jumlah' => [
            'required'     => 'Jumlah uang wajib diisi.',
            'integer'      => 'Jumlah uang harus berupa angka.',
            'greater_than' => 'Jumlah uang harus lebih besar dari 0.',
        ],
        'keterangan' => [
            'required' => 'Keterangan wajib diisi.',
        ],
        'tanggal' => [
            'required'   => 'Tanggal wajib diisi.',
            'valid_date' => 'Format tanggal tidak valid.',
        ],
    ];
}
