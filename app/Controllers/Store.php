<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelProduk;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;
use App\Models\ModelStore;
use App\Models\ModelBoard;
use App\Models\ModelTransaksi;
use App\Models\ModelCart;
use App\Models\ModelWarna;

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
        $this->ModelCart = new ModelCart();
        $this->ModelWarna = new ModelWarna();
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
        $cart = \Config\Services::cart();
        $isi_cart = $cart->contents();
    
        // Ambil semua ID warna unik dari cart
        $id_warnas = array_unique(array_column(array_map(function($item) {
            return ['id_warna' => $item['options']['warna']];
        }, $isi_cart), 'id_warna'));
    
        // Ambil data nama warna dari DB
        $warnaMap = [];
        if (!empty($id_warnas)) {
            $warnaData = $this->ModelWarna->whereIn('id_warna', $id_warnas)->findAll();
            foreach ($warnaData as $w) {
                $warnaMap[$w['id_warna']] = $w['nama_warna'];
            }
        }
    
        $data = [
            'judul' => 'View Cart',
            'isi' => 'v_cart',
            'kategori' => $this->ModelStore->AllData_Kategori(),
            'cart' => $cart,
            'warnaMap' => $warnaMap, // <-- Tambahkan ini ke view
        ];
        return view('layout/v_wrapper_frontend', $data);
    }

    public function cekout()
    {
        if ($this->validate([
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di isi!',
                ]
            ],
            'no_telpon' => [
                'label' => 'No Telpon',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di isi!',
                ]
            ],
            'alamat_lengkap' => [
                'label' => 'Alamat Lengkap',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di isi!',
                ]
            ],
            'pengiriman' => [
                'label' => 'Pengiriman',
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
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'no_telpon' => $this->request->getPost('no_telpon'),
                'kota' => $this->request->getPost('kota'),
                'kecamatan' => $this->request->getPost('kecamatan'),
                'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
                'pengiriman' => $this->request->getPost('pengiriman'),
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

            $this->ModelCart->deleteCartByUser(session()->get('id_user'));

            //================================================================
            session()->setFlashdata('pesan', 'Order Barang Berhasil Di Proses!');
            $cart->destroy();
            return redirect()->to(base_url('Store/cekout'));
        } else {

            $cart = \Config\Services::cart();
            $isi_cart = $cart->contents();

            // Ambil semua ID warna unik dari cart
            $id_warnas = array_unique(array_column(array_map(function($item) {
                return ['id_warna' => $item['options']['warna']];
            }, $isi_cart), 'id_warna'));

            // Ambil data warna dari DB
            $warnaMap = [];
            if (!empty($id_warnas)) {
                $warnaData = $this->ModelWarna->whereIn('id_warna', $id_warnas)->findAll();
                foreach ($warnaData as $w) {
                    $warnaMap[$w['id_warna']] = $w['nama_warna'];
                }
            }

            $data = [
                'judul' => 'Cek Out Belanja',
                'isi' => 'v_cekout',
                'kategori' => $this->ModelStore->AllData_Kategori(),
                'cart' => $cart,
                'warnaMap' => $warnaMap,
            ];
            return view('layout/v_wrapper_frontend', $data);

            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Store/cekout'))->withInput('validation', \Config\Services::validation());
        }
    }
}
