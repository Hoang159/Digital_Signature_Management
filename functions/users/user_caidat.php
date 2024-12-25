
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

    <div class="info-section">
        <h2>Thông tin đăng nhập</h2>
        <div class="info-item">
            <span class="info-label">Tài khoản</span>
            <span class="info-value"> Tên tài khoản </span>
            <span class="change-link-placeholder"></span>
        </div>
        <div class="info-item">
            <span class="info-label">Mật khẩu</span>
            <span class="info-value"> ******** </span>
            <a href="#" class="change-link" id="openModal">Thay đổi</a>
        </div>
    </div>

    <div class="info-section">
        <h2>Thông tin cá nhân <a href="#" class="change-link" id="openModal2">Thay đổi</a></h2>
        <div class="info-item">
            <span class="info-label">Họ và Tên</span>
            <span class="info-value">(Chưa có thông tin)</span>
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
            <span class="info-value">(Chưa có thông tin)</span>
            <span class="change-link-placeholder"></span>
        </div>
        <div class="info-item">
            <span class="info-label">Email</span>
            <span class="info-value">(Chưa có thông tin) </span>
            <span class="change-link-placeholder"></span>
            <!-- <a href="#" class="change-link">Thay đổi</a> -->
        </div>
        <div class="info-item">
            <span class="info-label">Số điện thoại</span>
            <span class="info-value">(Chưa có thông tin) </span>
            <span class="change-link-placeholder"></span>
            <!-- <a href="#" class="change-link">Thay đổi</a> -->
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span id="closeModalButton" class="close"><i class="fa-solid fa-xmark"></i></span>
            <h2>Thay đổi mật khẩu</h2>
            <form>
                <label for="caidat-oldpassword">Mật khẩu cũ:</label>
                <input type="text" id="caidat-oldpassword" name="oldpassword" placeholder="Nhập mật khẩu cũ" required>

                <label for="caidat-newpassword">Mật khẩu mới:</label>
                <input type="text" id="caidat-newpassword" name="newpassword" placeholder="Nhập mật khẩu mới" required>

                <button type="submit">Thay đổi</button>
            </form>
        </div>
    </div>

    <!-- Modal2 -->
    <div id="myModal2" class="modal2">
        <div class="modal2-content">
            <span id="closeModal2Button" class="close2"><i class="fa-solid fa-xmark"></i></span>
            <h2>Thay đổi thông tin cá nhân</h2>
            <form>
                <label for="caidat-name">Họ và tên:</label>
                <input type="text" id="caidat-name" name="name" placeholder="Nhập họ và tên mới" required>

                <label for="caidat-address">Địa chỉ:</label>
                <input type="text" id="caidat-address" name="address" placeholder="Nhập địa chỉ mới" required>
 
                <label for="caidat-email">Email:</label>
                <input type="email" id="caidat-email" name="email" placeholder="Nhập email mới" required>

                <label for="caidat-phone">Số điện thoại:</label>
                <input type="text" id="caidat-phone" name="phone" placeholder="Nhập số điện thoại mới" required>

                <button type="submit">Lưu</button>
            </form>
        </div>
    </div>

    <script src="../../src/js/script.js"></script>

</body>
</html>