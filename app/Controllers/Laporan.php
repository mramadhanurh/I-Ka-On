<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLaporan;
use App\Models\ModelAdmin;

class Laporan extends BaseController
{
    public function __construct()
    {
        $this->ModelLaporan = new ModelLaporan();
        $this->ModelAdmin = new ModelAdmin();
    }

    // Menampilkan halaman laporan harian
    public function LaporanStokMasukProduk()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => 'Laporan Stok Masuk Produk',
            'menu' => 'laporan',
            'submenu' => 'laporan-stok-masuk-produk',
            'page' => 'laporan/v_laporan_stok_masuk_produk',
            'web' => $this->ModelAdmin->DetailData(),
        ];
        return view('v_template', $data);
    }

    // Mengambil data laporan harian berdasarkan tanggal
    public function ViewLaporanStokMasukProduk()
    {
        $tgl = $this->request->getPost('tgl');
        $data = [
            'judul' => 'Laporan Stok Masuk Produk',
            'datastokmasukproduk' => $this->ModelLaporan->DataStokMasukProduk($tgl),
            'web' => $this->ModelAdmin->DetailData(),
            'tgl' => $tgl,
        ];

        $response = [
            'data' => view('laporan/v_tabel_laporan_stok_masuk_produk', $data)
        ];

        echo json_encode($response);
    }

    // Mencetak laporan harian berdasarkan tanggal
    public function PrintLaporanStokMasukProduk($tgl)
    {
        $data = [
            'judul' => 'Laporan Stok Masuk Produk',
            'web' => $this->ModelAdmin->DetailData(),
            'page' => 'laporan/v_print_lap_stok_masuk_produk',
            'datastokmasukproduk' => $this->ModelLaporan->DataStokMasukProduk($tgl),
            'tgl' => $tgl,
        ];
        return view('laporan/v_template_print_laporan', $data);
    }

    public function LaporanStokKeluarProduk()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => 'Laporan Stok Keluar Produk',
            'menu' => 'laporan',
            'submenu' => 'laporan-stok-keluar-produk',
            'page' => 'laporan/v_laporan_stok_keluar_produk',
            'web' => $this->ModelAdmin->DetailData(),
        ];
        return view('v_template', $data);
    }

    public function ViewLaporanStokKeluarProduk()
    {
        $tgl = $this->request->getPost('tgl');
        $data = [
            'judul' => 'Laporan Stok Keluar Produk',
            'datastokkeluarproduk' => $this->ModelLaporan->DataStokKeluarProduk($tgl),
            'web' => $this->ModelAdmin->DetailData(),
            'tgl' => $tgl,
        ];

        $response = [
            'data' => view('laporan/v_tabel_laporan_stok_keluar_produk', $data)
        ];

        echo json_encode($response);
    }

    public function PrintLaporanStokKeluarProduk($tgl)
    {
        $data = [
            'judul' => 'Laporan Stok Keluar Produk',
            'web' => $this->ModelAdmin->DetailData(),
            'page' => 'laporan/v_print_lap_stok_keluar_produk',
            'datastokkeluarproduk' => $this->ModelLaporan->DataStokKeluarProduk($tgl),
            'tgl' => $tgl,
        ];
        return view('laporan/v_template_print_laporan', $data);
    }

    public function LaporanStokMasukBahanBaku()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => 'Laporan Stok Masuk Bahan Baku',
            'menu' => 'laporan',
            'submenu' => 'laporan-stok-masuk-bahan-baku',
            'page' => 'laporan/v_laporan_stok_masuk_bahan_baku',
            'web' => $this->ModelAdmin->DetailData(),
        ];
        return view('v_template', $data);
    }

    public function ViewLaporanStokMasukBahanBaku()
    {
        $tgl = $this->request->getPost('tgl');
        $data = [
            'judul' => 'Laporan Stok Masuk Bahan Baku',
            'datastokmasukbahanbaku' => $this->ModelLaporan->DataStokMasukBahanBaku($tgl),
            'web' => $this->ModelAdmin->DetailData(),
            'tgl' => $tgl,
        ];

        $response = [
            'data' => view('laporan/v_tabel_laporan_stok_masuk_bahan_baku', $data)
        ];

        echo json_encode($response);
    }

    public function PrintLaporanStokMasukBahanBaku($tgl)
    {
        $data = [
            'judul' => 'Laporan Stok Masuk Bahan Baku',
            'web' => $this->ModelAdmin->DetailData(),
            'page' => 'laporan/v_print_lap_stok_masuk_bahan_baku',
            'datastokmasukbahanbaku' => $this->ModelLaporan->DataStokMasukBahanBaku($tgl),
            'tgl' => $tgl,
        ];
        return view('laporan/v_template_print_laporan', $data);
    }

    // Menampilkan halaman laporan
    public function LaporanStokKeluarBahanBaku()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => 'Laporan Stok Keluar Bahan Baku',
            'menu' => 'laporan',
            'submenu' => 'laporan-stok-keluar-bahan-baku',
            'page' => 'laporan/v_laporan_stok_keluar_bahan_baku',
            'web' => $this->ModelAdmin->DetailData(),
        ];
        return view('v_template', $data);
    }

    public function ViewLaporanStokKeluarBahanBaku()
    {
        $tgl = $this->request->getPost('tgl');
        $data = [
            'judul' => 'Laporan Stok Keluar Bahan Baku',
            'datastokkeluarbahanbaku' => $this->ModelLaporan->DataStokKeluarBahanBaku($tgl),
            'web' => $this->ModelAdmin->DetailData(),
            'tgl' => $tgl,
        ];

        $response = [
            'data' => view('laporan/v_tabel_laporan_stok_keluar_bahan_baku', $data)
        ];

        echo json_encode($response);
    }

    public function PrintLaporanStokKeluarBahanBaku($tgl)
    {
        $data = [
            'judul' => 'Laporan Stok Keluar Bahan Baku',
            'web' => $this->ModelAdmin->DetailData(),
            'page' => 'laporan/v_print_lap_stok_keluar_bahan_baku',
            'datastokkeluarbahanbaku' => $this->ModelLaporan->DataStokKeluarBahanBaku($tgl),
            'tgl' => $tgl,
        ];
        return view('laporan/v_template_print_laporan', $data);
    }

    public function exportExcelTanggal()
    {
        $tgl_mulai = $this->request->getGet('tgl_mulai'); // Tanggal mulai dari request GET
        $tgl_selesai = $this->request->getGet('tgl_selesai'); // Tanggal selesai dari request GET

        if (!$tgl_mulai || !$tgl_selesai) {
            return redirect()->back()->with('error', 'Rentang tanggal harus diisi.');
        }

        // Ambil data laporan berdasarkan rentang tanggal
        $dataLaporan = $this->ModelLaporan->DataTanggal($tgl_mulai, $tgl_selesai);

        // Buat file Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Produk');
        $sheet->setCellValue('C1', 'Harga Jual');
        $sheet->setCellValue('D1', 'Total Qty');

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($dataLaporan as $laporan) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $laporan['nama_produk']);
            $sheet->setCellValue('C' . $row, $laporan['harga_jual']);
            $sheet->setCellValue('D' . $row, $laporan['qty']);
            $row++;
        }

        // Simpan file Excel dan kirim untuk diunduh
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Tanggal_' . $tgl_mulai . '_sampai_' . $tgl_selesai . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
