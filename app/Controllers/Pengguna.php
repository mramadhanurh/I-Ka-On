<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pengguna extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'User',
            'subjudul' => 'User',
            'menu' => 'user',
            'submenu' => '',
            'page' => 'v_pengguna',
        ];
        return view('v_template', $data);
    }
}
