<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class UserManagement extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        
        // Blokir Kasir dari User Management
        if (session()->get('role') !== 'admin') {
            header('Location: ' . base_url('/'));
            exit;
        }
    }

    public function index()
    {
        $users = $this->userModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'User Management - Clean • Fresh • Shine',
            'users' => $users
        ];

        return view('user_management/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'      => 'Tambah User Baru - Clean • Fresh • Shine',
            'validation' => session()->getFlashdata('validation') ?? []
        ];

        return view('user_management/tambah', $data);
    }

    public function simpan()
    {
        $password = $this->request->getPost('password');
        
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $password,
            'role'     => $this->request->getPost('role'),
        ];

        
        if (!$this->userModel->validate($data)) {
            return redirect()->back()->withInput()->with('validation', $this->userModel->errors())->with('modal_open', 'tambah_user');
        }

        
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        
        $this->userModel->skipValidation(true)->insert($data);

        return redirect()->to('user-management')->with('success', 'User baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound("User dengan ID {$id} tidak ditemukan.");
        }

        $data = [
            'title'      => 'Edit User - Clean • Fresh • Shine',
            'user'       => $user,
            'validation' => session()->getFlashdata('validation') ?? []
        ];

        return view('user_management/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound("User dengan ID {$id} tidak ditemukan.");
        }

        $password = $this->request->getPost('password');
        
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]',
            'email'    => "required|valid_email|max_length[100]",
            'role'     => 'required|in_list[admin,kasir]'
        ];

        if (!empty($password)) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('validation', $this->validator->getErrors())
                             ->with('modal_open', 'edit_user')
                             ->with('edit_id', $id);
        }

        $updateData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role'),
        ];

        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->skipValidation(true)->update($id, $updateData);

        return redirect()->to('user-management')->with('success', 'Data user berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound("User dengan ID {$id} tidak ditemukan.");
        }

        
        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to('user-management')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        $this->userModel->delete($id);

        return redirect()->to('user-management')->with('success', 'User berhasil dihapus!');
    }
}
