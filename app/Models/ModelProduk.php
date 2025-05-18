<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduk extends Model
{
    protected $table = 'tbl_produk';
    protected $primaryKey = 'id_produk';
    protected $allowedFields = ['kode_produk', 'nama_produk', 'id_kategori', 'id_satuan', 'harga_beli', 'harga_jual', 'stok', 'status', 'gambar_produk'];

    public function AllData()
    {
        return $this->db->table('tbl_produk')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori=tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->orderBy('id_produk', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('tbl_produk')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('tbl_produk')
            ->where('id_produk', $data['id_produk'])
            ->update($data);
    }

    public function DetailData($id_produk)
    {
        return $this->db->table('tbl_produk')->where('id_produk', $id_produk)->get()->getRowArray();
    }

    public function DeleteData($data)
    {
        $this->db->table('tbl_produk')
            ->where('id_produk', $data['id_produk'])
            ->delete($data);
    }

    public function searchProduk($keyword)
    {
        return $this->table('tbl_produk')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori=tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->like('nama_produk', $keyword)
            ->findAll();
    }

    // Fungsi untuk update stok produk
    public function updateStok($kode_produk, $jumlah)
    {
        // Cari produk berdasarkan kode_produk
        $produk = $this->where('kode_produk', $kode_produk)->first();

        if ($produk) {
            // Tambahkan stok
            $newStok = $produk['stok'] + $jumlah;
            // Update stok produk
            return $this->update($produk['id_produk'], ['stok' => $newStok]);
        }
        return false;
    }

    public function reduceStok($kode_produk, $jumlah)
    {
        // Cari produk berdasarkan kode_produk
        $produk = $this->where('kode_produk', $kode_produk)->first();

        if ($produk && $produk['stok'] >= $jumlah) {
            // Kurangi stok
            $newStok = $produk['stok'] - $jumlah;
            // Update stok produk
            return $this->update($produk['id_produk'], ['stok' => $newStok]);
        }
        return false;
    }

    public function getPagingProduk()
    {
        return $this
            ->join('tbl_kategori', 'tbl_kategori.id_kategori=tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->orderBy('id_produk', 'DESC');
    }

    public function JumlahStatusTersedia()
    {
        return $this->db->table('tbl_produk')
            ->where('status', 1)
            ->countAllResults();
    }

    public function JumlahStatusRendah()
    {
        return $this->db->table('tbl_produk')
            ->where('status', 2)
            ->countAllResults();
    }

    public function JumlahStatusHabis()
    {
        return $this->db->table('tbl_produk')
            ->where('status', 3)
            ->countAllResults();
    }

    public function getProdukByStatus($status)
    {
        return $this->db->table('tbl_produk')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan = tbl_produk.id_satuan')
            ->where('tbl_produk.status', $status)
            ->get()
            ->getResultArray();
    }
}
