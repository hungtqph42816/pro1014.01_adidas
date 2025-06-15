<?php
require '../config/db.php';
$conn = connectDB();

$stmt = $conn->prepare("SELECT o.*, u.name AS user_name
                        FROM orders o
                        LEFT JOIN user u ON o.user_id = u.user_id
                        ORDER BY o.order_date DESC");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<style>
    .order-container {
        max-width: 960px;
        margin: 40px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .order-container h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #2c3e50;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-table th,
    .order-table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .order-table th {
        background-color: #f2f2f2;
        color: #333;
    }

    .order-table td a {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    .order-table td a:hover {
        color: #e67e22;
        text-decoration: underline;
    }
</style>

<div class="order-container">
    <h2>Quản lý đơn hàng</h2>

    <table class="order-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người đặt</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Chi tiết</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['order_id'] ?></td>
                <td><?= htmlspecialchars($order['user_name'] ?? 'Chưa rõ') ?></td>
                <td><?= $order['order_date'] ?></td>
                <td><?= $order['status'] ?></td>
                <td><a href="order_detail.php?id=<?= $order['order_id'] ?>">Xem</a></td>
                <td><a href="edit_order_status.php?id=<?= $order['order_id'] ?>">Sửa</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
