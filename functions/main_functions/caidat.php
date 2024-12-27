<?php
session_start(); // Bắt đầu session
require_once '../../../database/connect_pdo.php';
// require_once '../../../functions/main_functions/create_key/generate_rsa_keys.php'; // Tạo khóa RSA (nếu cần)

// Kiểm tra nếu form được gửi qua POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $username = $_POST['account'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Kiểm tra và làm sạch dữ liệu (ví dụ: sử dụng hàm htmlspecialchars)
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    // ... tương tự cho các trường còn lại

    // Chuẩn bị câu lệnh SQL
    $stmt = $pdo->prepare("UPDATE users SET name = :name, address = :address, email = :email, phone = :phone WHERE username = :username");

    // Gán giá trị cho các tham số
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':username', $username);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "Thông tin cá nhân đã được cập nhật thành công!";
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.";
    }
}