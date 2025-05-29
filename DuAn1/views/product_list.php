<?php
    require_once 'config/db.php';
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
?>

<?php include 'views/layouts/header.php';?>

<div class="container">
        <h2 style="text-align: center;">Tất Cả Sản Phẩm Nổi Bật</h2>
    <div class="product-grid">
        <?php
        while ($row =$result->fetch_assoc()):?>
            <div class="product-item">
                <img src="/assets/images/<?= $row['product_id'] ?>" alt="/">
                <h3><?= $row['name'] ?></h3>
                <p class="Giá"><?= number_format($row['price']) ?> VNĐ</p>
                <a href="/views/product_detail.php?id=<?= $row['product_id'] ?>" class="btn">Xem Chi Tiết</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php';?>

