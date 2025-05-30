<?php
    require_once 'config/db.php';
    session_start();
    $message = '';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();  
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password"])){
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_role"] = $user["role"];
            header("Location: ../index.php");
            exit();
        } else {
            $message = "Email hoặc mật khẩu không đúng!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Đăng nhập</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mật khẩu" required><br>
        <button type="submit">Đăng nhập</button>
    </form>
    <p style="color:red;"><? $message ?></p>
    <p>Chưa có tài khoản?<a href="register.php">Đăng Ký</a></p>
    </div>
</body>
</html>