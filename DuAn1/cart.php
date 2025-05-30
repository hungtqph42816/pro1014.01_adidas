<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $item = [
        'name' => $_POST['product_name'],
        'price' => $_POST['product_price'],
        'img' => $_POST['product_img'],
        'quantity' => 1
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [$item];
    } else {
        $index = -1;
        foreach ($_SESSION['cart'] as $i => $cart_item) {
            if ($cart_item['name'] == $item['name']) {
                $index = $i;
                break;
            }
        }

        if ($index >= 0) {
            $_SESSION['cart'][$index]['quantity'] += 1;
        } else {
            $_SESSION['cart'][] = $item;
        }
    }

    header("Location: cart.php"); // Quay lại trang giỏ hàng sau khi thêm
    exit;
}
?>
<h2>Giỏ hàng</h2>
<?php if (!empty($_SESSION['cart'])): ?>
    <ul>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <li>
                <img src="assets/image/<?php echo $item['img']; ?>" width="100">
                <p><?php echo $item['name']; ?></p>
                <p>Giá: <?php echo $item['price']; ?></p>
                <p>Số lượng: <?php echo $item['quantity']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Giỏ hàng trống.</p>
<?php endif; ?>

