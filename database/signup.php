<?php
include 'connect_pdo.php';
session_start();

// Khởi tạo biến lưu thông báo lỗi hoặc thành công
$username = '';
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $address = $_POST['address'];
    // Kiểm tra mật khẩu xác nhận
    if ($password !== $confirm_password) {
        $error_message = "Mật khẩu và xác nhận mật khẩu không khớp.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra tên người dùng đã tồn tại
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user || $username == "admin") {
            $error_message = "Tên đăng nhập đã tồn tại. Vui lòng thử lại!";
        } else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name, email, phonenumber, address) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $hashed_password, $full_name, $email, $phonenumber, $address]);
            header("Location: ../database/signin.php");
            exit;
            
        }
    }
}
include('../src/components/signup.html');
?>