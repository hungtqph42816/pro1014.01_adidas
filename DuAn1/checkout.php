<?php
session_start();
include 'db_connect.php'; // Kết nối CSDL

if (isset($_POST['checkout'])) {
    if (empty($_SESSION['cart'])) {
        echo "Giỏ hàng trống. Không thể thanh toán!";
        exit;
    }

    $user_id = 1; // Tùy bạn, nếu có đăng nhập thì lấy từ $_SESSION
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Lưu vào bảng orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Lưu vào bảng order_items
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $stmt_item->bind_param("iidi", $order_id, $product_id, $item['price'], $item['quantity']);
        $stmt_item->execute();
    }

    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    // Chuyển sang trang cảm ơn
    header("Location: order_success.php?order_id=$order_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán</title>
</head>
<body>
    <h2>Thanh toán đơn hàng</h2>
    <form method="post">
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            <?php
            $total = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    echo "<tr>
                        <td>{$item['name']}</td>
                        <td>" . number_format($item['price']) . " VND</td>
                        <td>{$item['quantity']}</td>
                        <td>" . number_format($subtotal) . " VND</td>
                    </tr>";
                }
                echo "<tr>
                    <td colspan='3'><strong>Tổng cộng</strong></td>
                    <td><strong>" . number_format($total) . " VND</strong></td>
                </tr>";
            } else {
                echo "<tr><td colspan='4'>Giỏ hàng trống</td></tr>";
            }
            ?>
        </table>
        <br>
        <?php if (!empty($_SESSION['cart'])): ?>
            <button type="submit" name="checkout">Thanh toán</button>
        <?php endif; ?>
    </form>
</body>
</html>
