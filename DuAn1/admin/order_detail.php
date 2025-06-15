<?php
require '../config/db.php';
$conn = connectDB();

if (!isset($_GET['id'])) {
    die("Thiếu ID đơn hàng.");
}
$orderId = $_GET['id'];

$stmt = $conn->prepare("SELECT o.*, u.name AS user_name
                        FROM orders o
                        LEFT JOIN user u ON o.user_id = u.user_id
                        WHERE o.order_id = :id");
$stmt->execute([':id' => $orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Không tìm thấy đơn hàng.");
}

$stmt = $conn->prepare("SELECT od.*, p.name AS product_name
                        FROM orderdetails od
                        JOIN products p ON od.product_id = p.product_id
                        WHERE od.order_id = :id");
$stmt->execute([':id' => $orderId]);
$details = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<style>
    .order-detail-container {
        max-width: 960px;
        margin: 40px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .order-detail-container h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .order-info p {
        font-size: 16px;
        color: #333;
        margin: 8px 0;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .order-table th, .order-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    .order-table th {
        background-color: #f8f8f8;
        color: #333;
    }

    .order-table td {
        background-color: #fafafa;
    }

    .back-link {
        display: inline-block;
        margin-top: 25px;
        text-decoration: none;
        color: #3498db;
        font-weight: bold;
    }

    .back-link:hover {
        color: #e67e22;
    }
</style>

<div class="order-detail-container">
    <h2>Chi tiết đơn hàng #<?= htmlspecialchars($order['order_id']) ?></h2>

    <div class="order-info">
        <p><strong>Người đặt:</strong> <?= htmlspecialchars($order['user_name'] ?? 'Không rõ') ?></p>
        <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>
    </div>

    <table class="order-table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($details as $item): 
                $subtotal = $item['quantity'] * $item['price'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= (int)$item['quantity'] ?></td>
                <td><?= number_format((float)$item['price'], 0, ',', '.') ?>đ</td>
                <td><?= number_format((float)$subtotal, 0, ',', '.') ?>đ</td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Tổng cộng</strong></td>
                <td><strong><?= number_format((float)$total, 0, ',', '.') ?>đ</strong></td>
            </tr>
        </tbody>
    </table>

    <a href="orders.php" class="back-link">← Quay lại</a>
</div>

<?php include 'footer.php'; ?>
