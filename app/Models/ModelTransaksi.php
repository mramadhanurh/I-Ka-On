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
}
