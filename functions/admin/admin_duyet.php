<?php
include '../../database/connect_pdo.php'; 
include '../main_functions/create_key/generate_rsa_keys.php';

// Truy vấn request
$sql = "SELECT * FROM request";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $username = trim($_POST['username'] ?? '');

    if ($action === 'reject' && !empty($username)) {
        // Cập nhật bảng "noti"
        $query1 = "UPDATE noti SET answer = 1 WHERE username = :username";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(':username', $username, PDO::PARAM_STR);

        if ($stmt1->execute()) {
            // Xóa trong bảng "request"
            $query = "DELETE FROM request WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header("Location: ../../src/components/admin_home.html");
                exit;
            } else {
                
                echo "Lỗi: Không thể từ chối";
            }
        } else {
            // Lỗi khi cập nhật thông báo
            echo "Lỗi: Không thể cập nhật thông báo";
        }
    } else if ($action === 'accept' && !empty($username)) {

        // Lấy thông tin từ bảng request
        $query = "SELECT full_name, email, phonenumber, address FROM request WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $request_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($request_data) {
            // Tạo giá trị ngẫu nhiên
            // $public_key = random_int(1, 99);  
            // $private_key = random_int(1, 99);

            $sql = "UPDATE users SET is_registered = 2 WHERE username = :username";
            $stmt1 = $pdo->prepare($sql);
            $stmt1->bindParam(':username', $username );
            $stmt1->execute();

            $keys = generateRSAKeys(512); // Gọi hàm tạo khóa RSA
            $public_key = $keys['public_key']; // Lấy toàn bộ public key
            $private_key = $keys['private_key']; // Lấy toàn bộ private key
    
            // Chèn vào bảng 'management'
            $query = "INSERT INTO management (full_name, username, email, phonenumber, address, public_key, private_key) 
                      VALUES (:full_name, :username, :email, :phonenumber, :address, :public_key, :private_key)";
    
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':full_name', $request_data['full_name'], PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $request_data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':phonenumber', $request_data['phonenumber'], PDO::PARAM_STR);
            $stmt->bindParam(':address', $request_data['address'], PDO::PARAM_STR);
            $stmt->bindParam(':public_key', $public_key, PDO::PARAM_STR);
            $stmt->bindParam(':private_key', $private_key, PDO::PARAM_STR);
    
            if ($stmt->execute()) {
                // Xóa yêu cầu trong bảng request
                $query1 = "DELETE FROM request WHERE username = :username";
                $stmt1 = $pdo->prepare($query1);
                $stmt1->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt1->execute();
                
                header("Location: ../../src/components/admin_home.html");
                exit;
            } else {
                echo "Lỗi khi chèn dữ liệu vào bảng management.";
            }
        } else {
            echo "Không tìm thấy yêu cầu cho username: $username.";
        }
    }
    
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../assets/images/logo1.png" type="image/png">
    <title> HMP Admin Home </title>
    <link rel="stylesheet" href="../../assets/fonts/googleapis.css">
    <link rel="stylesheet" href="../../src/css/admin_home.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.7.2/css/all.min.css">
</head>

<body>

    <div class="table-request">
        <h3> Các yêu cầu nhận bộ khóa </h3>
        <table class="table">
            <thead>
                <tr>
                    <th> Tài khoản yêu cầu </th>
                    <th> Họ và tên </th>
                    <th> Email </th>
                    <th> Số điện thoại </th>
                    <th class="button-cell"> Chấp nhận </th>
                    <th class="button-cell"> Từ chối </th>
                </tr>
            </thead>
            
            <tbody>
                <?php if (!empty($requests)): ?>
                    <?php foreach ($requests as $request): ?>
                        <tr>
                            <!-- <td class="no-data" colspan="4"> Chưa có dữ liệu </td> -->
                            <td> <?= htmlspecialchars($request['username']) ?> </td>
                            <td> <?= htmlspecialchars($request['full_name']) ?> </td>
                            <td> <?= htmlspecialchars($request['email']) ?> </td>
                            <td> <?= htmlspecialchars($request['phonenumber']) ?> </td>
                            <!-- <td><a href="#"> Duyệt </a></td>
                            <td><a href="#"> Hủy </a></td> -->
                            <td class="button-cell"> 

                            <form action="../../functions/admin/admin_duyet.php" method="POST">
                                <input type="hidden" name="action" value="accept" />
                                <input type="hidden" name="username" value="<?= htmlspecialchars($request['username']) ?>" />
                                <button ><i class="fa-solid fa-check"></i></button>
                            </form>
                            
                            </td>
                            <td class="button-cell"> 

                               <form action="../../functions/admin/admin_duyet.php" method="POST">
                                <input type="hidden" name="action" value="reject" />
                                <input type="hidden" name="username" value="<?= htmlspecialchars($request['username']) ?>" />
                                <button ><i class="fa-solid fa-xmark"></i></button>
                                </form>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Chưa có dữ liệu</td>
                        </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    

</body>
</html>