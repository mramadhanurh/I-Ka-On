<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelCart;

class Belanja extends BaseController
{
    public function __construct()
    {
        $this->ModelCart = new ModelCart();
    }

    public function index()
    {
    }

    public function cek()
    {
        $cart = \Config\Services::cart();
        $response = $cart->contents();
        // $data = json_encode($response);
        echo '<pre>';
        print_r($response);
        echo '</pre>';
    }

    public function add()
    {
        if (!session()->get('id_user')) {
            return redirect()->to(base_url('home'))->with('error', 'Silakan login terlebih dahulu!');
        }
    
        $cart = \Config\Services::cart();
    
        $id_user = session()->get('id_user');

        $produk = [
            'id'      => $this->request->getPost('id'),
            'qty'     => $this->request->getPost('qty'),
            'price'   => $this->request->getPost('price'),
            'name'    => $this->request->getPost('name'),
            'options' => [
                'gambar_produk' => $this->request->getPost('gambar_produk'),
                'nama_satuan'   => $this->request->getPost('nama_satuan'),
                'warna'         => $this->request->getPost('warna'),
            ]
        ];

        $cart->insert($produk);

        // Simpan ke DB juga
        $this->ModelCart->save([
            'id_user' => $id_user,
            'id_produk' => $produk['id'],
            'qty' => $produk['qty'],
            'price' => $produk['price'],
            'name' => $produk['name'],
            'warna' => $produk['options']['warna'],
            'nama_satuan' => $produk['options']['nama_satuan'],
            'gambar_produk' => $produk['options']['gambar_produk'],
        ]);
    
        return redirect()->to(base_url('store'));
    }

    public function clear()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
        $this->ModelCart->deleteCartByUser(session()->get('id_user'));
        return redirect()->to(base_url('store/cart'));
    }

    // mengupdate detail isi keranjang
    public function update()
    {
        $cart = \Config\Services::cart();
        $i = 1;
        foreach ($cart->contents() as $key => $value) {
            $cart->update(array(
                'rowid'   => $value['rowid'],
                'qty'     => $this->request->getPost('qty' . $i++),
            ));
        }
        return redirect()->to(base_url('store/cart'));
    }

    public function delete($rowid)
    {
        $cart = \Config\Services::cart();
        $cart->remove($rowid);
        return redirect()->to(base_url('store/cart'));
    }
}
