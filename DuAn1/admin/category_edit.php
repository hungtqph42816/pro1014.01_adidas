<?php
require_once '../config/db.php';
$conn = connectDB();

if (!isset($_GET['id'])) {
    die("Thiếu ID danh mục.");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die("Không tìm thấy danh mục.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $update = $conn->prepare("UPDATE categories SET name = ? WHERE category_id = ?");
        $update->execute([$name, $id]);
        header("Location: categories.php");
        exit;
    }
}
?>

<?php include 'header.php'; ?>
<h2>Chỉnh sửa danh mục</h2>
<form method="post">
    <label>Tên danh mục:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
    <br><br>
    <button type="submit">Cập nhật</button>
    <a href="categories.php">Hủy</a>
</form>
<?php include 'footer.php'; ?>
