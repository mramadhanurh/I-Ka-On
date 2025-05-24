<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelRekening;

class Rekening extends BaseController
{
    public function __construct()
    {
        $this->ModelRekening = new ModelRekening();
    }

    public function index()
    {
        $data = [
            'judul' => 'Master Data',
            'subjudul' => 'Rekening',
            'menu' => 'masterdata',
            'submenu' => 'rekening',
            'page' => 'v_rekening',
            'rekening' => $this->ModelRekening->AllData(),
        ];
        return view('v_template', $data);
    }

    public function InsertData()
    {
        $data = [
            'nama_rekening' => $this->request->getPost('nama_rekening'),
            'atas_nama' => $this->request->getPost('atas_nama'),
            'no_rekening' => $this->request->getPost('no_rekening'),
        ];
        $this->ModelRekening->InsertData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        return redirect()->to('Rekening');
    }

    public function UpdateData($id_rekening)
    {
        $data = [
            'id_rekening' => $id_rekening,
            'nama_rekening' => $this->request->getPost('nama_rekening'),
            'atas_nama' => $this->request->getPost('atas_nama'),
            'no_rekening' => $this->request->getPost('no_rekening'),
        ];
        $this->ModelRekening->UpdateData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
        return redirect()->to('Rekening');
    }

    public function DeleteData($id_rekening)
    {
        $data = [
            'id_rekening' => $id_rekening,
        ];
        $this->ModelRekening->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to('Rekening');
    }
}
