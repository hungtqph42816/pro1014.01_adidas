<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
</head>
<body>
    <h1>🛒 Giỏ hàng</h1>
    <?php if (empty($cart)): ?>
        <p>Giỏ hàng của bạn đang trống.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            <?php
                $total = 0;
                foreach ($cart as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
            ?>
            <tr>
                <td><img src="uploads/<?= htmlspecialchars($item['image']) ?>" width="60"></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" align="right"><strong>Tổng cộng:</strong></td>
                <td><strong><?= number_format($total, 0, ',', '.') ?>₫</strong></td>
            </tr>
        </table>
    <?php endif; ?>
    <p><a href="index.php">← Tiếp tục mua sắm</a></p>
</body>
</html>
