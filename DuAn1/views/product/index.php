<?php
$products = Product::all();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">🛍️ Danh sách sản phẩm</h2>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text"><?= number_format($product['price']) ?>đ</p>
                        <a href="/cart/add?id=<?= $product['product_id'] ?>" class="btn btn-primary">Thêm vào giỏ</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="/cart" class="btn btn-success">Xem giỏ hàng</a>
</div>
</body>
</html>