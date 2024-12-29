<?php
include '../../database/connect_pdo.php'; 
session_start();

// Lấy thông tin người dùng từ session
$username = $_SESSION['username'];
$full_name = $_SESSION['full_name'];

try {
    // Lấy dữ liệu từ bảng management
    $stmt = $pdo->prepare("SELECT * FROM management WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage());
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../assets/images/logo1.png" type="image/png">
    <title> HMP Home </title>
    <link rel="stylesheet" href="../../assets/fonts/googleapis.css">
    <link rel="stylesheet" href="../../src/css/home.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.7.2/css/all.min.css">
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>Thứ tự</th>
                <th>Tiêu đề</th>
                <th>Thông tin</th>
                <th>Người sở hữu</th>
                <th>Tải xuống</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($row): ?>
                    <tr data-public-key="<?php echo htmlspecialchars($row['public_key']); ?>">
                        <td>1</td>
                        <td>Public Key</td>
                        <td><a href="#" class="xemlink">Xem</a></td>
                        <td><?php echo htmlspecialchars($full_name); ?></td>
                        <td><a href="#" class="downloadLink">Download</a></td>
                    </tr>
                    <tr data-private-key="<?php echo htmlspecialchars($row['private_key']); ?>">
                        <td>2</td>
                        <td>Private Key</td>
                        <td><a href="#" class="xemlink">Xem</a></td>
                        <td><?php echo htmlspecialchars($full_name); ?></td>
                        <td><a href="#" class="downloadLink">Download</a></td>
                    </tr>
            <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Chưa có dữ liệu</td>
                    </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Hộp thoại khi nhấn vào Xem, d nghĩa là dynamic - nội dung động -->
    <div id="dynamicModal2" class="dmodal2"> 
        <div class="dmodal2-content">
            <span class="dclose2"><i class="fa-solid fa-xmark"></i></span>
            <h3>Thông tin khóa</h3>
            <p id="dmodal2Content">Nội dung</p>
        </div>
    </div>

    <script src="../../src/js/script.js"></script>

</body>
</html>