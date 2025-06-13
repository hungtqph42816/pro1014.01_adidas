<?php
require_once __DIR__ . '/../config/db.php'; // đường dẫn chính xác

class Product {
    public static function getAll() {
        $conn = connectDB(); // Lỗi ở đây nếu không require đúng

        $sql = "SELECT * FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductById($id) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>