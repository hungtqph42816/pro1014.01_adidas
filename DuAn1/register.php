<?php
require_once 'config/db.php';
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
    if (!$check) {
        die("Lỗi prepare: " . $conn->error);
    }
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $message = "⚠️ Email đã được sử dụng!";
    } else {
        // Thêm người dùng mới
        $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Lỗi prepare insert: " . $conn->error);
        }
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
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
    <link rel="stylesheet" href="assets/css/style.css">
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

