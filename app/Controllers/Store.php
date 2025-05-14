<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelProduk;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;
use App\Models\ModelStore;
use App\Models\ModelBoard;
use App\Models\ModelTransaksi;

class Store extends BaseController
{
    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelKategori = new ModelKategori();
        $this->ModelSatuan = new ModelSatuan();
        $this->ModelStore = new ModelStore();
        $this->ModelBoard = new ModelBoard();
        $this->ModelTransaksi = new ModelTransaksi();
    }

    public function index()
    {
        // Ambil keyword dari query string
        $keyword = $this->request->getGet('keyword');

        // Jika ada keyword, panggil fungsi pencarian produk
        if ($keyword) {
            $produk = $this->ModelProduk->searchProduk($keyword); // Fungsi searchProduk di Model
            $pager = null; // Tidak ada pagination saat pencarian
        } else {
            // Jika tidak ada keyword, ambil semua data produk dengan pagination
            $produk = $this->ModelProduk->getPagingProduk()->paginate(6, 'product_pages');
            $pager = $this->ModelProduk->pager; // Gunakan pagination hanya di sini
        }

        $data = [
            'judul' => 'Home',
            'isi' => 'v_store',
            'produk' => $produk,
            'pager' => $pager,
            'kategori' => $this->ModelStore->AllData_Kategori(),
            'cart' => \Config\Services::cart(),
            'slider' => $this->ModelBoard->AllData(),
            'keyword' => $keyword,
        ];
        return view('layout/v_wrapper_frontend', $data);
    }

    public function kategori($id_kategori)
    {
        $kategori = $this->ModelStore->kategori($id_kategori);
        $data = [
            'judul' => 'Kategori Barang : ' . $kategori->nama_kategori,
            'isi' => 'v_kategori_barang',
            'produk' => $this->ModelStore->AllData_Barang($id_kategori),
            'kategori' => $this->ModelStore->AllData_Kategori(),
            'cart' => \Config\Services::cart(),
            'slider' => $this->ModelBoard->AllData(),
        ];
        return view('layout/v_wrapper_frontend', $data);
    }

    public function detail_produk($id_produk)
    {
        $data = [
            'judul' => 'Detail Barang',
            'isi' => 'v_detail_barang',
            'gambar' => $this->ModelStore->gambar_barang($id_produk),
            'produk' => $this->ModelStore->Detail_Produk($id_produk),
            'warna'     => $this->ModelStore->warna_produk($id_produk),
            'kategori' => $this->ModelStore->AllData_Kategori(),
            'cart' => \Config\Services::cart(),
        ];
        return view('layout/v_wrapper_frontend', $data);
    }

    // menampilkan detail isi keranjang
    public function cart()
    {
        $data = [
            'judul' => 'View Cart',
            'isi' => 'v_cart',
            'kategori' => $this->ModelStore->AllData_Kategori(),
            'cart' => \Config\Services::cart(),
        ];
        return view('layout/v_wrapper_frontend', $data);
    }

    public function cekout()
    {
        if ($this->validate([
            'nama_transaksi' => [
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di isi!',
                ]
            ],
            'nrp' => [
                'label' => 'NRP',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di isi!',
                ]
            ],
            'no_hp' => [
                'label' => 'No Hp',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di isi!',
                ]
            ],
            'dept' => [
                'label' => 'Dept',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di isi!',
                ]
            ],

        ])) {
            // simpan ke table transaksi
            $data = [
                'no_order' => $this->request->getPost('no_order'),
                'tgl_transaksi' => date('Y-m-d'),
                'nama_transaksi' => $this->request->getPost('nama_transaksi'),
                'nrp' => $this->request->getPost('nrp'),
                'no_hp' => $this->request->getPost('no_hp'),
                'dept' => $this->request->getPost('dept'),
                'keterangan' => $this->request->getPost('keterangan'),
                'grand_total' => $this->request->getPost('grand_total'),
                'status_transaksi' => '0',
            ];
            $this->ModelTransaksi->simpan_transaksi($data);
            // simpan ke table rinci transaksi
            $cart = \Config\Services::cart();
            $i = 1;
            foreach ($cart->contents() as $items) {
                $data_rinci = [
                    'no_order' => $this->request->getPost('no_order'),
                    'id_produk' => $items['id'],
                    'qty' => $this->request->getPost('qty' . $i++),
                ];
                $this->ModelTransaksi->simpan_rinci_transaksi($data_rinci);
            }

            //================================================================
            session()->setFlashdata('pesan', 'Order Barang Berhasil Di Proses!');
            $cart->destroy();
            return redirect()->to(base_url('Store/cekout'));
        } else {
            $data = [
                'judul' => 'Cek Out Belanja',
                'isi' => 'v_cekout',
                'kategori' => $this->ModelStore->AllData_Kategori(),
                'cart' => \Config\Services::cart(),
            ];
            return view('layout/v_wrapper_frontend', $data);

            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Store/cekout'))->withInput('validation', \Config\Services::validation());
        }
    }
}
