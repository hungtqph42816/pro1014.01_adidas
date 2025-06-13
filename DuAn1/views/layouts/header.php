<?php
session_start();
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Store</title>
    <style>
        header {
            background-color: #1f1f1f;
            color: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 a {
            color: #fff;
            text-decoration: none;
            font-size: 28px;
            font-weight: bold;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #00f2fe;
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .user-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        /* Dropdown content (ẩn mặc định) */
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 40px;
            background-color: #2c2c2c;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 1000;
            min-width: 180px;
            padding: 12px;
        }

        .dropdown-content p {
            color: #ddd;
            font-weight: bold;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #444;
            padding-bottom: 6px;
        }

        .dropdown-content a {
            color: #eee;
            padding: 8px 0;
            display: block;
            font-size: 14px;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            color: #00f2fe;
        }

        .user-dropdown:hover .dropdown-content {
            display: block;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: flex-start;
            }

            nav {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <h1><a href="index.php">Shoe Store</a></h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="#">Liên hệ</a>
            <a href="#">Giới thiệu</a>
            <a href="cart.php">Giỏ hàng</a>

            <?php if (isset($_SESSION['user_name'])): ?>
            <div class="user-dropdown" onclick="toggleDropdown()">
                <img src="assets/image/user.png" alt="User Icon" class="user-icon">
                <div id="dropdownMenu" class="dropdown-content">
                    <p><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                    <a href="#">Lịch sử mua hàng</a>
                    <a href="logout.php">Đăng xuất</a>
                </div>
            </div>
            <?php else: ?>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<script>
    function toggleDropdown(){
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    }
    document.addEventListener("click", function(event){
        const dropdown = document.getElementById('dropdownMenu');
        const userDropdown = document.querySelector('.user-dropdown');
        if(!userDropdown.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>
</body>
</html>
