<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản trị Admin</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
    color: #333;
}

header {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: #fff;
    padding: 24px 0;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

header h1 {
    margin: 0;
    font-size: 32px;
    font-weight: 700;
    letter-spacing: 1px;
}

nav {
    background-color: #fff;
    display: flex;
    justify-content: center;
    padding: 14px 0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    position: sticky;
    top: 0;
    z-index: 1000;
}

nav a {
    color: #2c3e50;
    text-decoration: none;
    margin: 0 20px;
    font-weight: 500;
    font-size: 16px;
    position: relative;
    padding-bottom: 4px;
    transition: color 0.3s;
}

nav a:hover {
    color: #f39c12;
}

nav a::after {
    content: "";
    display: block;
    width: 0;
    height: 2px;
    background: #f39c12;
    transition: width 0.3s ease;
    position: absolute;
    bottom: 0;
    left: 0;
}

nav a:hover::after {
    width: 100%;
}

.container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}
</style>

</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <nav>
        <a href="../index.php">Trang chủ</a>
        <a href="index.php">Dashboard</a>
        <a href="products.php">Sản phẩm</a>
        <a href="categories.php">Danh mục</a>
        <a href="orders.php">Đơn hàng</a>
        <a href="users.php">Người dùng</a>
    </nav>
    <div class="container">
