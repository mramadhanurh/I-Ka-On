<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGambar extends Model
{
    protected $table = 'tbl_gambar_produk';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_produk', 'nama_file'];
}
