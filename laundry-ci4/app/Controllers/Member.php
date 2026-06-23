<?php

namespace App\Controllers;

use App\Models\MemberModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Member extends BaseController
{
    protected $memberModel;

    public function __construct()
    {
        $this->memberModel = new MemberModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if (!empty($keyword)) {
            $members = $this->memberModel->like('nama', $keyword)
                                         ->orLike('telepon', $keyword)
                                         ->orLike('alamat', $keyword)
                                         ->orderBy('created_at', 'DESC')
                                         ->findAll();
        } else {
            $members = $this->memberModel->orderBy('created_at', 'DESC')->findAll();
        }

        $data = [
            'title'   => 'Kelola Member - Clean • Fresh • Shine',
            'members' => $members,
            'keyword' => $keyword
        ];

        return view('member/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'      => 'Tambah Member - Clean • Fresh • Shine',
            'validation' => session()->getFlashdata('validation') ?? []
        ];

        return view('member/tambah', $data);
    }

    public function simpan()
    {
        $data = [
            'nama'    => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat'  => $this->request->getPost('alamat'),
            'poin'    => $this->request->getPost('poin') ?? 0,
        ];

        if (!$this->memberModel->insert($data)) {
            return redirect()->back()->withInput()->with('validation', $this->memberModel->errors())->with('modal_open', 'tambah_member');
        }

        return redirect()->to('member')->with('success', 'Member baru berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $member = $this->memberModel->find($id);

        if (!$member) {
            throw PageNotFoundException::forPageNotFound("Member dengan ID {$id} tidak ditemukan.");
        }

        $data = [
            'title'      => 'Edit Member - Clean • Fresh • Shine',
            'member'     => $member,
            'validation' => session()->getFlashdata('validation') ?? []
        ];

        return view('member/edit', $data);
    }

    public function update($id)
    {
        $member = $this->memberModel->find($id);

        if (!$member) {
            throw PageNotFoundException::forPageNotFound("Member dengan ID {$id} tidak ditemukan.");
        }

        $data = [
            'nama'    => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat'  => $this->request->getPost('alamat'),
            'poin'    => $this->request->getPost('poin') ?? 0,
        ];

        if (!$this->memberModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('validation', $this->memberModel->errors());
        }

        return redirect()->to('member')->with('success', 'Data member berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $member = $this->memberModel->find($id);

        if (!$member) {
            throw PageNotFoundException::forPageNotFound("Member dengan ID {$id} tidak ditemukan.");
        }

        $this->memberModel->delete($id);

        return redirect()->to('member')->with('success', 'Data member berhasil dihapus!');
    }
}
