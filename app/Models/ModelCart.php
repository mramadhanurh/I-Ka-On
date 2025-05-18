<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCart extends Model
{
    protected $table = 'tbl_cart_user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_user', 'id_produk', 'qty', 'price', 'name', 
        'warna', 'nama_satuan', 'gambar_produk', 'created_at'
    ];

    public function getCartByUser($id_user)
    {
        return $this->where('id_user', $id_user)->findAll();
    }

    public function deleteCartByUser($id_user)
    {
        return $this->where('id_user', $id_user)->delete();
    }
}
