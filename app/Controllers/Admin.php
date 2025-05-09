<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAdmin;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->ModelAdmin = new ModelAdmin();
    }

    public function index()
    {
        $data = [
            'judul' => 'Dashboard',
            'subjudul' => '',
            'menu' => 'dashboard',
            'submenu' => '',
            'page' => 'v_admin',
            'jml_produk' => $this->ModelAdmin->JumlahProduk(),
            'jml_kategori' => $this->ModelAdmin->JumlahKategori(),
            'jml_satuan' => $this->ModelAdmin->JumlahSatuan(),
            'jml_user' => $this->ModelAdmin->JumlahUser(),
        ];
        return view('v_template', $data);
    }
}
