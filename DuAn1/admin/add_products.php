<?php
require '../config/db.php';
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Xử lý upload ảnh
    $image = $_FILES['image']['name'];
    $target_dir = "../assets/image/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (:name, :price, :image)");
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':image' => $image
        ]);
        header("Location: products.php");
        exit;
    } else {
        $error = "Upload ảnh thất bại!";
    }
}
?>

<?php include 'header.php'; ?>

<h2>Thêm sản phẩm</h2>

<?php if (isset($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <label>Tên sản phẩm:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Giá:</label><br>
    <input type="number" name="price" required><br><br>

    <label>Ảnh:</label><br>
    <input type="file" name="image" required><br><br>

    <button type="submit">Thêm sản phẩm</button>
</form>

<a href="products.php">Quay lại danh sách</a>

<?php include 'footer.php'; ?>
