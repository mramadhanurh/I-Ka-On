<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangMasuk extends Model
{
    protected $table = 'tbl_barangmasuk';
    protected $primaryKey = 'id_barangmasuk';
    protected $allowedFields = ['kode_produk', 'nama_produk', 'id_satuan', 'harga_jual', 'stok', 'tanggal'];

    public function AllData()
    {
        return $this->db->table('tbl_barangmasuk')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_barangmasuk.id_satuan')
            ->orderBy('id_barangmasuk', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function DeleteData($data)
    {
        $this->db->table('tbl_barangmasuk')
            ->where('id_barangmasuk', $data['id_barangmasuk'])
            ->delete($data);
    }
}
