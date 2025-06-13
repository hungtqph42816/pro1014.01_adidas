<div class="banner-wrapper">
  <div class="banner-slide active">
    <img src="assets/image/giay_kieu_si.jpg" alt="Giày kiểu sĩ">
  </div>
  <div class="banner-slide">
    <img src="assets/image/giay_the_thao.jpg" alt="Giày thể thao">
  </div>
  <div class="banner-slide">
    <img src="assets/image/giay_luoi.jpg" alt="Giày lười">
  </div>
</div>
<div class="container1">
  <h2 class="section-title">Sản phẩm mới nhất</h2>
  <div class="product-grid">
    <?php foreach ($products as $product): ?>
      <div class="product-card">
        <img src="assets/image/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <p><?= number_format($product['price']) ?>₫</p>
        <a class="btn" href="index.php?route=product_detail&id=<?= $product['product_id'] ?>">Xem chi tiết</a>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<style>
  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f9f9f9;
    overflow-x: hidden;
  }
  .container1{
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
  }

  .section-title {
    text-align: center;
    font-size: 24px;
    margin-bottom: 30px;
    color: #333;
  }

  .banner-wrapper {
    position: relative;
    width: 100%;
    max-width: 1200px;
    height: 400px;
    margin: 30px auto;
    overflow: hidden;
    border-radius: 12px;
  }

  .banner-slide {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
  }

  .banner-slide.active {
    opacity: 1;
    z-index: 1;
  }

  .banner-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
  }

  .product-card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
  }

  .product-card:hover {
    transform: translateY(-5px);
  }

  .product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    display: block;
  }

  .product-card h3 {
    margin: 10px 0 5px;
    font-size: 18px;
    color: #333;
  }

  .product-card p {
    color: #00c6ff;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .btn {
    display: inline-block;
    padding: 8px 16px;
    margin: 5px 4px;
    background-color: #4facfe;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease;
  }

  .btn:hover {
    background-color: #00c6ff;
  }

  .main-footer {
    background: #333;
    color: white;
    padding: 20px 0;
    text-align: center;
  }
</style>

<script>
  let currentBanner = 0;
  const bannerSlides = document.querySelectorAll('.banner-slide');

  setInterval(() => {
    bannerSlides[currentBanner].classList.remove('active');
    currentBanner = (currentBanner + 1) % bannerSlides.length;
    bannerSlides[currentBanner].classList.add('active');
  }, 3000);
</script>
