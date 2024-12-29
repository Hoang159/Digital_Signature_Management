<?php
include '../../database/connect_pdo.php';
session_start();
// Lấy thông tin người dùng từ session
$username = $_SESSION['username'];
$full_name = $_SESSION['full_name'];
$address = $_SESSION['address'];
$email = $_SESSION['email'];
$phonenumber = $_SESSION['phonenumber'];

// Kiểm tra nếu đã đăng ký hay chưa
$checkQuery = "SELECT COUNT(*) FROM request WHERE username = :username ";
$checkStmt = $pdo->prepare($checkQuery);
$checkStmt->bindParam(':username', $username, PDO::PARAM_STR);
$checkStmt->execute();
$checkrequest = $checkStmt->fetchColumn();

// Kiểm tra trong bảng users

$userQuery = "SELECT is_registered FROM users WHERE username = :username";
$userStmt = $pdo->prepare($userQuery);
$userStmt->bindParam(':username', $username, PDO::PARAM_STR);
$userStmt->execute();
$is_registered = $userStmt->fetchColumn();

// Kiểm tra answer trong noti
$answerQuery = "SELECT answer  FROM noti  WHERE username = :username ";
$answerStmt = $pdo->prepare($answerQuery);
$answerStmt->bindParam(':username', $username, PDO::PARAM_STR);
$answerStmt->execute();
$answer = $answerStmt->fetchColumn();

