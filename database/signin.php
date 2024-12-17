<?php
include 'db_account.php'; // Kết nối cơ sở dữ liệu cho users

session_start(); 

$error_message = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']); 
    $password = $_POST['password'];

    // 1. Kiểm tra trong cơ sở dữ liệu users
    $stmt_users = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt_users->execute([$username]);
    $user = $stmt_users->fetch();

    // 2. Kiểm tra trong cơ sở dữ liệu admin
    $stmt_admin = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt_admin->execute([$username]);
    $admin = $stmt_admin->fetch();

    // 3. Xác thực tài khoản
    if ($user && password_verify($password, $user['password'])) {
        // Lưu thông tin người dùng
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'user'; 

        // Chuyển hướng đến trang home cho user
        header("Location: ../src/components/home.html");
        exit; 
    } elseif ($admin && $password == $admin['password']) {
        // Lưu thông tin admin
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = 'admin';

        // Chuyển hướng đến trang admin_home
        header("Location: ../src/components/admin_home.html");
        exit; 
    } else {
        // Sai thông tin đăng nhập
        $error_message = "Tên đăng nhập hoặc mật khẩu sai!";
    }
}

include('../src/components/signin.html'); 
?>
