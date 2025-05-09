<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelWarna;

class Warna extends BaseController
{
    public function __construct()
    {
        $this->ModelWarna = new ModelWarna();
    }

    public function index()
    {
        $data = [
            'judul' => 'Master Data',
            'subjudul' => 'Warna',
            'menu' => 'masterdata',
            'submenu' => 'warna',
            'page' => 'v_warna',
            'warna' => $this->ModelWarna->AllData(),
        ];
        return view('v_template', $data);
    }

    public function InsertData()
    {
        $data = ['nama_warna' => $this->request->getPost('nama_warna')];
        $this->ModelWarna->InsertData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        return redirect()->to('Warna');
    }

    public function UpdateData($id_warna)
    {
        $data = [
            'id_warna' => $id_warna,
            'nama_warna' => $this->request->getPost('nama_warna')
        ];
        $this->ModelWarna->UpdateData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
        return redirect()->to('Warna');
    }

    public function DeleteData($id_warna)
    {
        $data = [
            'id_warna' => $id_warna
        ];
        $this->ModelWarna->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to('Warna');
    }
}
