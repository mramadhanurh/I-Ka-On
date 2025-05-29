<?php

namespace App\Controllers;

use App\Models\ModelUser;
use App\Models\ModelCart;

class Home extends BaseController
{
    public function __construct()
    {
        $this->ModelUser = new ModelUser();
        $this->ModelCart = new ModelCart();
    }

    public function index()
    {
        $data = [
            'judul' => 'Login',
        ];
        return view('v_login', $data);
    }

    public function CekLogin()
    {
        if ($this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong!',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong!',
                ]
            ],
            
        ])) {
            $email = $this->request->getPost('email');
            $password = sha1($this->request->getPost('password'));
            $cek_login = $this->ModelUser->LoginUser($email, $password);
            if ($cek_login) {
                // Jika login berhasil
                session()->set('id_user', $cek_login['id_user']);
                session()->set('nama_user', $cek_login['nama_user']);
                session()->set('level', $cek_login['level']);
                // Load cart dari database ke session
                    $cart = \Config\Services::cart();
                    $cart->destroy(); // kosongkan dulu

                    $cartItems = $this->ModelCart->getCartByUser($cek_login['id_user']);
                    foreach ($cartItems as $item) {
                        $cart->insert([
                            'id'    => $item['id_produk'],
                            'qty'   => $item['qty'],
                            'price' => $item['price'],
                            'name'  => $item['name'],
                            'options' => [
                                'gambar_produk' => $item['gambar_produk'],
                                'nama_satuan'   => $item['nama_satuan'],
                                'warna'         => $item['warna'],
                            ]
                        ]);
                    }
                if ($cek_login['level'] == 1) {
                    return redirect()->to(base_url('Admin'));
                } else {
                    return redirect()->to(base_url('Pengguna'));
                }
            } else {
                // Jika login gagal
                session()->setFlashdata('gagal', 'Email atau Password salah!');
                return redirect()->to(base_url('Home'));
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Home'))->withInput('validation',\Config\Services::validation());
        }
    }

    public function Logout()
    {
        $cart = \Config\Services::cart();
        $cart->destroy(); // kosongkan cart session saat logout

        session()->remove('id_user');
        session()->remove('nama_user');
        session()->remove('level');
        session()->setFlashdata('pesan', 'Anda telah berhasil Logout!');
        return redirect()->to(base_url('Home'));
    }

    public function SettingUser()
    {
        $session = session();
        $id_user = $session->get('id_user'); // Pastikan session ada id_user
        $model = new \App\Models\ModelUser();
        $user = $model->find($id_user);

        if (!$user) {
            return redirect()->to('/')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'judul' => 'Setting Akun',
            'subjudul' => 'Setting Akun',
            'menu' => 'dashboard',
            'user' => $user,
            'submenu' => '',
            'page' => 'v_setting_user',
        ];
        return view('v_template', $data);
    }

    public function SettingUserSave()
    {
        $session = session();
        $id_user = $session->get('id_user');

        $model = new \App\Models\ModelUser();
        $user = $model->find($id_user);

        if (!$user) {
            return redirect()->to('/')->with('error', 'User tidak ditemukan.');
        }

        $nama_user = $this->request->getPost('nama_user');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $data = [
            'nama_user' => $nama_user,
            'email' => $email
        ];

        if (!empty($password)) {
            $data['password'] = sha1($password); // Hash password jika diisi
        }

        $model->update($id_user, $data);

        return redirect()->to(base_url('Home/SettingUser'))->with('success', 'Akun berhasil diperbarui.');
    }
}
