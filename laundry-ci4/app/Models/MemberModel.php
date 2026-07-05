<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'telepon',
        'alamat',
        'poin'
    ];

    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    
    protected $validationRules      = [
        'nama'    => 'required|min_length[3]|max_length[100]',
        'telepon' => 'required|min_length[5]|max_length[20]',
        'alamat'  => 'required|string',
        'poin'    => 'permit_empty|integer',
    ];

    protected $validationMessages   = [
        'nama' => [
            'required'   => 'Nama member wajib diisi.',
            'min_length' => 'Nama member minimal 3 karakter.',
            'max_length' => 'Nama member maksimal 100 karakter.',
        ],
        'telepon' => [
            'required'   => 'Nomor telepon wajib diisi.',
            'min_length' => 'Nomor telepon minimal 5 karakter.',
            'max_length' => 'Nomor telepon maksimal 20 karakter.',
        ],
        'alamat' => [
            'required' => 'Alamat tinggal wajib diisi.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
