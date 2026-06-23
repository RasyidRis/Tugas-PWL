<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_antrian',
        'member_id',
        'status',
        'total_harga',
        'bayar',
        'status_bayar',
        'completed_at'
    ];

    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    
    protected $validationRules      = [
        'no_antrian'   => 'required|max_length[50]',
        'member_id'    => 'required|integer',
        'status'       => 'required|in_list[Hold,Cuci,Dalam Proses,Selesai,Diambil]',
        'total_harga'  => 'required|integer',
        'bayar'        => 'permit_empty|integer',
        'status_bayar' => 'required|in_list[Lunas,Belum Lunas]',
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
