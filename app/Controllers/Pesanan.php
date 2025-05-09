<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelTransaksiPesanan;
use App\Models\ModelRinciTransaksi;
use App\Models\ModelProduk;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pesanan extends BaseController
{
    public function __construct()
    {
        $this->ModelTransaksiPesanan = new ModelTransaksiPesanan();
        $this->ModelRinciTransaksi = new ModelRinciTransaksi();
        $this->ModelProduk = new ModelProduk();
    }

    public function index()
    {
        $data = [
            'judul' => 'Transaksi',
            'subjudul' => 'Transaksi',
            'menu' => 'transaksi',
            'submenu' => '',
            'page' => 'v_transaksi_pesanan',
            'pesanan' => $this->ModelTransaksiPesanan->AllData(),
        ];
        return view('v_template', $data);
    }

    public function DetailData($id_transaksi)
    {
        $transaksi = $this->ModelTransaksiPesanan->getDetail($id_transaksi); // Ambil data transaksi
        $rinciTransaksi = $this->ModelRinciTransaksi->getRinciByOrder($transaksi['no_order']); // Ambil rincian dari no_order

        $data = [
            'judul' => 'Detail Transaksi',
            'subjudul' => 'Detail Transaksi',
            'menu' => 'transaksi',
            'submenu' => '',
            'page' => 'v_detail_rinci_transaksi',
            'transaksi' => $transaksi,
            'rinciTransaksi' => $rinciTransaksi,
        ];

        return view('v_template', $data);
    }

    // Method untuk menampilkan form update
    public function updateData($id_transaksi)
    {
        $transaksi = $this->ModelTransaksiPesanan->getDetail($id_transaksi);
        $rinciTransaksi = $this->ModelRinciTransaksi->getRinciByOrder($transaksi['no_order']);

        $data = [
            'judul' => 'Update Transaksi',
            'subjudul' => 'Update Transaksi',
            'menu' => 'transaksi',
            'submenu' => '',
            'page' => 'v_update_rinci_transaksi',
            'transaksi' => $transaksi,
            'rinciTransaksi' => $rinciTransaksi,
        ];

        return view('v_template', $data);
    }

    // Method untuk menyimpan perubahan
    public function saveUpdateData($id_transaksi)
    {
        // Update status transaksi
        $status_transaksi = $this->request->getPost('status_transaksi');
        $this->ModelTransaksiPesanan->update($id_transaksi, ['status_transaksi' => $status_transaksi]);

        // Update rincian transaksi dan stok produk
        $rincian = $this->request->getPost('rinci');
        foreach ($rincian as $id_rinci => $qty_baru) {
            // Ambil data rincian lama
            $rinciLama = $this->ModelRinciTransaksi->find($id_rinci);
            $id_produk = $rinciLama['id_produk'];
            $qty_lama = $rinciLama['qty'];

            // Hitung stok yang berkurang sesuai qty baru, terlepas dari apakah ada perubahan
            $produk = $this->ModelProduk->find($id_produk);
            $stok_sekarang = $produk['stok'];

            // Stok harus selalu berkurang sebesar qty baru
            $stok_baru = $stok_sekarang - $qty_baru;

            // Update stok di tabel tbl_produk
            $this->ModelProduk->update($id_produk, ['stok' => $stok_baru]);

            // Update qty di tbl_rinci_transaksi hanya jika ada perubahan
            if ($qty_baru != $qty_lama) {
                $this->ModelRinciTransaksi->update($id_rinci, ['qty' => $qty_baru]);
            }
        }

        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
        return redirect()->to(base_url('Pesanan'));
    }

    public function deleteData($id_transaksi)
    {
        // Ambil data transaksi untuk mendapatkan no_order
        $transaksi = $this->ModelTransaksiPesanan->getTransaksi($id_transaksi);
        $no_order = $transaksi['no_order'];

        // Hapus data rincian transaksi di tbl_rinci_transaksi berdasarkan no_order
        $this->ModelRinciTransaksi->deleteRinciTransaksiByOrder($no_order);

        // Hapus data transaksi di tbl_transaksi berdasarkan id_transaksi
        $this->ModelTransaksiPesanan->deleteTransaksi($id_transaksi);

        return redirect()->to(base_url('Pesanan'))->with('pesan', 'Data Berhasil Dihapus!');
    }

    // Method untuk menampilkan form update transaksi diambil/belum diambil
    public function updateDiambil($id_transaksi)
    {
        $transaksi = $this->ModelTransaksiPesanan->getDetail($id_transaksi);

        $data = [
            'judul' => 'Update Transaksi Diambil',
            'subjudul' => 'Update Transaksi Diambil',
            'menu' => 'transaksi',
            'submenu' => '',
            'page' => 'v_update_diambil_rinci_transaksi',
            'transaksi' => $transaksi,
        ];

        return view('v_template', $data);
    }

    // Method untuk menyimpan perubahan transaksi diambil/belum diambil
    public function saveUpdateDataDiambil($id_transaksi)
    {
        // Update status transaksi diambil
        $status_diambil = $this->request->getPost('status_diambil');
        $this->ModelTransaksiPesanan->update($id_transaksi, ['status_diambil' => $status_diambil]);

        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
        return redirect()->to(base_url('Pesanan'));
    }

    // Fungsi untuk mengekspor data ke Excel
    public function exportExcel()
    {
        // Mengambil data transaksi dari model dengan field yang diizinkan
        $transaksi = $this->ModelTransaksiPesanan
        ->select('tbl_transaksi.nama_transaksi, tbl_transaksi.nrp, tbl_transaksi.dept, tbl_transaksi.status_transaksi, tbl_transaksi.status_diambil')
        ->findAll();

        // Membuat objek spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Mengatur header kolom
        $sheet->setCellValue('A1', 'NRP');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Dept');
        $sheet->setCellValue('D1', 'Status Konfirmasi');
        $sheet->setCellValue('E1', 'Status Diambil');

        // Mengisi data transaksi ke dalam sheet
        $row = 2;
        foreach ($transaksi as $p) {
            $sheet->setCellValue('A' . $row, $p['nrp']);
            $sheet->setCellValue('B' . $row, $p['nama_transaksi']);
            $sheet->setCellValue('C' . $row, $p['dept']);
            
            // Status Konfirmasi
            $statusKonfirmasi = $p['status_transaksi'] == 1 ? 'Sudah Konfirmasi' : 'Belum Konfirmasi';
            $sheet->setCellValue('D' . $row, $statusKonfirmasi);
            
            // Status Diambil
            $statusDiambil = $p['status_diambil'] == 1 ? 'Sudah Diambil' : 'Belum Diambil';
            $sheet->setCellValue('E' . $row, $statusDiambil);
            
            $row++;
        }

        // Membuat file Excel dan mengirimkannya untuk diunduh
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data_Transaksi_' . date('Y-m-d') . '.xlsx';

        // Header response untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    public function exportExcelDetailTransaksi($id_transaksi)
    {
        // Mengambil detail transaksi dan rincian produk
        $transaksi = $this->ModelTransaksiPesanan->getDetail($id_transaksi);
        $rinciTransaksi = $this->ModelRinciTransaksi->getRinciByOrder($transaksi['no_order']);

        // Membuat objek spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan data detail transaksi
        $sheet->setCellValue('A1', 'Detail Transaksi');
        $sheet->setCellValue('A3', 'No Order');
        $sheet->setCellValue('B3', $transaksi['no_order']);
        $sheet->setCellValue('A4', 'Nama Transaksi');
        $sheet->setCellValue('B4', $transaksi['nama_transaksi']);
        $sheet->setCellValue('A5', 'NRP');
        $sheet->setCellValue('B5', $transaksi['nrp']);
        $sheet->setCellValue('A6', 'No HP');
        $sheet->setCellValue('B6', $transaksi['no_hp']);
        $sheet->setCellValue('A7', 'Department');
        $sheet->setCellValue('B7', $transaksi['dept']);
        $sheet->setCellValue('A8', 'Tanggal Transaksi');
        $sheet->setCellValue('B8', $transaksi['tgl_transaksi']);
        $sheet->setCellValue('A9', 'Grand Total');
        $sheet->setCellValue('B9', $transaksi['grand_total']);

        $statusTransaksi = ($transaksi['status_transaksi'] == 0) ? 'Belum Konfirmasi' : 'Sudah Konfirmasi';
        $sheet->setCellValue('A10', 'Status Transaksi');
        $sheet->setCellValue('B10', $statusTransaksi);

        $sheet->setCellValue('A11', 'Keterangan');
        $sheet->setCellValue('B11', $transaksi['keterangan']);

        // Menambahkan rincian produk
        $sheet->setCellValue('A13', 'Rincian Produk');
        $sheet->setCellValue('A15', 'No');
        $sheet->setCellValue('B15', 'Nama Produk');
        $sheet->setCellValue('C15', 'Satuan');
        $sheet->setCellValue('D15', 'Qty');

        $row = 16; // Mulai dari baris setelah header rincian produk
        $no = 1;
        foreach ($rinciTransaksi as $rinci) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $rinci['nama_produk']);
            $sheet->setCellValue('C' . $row, $rinci['nama_satuan']);
            $sheet->setCellValue('D' . $row, $rinci['qty']);
            $row++;
        }

        // Membuat file Excel dan mengirimkannya untuk diunduh
        $writer = new Xlsx($spreadsheet);
        $filename = 'Detail_Transaksi_' . $transaksi['no_order'] . '.xlsx';

        // Header response untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
