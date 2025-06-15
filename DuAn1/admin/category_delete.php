<?php
require_once '../config/db.php';
$conn = connectDB();

if (!isset($_GET['id'])) {
    die("Thiếu ID danh mục.");
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
$stmt->execute([$id]);

header("Location: categories.php");
exit;
