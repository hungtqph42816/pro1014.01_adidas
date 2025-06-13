<?php
require_once 'models/Product.php';

class ProductController {
    public function index() {
        $products = Product::getAll();
        require 'views/home.php';
    }
        public function showDetail() {
        require_once 'models/Product.php';
        $productModel = new Product();

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "ID sản phẩm không hợp lệ.";
            exit;
        }

        $id = (int) $_GET['id'];
        $product = $productModel->getProductById($id);

        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            exit;
        }

        include 'views/product_detail.php';
    }
}
?>