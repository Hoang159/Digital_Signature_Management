<?php
session_start(); // Bắt đầu session
require_once '../../database/connect_pdo.php';
require_once '../main_functions/create_key/generate_rsa_keys.php'; // Tạo khóa RSA

// Kiểm tra nếu form được gửi qua POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $username = $_POST['username'];             // Lấy từ input "Tên tài khoản"
    $full_name = $_POST['full_name'];           // Lấy từ input "Họ và tên"
    $email = $_POST['email'];                   // Lấy từ input "Email"
    $phonenumber = $_POST['phonenumber'];       // Lấy từ input "Số điện thoại"
    $address = $_POST['address'];               // Lấy từ input "Địa chỉ"

    try {
        // Kiểm tra nếu username đã tồn tại trong cơ sở dữ liệu
        $stmt = $pdo->prepare("SELECT * FROM management WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // Nếu người dùng chưa tồn tại, thêm vào cơ sở dữ liệu
            $keys = generateRSAKeys(512); // Gọi hàm tạo khóa RSA
            $publickey = $keys['publickey']; // Lấy toàn bộ public key
            $privatekey = $keys['privatekey']; // Lấy toàn bộ private key

            // Thêm người dùng mới
            $insertStmt = $pdo->prepare("
                INSERT INTO management (username, full_name, email, phonenumber, address, public_key, private_key, created_at) 
                VALUES (:username, :full_name, :email, :phonenumber, :address, :public_key, :private_key, NOW())
            ");
            $insertStmt->execute([
                ':username' => $username,
                ':full_name' => $full_name,
                ':email' => $email,
                ':phonenumber' => $phonenumber,
                ':address' => $address,
                ':public_key' => $publickey,  // Lưu toàn bộ public key
                ':private_key' => $privatekey // Lưu toàn bộ private key
            ]);

            // Lưu thông tin vào session
            $_SESSION['username'] = $username;

            echo 'Người dùng mới đã được thêm và cặp khóa RSA đã được tạo thành công!';
            echo '<br>Public Key: <pre>' . htmlspecialchars($publickey) . '</pre>';
            echo '<br>Private Key: <pre>' . htmlspecialchars($privatekey) . '</pre>';
        } else {
            echo 'Username đã tồn tại trong hệ thống: ' . htmlspecialchars($username);
        }
    } catch (PDOException $e) {
        die('Lỗi khi truy vấn cơ sở dữ liệu: ' . $e->getMessage());
    }
} else {
    die('Phương thức không hợp lệ.');
}
?>