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
    public function LaporanHarian()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => 'Laporan Harian',
            'menu' => 'laporan',
            'submenu' => 'laporan-harian',
            'page' => 'laporan/v_laporan_harian',
            'web' => $this->ModelAdmin->DetailData(),
        ];
        return view('v_template', $data);
    }

    // Mengambil data laporan harian berdasarkan tanggal
    public function ViewLaporanHarian()
    {
        $tgl = $this->request->getPost('tgl');
        $data = [
            'judul' => 'Laporan Harian',
            'dataharian' => $this->ModelLaporan->DataHarian($tgl),
            'web' => $this->ModelAdmin->DetailData(),
            'tgl' => $tgl,
        ];

        $response = [
            'data' => view('laporan/v_tabel_laporan_harian', $data)
        ];

        echo json_encode($response);
    }

    // Mencetak laporan harian berdasarkan tanggal
    public function PrintLaporanHarian($tgl)
    {
        $data = [
            'judul' => 'Laporan Harian',
            'web' => $this->ModelAdmin->DetailData(),
            'page' => 'laporan/v_print_lap_harian',
            'dataharian' => $this->ModelLaporan->DataHarian($tgl),
            'tgl' => $tgl,
        ];
        return view('laporan/v_template_print_laporan', $data);
    }

    public function LaporanBulanan()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => 'Laporan Bulanan',
            'menu' => 'laporan',
            'submenu' => 'laporan-bulanan',
            'page' => 'laporan/v_laporan_bulanan',
            'web' => $this->ModelAdmin->DetailData(),
        ];
        return view('v_template', $data);
    }

    public function ViewLaporanBulanan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        // Ambil data grand_total dan qty
        $grandTotalData = $this->ModelLaporan->getGrandTotalBulanan($bulan, $tahun);
        $qtyData = $this->ModelLaporan->getQtyBulanan($bulan, $tahun);

        // Gabungkan data berdasarkan tgl_transaksi
        $dataBulanan = [];
        foreach ($grandTotalData as $gt) {
            $tgl = $gt['tgl_transaksi'];
            $dataBulanan[$tgl]['tgl_transaksi'] = $tgl;
            $dataBulanan[$tgl]['total_grand'] = $gt['total_grand'];
            $dataBulanan[$tgl]['total_qty'] = 0; // Inisialisasi total_qty

            // Cari total_qty dari qtyData
            foreach ($qtyData as $qty) {
                if ($qty['tgl_transaksi'] == $tgl) {
                    $dataBulanan[$tgl]['total_qty'] = $qty['total_qty'];
                }
            }
        }

        $data = [
            'judul' => 'Laporan Bulanan',
            'databulanan' => $dataBulanan,
            'web' => $this->ModelAdmin->DetailData(),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        $response = [
            'data' => view('laporan/v_tabel_laporan_bulanan', $data)
        ];

        echo json_encode($response);
    }

    public function PrintLaporanBulanan($bulan, $tahun)
    {
        // Ambil data grand_total dan qty
        $grandTotalData = $this->ModelLaporan->getGrandTotalBulanan($bulan, $tahun);
        $qtyData = $this->ModelLaporan->getQtyBulanan($bulan, $tahun);

        // Gabungkan data berdasarkan tgl_transaksi
        $dataBulanan = [];
        foreach ($grandTotalData as $gt) {
            $tgl = $gt['tgl_transaksi'];
            $dataBulanan[$tgl]['tgl_transaksi'] = $tgl;
            $dataBulanan[$tgl]['total_grand'] = $gt['total_grand'];
            $dataBulanan[$tgl]['total_qty'] = 0; // Inisialisasi total_qty

            // Cari total_qty dari qtyData
            foreach ($qtyData as $qty) {
                if ($qty['tgl_transaksi'] == $tgl) {
                    $dataBulanan[$tgl]['total_qty'] = $qty['total_qty'];
                }
            }
        }

        $data = [
            'judul' => 'Laporan Bulanan',
            'web' => $this->ModelAdmin->DetailData(),
            'page' => 'laporan/v_print_lap_bulanan',
            'databulanan' => $dataBulanan, // Mengirimkan data gabungan
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('laporan/v_template_print_laporan', $data);
    }

    public function LaporanTahunan()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => 'Laporan Tahunan',
            'menu' => 'laporan',
            'submenu' => 'laporan-tahunan',
            'page' => 'laporan/v_laporan_tahunan',
            'web' => $this->ModelAdmin->DetailData(),
        ];
        return view('v_template', $data);
    }

    public function ViewLaporanTahunan()
    {
        $tahun = $this->request->getPost('tahun');
        $data = [
            'judul' => 'Laporan Tahunan',
            'datatahunan' => $this->ModelLaporan->DataTahunan($tahun),
            'web' => $this->ModelAdmin->DetailData(),
            'tahun' => $tahun,
        ];

        $response = [
            'data' => view('laporan/v_tabel_laporan_tahunan', $data)
        ];

        echo json_encode($response);
    }

    public function PrintLaporanTahunan($tahun)
    {
        $data = [
            'judul' => 'Laporan Tahunan',
            'web' => $this->ModelAdmin->DetailData(),
            'page' => 'laporan/v_print_lap_tahunan',
            'datatahunan' => $this->ModelLaporan->DataTahunan($tahun),
            'tahun' => $tahun,
        ];
        return view('laporan/v_template_print_laporan', $data);
    }

    // Menampilkan halaman laporan tanggal
    public function LaporanTanggal()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => 'Laporan Tanggal',
            'menu' => 'laporan',
            'submenu' => 'laporan-tanggal',
            'page' => 'laporan/v_laporan_tanggal',
            'web' => $this->ModelAdmin->DetailData(),
        ];
        return view('v_template', $data);
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
