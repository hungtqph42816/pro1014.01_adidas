<?php
    require_once 'config/db.php';
    session_start();
    $message = '';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = trim($_POST['name']);
        $password = trim($_POST['password']);

        $stmt = $conn->prepare("SELECT * FROM user WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();  
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password"])){
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_role"] = $user["role"];
            header("Location: index.php");
            exit();
        } else {
            $message = "Tên đăng nhập hoặc mật khẩu không đúng!";
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
    <input type="text" name="name" placeholder="Tên đăng nhập" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
        <button type="submit">Đăng nhập</button>
    </form>
    <p style="color:red;"><?php echo $message; ?></p>
    <p>Chưa có tài khoản?<a href="register.php">Đăng Ký</a></p>
    </div>
</body>
</html>
