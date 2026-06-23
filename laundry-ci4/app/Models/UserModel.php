<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'email',
        'password',
        'role'
    ];

    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    
    protected $validationRules      = [
        'username' => 'required|min_length[3]|max_length[100]',
        'email'    => 'required|valid_email|max_length[100]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[admin,kasir]',
    ];

    protected $validationMessages   = [
        'username' => [
            'required'   => 'Username wajib diisi.',
            'min_length' => 'Username minimal 3 karakter.',
            'max_length' => 'Username maksimal 100 karakter.',
        ],
        'email' => [
            'required'    => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
        ],
        'password' => [
            'required'   => 'Password wajib diisi.',
            'min_length' => 'Password minimal 6 karakter.',
        ],
        'role' => [
            'required' => 'Role wajib dipilih.',
            'in_list'  => 'Role harus salah satu dari: admin, kasir.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
