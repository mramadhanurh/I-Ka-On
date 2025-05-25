<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelTransaksiPesanan;
use App\Models\ModelRinciTransaksi;
use App\Models\ModelProduk;
use App\Models\ModelRekening;

class Pesananuser extends BaseController
{
    public function __construct()
    {
        $this->ModelTransaksiPesanan = new ModelTransaksiPesanan();
        $this->ModelRinciTransaksi = new ModelRinciTransaksi();
        $this->ModelProduk = new ModelProduk();
        $this->ModelRekening = new ModelRekening();
    }

    public function index()
    {
        $id_user = session()->get('id_user');

        $data = [
            'judul' => 'Transaksi Pesanan',
            'subjudul' => 'Transaksi Pesanan',
            'menu' => 'transaksipesanan',
            'submenu' => '',
            'page' => 'v_pesanan_user',
            'pesanan' => $this->ModelTransaksiPesanan->AllDataTransaksi($id_user),
        ];
        return view('v_template', $data);
    }

    public function DetailData($id_transaksi)
    {
        $transaksi = $this->ModelTransaksiPesanan->getDetail($id_transaksi); // Ambil data transaksi
        $rinciTransaksi = $this->ModelRinciTransaksi->getRinciByOrder($transaksi['no_order']); // Ambil rincian dari no_order

        $data = [
            'judul' => 'Detail Transaksi Pesanan',
            'subjudul' => 'Detail Transaksi Pesanan',
            'menu' => 'transaksipesanan',
            'submenu' => '',
            'page' => 'v_detail_rinci_transaksi_pesanan_user',
            'transaksi' => $transaksi,
            'rinciTransaksi' => $rinciTransaksi,
        ];

        return view('v_template', $data);
    }

    // Method untuk menampilkan form bukti bayar
    public function updateData($id_transaksi)
    {
        $transaksi = $this->ModelTransaksiPesanan->getDetail($id_transaksi);
        $rinciTransaksi = $this->ModelRinciTransaksi->getRinciByOrder($transaksi['no_order']);
        $rekening = $this->ModelRekening->AllData();

        $data = [
            'judul' => 'Update Bukti Transaksi',
            'subjudul' => 'Update Bukti Transaksi',
            'menu' => 'transaksipesanan',
            'submenu' => '',
            'page' => 'v_update_rinci_bukti_transaksi',
            'transaksi' => $transaksi,
            'rinciTransaksi' => $rinciTransaksi,
            'bankrekening' => $rekening,
        ];

        return view('v_template', $data);
    }

    public function saveUpdateData($id_transaksi)
    {
        $bukti = $this->request->getFile('bukti_transaksi');

        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {
            // Rename nama file agar unik
            $namaBukti = $bukti->getRandomName();
            // Pindahkan file ke folder public/bukti_transaksi
            $bukti->move('bukti_transaksi', $namaBukti);

            // Update ke database
            $this->ModelTransaksiPesanan->update($id_transaksi, [
                'bukti_transaksi' => $namaBukti
            ]);
            session()->setFlashdata('pesan', 'Bukti transaksi berhasil diupload.');
        } else {
            session()->setFlashdata('error', 'Gagal upload file.');
        }

        return redirect()->to(base_url('Pesananuser'));
    }
}
