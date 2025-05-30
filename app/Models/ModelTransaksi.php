<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksi extends Model
{
    public function simpan_transaksi($data)
    {
        $this->db->table('tbl_transaksi')->insert($data);
    }

    public function simpan_rinci_transaksi($data_rinci)
    {
        $this->db->table('tbl_rinci_transaksi')->insert($data_rinci);
    }

    // Hitung transaksi hari ini berdasarkan user
    public function getTransaksiHariIni($id_user)
    {
        return $this->db->table('tbl_transaksi')
            ->selectSum('grand_total')
            ->where('id_user', $id_user)
            ->where('DATE(tgl_transaksi)', date('Y-m-d'))
            ->get()
            ->getRow()->grand_total ?? 0;
    }

    // Hitung transaksi bulan ini berdasarkan user
    public function getTransaksiBulanIni($id_user)
    {
        return $this->db->table('tbl_transaksi')
            ->selectSum('grand_total')
            ->where('id_user', $id_user)
            ->where('MONTH(tgl_transaksi)', date('m'))
            ->where('YEAR(tgl_transaksi)', date('Y'))
            ->get()
            ->getRow()->grand_total ?? 0;
    }

    // Hitung transaksi tahun ini berdasarkan user
    public function getTransaksiTahunIni($id_user)
    {
        return $this->db->table('tbl_transaksi')
            ->selectSum('grand_total')
            ->where('id_user', $id_user)
            ->where('YEAR(tgl_transaksi)', date('Y'))
            ->get()
            ->getRow()->grand_total ?? 0;
    }
}
