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

    <div class="table-management">
        <h3> Các chữ ký đã duyệt</h3>
        <table class="table">
            <thead>
                <tr>
                    <th> Số thứ tự </th>
                    <th> Chủ sở hữu </th>
                    <th> Họ và tên </th>
                    <th> Số điện thoại </th>
                    <th> Public Key </th>
                    <th class="button-cell"> Xóa </th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <!-- <td class="no-data" colspan="4"> Chưa có dữ liệu </td> -->
                    <td> 1 </td>
                    <td> ... </td>
                    <td> ... </td>
                    <td> ... </td>
                    <td><a href="#" class="xemlink"> Xem </a></td>
                    <td class="button-cell"> 
                        <button><i class="fa-solid fa-trash"></i></button> 
                    </td>
                </tr>

                <tr>
                    <!-- <td class="no-data" colspan="4"> Chưa có dữ liệu </td> -->
                    <td> 2 </td>
                    <td> ... </td>
                    <td> ... </td>
                    <td> ... </td>
                    <td><a href="#" class="xemlink"> Xem </a></td>
                    <td class="button-cell"> 
                        <button><i class="fa-solid fa-trash"></i></button> 
                    </td>
                </tr>

                <tr>
                    <!-- <td class="no-data" colspan="4"> Chưa có dữ liệu </td> -->
                    <td> 3 </td>
                    <td> ... </td>
                    <td> ... </td>
                    <td> ... </td>
                    <td><a href="#" class="xemlink"> Xem </a></td>
                    <td class="button-cell"> 
                        <button><i class="fa-solid fa-trash"></i></button> 
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <!-- Hộp thoại khi nhấn vào Xem, d nghĩa là dynamic - nội dung động -->
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