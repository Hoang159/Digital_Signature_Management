<?php
session_start(); // Bắt đầu phiên làm việc
require_once '../../database/db_account.php';  // Kết nối với database
require_once 'generate_rsa_keys.php'; // Tạo khóa RSA

// Kiểm tra nếu form được gửi qua POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $username = $_POST['username'];
    $email = $_POST['email'];

    try {
        // Kiểm tra nếu username đã tồn tại trong cơ sở dữ liệu
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Nếu người dùng đã tồn tại, tạo cặp khóa RSA 2048 bit
            $keys = generateRSAKeys(512); // Gọi hàm tạo khóa RSA
            $publickey = $keys['publickey']; // Lấy toàn bộ public key
            $privatekey = $keys['privatekey']; // Lấy toàn bộ private key

            // Cập nhật cơ sở dữ liệu với các khóa đầy đủ
            $updateStmt = $pdo->prepare("
                UPDATE users 
                SET public_key = :public_key, private_key = :private_key, email = :email, updated_at = NOW()
                WHERE username = :username
            ");
            $updateStmt->execute([
                ':username' => $username,
                ':public_key' => $publickey,  // Lưu toàn bộ public key
                ':private_key' => $privatekey, // Lưu toàn bộ private key
                ':email' => $email,  
            ]);

            // Lưu username vào session
            $_SESSION['username'] = $username;

            echo 'Cặp khóa đã được tạo và cập nhật thành công cho người dùng: ' . htmlspecialchars($username);
            echo '<br>Public Key: <pre>' . htmlspecialchars($publickey) . '</pre>';
            echo '<br>Private Key: <pre>' . htmlspecialchars($privatekey) . '</pre>';
            echo '<br>Username đã được lưu vào session.';
        } else {
            echo 'Không tìm thấy người dùng với username: ' . htmlspecialchars($username);
        }
    } catch (PDOException $e) {
        die('Lỗi khi truy vấn cơ sở dữ liệu: ' . $e->getMessage());
    }
} else {
    die('Phương thức không hợp lệ.');
}
?>
