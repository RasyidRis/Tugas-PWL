<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/login', [
            'title' => 'Login - Clean • Fresh • Shine'
        ]);
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        
        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan password wajib diisi.');
        }

        
        $user = $this->userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        
        session()->set([
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true,
        ]);

        return redirect()->to('/')->with('success', "Selamat datang kembali, {$user['username']}!");
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
