<?php
include '../../database/connect_pdo.php'; 
session_start();

// Lấy thông tin người dùng từ session
$username = $_SESSION['username'];
$full_name = $_SESSION['full_name'];
$address = $_SESSION['address'];
$email = $_SESSION['email'];
$phonenumber = $_SESSION['phonenumber'];
$password = $_SESSION['password'];

// Thay đổi thông tin cá nhân
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? ''; 

  if ($action === 'update_in4') {
      // Xử lý thay đổi thông tin cá nhân
      $full_name = $_POST['full_name'];
      $address = $_POST['address'];
      $email = $_POST['email'];
      $phonenumber = $_POST['phonenumber'];

      $username = $_SESSION['username'];

      $sql = "UPDATE users SET full_name = :full_name, address = :address, email = :email, phonenumber = :phonenumber, is_registered = 1 WHERE username = :username";
      $stmt = $pdo->prepare($sql);

      $stmt->bindParam(':full_name', $full_name);
      $stmt->bindParam(':address', $address);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':phonenumber', $phonenumber);
      $stmt->bindParam(':username', $username);

      // Truy vấn bảng " noti"
       $answerQuery = "SELECT answer  FROM noti  WHERE username = :username ";
       $answerStmt = $pdo->prepare($answerQuery);
       $answerStmt->bindParam(':username', $username, PDO::PARAM_STR);
       $answerStmt->execute();
       $answer = $answerStmt->fetchColumn();

       if ($answer == 1){
        $query1 = "UPDATE noti SET answer = 0 WHERE username = :username";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt1->execute();
        }
      

      if ($stmt->execute()) {
          $_SESSION['full_name'] = $full_name;
          $_SESSION['address'] = $address;
          $_SESSION['email'] = $email;
          $_SESSION['phonenumber'] = $phonenumber;
          $success_message = "Đã cập nhật thông tin thành công!";
          header("Location: ../../src/components/home.html");
          exit;
      } else {
          $error_message = "Cập nhật thông tin bị lỗi!";
      }
  } elseif ($action === 'update_password') {
      // Xử lý thay đổi mật khẩu
      $old_password = $_POST['old_password'];
      $new_password = $_POST['new_password'];
      $confirm_password = $_POST['confirm_password'];

      $username = $_SESSION['username'];

      $sql = "SELECT password FROM users WHERE username = :username";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':username', $username);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user && $old_password === $user['password']) {
          if ($new_password === $confirm_password) {
              $sql = "UPDATE users SET password = :password WHERE username = :username";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':password', $new_password);
              $stmt->bindParam(':username', $username);

              if ($stmt->execute()) {
                  $_SESSION['password'] = $new_password;
                  $success_message = "Đã thay đổi mật khẩu thành công!";
                  header("Location: ../../src/components/home.html");
                  exit;
              } else {
                  $error_message = "Thay đổi mật khẩu bị lỗi!";
              }
          } else {
              $error_message = "Mật khẩu mới và xác nhận không khớp!";
          }
      } else {
          $error_message = "Mật khẩu cũ không đúng!";
      }
  } else {
      $error_message = "Hành động không hợp lệ!";
  }
}
?>

