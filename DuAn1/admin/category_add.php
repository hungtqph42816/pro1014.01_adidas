<?php
require_once '../config/db.php';
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
        header("Location: categories.php");
        exit;
    }
}
?>

<?php include 'header.php'; ?>
<h2>Thêm danh mục</h2>
<form method="post">
    <label>Tên danh mục:</label>
    <input type="text" name="name" required>
    <br><br>
    <button type="submit">Thêm</button>
    <a href="categories.php">Hủy</a>
</form>
<?php include 'footer.php'; ?>
