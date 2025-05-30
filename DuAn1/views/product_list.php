<div class="container">
    <h2 class="section-title">Danh sách sản phẩm</h2>
    <div class="product-grid">
        
        <?php
        $products = [
            ["name" => "Giày chạy bộ Yueying", "img" => "giày chạy bộ Yueying.jpg", "price" => "850.000đ"],
            ["name" => "Giày thể thao", "img" => "giày thể thao.jpg", "price" => "950.000đ"],
            ["name" => "Giày kiểu sĩ", "img" => "giày kiểu sĩ.webp", "price" => "990.000đ"],
            ["name" => "Giày lười", "img" => "giày lười.jpg", "price" => "870.000đ"],
            ["name" => "Giày pickleball", "img" => "giày pickleball.webp", "price" => "1.100.000đ"],
            ["name" => "Giày sneaker", "img" => "giày sneaker.webp", "price" => "1.200.000đ"],
            ["name" => "Giày tây", "img" => "giày tây.webp", "price" => "1.300.000đ"]
        ];

foreach ($products as $product) {
    echo '<form action="cart.php" method="post">';
    echo '<div class="product-card">';
    echo '<img src="assets/image/' . $product["img"] . '" alt="' . $product["name"] . '">';
    echo '<h3>' . $product["name"] . '</h3>';
    echo '<p class="price">' . $product["price"] . '</p>';
    echo '<input type="hidden" name="product_name" value="' . $product["name"] . '">';
    echo '<input type="hidden" name="product_price" value="' . $product["price"] . '">';
    echo '<input type="hidden" name="product_img" value="' . $product["img"] . '">';
    echo '<button type="submit" name="add_to_cart">Thêm vào giỏ hàng</button>';
    echo '</div>';
    echo '</form>';
}

        ?>
    </div>
</div>

