<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelWarna extends Model
{
    protected $table = 'tbl_warna';
    protected $primaryKey = 'id_warna';
    protected $allowedFields = ['nama_warna'];

    public function AllData()
    {
        return $this->db->table('tbl_warna')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('tbl_warna')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('tbl_warna')
            ->where('id_warna', $data['id_warna'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tbl_warna')
            ->where('id_warna', $data['id_warna'])
            ->delete($data);
    }
}
