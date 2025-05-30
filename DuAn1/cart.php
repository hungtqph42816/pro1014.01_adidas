<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Cập nhật số lượng
if (isset($_POST['update'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $_SESSION['cart'][$id]['quantity'] = max(1, intval($qty));
    }
    header("Location: cart.php");
    exit();
}

// Xóa sản phẩm
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f3f4f6;
            padding: 30px;
        }
        .cart-container {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
            padding: 30px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        thead {
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }
        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }
        tbody tr:hover {
            background-color: #f1f5f9;
        }
        .quantity-input {
            width: 60px;
            padding: 5px;
            text-align: center;
        }
        .remove-btn {
            color: red;
            text-decoration: none;
        }
        .cart-total {
            text-align: right;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }
        .actions button,
        .actions a {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
        }
        .update-btn {
            background-color: #3b82f6;
            color: white;
        }
        .checkout-btn {
            background-color: #10b981;
            color: white;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Giỏ Hàng Của Bạn</h2>

        <?php if (empty($_SESSION['cart'])): ?>
            <p>Giỏ hàng đang trống.</p>
        <?php else: ?>
            <form method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $id => $item):
                            $price = (float) preg_replace('/[^\d.]/', '', $item['price']);
                            $quantity = (int) $item['quantity'];
                            $subtotal = $price * $quantity;
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= number_format((float)$item['price']) ?> đ</td>
                            <td>
                                <input class="quantity-input" type="number" name="quantities[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="1">
                            </td>
                            <td><?= number_format((float)$subtotal) ?> đ</td>
                            <td><a class="remove-btn" href="?remove=<?= $id ?>">X</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-total">Tổng cộng: <?= number_format((float)$total) ?> đ</div>

                <div class="actions">
                    <button class="update-btn" type="submit" name="update">Cập nhật</button>
                    <a class="checkout-btn" href="checkout.php">Thanh toán</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
