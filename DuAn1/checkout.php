<?php
session_start();
require_once 'config/db.php';

$conn = connectDB();
$cart = $_SESSION['cart'] ?? [];
$totalAmount = 0;
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    foreach ($cart as $product_id => $item) {
        $quantity = (int)$item['quantity'];

        // Lấy số lượng tồn kho hiện tại
        $stmt = $conn->prepare("SELECT stock_quantity FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $error = "Sản phẩm không tồn tại (ID: $product_id).";
            break;
        }

        $stock = (int)$product['stock_quantity'];

        if ($stock < $quantity) {
            $error = "Không đủ hàng cho sản phẩm \"{$item['name']}\".";
            break;
        }

        // Trừ tồn kho
        $newStock = $stock - $quantity;
        $update = $conn->prepare("UPDATE products SET stock_quantity = ? WHERE product_id = ?");
        $update->execute([$newStock, $product_id]);
    }

    if (empty($error)) {
        unset($_SESSION['cart']);
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f7f7f7;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h1, h2 {
            text-align: center;
            color: #27ae60;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        td img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        .total {
            font-weight: bold;
            color: #e74c3c;
        }

        .btn, .checkout-btn {
            background-color: #2ecc71;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto 0;
            text-align: center;
        }

        .btn:hover, .checkout-btn:hover {
            background-color: #27ae60;
        }

        .success-message, .error-message {
            background: #dff0d8;
            color: #155724;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            border: 1px solid #c3e6cb;
            margin-bottom: 20px;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($success): ?>
            <div class="success-message">
                <h2>🎉 Thanh toán thành công!</h2>
                <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi.</p>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 3000);
            </script>

        <?php elseif (!empty($error)): ?>
            <div class="error-message">
                <strong>Lỗi:</strong> <?= htmlspecialchars($error) ?>
                <p><a class="btn" href="cart.php">Quay lại giỏ hàng</a></p>
            </div>

        <?php elseif (empty($cart)): ?>
            <h2>🛒 Giỏ hàng trống!</h2>
            <p><a href="index.php" class="btn">← Quay lại trang chủ</a></p>

        <?php else: ?>
            <h1>Thông tin đơn hàng</h1>
            <table>
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): 
                        $itemTotal = $item['price'] * $item['quantity'];
                        $totalAmount += $itemTotal;
                    ?>
                    <tr>
                        <td>
                            <img src="assets/image/<?= htmlspecialchars($item['image'] ?? 'no-image.png') ?>" 
                                 alt="<?= htmlspecialchars($item['name'] ?? 'Sản phẩm') ?>">
                        </td>
                        <td><?= htmlspecialchars($item['name'] ?? '') ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($itemTotal, 0, ',', '.') ?> đ</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="total">Tổng cộng:</td>
                        <td class="total"><?= number_format($totalAmount, 0, ',', '.') ?> đ</td>
                    </tr>
                </tbody>
            </table>
            <form method="POST">
                <button type="submit" name="checkout" class="checkout-btn">Xác nhận thanh toán</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
