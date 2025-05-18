<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiPesanan extends Model
{
    protected $table = 'tbl_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = ['no_order', 'nama_lengkap', 'no_telpon', 'kota', 'kecamatan', 'alamat_lengkap', 'pengiriman', 'tgl_transaksi', 'grand_total', 'status_transaksi', 'status_diambil'];

    public function AllData()
    {
        return $this->db->table('tbl_transaksi')
            ->orderBy('id_transaksi', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Method untuk mendapatkan detail transaksi
    public function getDetail($id_transaksi)
    {
        return $this->db->table('tbl_transaksi')
            ->where('id_transaksi', $id_transaksi)
            ->get()
            ->getRowArray(); // Mengambil 1 data dalam bentuk array
    }

    // Fungsi untuk mengambil satu transaksi berdasarkan id_transaksi
    public function getTransaksi($id_transaksi)
    {
        return $this->find($id_transaksi);
    }

    // Fungsi untuk menghapus transaksi berdasarkan id_transaksi
    public function deleteTransaksi($id_transaksi)
    {
        return $this->delete($id_transaksi);
    }
    
}
