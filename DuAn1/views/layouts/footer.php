<section class="product-galley">
    <h2>Sản phẩm nổi bật</h2>
    <div class="galley-row">
        <?php
        $imageDir = 'assets/image/';
        $images = glob($imageDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        $limitedImages = array_slice($images, 0, 6);
        foreach ($limitedImages as $image):
            $imageName = basename($image);
        ?>
            <div class="gallery-item">
                <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($imageName) ?>">
            </div>
        <?php endforeach; ?>
    </div>
</section>
<style>
    .product-galley {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .product-galley h2{
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }
    .galley-row{
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 16px;
        padding: 10px;
    }
    .gallery-item {
    flex: 0 0 auto;
    width: 180px;
    border-radius: 10px;
    overflow: hidden;
    background: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    }
    .gallery-item:hover {
        transform: scale(1.05);
    }
    .gallery-item img {
        width: 100%;
        height: 180px;
        display: block;
        object-fit: cover;
        border-bottom: 2px solid #00f2fe;
    }
</style>
<footer style="background: #222; color: #aaa; text-align: center; padding: 20px; margin-top: 40px;">
    <p>&copy; 2025 Shoe Adidas Store.</p>
</footer>
</body>
</html>
