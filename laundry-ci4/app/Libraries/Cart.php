<?php

namespace App\Libraries;

class Cart
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        if (!$this->session->has('cart')) {
            $this->session->set('cart', []);
        }
    }

    /**
     * Menambah item ke keranjang belanja
     */
    public function insert($item)
    {
        $cart = $this->session->get('cart');
        
        // $item must contain: id, name, price, qty, unit
        $id = $item['id'];
        
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $item['qty'];
        } else {
            $cart[$id] = [
                'id'    => $item['id'],
                'name'  => $item['name'],
                'price' => floatval($item['price']),
                'qty'   => floatval($item['qty']),
                'unit'  => $item['unit']
            ];
        }
        
        $this->session->set('cart', $cart);
        return true;
    }

    /**
     * Mengubah quantity barang/layanan yang dipesan
     */
    public function update($id, $qty)
    {
        $cart = $this->session->get('cart');
        if (isset($cart[$id])) {
            $qty = floatval($qty);
            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $qty;
            }
            $this->session->set('cart', $cart);
            return true;
        }
        return false;
    }

    /**
     * Menghapus item dari cart
     */
    public function remove($id)
    {
        $cart = $this->session->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->session->set('cart', $cart);
            return true;
        }
        return false;
    }

    /**
     * Menghitung total
     */
    public function total()
    {
        $cart = $this->session->get('cart');
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    /**
     * Mengkosongkan keranjang belanja
     */
    public function destroy()
    {
        $this->session->set('cart', []);
        return true;
    }

    /**
     * Mengambil seluruh item di dalam cart
     */
    public function getItems()
    {
        return $this->session->get('cart') ?? [];
    }
}
