
<?php
session_start();
// Lấy thông tin người dùng từ session
$username = $_SESSION['username'];
$full_name = $_SESSION['full_name'];
$address = $_SESSION['address'];
$email = $_SESSION['email'];
$phonenumber = $_SESSION['phonenumber'];
?>
<!DOCTYPE html>
<html lang="en">
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
        <form>
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
            
            <div class="form-group">
                <button type="submit">Đăng ký bộ khóa ngay</button>
            </div>
        </form>
    </div>
    
</body>
</html>