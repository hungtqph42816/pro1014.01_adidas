<?php
function connectDB() {
    $host = 'localhost';
    $dbname = 'shoestore'; 
    $username = 'root';
    $password = ''; 

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Lỗi kết nối: " . $e->getMessage());
    }
}
?>