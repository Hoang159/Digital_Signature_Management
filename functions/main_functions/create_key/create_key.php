<?php
session_start(); // Bắt đầu session
require_once '../../../database/connect_pdo.php';
require_once '../../../functions/main_functions/create_key/generate_rsa_keys.php'; // Tạo khóa RSA

// Kiểm tra nếu form được gửi qua POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $username = $_POST['account']; // Lấy từ input "Tên tài khoản"
    $name = $_POST['name'];        // Lấy từ input "Họ và tên"
    $address = $_POST['address'];  // Lấy từ input "Địa chỉ"
    $email = $_POST['email'];      // Lấy từ input "Email"
    $phone = $_POST['phone'];      // Lấy từ input "Số điện thoại"

    try {
        // Kiểm tra nếu username đã tồn tại trong cơ sở dữ liệu
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // Nếu người dùng chưa tồn tại, thêm vào cơ sở dữ liệu
            $keys = generateRSAKeys(512); // Gọi hàm tạo khóa RSA
            $publickey = $keys['publickey']; // Lấy toàn bộ public key
            $privatekey = $keys['privatekey']; // Lấy toàn bộ private key

            // Thêm người dùng mới
            $insertStmt = $pdo->prepare("
                INSERT INTO users (username, name, address, phone, email, public_key, private_key, created_at) 
                VALUES (:username, :name, :address, :phone, :email, :public_key, :private_key, NOW())
            ");
            $insertStmt->execute([
                ':username' => $username,
                ':name' => $name,
                ':address' => $address,
                ':phone' => $phone,
                ':email' => $email,
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
