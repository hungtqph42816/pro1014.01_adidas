<?php
require_once 'config/db.php';
include 'views/layouts/header.php';
require_once 'controllers/productController.php';

$controller = new ProductController();
$route = $_GET['route'] ?? 'home';

if ($route === 'home') {
    $controller->index();
} elseif ($route === 'product_detail') {
    $controller->showDetail(); // Gọi hàm mới để hiển thị chi tiết
}

include 'views/layouts/footer.php';
