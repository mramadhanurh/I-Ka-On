<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStore extends Model
{
    public function AllData()
    {
        return $this->db->table('tbl_produk')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori=tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->orderBy('id_produk', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function AllData_Kategori()
    {
        return $this->db->table('tbl_kategori')
            ->orderBy('id_kategori', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function Detail_Produk($id_produk)
    {
        return $this->db->table('tbl_produk')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori=tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->where('id_produk', $id_produk)
            ->get()
            ->getRow();
    }

    public function kategori($id_kategori)
    {
        return $this->db->table('tbl_kategori')
            ->where('id_kategori', $id_kategori)
            ->get()
            ->getRow();
    }

    public function AllData_Barang($id_kategori)
    {
        return $this->db->table('tbl_produk')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori=tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->where('tbl_produk.id_kategori', $id_kategori)
            ->get()
            ->getResultArray();
    }

    public function gambar_barang($id_produk)
    {
        return $this->db->table('tbl_gambar_produk')
            ->where('id_produk', $id_produk)
            ->get()
            ->getResult();
    }

    public function warna_produk($id_produk)
    {
        return $this->db->table('tbl_produk_warna')
            ->join('tbl_warna', 'tbl_warna.id_warna=tbl_produk_warna.id_warna')
            ->where('id_produk', $id_produk)
            ->get()
            ->getResultArray();
    }

}
