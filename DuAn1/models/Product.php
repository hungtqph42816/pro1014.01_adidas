<?php
require_once 'core/Database.php';

class Product {
    public static function all() {
        $sql = "SELECT * FROM products";
        $stmt = Database::connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $stmt = Database::connect()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}