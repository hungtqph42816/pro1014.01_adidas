<?php
require_once 'models/Product.php';
require_once 'core/Session.php';

class CartController {
    public function index() {
        $cart = Session::get('cart', []);
        require 'views/cart/index.php';
    }

    public function add() {
        $id = $_GET['id'] ?? 0;
        $product = Product::find($id);
        if ($product) {
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'id' => $id,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1
                ];
            }
            Session::set('cart', $cart);
        }
        header('Location: /cart');
    }

    public function remove() {
        $id = $_GET['id'] ?? 0;
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::set('cart', $cart);
        header('Location: /cart');
    }

    public function update() {
        $quantities = $_POST['quantities'] ?? [];
        $cart = Session::get('cart', []);
        foreach ($quantities as $id => $qty) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, intval($qty));
            }
        }
        Session::set('cart', $cart);
        header('Location: /cart');
    }
}