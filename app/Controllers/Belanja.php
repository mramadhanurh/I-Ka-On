<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Belanja extends BaseController
{
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
        $cart = \Config\Services::cart();

        $cart->insert(array(
            'id'      => $this->request->getPost('id'),
            'qty'     => $this->request->getPost('qty'),
            'price'   => $this->request->getPost('price'),
            'name'    => $this->request->getPost('name'),
            'options' => array(
                'gambar_produk' => $this->request->getPost('gambar_produk'),
                'nama_satuan' => $this->request->getPost('nama_satuan'),
            )
        ));
        return redirect()->to(base_url('store'));
    }

    public function clear()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
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
