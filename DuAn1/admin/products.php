<?php
require '../config/db.php'; // Kết nối PDO
$conn = connectDB();

$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<style>
    h2 {
        font-size: 26px;
        margin-bottom: 20px;
        color: #2c3e50;
        text-align: center;
    }

    .add-btn {
        display: inline-block;
        margin-bottom: 20px;
        background-color: #27ae60;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s;
    }

    .add-btn:hover {
        background-color: #219150;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #34495e;
        color: white;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    img {
        border-radius: 6px;
        max-height: 60px;
    }

    .action-links a {
        margin: 0 5px;
        text-decoration: none;
        color: #3498db;
        font-weight: bold;
        transition: color 0.2s;
    }

    .action-links a:hover {
        color: #e74c3c;
    }
</style>

<h2>📦 Danh sách sản phẩm</h2>
<a href="add_products.php" class="add-btn">➕ Thêm sản phẩm</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Ảnh</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $row): ?>
        <tr>
            <td><?= $row['product_id'] ?? '' ?></td>
            <td><?= htmlspecialchars($row['name'] ?? 'Chưa có tên') ?></td>
            <td><?= number_format($row['price'] ?? 0, 0, '.', '.') ?>đ</td>
            <td>
                <?php if (!empty($row['image'])): ?>
                    <img src="../assets/image/<?= htmlspecialchars($row['image']) ?>" alt="Ảnh sản phẩm">
                <?php else: ?>
                    <span style="color: #999;">Không có ảnh</span>
                <?php endif; ?>
            </td>
            <td><?= $row['stock_quantity'] ?? 0 ?></td>

            <td>
                <?php
                    $quantity = $row['stock_quantity'] ?? 0;
                    if ($quantity <= 0) {
                        echo '<span style="color: red; font-weight: bold;">Hết hàng</span>';
                    } elseif ($quantity <= 3) {
                        echo '<span style="color: orange;">Sắp hết</span>';
                    } else {
                        echo '<span style="color: green;">Còn hàng</span>';
                    }
                ?>
            </td>
            <td class="action-links">
                <?php if (isset($row['product_id'])): ?>
                    <a href="edit_products.php?id=<?= $row['product_id'] ?>">✏️ Sửa</a>
                    <a href="delete_products.php?id=<?= $row['product_id'] ?>" onclick="return confirm('Xoá sản phẩm này?')">🗑️ Xoá</a>
                <?php else: ?>
                    Không khả dụng
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
