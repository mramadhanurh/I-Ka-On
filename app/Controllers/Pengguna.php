<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelTransaksi;

class Pengguna extends BaseController
{
    public function __construct()
    {
        $this->ModelTransaksi = new ModelTransaksi();
    }

    public function index()
    {
        $id_user = session('id_user'); // Ambil ID user dari session

        $data = [
            'judul' => 'User',
            'subjudul' => 'User',
            'menu' => 'user',
            'submenu' => '',
            'page' => 'v_pengguna',
            'transaksi_hari_ini' => $this->ModelTransaksi->getTransaksiHariIni($id_user),
            'transaksi_bulan_ini' => $this->ModelTransaksi->getTransaksiBulanIni($id_user),
            'transaksi_tahun_ini' => $this->ModelTransaksi->getTransaksiTahunIni($id_user),
        ];
        return view('v_template', $data);
    }
}
