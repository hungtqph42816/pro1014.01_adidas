<?php
require '../config/db.php';
$conn = connectDB();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy ảnh cũ từ sản phẩm
    $stmt = $conn->prepare("SELECT image FROM products WHERE product_id = :id");
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && !empty($product['image'])) {
        $image_path = "../assets/image/" . $product['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // xoá file ảnh
        }
    }

    // Xoá sản phẩm khỏi CSDL
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: products.php");
exit;
