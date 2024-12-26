<?php
session_start(); // Bắt đầu phiên làm việc
require_once '../../database/db_account.php'; // Kết nối với database

// Kiểm tra nếu username tồn tại trong session
if (!isset($_SESSION['username'])) {
    echo 'Vui lòng đăng nhập để tiếp tục.';
    exit;
}

$username = $_SESSION['username']; // Lấy username từ session
$type = $_GET['type'] ?? ''; // Loại key (public hoặc private)

// Kiểm tra loại key hợp lệ
if (!in_array($type, ['public', 'private'])) {
    echo 'Loại key không hợp lệ.';
    exit;
}

try {
    // Truy vấn cơ sở dữ liệu để lấy key
    $stmt = $pdo->prepare("SELECT public_key, private_key FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo 'Người dùng không tồn tại.';
        exit;
    }

    // Lấy 50 ký tự đầu của key tương ứng
    $key = $type === 'public' ? $user['public_key'] : $user['private_key'];
    if (!$key) {
        echo ucfirst($type) . ' key không tồn tại.';
        exit;
    }

    // Hiển thị 50 ký tự đầu tiên
    echo "50 ký tự đầu của {$type} key:<br>";
    echo htmlspecialchars(substr($key, 0, 50)); // Bảo mật dữ liệu đầu ra
} catch (PDOException $e) {
    echo 'Lỗi truy vấn cơ sở dữ liệu: ' . htmlspecialchars($e->getMessage());
    exit;
}
?>