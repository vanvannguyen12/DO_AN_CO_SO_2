<?php
// config.php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "doan";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}

// Khởi động session ở đây để dùng chung cho toàn trang
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>