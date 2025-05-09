<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelWarna extends Model
{
    protected $table = 'tbl_warna';
    protected $primaryKey = 'id_warna';
    protected $allowedFields = ['nama_warna'];
}
