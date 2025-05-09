<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBoard;

class Board extends BaseController
{
    public function __construct()
    {
        $this->ModelBoard = new ModelBoard();
    }

    public function index()
    {
        $data = [
            'judul' => 'Slider',
            'subjudul' => 'Slider',
            'menu' => 'board',
            'submenu' => '',
            'page' => 'v_board',
            'slider' => $this->ModelBoard->AllData(),
        ];
        return view('v_template', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'judul_slider' => [
                'label' => 'Judul Slider',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong!',
                ]
            ],
            'gambar_slider' => [
                'label' => 'Gambar Slider',
                'rules' => 'uploaded[gambar_slider]|max_size[gambar_slider,500]',
                'errors' => [
                    'uploaded' => '{field} Masih Kosong!',
                    'max_size' => '{field} Maksimal File 500 KB!',
                ]
            ],
            
        ])) {
            $gambar_slider = $this->request->getFile('gambar_slider');
            $nama_file = $gambar_slider->getRandomName();
            $gambar_slider->move('gambar_slider', $nama_file);
            $data = [
                'judul_slider' => $this->request->getPost('judul_slider'),
                'gambar_slider' => $nama_file,
            ];
            $this->ModelBoard->InsertData($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to('Board');
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Board'))->withInput('validation',\Config\Services::validation());
        }
    }

    public function UpdateData($id_slider)
    {
        if ($this->validate([
            'judul_slider' => [
                'label' => 'Judul Slider',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong!',
                ]
            ],
            'gambar_slider' => [
                'label' => 'Gambar Slider',
                'rules' => 'max_size[gambar_slider,500]',
                'errors' => [
                    'max_size' => '{field} Maksimal File 500 KB!',
                ]
            ],
            
        ])) {
            $slider = $this->ModelBoard->DetailData($id_slider);
            $gambar_slider = $this->request->getFile('gambar_slider');
            if ($gambar_slider->getError() == 4) {
                # jika tidak ganti gambar
                $nama_file = $slider['gambar_slider'];
            } else {
                # jika ganti gambar
                $nama_file = $gambar_slider->getRandomName();
                $gambar_slider->move('gambar_slider', $nama_file);
            }
            
            $data = [
                'id_slider' => $id_slider,
                'judul_slider' => $this->request->getPost('judul_slider'),
                'gambar_slider' => $nama_file,
            ];
            $this->ModelBoard->UpdateData($data);
            session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
            return redirect()->to('Board');
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Board'))->withInput('validation',\Config\Services::validation());
        }
    }

    public function DeleteData($id_slider)
    {
        $data = [
            'id_slider' => $id_slider,
        ];
        $this->ModelBoard->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to('Board');
    }
}
