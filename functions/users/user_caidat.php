<?php
include '../../database/connect_pdo.php'; 
session_start();

// Lấy thông tin người dùng từ session
$username = $_SESSION['username'];
$full_name = $_SESSION['full_name'];
$address = $_SESSION['address'];
$email = $_SESSION['email'];
$phonenumber = $_SESSION['phonenumber'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Lấy dữ liệu từ form
  $full_name = $_POST['full_name'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $phonenumber = $_POST['phonenumber'];

  // Lấy username từ session
  $username = $_SESSION['username'];

  // Cập nhật thông tin vào database bằng PDO
  $sql = "UPDATE users SET full_name = :full_name, address = :address, email = :email, phonenumber = :phonenumber WHERE username = :username";
  $stmt = $conn->prepare($sql); // Chuẩn bị câu lệnh SQL

  // Ràng buộc tham số
  $stmt->bindParam(':full_name', $full_name);
  $stmt->bindParam(':address', $address);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':phonenumber', $phonenumber);
  $stmt->bindParam(':username', $username);

  // Thực thi câu lệnh và kiểm tra kết quả
  if ($stmt->execute()) {
      // Cập nhật thông tin vào session nếu thành công
      $_SESSION['full_name'] = $full_name;
      $_SESSION['address'] = $address;
      $_SESSION['email'] = $email;
      $_SESSION['phonenumber'] = $phonenumber;

      // Thông báo thành công và chuyển hướng
      $success_message = "Đã cập nhật thành công!";
      header("Location: ../../src/components/home.html");
      exit; // Dừng thực thi mã sau khi chuyển hướng
  } else {
      // Thông báo lỗi nếu câu lệnh không thực thi thành công
      $error_message = "Cập nhật thông tin bị lỗi!";
  }
} else {
  // Thông báo nếu request không phải là POST
  $error_message = "Request không hợp lệ!";
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
        <form>
          <label for="caidat-oldpassword">Mật khẩu cũ:</label>
          <input
            type="text"
            id="caidat-oldpassword"
            name="oldpassword"
            placeholder="Nhập mật khẩu cũ"
            required
          />

          <label for="caidat-newpassword">Mật khẩu mới:</label>
          <input
            type="text"
            id="caidat-newpassword"
            name="newpassword"
            placeholder="Nhập mật khẩu mới"
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

        <!-- //Hiển thị thông báo thành công nếu có
        <?php if (!empty($success_message)): ?>
        <p style="color: green"><?php echo $success_message; ?></p>
        <?php endif; ?>

        //Hiển thị thông báo lỗi nếu có 
        <?php if (!empty($error_message)): ?>
        <p style="color: red"><?php echo $error_message; ?></p>
        <?php endif; ?> -->

        <form action="user_caidat.php" method="POST">
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
            <option value="HaNoi">Hà Nội</option>
            <option value="HoChiMinh">Hồ Chí Minh</option>
            <option value="DaNang">Đà Nẵng</option>
            <option value="HaiPhong">Hải Phòng</option>
            <option value="CanTho">Cần Thơ</option>
            <option value="AnGiang">An Giang</option>
            <option value="BacGiang">Bắc Giang</option>
            <option value="BacKan">Bắc Kạn</option>
            <option value="BacLieu">Bạc Liêu</option>
            <option value="BinhDinh">Bình Định</option>
            <option value="BinhDuong">Bình Dương</option>
            <option value="BinhPhuoc">Bình Phước</option>
            <option value="CaMau">Cà Mau</option>
            <option value="CaoBang">Cao Bằng</option>
            <option value="DaNang">Đà Nẵng</option>
            <option value="DacLak">Đắk Lắk</option>
            <option value="DacNong">Đắk Nông</option>
            <option value="DienBien">Điện Biên</option>
            <option value="DongNai">Đồng Nai</option>
            <option value="DongThap">Đồng Tháp</option>
            <option value="GiaLai">Gia Lai</option>
            <option value="HaGiang">Hà Giang</option>
            <option value="HaNam">Hà Nam</option>
            <option value="HaiDuong">Hải Dương</option>
            <option value="HauGiang">Hậu Giang</option>
            <option value="HoaBinh">Hòa Bình</option>
            <option value="HungYen">Hưng Yên</option>
            <option value="KhanhHoa">Khánh Hòa</option>
            <option value="KienGiang">Kiên Giang</option>
            <option value="KonTum">Kon Tum</option>
            <option value="LaiChau">Lai Châu</option>
            <option value="LamDong">Lâm Đồng</option>
            <option value="LangSon">Lạng Sơn</option>
            <option value="LaoCai">Lào Cai</option>
            <option value="LongAn">Long An</option>
            <option value="NamDinh">Nam Định</option>
            <option value="NgheAn">Nghệ An</option>
            <option value="NinhBinh">Ninh Bình</option>
            <option value="NinhThuan">Ninh Thuận</option>
            <option value="PhuTho">Phú Thọ</option>
            <option value="PhuYen">Phú Yên</option>
            <option value="QuangBinh">Quảng Bình</option>
            <option value="QuangNam">Quảng Nam</option>
            <option value="QuangNgai">Quảng Ngãi</option>
            <option value="QuangNinh">Quảng Ninh</option>
            <option value="QuangTri">Quảng Trị</option>
            <option value="SocTrang">Sóc Trăng</option>
            <option value="SonLa">Sơn La</option>
            <option value="TayNinh">Tây Ninh</option>
            <option value="ThanhHoa">Thanh Hóa</option>
            <option value="ThuaThienHue">Thừa Thiên Huế</option>
            <option value="TienGiang">Tiền Giang</option>
            <option value="VinhPhuc">Vĩnh Phúc</option>
            <option value="VinhLong">Vĩnh Long</option>
            <option value="YenBai">Yên Bái</option>
            <option value="BinhThuan">Bình Thuận</option>
            <option value="KienGiang">Kiên Giang</option>
            <option value="QuangNam">Quảng Nam</option>
            <option value="TuyenQuang">Tuyên Quang</option>
            <option value="BacNinh">Bắc Ninh</option>
            <option value="BinhPhuoc">Bình Phước</option>
            <option value="LaiChau">Lai Châu</option>
            <option value="LangSon">Lạng Sơn</option>
            <option value="QuangNgai">Quảng Ngãi</option>
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
