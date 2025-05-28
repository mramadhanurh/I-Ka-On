<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenjualan extends Model
{
    public function NoFaktur()
    {
        $tgl = date('ymd');

        // Cari urutan transaksi harian (3 digit)
        $query = $this->db->query("SELECT MAX(RIGHT(no_faktur,3)) as no_urut FROM tbl_jual WHERE DATE(tgl_jual) = CURDATE()");
        $hasil = $query->getRowArray();

        if ($hasil['no_urut'] > 0) {
            $tmp = $hasil['no_urut'] + 1;
            $kd = sprintf("%03s", $tmp); // 3 digit urutan
        } else {
            $kd = "001";
        }

        // Random angka 3 digit
        $randomNumber = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        // Gabungkan
        $no_faktur = $tgl . $randomNumber . $kd;

        return $no_faktur;
    }

    public function CekProduk($kode_produk)
    {
        return $this->db->table('tbl_produk')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori=tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->where('kode_produk', $kode_produk)
            ->get()
            ->getRowArray();
    }

    public function AllProduk()
    {
        return $this->db->table('tbl_produk')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori=tbl_produk.id_kategori')
            ->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_produk.id_satuan')
            ->where('stok > 0')
            ->get()
            ->getResultArray();
    }

    public function InsertJual($data)
    {
        $this->db->table('tbl_jual')->insert($data);
    }

    public function InsertRinciJual($data)
    {
        $this->db->table('tbl_rinci_jual')->insert($data);
    }

    public function DetailPenjualan($no_faktur)
    {
        return $this->db->table('tbl_jual')
                        ->where('no_faktur', $no_faktur)
                        ->get()
                        ->getRowArray();
    }

    public function DetailRinciPenjualan($no_faktur)
    {
        return $this->db->table('tbl_rinci_jual')
                        ->join('tbl_produk', 'tbl_produk.kode_produk = tbl_rinci_jual.kode_produk')
                        ->where('no_faktur', $no_faktur)
                        ->get()
                        ->getResultArray();
    }
}
