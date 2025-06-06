<?php
require_once 'controllers/CartController.php';
require_once 'models/Product.php';

$uri = strtok($_SERVER['REQUEST_URI'], '?');
$method = $_SERVER['REQUEST_METHOD'];

if ($uri == '/' || $uri == '/products') {
    require 'views/product/index.php';
} elseif ($uri == '/cart') {
    $controller = new CartController();
    $controller->index();
} elseif ($uri == '/cart/add') {
    $controller = new CartController();
    $controller->add();
} elseif ($uri == '/cart/remove') {
    $controller = new CartController();
    $controller->remove();
} elseif ($uri == '/cart/update' && $method == 'POST') {
    $controller = new CartController();
    $controller->update();
} else {
    http_response_code(404);
    echo "404 Not Found";
}