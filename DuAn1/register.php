<?php
    require_once 'config/db.php';
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result -> num_rows > 0){
            $message = "Email đã được sử dụng!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $message = "Đăng ký không thành công!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
</head>
<fo>
    <h2>Đăng ký tài khoản</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Họ tên" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mật khẩu" required><br>
        <button type="submit">Đăng ký</button>
    </form>
    <p style="color:red;"><?= $message ?></p>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</body>
</html>