<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangKeluar;
use App\Models\ModelProduk;
use App\Models\ModelSatuan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BarangKeluar extends BaseController
{
    public function __construct()
    {
        $this->ModelBarangKeluar = new ModelBarangKeluar();
        $this->ModelProduk = new ModelProduk();
        $this->ModelSatuan = new ModelSatuan();
    }

    public function index()
    {
        $data = [
            'judul' => 'Barang',
            'subjudul' => 'Barang Keluar',
            'menu' => 'barang',
            'submenu' => 'barangkeluar',
            'page' => 'v_barangkeluar',
            'barangkeluar' => $this->ModelBarangKeluar->AllData(),
        ];
        return view('v_template', $data);
    }

    public function create()
    {
        // Cek apakah request adalah POST
        if ($this->request->getMethod(true) == 'POST') {
            // Dapatkan data produk berdasarkan ID produk dari form input
            $produk = $this->ModelProduk->where('id_produk', $this->request->getPost('id_produk'))->first();

            if (!$produk) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            // Cek apakah stok cukup untuk dikurangi
            $stokKeluar = $this->request->getPost('stok');
            if ($produk['stok'] < $stokKeluar) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
            }

            // Siapkan data untuk disimpan ke tabel barang keluar
            $dataBarangKeluar = [
                'kode_produk' => $produk['kode_produk'],
                'nama_produk' => $produk['nama_produk'],
                'id_satuan'   => $produk['id_satuan'],
                'harga_jual'  => $produk['harga_jual'],
                'stok'        => $stokKeluar, // Stok keluar dari form input
                'tanggal'     => $this->request->getPost('tanggal'), // Ambil tanggal dari form input date
            ];

            // Simpan data ke tabel barang keluar
            if ($this->ModelBarangKeluar->insert($dataBarangKeluar)) {
                // Kurangi stok di tabel produk
                $newStok = $produk['stok'] - $stokKeluar;
                $this->ModelProduk->update($produk['id_produk'], ['stok' => $newStok]);

                // Redirect dengan pesan sukses
                session()->setFlashdata('pesan', 'Data Barang Keluar Berhasil Ditambahkan!');
                return redirect()->to(base_url('BarangKeluar'));
            } else {
                // Redirect dengan pesan gagal
                return redirect()->back()->with('error', 'Gagal menambahkan data barang keluar.');
            }
        }

        // Jika bukan POST, tampilkan form input barang keluar
        $data = [
            'judul'    => 'Barang',
            'subjudul' => 'Barang Keluar Create Data',
            'menu'     => 'barang',
            'submenu'  => 'barangkeluar',
            'page'     => 'v_barangkeluar_create',
            'produk'   => $this->ModelProduk->AllData(), // Ambil semua data produk untuk select option
            'satuan'   => $this->ModelSatuan->AllData(), // Ambil semua data satuan
        ];

        return view('v_template', $data);
    }

    public function DeleteData($id_barangkeluar)
    {
        $data = [
            'id_barangkeluar' => $id_barangkeluar
        ];
        $this->ModelBarangKeluar->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to('BarangKeluar');
    }

    public function exportExcel()
    {
        // Mengambil data barang keluar dari model dengan field yang diizinkan
        $barangmasuk = $this->ModelBarangKeluar
        ->select('tbl_barangkeluar.kode_produk, tbl_barangkeluar.nama_produk, tbl_satuan.nama_satuan, tbl_barangkeluar.stok, tbl_barangkeluar.tanggal')
        ->join('tbl_satuan', 'tbl_satuan.id_satuan = tbl_barangkeluar.id_satuan')
        ->findAll();

        // Membuat objek spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Mengatur header kolom
        $sheet->setCellValue('A1', 'Kode Produk');
        $sheet->setCellValue('B1', 'Nama Produk');
        $sheet->setCellValue('C1', 'Nama Satuan');
        $sheet->setCellValue('D1', 'Stok');
        $sheet->setCellValue('E1', 'Tanggal');

        // Mengisi data barang masuk ke dalam sheet
        $row = 2;
        foreach ($barangmasuk as $p) {
            $sheet->setCellValue('A' . $row, $p['kode_produk']);
            $sheet->setCellValue('B' . $row, $p['nama_produk']);
            $sheet->setCellValue('C' . $row, $p['nama_satuan']);
            $sheet->setCellValue('D' . $row, $p['stok']);
            $sheet->setCellValue('E' . $row, $p['tanggal']);
            $row++;
        }

        // Membuat file Excel dan mengirimkannya untuk diunduh
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data_Barang_Keluar_' . date('Y-m-d') . '.xlsx';

        // Header response untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
