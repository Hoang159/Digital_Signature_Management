<?php
include '../../database/connect_pdo.php';
// Truy vấn management
$sql = "SELECT * FROM management";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$mana = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    if (!empty($username)) {
            // Xóa trong bảng "management"
            $query = "DELETE FROM management WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header("Location: ../../src/components/admin_home.html");
                exit;
            } else {
                
                echo "Lỗi: Không thể xóa";
            }
        }       
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../assets/images/logo1.png" type="image/png">
    <title>HMP Admin Home</title>
    <link rel="stylesheet" href="../../assets/fonts/googleapis.css">
    <link rel="stylesheet" href="../../src/css/admin_home.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.7.2/css/all.min.css">
</head>
<body>
    <div class="table-management">
        <h3>Các tài khoản đã được cấp bộ khóa</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Số thứ tự</th>
                    <th>Chủ sở hữu</th>
                    <th>Họ và tên</th>
                    <th>Số điện thoại</th>
                    <th>Public Key</th>
                    <th class="button-cell">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mana)): ?>
                    <?php foreach ($mana as $index => $manas): ?>
                        <tr public-key-user="<?php echo htmlspecialchars($manas['public_key']); ?>">
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($manas['username']) ?></td>
                            <td><?= htmlspecialchars($manas['full_name']) ?></td>
                            <td><?= htmlspecialchars($manas['phonenumber']) ?></td>
                            <td><a href="#" class="xemlink">Xem</a></td>

                            <td class="button-cell">

                            <form action="../../functions/admin/admin_quanly.php" method="POST">
                            <input type="hidden" name="username" value="<?= htmlspecialchars($manas['username']) ?>" />
                                <button data-id="<?= $manas['id'] ?>" class="delete-button">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="no-data" colspan="6">Chưa có dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Hộp thoại khi nhấn vào Xem -->
    <div id="dynamicModal" class="dmodal">
        <div class="dmodal-content">
            <span class="dclose"><i class="fa-solid fa-xmark"></i></span>
            <h3>Thông tin chi tiết</h3>
            <p id="dmodalContent">Nội dung</p>
        </div>
    </div>

    <script src="../../src/js/script.js"></script>
</body>
</html>
