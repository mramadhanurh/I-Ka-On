<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    public function DetailData()
    {
        return $this->db->table('tbl_setting')
            ->where('id', '1')
            ->get()
            ->getRowArray();
    }

    public function Grafik()
    {
        return $this->db->table('tbl_rinci_jual')
        ->join('tbl_jual', 'tbl_jual.no_faktur=tbl_rinci_jual.no_faktur')
        ->where('month(tbl_jual.tgl_jual)', date('m'))
        ->where('year(tbl_jual.tgl_jual)', date('Y'))
        ->select('tbl_jual.tgl_jual')
        ->groupBy('tbl_jual.tgl_jual')
        ->selectSum('tbl_rinci_jual.total_harga')
        ->selectSum('tbl_rinci_jual.untung')
        ->get()->getResultArray();
    }

    public function JumlahProduk()
    {
        return $this->db->table('tbl_produk')->countAll();
    }

    public function JumlahKategori()
    {
        return $this->db->table('tbl_kategori')->countAll();
    }

    public function JumlahSatuan()
    {
        return $this->db->table('tbl_satuan')->countAll();
    }

    public function JumlahUser()
    {
        return $this->db->table('tbl_user')->countAll();
    }
}
