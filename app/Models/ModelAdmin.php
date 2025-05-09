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
