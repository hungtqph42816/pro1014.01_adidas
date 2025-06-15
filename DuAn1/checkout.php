<?php
session_start();
require_once 'config/db.php';

$conn = connectDB();
$cart = $_SESSION['cart'] ?? [];
$totalAmount = 0;
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_checkout'])) {
    // Kiểm tra tồn kho và trừ hàng
    foreach ($cart as $product_id => $item) {
        $quantity = (int)$item['quantity'];

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

        $newStock = $stock - $quantity;
        $update = $conn->prepare("UPDATE products SET stock_quantity = ? WHERE product_id = ?");
        $update->execute([$newStock, $product_id]);
    }

    // Nếu không có lỗi thì tạo đơn hàng
    if (empty($error)) {
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $user_id = $_SESSION['user']['user_id'] ?? null;

        if ($user_id !== null) {
            $orderStmt = $conn->prepare("INSERT INTO orders (user_id, order_date, total_amount, status) VALUES (?, NOW(), ?, 'Đang xử lý')");
            $orderStmt->execute([$user_id, $totalAmount]);
        } else {
            $orderStmt = $conn->prepare("INSERT INTO orders (order_date, total_amount, status) VALUES (NOW(), ?, 'Đang xử lý')");
            $orderStmt->execute([$totalAmount]);
        }

        $order_id = $conn->lastInsertId();

        $detailStmt = $conn->prepare("INSERT INTO orderdetails (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart as $product_id => $item) {
            $detailStmt->execute([
                $order_id,
                $product_id,
                $item['quantity'],
                $item['price']
            ]);
        }

        unset($_SESSION['cart']);
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác Nhận Thanh Toán</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            padding: 40px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.05);
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .confirm-btn {
            background-color: #10b981;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
        }
        .success {
            padding: 20px;
            background-color: #d1fae5;
            border: 1px solid #34d399;
            color: #065f46;
            border-radius: 8px;
            text-align: center;
        }
        .error {
            padding: 20px;
            background-color: #fee2e2;
            border: 1px solid #f87171;
            color: #991b1b;
            border-radius: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($success): ?>
            <div class="success">
                <h2>Thanh toán thành công!</h2>
                <p>Đơn hàng của bạn đã được ghi nhận.</p>
                <p>Đang chuyển hướng về trang chủ...</p>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000);
            </script>
        <?php elseif (!empty($error)): ?>
            <div class="error">
                <h2>Lỗi khi thanh toán</h2>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php else: ?>
            <h2>Xác nhận thanh toán</h2>
            <table>
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
                    foreach ($cart as $item):
                        $subtotal = $item['quantity'] * $item['price'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price']) ?>đ</td>
                        <td><?= number_format($subtotal) ?>đ</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="total">Tổng cộng</td>
                        <td class="total"><?= number_format($total) ?>đ</td>
                    </tr>
                </tbody>
            </table>
            <form method="post">
                <button class="confirm-btn" type="submit" name="confirm_checkout">Xác nhận thanh toán</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
