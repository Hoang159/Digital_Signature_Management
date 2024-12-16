<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Kiểm tra thông tin đăng nhập
    if ($user && password_verify($password, $user['password'])) {
        // Lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $user['id'];
        // Chuyển hướng đến file home.html
        header("Location: ../src/components/home.html");
        exit;
    } else {
        // Hiển thị thông báo lỗi nếu sai thông tin đăng nhập
        $error_message = "Tên đăng nhập hoặc mật khẩu sai!";
    }
}
include('../src/components/signin.html');
?>

