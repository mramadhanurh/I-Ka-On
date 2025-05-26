<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiPesanan extends Model
{
    protected $table = 'tbl_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = ['id_user', 'no_order', 'nama_lengkap', 'no_telpon', 'kota', 'kecamatan', 'alamat_lengkap', 'pengiriman', 'tgl_transaksi', 'grand_total', 'status_transaksi', 'status_diambil', 'bukti_transaksi'];

    public function AllData()
    {
        return $this->db->table('tbl_transaksi')
            ->orderBy('id_transaksi', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function AllDataTransaksi($id_user)
    {
        return $this->db->table('tbl_transaksi')
            ->where('id_user', $id_user)
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

    public function getProdukByStatus($status)
    {
        return $this->db->table('tbl_transaksi')
            ->where('tbl_transaksi.status_transaksi', $status)
            ->get()
            ->getResultArray();
    }

    public function StatusKonfirmasi()
    {
        return $this->db->table('tbl_transaksi')
            ->where('status_transaksi', 0)
            ->countAllResults();
    }

    public function StatusProses()
    {
        return $this->db->table('tbl_transaksi')
            ->where('status_transaksi', 1)
            ->countAllResults();
    }

    public function StatusSelesai()
    {
        return $this->db->table('tbl_transaksi')
            ->where('status_transaksi', 2)
            ->countAllResults();
    }
    
}
