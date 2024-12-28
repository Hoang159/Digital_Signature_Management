<?php
include '../../database/connect_pdo.php'; 

// Truy vấn dữ liệu từ bảng request
$sql = "SELECT * FROM request";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <h3> Các yêu cầu chữ ký </h3>
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
                                <button><i class="fa-solid fa-check"></i></button> 
                            </td>
                            <td class="button-cell"> 
                                <button ><i class="fa-solid fa-xmark"></i></button>
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