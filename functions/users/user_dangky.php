<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../assets/images/logo1.png" type="image/png">
    <title>Đăng ký chữ ký số</title>
    <link rel="stylesheet" href="../../assets/fonts/googleapis.css">
    <link rel="stylesheet" href="../../src/css/home.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.7.2/css/all.min.css">
</head>
<body>
    <div class="left-dangky">
        <h1>Đăng ký chữ ký số </h1>
        <p>Điền form để nhận bộ khóa Private Key và Public Key</p>
        <ul>
            <li>Xác minh danh tính của người gửi văn bản thông qua chữ ký số.</li>
            <li>Đảm bảo nội dung không bị chỉnh sửa hoặc giả mạo sau khi ký.</li>
            <li>Tăng cường tính bảo mật trong giao dịch, đặc biệt với tài liệu quan trọng.</li>
        </ul>
    </div>
    <div class="right-dangky">
        <!-- Form gửi dữ liệu đếncreate_key.php -->
        <form method="POST" action="../main_functions/create_key/create_key.php">
            <div class="form-group-special">
                <label for="account">Tên tài khoản</label>
                <input type="text" id="account" name="account" placeholder="Tên tài khoản" required>
            </div>
            <div class="form-group half">
                <label for="name">Họ và tên bạn</label>
                <input type="text" id="name" name="name" placeholder="Tên của bạn" required>
            </div>
            <div class="form-group half">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" name="address" placeholder="Địa chỉ của bạn" required>
            </div>
            <div class="form-group half">
                <label for="email">Email của bạn</label>
                <input type="email" id="email" name="email" placeholder="Email của bạn" required>
            </div>
            <div class="form-group half">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" placeholder="Số điện thoại của bạn" required>
            </div>
            <div class="form-group">
                <button type="submit">Đăng ký bộ khóa ngay</button>
            </div>
        </form>
    </div>
</body>
</html>
