<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelProduk;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;
use App\Models\ModelGambar;
use App\Models\ModelWarna;
use App\Models\ModelProdukWarna;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Produk extends BaseController
{
    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelKategori = new ModelKategori();
        $this->ModelSatuan = new ModelSatuan();
        $this->ModelGambar = new ModelGambar();
        $this->ModelWarna = new ModelWarna();
        $this->ModelProdukWarna = new ModelProdukWarna();
    }

    public function index()
    {
        $data = [
            'judul' => 'Master Data',
            'subjudul' => 'Produk',
            'menu' => 'masterdata',
            'submenu' => 'produk',
            'page' => 'v_produk',
            'produk' => $this->ModelProduk->AllData(),
            'kategori' => $this->ModelKategori->AllData(),
            'satuan' => $this->ModelSatuan->AllData(),
        ];
        return view('v_template', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'kode_produk' => [
                'label' => 'Kode Produk',
                'rules' => 'is_unique[tbl_produk.kode_produk]',
                'errors' => [
                    'is_unique' => '{field} Sudah Ada, Masukkan Kode Lain!',
                ]
            ],
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Dipilih!',
                ]
            ],
            'id_satuan' => [
                'label' => 'Satuan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Dipilih!',
                ]
            ],
            'gambar_produk' => [
                'label' => 'Upload Foto',
                'rules' => 'uploaded[gambar_produk]|max_size[gambar_produk,500]|mime_in[gambar_produk,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => '{field} Tidak Boleh Kosong!',
                    'max_size' => '{field} Maksimal File 500 KB!',
                    'mime_in' => '{field} Harus Format jpg,jpeg,png!',
                ]
            ]
            
        ])) {
            $hargabeli = str_replace(",", "", $this->request->getPost('harga_beli'));
            $hargajual = str_replace(",", "", $this->request->getPost('harga_jual'));
            $gambar_produk = $this->request->getFile('gambar_produk');
            $nama_file = $gambar_produk->getRandomName();
            $gambar_produk->move('foto', $nama_file);
            $data = [
                'kode_produk' => $this->request->getPost('kode_produk'),
                'nama_produk' => $this->request->getPost('nama_produk'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'id_satuan' => $this->request->getPost('id_satuan'),
                'harga_beli' => $hargabeli,
                'harga_jual' => $hargajual,
                'stok' => $this->request->getPost('stok'),
                'gambar_produk' => $nama_file,
            ];
            $this->ModelProduk->InsertData($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('Produk'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Produk'))->withInput('validation',\Config\Services::validation());
        }
    }

    public function gambar($id_produk)
    {
        $data = [
            'judul'     => 'Master Data',
            'subjudul'  => 'Gambar Produk',
            'menu'      => 'masterdata',
            'submenu'   => 'produk',
            'page'      => 'v_gambar_produk',
            'produk'    => $this->ModelProduk->find($id_produk),
            'gambar'    => $this->ModelGambar->where('id_produk', $id_produk)->findAll(),
        ];

        return view('v_template', $data);
    }

    public function uploadGambar()
    {
        $id_produk = $this->request->getPost('id_produk');
        $files = $this->request->getFiles();

        foreach ($files['gambar'] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('foto/', $newName);

                $this->ModelGambar->save([
                    'id_produk' => $id_produk,
                    'nama_file' => $newName
                ]);
            }
        }

        return redirect()->to('produk/gambar/' . $id_produk)->with('success', 'Gambar berhasil diupload');
    }

    public function hapusGambar($id)
    {
        // Ambil data gambar berdasarkan ID
        $gambar = $this->ModelGambar->find($id);

        if ($gambar) {
            // Hapus file dari folder jika ada
            $filePath = FCPATH . 'foto/' . $gambar['nama_file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus data dari database
            $this->ModelGambar->delete($id);

            // Redirect kembali ke halaman gambar produk
            return redirect()->to('produk/gambar/' . $gambar['id_produk'])->with('success', 'Gambar berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gambar tidak ditemukan');
    }

    public function UpdateData($id_produk)
    {
        if ($this->validate([
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Dipilih!',
                ]
            ],
            'id_satuan' => [
                'label' => 'Satuan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Dipilih!',
                ]
            ],
            'gambar_produk' => [
                'label' => 'Upload Foto',
                'rules' => 'max_size[gambar_produk,500]|mime_in[gambar_produk,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => '{field} Maksimal File 500 KB!',
                    'mime_in' => '{field} Harus Format jpg,jpeg,png!',
                ]
            ]
            
        ])) {
            $hargabeli = str_replace(",", "", $this->request->getPost('harga_beli'));
            $hargajual = str_replace(",", "", $this->request->getPost('harga_jual'));

            $produk = $this->ModelProduk->DetailData($id_produk);
            $gambar_produk = $this->request->getFile('gambar_produk');
            if ($gambar_produk->getError() == 4) {
                // jika tidak ganti gambar
                $nama_file = $produk['gambar_produk'];
            } else {
                // jika ganti gambar
                $nama_file = $gambar_produk->getRandomName();
                $gambar_produk->move('foto', $nama_file);
            }
            
            $data = [
                'id_produk' => $id_produk,
                'nama_produk' => $this->request->getPost('nama_produk'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'id_satuan' => $this->request->getPost('id_satuan'),
                'harga_beli' => $hargabeli,
                'harga_jual' => $hargajual,
                'stok' => $this->request->getPost('stok'),
                'gambar_produk' => $nama_file,
            ];
            $this->ModelProduk->UpdateData($data);
            session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
            return redirect()->to(base_url('Produk'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Produk'))->withInput('validation',\Config\Services::validation());
        }
    }

    public function DeleteData($id_produk)
    {
        $data = [
            'id_produk' => $id_produk
        ];
        $this->ModelProduk->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to('Produk');
    }

    // Fungsi untuk mengekspor data ke Excel
    public function exportExcel()
    {
        // Mengambil data produk dari model dengan field yang diizinkan
        $produk = $this->ModelProduk
        ->select('tbl_produk.kode_produk, tbl_produk.nama_produk, tbl_kategori.nama_kategori, tbl_satuan.nama_satuan, tbl_produk.stok')
        ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_produk.id_kategori')
        ->join('tbl_satuan', 'tbl_satuan.id_satuan = tbl_produk.id_satuan')
        ->findAll();

        // Membuat objek spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Mengatur header kolom
        $sheet->setCellValue('A1', 'Kode Produk');
        $sheet->setCellValue('B1', 'Nama Produk');
        $sheet->setCellValue('C1', 'Nama Kategori');
        $sheet->setCellValue('D1', 'Nama Satuan');
        $sheet->setCellValue('E1', 'Stok');

        // Mengisi data produk ke dalam sheet
        $row = 2;
        foreach ($produk as $p) {
            $sheet->setCellValue('A' . $row, $p['kode_produk']);
            $sheet->setCellValue('B' . $row, $p['nama_produk']);
            $sheet->setCellValue('C' . $row, $p['nama_kategori']);
            $sheet->setCellValue('D' . $row, $p['nama_satuan']);
            $sheet->setCellValue('E' . $row, $p['stok']);
            $row++;
        }

        // Membuat file Excel dan mengirimkannya untuk diunduh
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data_Produk_' . date('Y-m-d') . '.xlsx';

        // Header response untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    public function warna($id_produk)
    {
        $data = [
            'judul' => 'Master Data',
            'subjudul' => 'Variasi Warna Produk',
            'menu' => 'masterdata',
            'submenu' => 'produk',
            'page' => 'v_warna_produk',
            'produk' => $this->ModelProduk->find($id_produk),
            'warna' => $this->ModelWarna->findAll(),
            'variasi' => $this->ModelProdukWarna->getWarnaProduk($id_produk),
        ];
        return view('v_template', $data);
    }

    public function insertWarna()
    {
        $id_produk = $this->request->getPost('id_produk');
        $id_warna = $this->request->getPost('id_warna');

        $this->ModelProdukWarna->insert([
            'id_produk' => $id_produk,
            'id_warna' => $id_warna,
        ]);

        return redirect()->to('produk/warna/' . $id_produk)->with('pesan', 'Variasi Warna berhasil ditambahkan');
    }

    public function deleteWarna($id_produk_warna)
    {
        $data = $this->ModelProdukWarna->find($id_produk_warna);
        if ($data) {
            $this->ModelProdukWarna->delete($id_produk_warna);
            return redirect()->to('produk/warna/' . $data['id_produk'])->with('pesan', 'Variasi Warna berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }
}
