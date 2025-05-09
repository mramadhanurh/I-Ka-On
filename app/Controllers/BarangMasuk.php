<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangMasuk;
use App\Models\ModelProduk;
use App\Models\ModelSatuan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BarangMasuk extends BaseController
{
    public function __construct()
    {
        $this->ModelBarangMasuk = new ModelBarangMasuk();
        $this->ModelProduk = new ModelProduk();
        $this->ModelSatuan = new ModelSatuan();
    }

    public function index()
    {
        $data = [
            'judul' => 'Barang',
            'subjudul' => 'Barang Masuk',
            'menu' => 'barang',
            'submenu' => 'barangmasuk',
            'page' => 'v_barangmasuk',
            'barangmasuk' => $this->ModelBarangMasuk->AllData(),
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

            // Siapkan data untuk disimpan ke tabel barang masuk
            $dataBarangMasuk = [
                'kode_produk' => $produk['kode_produk'],            // Ambil kode produk dari tabel produk
                'nama_produk' => $produk['nama_produk'],            // Ambil nama produk dari tabel produk
                'id_satuan'   => $produk['id_satuan'],               // Ambil id satuan dari tabel produk
                'harga_jual'  => $produk['harga_jual'],             // Ambil harga jual dari tabel produk
                'stok'        => $this->request->getPost('stok'),    // Ambil stok dari form input
                'tanggal'     => $this->request->getPost('tanggal'), // Ambil tanggal dari form input date
            ];

            // Simpan data ke tabel barang masuk
            if ($this->ModelBarangMasuk->insert($dataBarangMasuk)) {
                // Update stok di tabel produk
                $newStok = $produk['stok'] + $this->request->getPost('stok');
                $this->ModelProduk->update($produk['id_produk'], ['stok' => $newStok]);

                // Redirect dengan pesan sukses
                session()->setFlashdata('pesan', 'Data Barang Masuk Berhasil Ditambahkan!');
                return redirect()->to(base_url('BarangMasuk'));
            } else {
                // Redirect dengan pesan gagal
                return redirect()->back()->with('error', 'Gagal menambahkan data barang masuk.');
            }
        }

        // Jika bukan POST, tampilkan form input barang masuk
        $data = [
            'judul'    => 'Barang',
            'subjudul' => 'Barang Masuk Create Data',
            'menu'     => 'barang',
            'submenu'  => 'barangmasuk',
            'page'     => 'v_barangmasuk_create',
            'produk'   => $this->ModelProduk->AllData(), // Ambil semua data produk untuk select option
            'satuan'   => $this->ModelSatuan->AllData(), // Ambil semua data satuan
        ];

        return view('v_template', $data);
    }

    public function DeleteData($id_barangmasuk)
    {
        $data = [
            'id_barangmasuk' => $id_barangmasuk
        ];
        $this->ModelBarangMasuk->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to('BarangMasuk');
    }

    // Fungsi untuk mengekspor data ke Excel
    public function exportExcel()
    {
        // Mengambil data barang masuk dari model dengan field yang diizinkan
        $barangmasuk = $this->ModelBarangMasuk
        ->select('tbl_barangmasuk.kode_produk, tbl_barangmasuk.nama_produk, tbl_satuan.nama_satuan, tbl_barangmasuk.stok, tbl_barangmasuk.tanggal')
        ->join('tbl_satuan', 'tbl_satuan.id_satuan = tbl_barangmasuk.id_satuan')
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
        $filename = 'Data_Barang_Masuk_' . date('Y-m-d') . '.xlsx';

        // Header response untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

}
