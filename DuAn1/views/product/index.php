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
    <h2 class="mb-4 text-center">🛍️ Danh sách sản phẩm</h2>
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text text-muted mb-2"><?= number_format($product['price']) ?>đ</p>
                        <a href="/cart/add?id=<?= $product['product_id'] ?>" class="btn btn-primary mt-auto">Thêm vào giỏ</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
        <a href="/cart" class="btn btn-success">Xem giỏ hàng</a>
    </div>
</div>
</body>
</html>