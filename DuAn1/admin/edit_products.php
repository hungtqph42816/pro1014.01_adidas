<?php
require '../config/db.php';
$conn = connectDB();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("Thiếu hoặc sai định dạng ID sản phẩm.");
}

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock_quantity = $_POST['stock_quantity'] ?? 0;

    if (!empty($_FILES['image']['name'])) {
        $originalImage = $_FILES['image']['name'];
        $imageExtension = pathinfo($originalImage, PATHINFO_EXTENSION);
        $newImage = time() . '_' . uniqid() . '.' . $imageExtension;

        $target_dir = "../assets/image/";
        $target_file = $target_dir . $newImage;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            if (!empty($product['image'])) {
                $oldImagePath = $target_dir . $product['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price, image = :image, stock_quantity = :stock_quantity WHERE product_id = :id");
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':image' => $newImage,
                ':stock_quantity' => $stock_quantity,
                ':id' => $id
            ]);
        } else {
            $error = "Lỗi upload ảnh.";
        }
    } else {
        $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price, stock_quantity = :stock_quantity WHERE product_id = :id");
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':stock_quantity' => $stock_quantity,
            ':id' => $id
        ]);
    }

    if (!isset($error)) {
        header("Location: products.php");
        exit;
    }
}
?>

<?php include 'header.php'; ?>

<style>
    .form-wrapper {
        max-width: 500px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .form-wrapper h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #2c3e50;
    }

    .form-wrapper label {
        display: block;
        margin-top: 15px;
        font-weight: bold;
        color: #34495e;
    }

    .form-wrapper input[type="text"],
    .form-wrapper input[type="number"],
    .form-wrapper input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1.5px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        transition: border-color 0.3s ease;
    }

    .form-wrapper input:focus {
        border-color: #3498db;
        outline: none;
    }

    .form-wrapper button {
        width: 100%;
        padding: 12px;
        margin-top: 25px;
        background-color: #2ecc71;
        color: white;
        font-weight: bold;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-wrapper button:hover {
        background-color: #27ae60;
    }

    .form-wrapper img {
        margin-top: 10px;
        border-radius: 6px;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #2980b9;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .error-msg {
        color: red;
        font-size: 14px;
        text-align: center;
    }
</style>

<div class="form-wrapper">
    <h2>Sửa sản phẩm</h2>

    <?php if (isset($error)): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>

        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" value="<?= $product['price'] ?? 0 ?>" required>

        <label for="stock_quantity">Số lượng:</label>
        <input type="number" name="stock_quantity" id="stock_quantity" value="<?= $product['stock_quantity'] ?? 0 ?>" min="0" required>

        <label>Ảnh hiện tại:</label>
        <?php if (!empty($product['image'])): ?>
            <img src="../assets/image/<?= htmlspecialchars($product['image']) ?>" width="100" alt="Ảnh sản phẩm">
        <?php else: ?>
            <p>Không có ảnh</p>
        <?php endif; ?>

        <label for="image">Chọn ảnh mới (nếu muốn thay):</label>
        <input type="file" name="image" id="image">

        <button type="submit">Cập nhật sản phẩm</button>
    </form>

    <a class="back-link" href="products.php">← Quay lại danh sách sản phẩm</a>
</div>

<?php include 'footer.php'; ?>
