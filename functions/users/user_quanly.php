
<?php
session_start();
// Lấy thông tin người dùng từ session
$username = $_SESSION['username'];
$full_name = $_SESSION['full_name'];
$address = $_SESSION['address'];
$email = $_SESSION['email'];
$phonenumber = $_SESSION['phonenumber'];
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
            <tr>
                <td>1</td>
                <td>Public Key</td>
                <td><a href="#" class="xemlink">Xem</a></td>
                <td><?php echo htmlspecialchars($full_name); ?></td>
                <td><a href="#">Download</a></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Private Key</td>
                <td><a href="#" class="xemlink">Xem</a></td>
                <td><?php echo htmlspecialchars($full_name); ?></td>
                <td><a href="#">Download</a></td>
            </tr>
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