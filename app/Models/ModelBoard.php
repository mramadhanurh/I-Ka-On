<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBoard extends Model
{
    public function AllData()
    {
        return $this->db->table('tbl_slider')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('tbl_slider')->insert($data);
    }

    public function DetailData($id_slider)
    {
        return $this->db->table('tbl_slider')->where('id_slider',$id_slider)->get()->getRowArray();
    }

    public function UpdateData($data)
    {
        $this->db->table('tbl_slider')
            ->where('id_slider', $data['id_slider'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tbl_slider')
            ->where('id_slider', $data['id_slider'])
            ->delete($data);
    }
}
