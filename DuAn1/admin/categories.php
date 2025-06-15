<?php
require_once '../config/db.php';
$conn = connectDB();

$stmt = $conn->query("SELECT * FROM categories ORDER BY category_id DESC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<style>
    .category-container {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .category-container h2 {
        margin-bottom: 25px;
        color: #2c3e50;
        text-align: center;
    }

    .category-container a.add-btn {
        display: inline-block;
        background-color: #3498db;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
    }

    .category-container a.add-btn:hover {
        background-color: #2980b9;
    }

    table.category-table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    table.category-table th,
    table.category-table td {
        border: 1px solid #ddd;
        padding: 12px 15px;
    }

    table.category-table th {
        background-color: #f2f2f2;
        color: #2c3e50;
    }

    table.category-table td a {
        color: #2980b9;
        text-decoration: none;
        font-weight: bold;
    }

    table.category-table td a:hover {
        color: #e67e22;
        text-decoration: underline;
    }
</style>

<div class="category-container">
    <h2>Quản lý Danh mục</h2>

    <a href="category_add.php" class="add-btn">➕ Thêm danh mục</a>

    <table class="category-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['category_id'] ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td>
                        <a href="category_edit.php?id=<?= $cat['category_id'] ?>">Sửa</a> |
                        <a href="category_delete.php?id=<?= $cat['category_id'] ?>" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
