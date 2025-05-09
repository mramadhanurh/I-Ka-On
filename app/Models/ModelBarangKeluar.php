<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangKeluar extends Model
{
    protected $table = 'tbl_barangkeluar';
    protected $primaryKey = 'id_barangkeluar';
    protected $allowedFields = ['kode_produk', 'nama_produk', 'id_satuan', 'harga_jual', 'stok', 'tanggal'];

    public function AllData()
    {
        return $this->db->table('tbl_barangkeluar')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_barangkeluar.id_satuan')
            ->orderBy('id_barangkeluar', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function DeleteData($data)
    {
        $this->db->table('tbl_barangkeluar')
            ->where('id_barangkeluar', $data['id_barangkeluar'])
            ->delete($data);
    }
}
