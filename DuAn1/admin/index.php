<?php
session_start();
include 'header.php';
?>
<style>
    .admin-dashboard {
        max-width: 800px;
        margin: 40px auto;
        padding: 40px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        text-align: center;
    }

    .admin-dashboard h2 {
        font-size: 28px;
        margin-bottom: 10px;
        color: #2c3e50;
        font-weight: 700;
    }

    .admin-dashboard p {
        font-size: 16px;
        color: #7f8c8d;
        margin-bottom: 30px;
    }

    .admin-links {
        display: flex;
        flex-direction: column;
        gap: 16px;
        padding: 0;
        margin: 0 auto;
        max-width: 300px;
        list-style: none;
    }

    .admin-links a {
        display: block;
        background: #3498db;
        color: #fff;
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        transition: background 0.3s;
    }

    .admin-links a:hover {
        background: #2980b9;
    }
</style>

<div class="admin-dashboard">
    <h2>Chào, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?> 👋</h2>
    <p>Chào mừng bạn đến với bảng điều khiển quản trị</p>
    <ul class="admin-links">
        <li><a href="products.php">🛍️ Quản lý sản phẩm</a></li>
        <li><a href="categories.php">📂 Quản lý danh mục</a></li>
        <li><a href="orders.php">📦 Quản lý đơn hàng</a></li>
    </ul>
</div>

<?php include 'footer.php'; ?>
