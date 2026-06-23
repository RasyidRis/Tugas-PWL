<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{
    protected $table            = 'transaksi_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'transaksi_id',
        'layanan_id',
        'jumlah',
        'subtotal'
    ];

    
    protected $useTimestamps = false;
    protected $validationRules = [
        'transaksi_id' => 'required|integer',
        'layanan_id'   => 'required|integer',
        'jumlah'       => 'required|decimal',
        'subtotal'     => 'required|integer',
    ];
}
