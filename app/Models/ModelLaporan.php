<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLaporan extends Model
{
    // Mengambil data transaksi harian berdasarkan tanggal
    public function DataHarian($tgl)
    {
        return $this->db->table('tbl_rinci_transaksi')
            ->join('tbl_transaksi', 'tbl_transaksi.no_order = tbl_rinci_transaksi.no_order')
            ->join('tbl_produk', 'tbl_produk.id_produk = tbl_rinci_transaksi.id_produk')
            ->where('tbl_transaksi.tgl_transaksi', $tgl)
            ->select('tbl_rinci_transaksi.id_produk')
            ->select('tbl_produk.nama_produk')
            ->select('tbl_produk.harga_jual')
            ->selectSum('tbl_rinci_transaksi.qty') // Agregat total qty
            ->selectSum('tbl_transaksi.grand_total') // Jika ingin total grand_total, gunakan agregat juga
            ->groupBy('tbl_rinci_transaksi.id_produk') // Grup berdasarkan id_produk
            ->get()->getResultArray();
    }

    public function getGrandTotalBulanan($bulan, $tahun)
    {
        return $this->db->table('tbl_transaksi')
            ->select('tgl_transaksi')
            ->selectSum('grand_total', 'total_grand')
            ->where('MONTH(tgl_transaksi)', $bulan)
            ->where('YEAR(tgl_transaksi)', $tahun)
            ->groupBy('tgl_transaksi')
            ->get()->getResultArray();
    }

    public function getQtyBulanan($bulan, $tahun)
    {
        return $this->db->table('tbl_rinci_transaksi')
            ->join('tbl_transaksi', 'tbl_transaksi.no_order = tbl_rinci_transaksi.no_order')
            ->select('tbl_transaksi.tgl_transaksi')
            ->selectSum('tbl_rinci_transaksi.qty', 'total_qty')
            ->where('MONTH(tbl_transaksi.tgl_transaksi)', $bulan)
            ->where('YEAR(tbl_transaksi.tgl_transaksi)', $tahun)
            ->groupBy('tbl_transaksi.tgl_transaksi')
            ->get()->getResultArray();
    }

    public function DataTahunan($tahun)
    {
        // Mengambil data transaksi dari tbl_transaksi saja untuk menghitung grand_total tanpa join tbl_rinci_transaksi
        $transaksi = $this->db->table('tbl_transaksi')
            ->where('YEAR(tgl_transaksi)', $tahun)
            ->select('MONTH(tgl_transaksi) as bulan') // Mengambil bulan dari tanggal transaksi
            ->groupBy('MONTH(tgl_transaksi)') // Kelompokkan berdasarkan bulan
            ->selectSum('grand_total') // Hitung total grand_total dari tabel transaksi
            ->get()->getResultArray();

        // Mengambil total qty dari tbl_rinci_transaksi
        $qty = $this->db->table('tbl_rinci_transaksi')
            ->join('tbl_transaksi', 'tbl_transaksi.no_order = tbl_rinci_transaksi.no_order')
            ->where('YEAR(tbl_transaksi.tgl_transaksi)', $tahun)
            ->select('MONTH(tbl_transaksi.tgl_transaksi) as bulan')
            ->groupBy('MONTH(tbl_transaksi.tgl_transaksi)')
            ->selectSum('tbl_rinci_transaksi.qty') // Hitung total qty
            ->get()->getResultArray();

        // Gabungkan hasil grand_total dan qty berdasarkan bulan
        $result = [];
        foreach ($transaksi as $key => $trans) {
            $result[$key]['bulan'] = $trans['bulan'];
            $result[$key]['grand_total'] = $trans['grand_total'];

            // Cari qty untuk bulan yang sama
            foreach ($qty as $q) {
                if ($q['bulan'] == $trans['bulan']) {
                    $result[$key]['qty'] = $q['qty'];
                }
            }

            // Jika tidak ada qty untuk bulan tersebut, set qty menjadi 0
            if (!isset($result[$key]['qty'])) {
                $result[$key]['qty'] = 0;
            }
        }

        return $result;
    }

    public function DataTanggal($tgl_mulai, $tgl_selesai)
    {
        return $this->db->table('tbl_rinci_transaksi')
            ->join('tbl_transaksi', 'tbl_transaksi.no_order = tbl_rinci_transaksi.no_order')
            ->join('tbl_produk', 'tbl_produk.id_produk = tbl_rinci_transaksi.id_produk')
            ->where('tbl_transaksi.tgl_transaksi >=', $tgl_mulai)
            ->where('tbl_transaksi.tgl_transaksi <=', $tgl_selesai)
            ->select('tbl_rinci_transaksi.id_produk')
            ->select('tbl_produk.nama_produk')
            ->select('tbl_produk.harga_jual')
            ->selectSum('tbl_rinci_transaksi.qty')
            ->groupBy('tbl_rinci_transaksi.id_produk')
            ->get()->getResultArray();
    }
}
