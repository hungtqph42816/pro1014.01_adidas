<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">🛒 Giỏ hàng của bạn</h2>

    <?php if (empty($cart)): ?>
        <div class="alert alert-warning">Giỏ hàng của bạn đang trống.</div>
        <a href="/" class="btn btn-primary">Quay lại mua hàng</a>
    <?php else: ?>
        <form method="post" action="/cart/update">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= number_format($item['price']) ?>đ</td>
                            <td style="width:120px;">
                                <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control">
                            </td>
                            <td><?= number_format($subtotal) ?>đ</td>
                            <td>
                                <a href="/cart/remove?id=<?= $item['id'] ?>" class="btn btn-sm btn-danger">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td colspan="2"><strong><?= number_format($total) ?>đ</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/" class="btn btn-secondary">← Tiếp tục mua hàng</a>
                <div>
                    <button type="submit" class="btn btn-success">Cập nhật giỏ hàng</button>
                    <a href="/checkout" class="btn btn-warning">Thanh toán</a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>