<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="../../assets/images/logo1.png" type="image/png" />
    <title>HMP Home</title>
    <link rel="stylesheet" href="../../assets/fonts/googleapis.css" />
    <link rel="stylesheet" href="../../src/css/home.css" />
    <link
      rel="stylesheet"
      href="../../assets/fonts/fontawesome-free-6.7.2/css/all.min.css"
    />
  </head>

  <body>
    <div class="info-section">
      <h2>Thông tin đăng nhập</h2>
      <div class="info-item">
        <span class="info-label">Tài khoản</span>
        <span class="info-value" id="username">
          <?php echo htmlspecialchars($username); ?>
        </span>
        <span class="change-link-placeholder"></span>
      </div>
      <div class="info-item">
        <span class="info-label">Mật khẩu</span>
        <span class="info-value"> ******** </span>
        <a href="#" class="change-link" id="openModal">Thay đổi</a>
      </div>
    </div>

    <div class="info-section">
      <h2>
        Thông tin cá nhân
        <a href="#" class="change-link" id="openModal2">Thay đổi</a>
      </h2>
      <div class="info-item">
        <span class="info-label">Họ và Tên</span>
        <span class="info-value" id="full_name">
          <?php echo htmlspecialchars($full_name); ?>
        </span>
        <span class="change-link-placeholder"></span>
      </div>
      <!-- <div class="info-item">
            <span class="info-label">Giới tính</span>
            <span class="info-value">(Chưa có thông tin)</span>
            <span class="change-link-placeholder"></span>
        </div> -->
      <!-- <div class="info-item">
            <span class="info-label">Ngày sinh</span>
            <span class="info-value">(Chưa có thông tin)</span>
            <span class="change-link-placeholder"></span>
        </div> -->
      <div class="info-item">
        <span class="info-label">Địa chỉ</span>
        <span class="info-value" id="address">
          <?php echo htmlspecialchars($address); ?>
        </span>
        <span class="change-link-placeholder"></span>
      </div>
      <div class="info-item">
        <span class="info-label">Email</span>
        <span class="info-value" id="email">
          <?php echo htmlspecialchars($email); ?>
        </span>
        <span class="change-link-placeholder"></span>
        <!-- <a href="#" class="change-link">Thay đổi</a> -->
      </div>
      <div class="info-item">
        <span class="info-label">Số điện thoại</span>
        <span class="info-value" id="phonenumber">
          <?php echo htmlspecialchars($phonenumber); ?>
        </span>
        <span class="change-link-placeholder"></span>
        <!-- <a href="#" class="change-link">Thay đổi</a> -->
      </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
      <div class="modal-content">
        <span id="closeModalButton" class="close"
          ><i class="fa-solid fa-xmark"></i
        ></span>
        <h2>Thay đổi mật khẩu</h2>
        <form action="../../functions/users/user_caidat.php" method="POST">
          <input type="hidden" name="action" value="update_password" />
          <label for="old_password">Mật khẩu cũ:</label>

          <input
            type="password"
            id="old_password"
            name="old_password"
            placeholder="Nhập mật khẩu cũ"
            required
          />

          <label for="new_password">Mật khẩu mới:</label>
          <input
            type="password"
            id="new_password"
            name="new_password"
            placeholder="Nhập mật khẩu mới"
            required
          />

          <label for="confirm_password">Mật khẩu mới:</label>
          <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            placeholder="Xác nhận lại mật khẩu"
            required
          />

          <button type="submit">Thay đổi</button>
        </form>
      </div>
    </div>

    <!-- Modal2 -->
    <div id="myModal2" class="modal2">
      <div class="modal2-content">
        <span id="closeModal2Button" class="close2"
          ><i class="fa-solid fa-xmark"></i
        ></span>

        <h2>Thay đổi thông tin cá nhân</h2>

        <form action="../../functions/users/user_caidat.php" method="POST">
          <input type="hidden" name="action" value="update_in4" />
          <label for="full_name">Họ và tên:</label>
          <input
            type="text"
            id="full_name"
            name="full_name"
            placeholder="Nhập họ và tên mới"
            required
          />

          <label for="address">Địa chỉ:</label>
          <select id="address" name="address" required>
            <option value="">Chọn địa chỉ mới</option>
            <option value="Hà Nội">Hà Nội</option>
            <option value="Hồ Chí Minh">Hồ Chí Minh</option>
            <option value="Đà Nẵng">Đà Nẵng</option>
            <option value="Hải Phòng">Hải Phòng</option>
            <option value="Cần Thơ">Cần Thơ</option>
            <option value="An Giang">An Giang</option>
            <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
            <option value="Bắc Giang">Bắc Giang</option>
            <option value="Bắc Kạn">Bắc Kạn</option>
            <option value="Bạc Liêu">Bạc Liêu</option>
            <option value="Bắc Ninh">Bắc Ninh</option>
            <option value="Bến Tre">Bến Tre</option>
            <option value="Bình Định">Bình Định</option>
            <option value="Bình Dương">Bình Dương</option>
            <option value="Bình Phước">Bình Phước</option>
            <option value="Bình Thuận">Bình Thuận</option>
            <option value="Cà Mau">Cà Mau</option>
            <option value="Cao Bằng">Cao Bằng</option>
            <option value="Đắk Lắk">Đắk Lắk</option>
            <option value="Đắk Nông">Đắk Nông</option>
            <option value="Điện Biên">Điện Biên</option>
            <option value="Đồng Nai">Đồng Nai</option>
            <option value="Đồng Tháp">Đồng Tháp</option>
            <option value="Gia Lai">Gia Lai</option>
            <option value="Hà Giang">Hà Giang</option>
            <option value="Hà Nam">Hà Nam</option>
            <option value="Hà Tĩnh">Hà Tĩnh</option>
            <option value="Hải Dương">Hải Dương</option>
            <option value="Hậu Giang">Hậu Giang</option>
            <option value="Hòa Bình">Hòa Bình</option>
            <option value="Hưng Yên">Hưng Yên</option>
            <option value="Khánh Hòa">Khánh Hòa</option>
            <option value="Kiên Giang">Kiên Giang</option>
            <option value="Kon Tum">Kon Tum</option>
            <option value="Lai Châu">Lai Châu</option>
            <option value="Lâm Đồng">Lâm Đồng</option>
            <option value="Lạng Sơn">Lạng Sơn</option>
            <option value="Lào Cai">Lào Cai</option>
            <option value="Long An">Long An</option>
            <option value="Nam Định">Nam Định</option>
            <option value="Nghệ An">Nghệ An</option>
            <option value="Ninh Bình">Ninh Bình</option>
            <option value="Ninh Thuận">Ninh Thuận</option>
            <option value="Phú Thọ">Phú Thọ</option>
            <option value="Phú Yên">Phú Yên</option>
            <option value="Quảng Bình">Quảng Bình</option>
            <option value="Quảng Nam">Quảng Nam</option>
            <option value="Quảng Ngãi">Quảng Ngãi</option>
            <option value="Quảng Ninh">Quảng Ninh</option>
            <option value="Quảng Trị">Quảng Trị</option>
            <option value="Sóc Trăng">Sóc Trăng</option>
            <option value="Sơn La">Sơn La</option>
            <option value="Tây Ninh">Tây Ninh</option>
            <option value="Thái Bình">Thái Bình</option>
            <option value="Thái Nguyên">Thái Nguyên</option>
            <option value="Thanh Hóa">Thanh Hóa</option>
            <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
            <option value="Tiền Giang">Tiền Giang</option>
            <option value="Trà Vinh">Trà Vinh</option>
            <option value="Tuyên Quang">Tuyên Quang</option>
            <option value="Vĩnh Long">Vĩnh Long</option>
            <option value="Vĩnh Phúc">Vĩnh Phúc</option>
            <option value="Yên Bái">Yên Bái</option>
          </select>

          <label for="email">Email:</label>
          <input
            id="email"
            name="email"
            placeholder="Nhập email của bạn"
            type="email"
            required
          />

          <label for="phonenumber">Số điện thoại:</label>
          <input
            type="tel"
            pattern="^0\d{9}$"
            id="phonenumber"
            name="phonenumber"
            placeholder="Nhập số điện thoại mới"
            required
          />

          <button type="submit">Thay đổi thông tin</button>

        </form>
      </div>
    </div>

    <script src="../../src/js/script.js"></script>
  </body>
</html>
