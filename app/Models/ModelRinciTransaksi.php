<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRinciTransaksi extends Model
{
    protected $table = 'tbl_rinci_transaksi';
    protected $primaryKey = 'id_rinci';
    protected $allowedFields = ['no_order', 'id_produk', 'qty'];

    // Method untuk mendapatkan rincian berdasarkan no_order
    public function getRinciByOrder($no_order)
    {
        return $this->db->table('tbl_rinci_transaksi')
            ->join('tbl_produk', 'tbl_produk.id_produk=tbl_rinci_transaksi.id_produk')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->where('no_order', $no_order)
            ->get()
            ->getResultArray();
    }

    // Fungsi untuk menghapus rincian transaksi berdasarkan no_order
    public function deleteRinciTransaksiByOrder($no_order)
    {
        return $this->where('no_order', $no_order)->delete();
    }
}
