<?php
require_once 'config/db.php';
$conn = connectDB();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID sản phẩm không hợp lệ.";
    exit();
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Không tìm thấy sản phẩm.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm - <?php echo htmlspecialchars($product['name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f9f9f9;
        }

        .product-detail {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            display: flex;
            gap: 30px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .product-detail img {
            max-width: 400px;
            border-radius: 10px;
            object-fit: cover;
        }

        .product-info {
            flex: 1;
        }

        .product-info h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .price {
            font-size: 22px;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .description {
            margin-bottom: 20px;
        }

        .stock {
            margin-bottom: 15px;
            font-weight: bold;
            color: #555;
        }

        .add-to-cart form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        input[type="number"] {
            width: 70px;
            padding: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #27ae60;
        }

        a.back-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="product-detail">
        <img src="assets/image/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</div>
            <div class="description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></div>
            <div class="stock">Số lượng tồn kho: <?php echo (int)$product['stock_quantity']; ?></div>

            <div class="add-to-cart">
                <form method="POST" action="cart.php?action=add&id=<?php echo $product['product_id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo (int)$product['stock_quantity']; ?>">
                    <button type="submit">🛒 Thêm vào giỏ</button>
                </form>
                <div class="price" id="totalPrice">
                    <?php echo number_format($product['price'], 0, ',', '.'); ?> đ
                </div>
            </div>

            <a href="index.php" class="back-link">← Quay lại trang chủ</a>
        </div>
    </div>

    <script>
        const quantityInput = document.querySelector('input[name="quantity"]');
        const totalPriceEl = document.getElementById('totalPrice');
        const pricePerItem = <?= $product['price'] ?>;

        quantityInput.addEventListener('input', () => {
            const qty = parseInt(quantityInput.value) || 1;
            const total = pricePerItem * qty;
            totalPriceEl.textContent = total.toLocaleString('vi-VN') + ' đ';
        });
    </script>
</body>
</html>
