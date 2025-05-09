<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSetting;

class Setting extends BaseController
{
    public function __construct()
    {
        $this->ModelSetting = new ModelSetting();
    }

    public function index()
    {
        $data = [
            'judul' => 'Setting',
            'subjudul' => 'Setting',
            'menu' => 'setting',
            'submenu' => '',
            'page' => 'v_setting',
            'setting' => $this->ModelSetting->DetailData(),
        ];
        return view('v_template', $data);
    }

    public function UpdateSetting()
    {
        $data = [
            'id' => '1',
            'nama_toko' => $this->request->getPost('nama_toko'),
            'slogan' => $this->request->getPost('slogan'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telpon' => $this->request->getPost('no_telpon'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];
        $this->ModelSetting->UpdateData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
        return redirect()->to('Setting');
    }
}
