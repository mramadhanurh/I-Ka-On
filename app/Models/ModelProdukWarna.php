<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProdukWarna extends Model
{
    protected $table = 'tbl_produk_warna';
    protected $primaryKey = 'id_produk_warna';
    protected $allowedFields = ['id_produk', 'id_warna'];

    public function getWarnaProduk($id_produk)
    {
        return $this->db->table($this->table)
            ->join('tbl_warna', 'tbl_warna.id_warna = tbl_produk_warna.id_warna')
            ->where('id_produk', $id_produk)
            ->get()->getResultArray();
    }
}