//$requestData = [];
if ($answer == 0 || $answer === NULL){
if ($checkrequest > 0 && $is_registered == 0 ) {
    // Nếu đã đăng ký rồi, thông báo
    $success_message = "Đã đăng ký thành công ";
    $formSubmitted = true;
     // Nếu đã đăng ký, lấy dữ liệu đánh giá từ bảng 'request'
    // $fetchrequestQuery = "SELECT full_name, username, email, phonenumber, address FROM request WHERE username = :username ";
    // $fetchStmt = $pdo->prepare($fetchrequestQuery);
    // $fetchStmt->bindParam(':username', $username, PDO::PARAM_STR);
    // $fetchStmt->execute();
    // $requestData = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    // if ($requestData) {
    //     $formSubmitted = true;
    // } else {
    //     $error_message = "Không tìm thấy dữ liệu đăng ký.";
    // }
} else if ($checkrequest > 0 && $is_registered == 1 ) {
    // Nếu đã đăng ký rồi, thông báo
    //$success_message = "Đã đăng ký thành công ";
    $formSubmitted = false; 
    // Kiểm tra nếu form đã được gửi
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy giá trị từ form
        $full_name = $_POST['full_name']; // Thêm trường này trong form để lấy tên đầy đủ
        $username = $_POST['username']; // Thêm trường này để lấy username
        $email = $_POST['email']; // Thêm trường này để lấy email
        $phonenumber = $_POST['phonenumber']; // Thêm trường này để lấy số điện thoại
        $address = $_POST['address']; // Thêm trường này để lấy địa chỉ


        // Câu lệnh SQL để chèn kết quả vào bảng 'request'
        $query = "UPDATE request 
        SET full_name = :full_name, 
            email = :email, 
            phonenumber = :phonenumber, 
            address = :address
        WHERE username = :username";

        // Chuẩn bị câu lệnh
        $stmt = $pdo->prepare($query);

        // Liên kết các tham số
        $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            // Cập nhật is_registered = 0 trong bảng 'users'
        $updateUserQuery = "UPDATE users SET is_registered = 0 WHERE username = :username";
        $updateUserStmt = $pdo->prepare($updateUserQuery);
        $updateUserStmt->bindParam(':username', $username, PDO::PARAM_STR);
        
        if ($updateUserStmt->execute()) {
            $success_message = "Đánh giá của bạn đã được gửi thành công! ";
            $formSubmitted = true;
            header("Location: ../../src/components/home.html");
            exit;
        } else {
            $error_message = "Có lỗi xảy ra trong quá trình gửi đánh giá.";
        }
    }
    }

} else if ($checkrequest == 0 && $is_registered == 1 ) {
    // Biến để kiểm tra form đã được gửi
    $formSubmitted = false;

    // Kiểm tra nếu form đã được gửi
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy giá trị từ form
        $full_name = $_POST['full_name']; // Thêm trường này trong form để lấy tên đầy đủ
        $username = $_POST['username']; // Thêm trường này để lấy username
        $email = $_POST['email']; // Thêm trường này để lấy email
        $phonenumber = $_POST['phonenumber']; // Thêm trường này để lấy số điện thoại
        $address = $_POST['address']; // Thêm trường này để lấy địa chỉ


        // Chèn kết quả vào bảng 'request'
        $query = "INSERT INTO request (full_name, username, email, phonenumber, address) 
                  VALUES (:full_name, :username, :email, :phonenumber, :address)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);

        // Chèn kết quả vào bảng 'noti'
        $query1 = "INSERT INTO noti (username) 
        VALUES (:username)";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt1->execute();

        // Thực thi câu lệnh
        if ($stmt->execute()) {
             // Cập nhật is_registered = 0 trong bảng 'users'
        $updateUserQuery = "UPDATE users SET is_registered = 0 WHERE username = :username";
        $updateUserStmt = $pdo->prepare($updateUserQuery);
        $updateUserStmt->bindParam(':username', $username, PDO::PARAM_STR);
        
        if ($updateUserStmt->execute()) {
            $success_message = "Đánh giá của bạn đã được gửi thành công! ";
            $formSubmitted = true;
            header("Location: ../../src/components/home.html");
            exit;
        } else {
            $error_message = "Có lỗi xảy ra trong quá trình gửi đánh giá.";
        }
    }
    }
}else if ($checkrequest == 0 && $is_registered == 0 ) {
    // Biến để kiểm tra form đã được gửi
    $formSubmitted = false;

    // Kiểm tra nếu form đã được gửi
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy giá trị từ form
        $full_name = $_POST['full_name']; // Thêm trường này trong form để lấy tên đầy đủ
        $username = $_POST['username']; // Thêm trường này để lấy username
        $email = $_POST['email']; // Thêm trường này để lấy email
        $phonenumber = $_POST['phonenumber']; // Thêm trường này để lấy số điện thoại
        $address = $_POST['address']; // Thêm trường này để lấy địa chỉ


        // Chèn kết quả vào bảng 'request'
        $query = "INSERT INTO request (full_name, username, email, phonenumber, address) 
                  VALUES (:full_name, :username, :email, :phonenumber, :address)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);

        // Chèn kết quả vào bảng 'noti'
        $query1 = "INSERT INTO noti (username) 
                  VALUES (:username)";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt1->execute();

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            $success_message = "Đánh giá của bạn đã được gửi thành công! ";
            $formSubmitted = true;
            header("Location: ../../src/components/home.html");
            exit;
        } else {
            $error_message = "Có lỗi xảy ra trong quá trình gửi đánh giá.";
        }
    }
}
} else if ($answer == 1){
    $error_message = "Bạn đã bị từ chối tài khoản khi đăng ký";
    $formSubmitted = true;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../assets/images/logo1.png" type="image/png">
    <title> HMP Home </title>
    <link rel="stylesheet" href="../../assets/fonts/googleapis.css">
    <link rel="stylesheet" href="../../src/css/home.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.7.2/css/all.min.css">
</head>

<body>
    <div class="left-dangky">
        <h1>Đăng ký chữ ký số</h1>
        <p>Điền form để nhận bộ khóa Private Key và Public Key</p>
        <ul>
            <li>Xác minh danh tính của người gửi văn bản thông qua chữ ký số.</li>
            <li>Đảm bảo nội dung không bị chỉnh sửa hoặc giả mạo sau khi ký.</li>
            <li>Tăng cường tính bảo mật trong giao dịch, đặc biệt với tài liệu quan trọng.</li>
        </ul>
    </div>
    <div class="right-dangky">

        <!-- //Hiển thị thông báo lỗi nếu có -->
        <?php if (!empty($error_message)): ?>
            <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
        <?php endif; ?>
          <!-- //Hiển thị thông báo lỗi nếu có -->
        <?php if (!empty($success_message)): ?>
            <p style="color: green; text-align: center;"><?php echo $success_message; ?></p>
        <?php endif; ?>   

        <form action="../../functions/users/user_dangky.php" method="POST">
            <div class="form-group-special">
                <label for="account">Tên tài khoản</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required readonly>
            </div>
            <div class="form-group half">
                <label for="full_name">Họ và tên bạn</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required readonly>
            </div>
            <div class="form-group half">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required readonly>
            </div>
            <!-- <div class="form-group">
                <label for="product">Sản phẩm bạn quan tâm *</label>
                <select id="product" name="product" required>
                    <option value="">--- Chọn giải pháp/ứng dụng bạn quan tâm nhất ---</option>
                </select>
            </div> -->
            <div class="form-group half">
                <label for="email">Email của bạn</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required readonly>
            </div>
            <div class="form-group half">
                <label for="phonenumber">Số điện thoại</label>
                <input type="text" id="phonenumber" name="phonenumber" value="<?php echo htmlspecialchars($phonenumber); ?>" required readonly>
            </div>
            <!-- <div class="form-group half">
                <label for="position">Vị trí công việc *</label>
                <select id="position" name="position" required>
                    <option value="">-- Lựa chọn vị trí công việc --</option>
                </select>
            </div> -->
            <!-- <div class="form-group half">
                <label for="company">Tên công ty *</label>
                <input type="text" id="company" name="company" placeholder="Tên công ty của bạn" required>
            </div> -->
            <!-- <div class="form-group half">
                <label for="hometown">Quê quán *</label>
                <select id="hometown" name="hometown" required>
                    <option value="">-- Tỉnh/Thành phố --</option>
                    <option value="Khu vực miền Bắc">Khu vực miền Bắc</option>
                    <option value="Khu vực miền Trung">Khu vực miền Trung</option>
                    <option value="Khu vực miền Nam">Khu vực miền Nam</option>
                </select>
            </div>
            <div class="form-group half">
                <label for="citywork">Nơi làm việc *</label>
                <select id="citywork" name="citywork" required>
                    <option value="">-- Tỉnh/Thành phố --</option>
                    <option value="Khu vực miền Bắc">Khu vực miền Bắc</option>
                    <option value="Khu vực miền Trung">Khu vực miền Trung</option>
                    <option value="Khu vực miền Nam">Khu vực miền Nam</option>
                </select>
            </div> -->
            
             <!-- thay đổi thông tin thì hiển nút gửi đánh giá -->

            <?php if (!$formSubmitted) { ?>
            
                <button type="submit">Gửi đăng ký</button>
            
            <?php } ?>
            
        </form>
    </div>
    
</body>
</html>