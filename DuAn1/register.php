<?php
require_once 'config/db.php';
session_start();
$conn = connectDB();
$message = '';

// Kiểm tra form gửi đi
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Bảo mật mật khẩu bằng hash
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Kiểm tra email đã tồn tại chưa
    $check = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $check->execute([$email]);
    $result = $check->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $message = "⚠️ Email đã được sử dụng!";
    } else {
        // Thêm người dùng mới
        $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $hashedPassword])) {
            header("Location: login.php");
            exit();
        } else {
            $message = "❌ Đăng ký không thành công! Vui lòng thử lại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
</head>
<body>
    <div class="container">
        <h2>Đăng ký</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Họ và tên" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Mật khẩu" required><br>
            <button type="submit">Đăng ký</button>
        </form>
        <?php if ($message): ?>
            <p style="color:red;"><?php echo $message; ?></p>
        <?php endif; ?>
        <p>Đã có tài khoản? <a href="login.php">Đăng Nhập</a></p>
    </div>
</body>
</html>
<style>
    body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #4facfe, #00f2fe);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background: white;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

h2 {
    margin-bottom: 25px;
    color: #333;
}

form input {
    width: 100%;
    padding: 12px 0px;
    margin: 10px 0;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    transition: 0.3s ease;
}

form input:focus {
    border-color: #4facfe;
    outline: none;
    box-shadow: 0 0 5px rgba(79, 172, 254, 0.5);
}

button {
    width: 100%;
    padding: 12px;
    background-color: #4facfe;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #00c6ff;
}

p {
    margin-top: 15px;
    font-size: 14px;
    color: #444;
}

a {
    color: #4facfe;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

</style>

