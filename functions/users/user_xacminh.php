
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

    <div class="section-xacminh">
        <h2>Mã hóa văn bản</h2>
        <div class="form-group">
            <label for="file-sign">Văn bản</label>
            <input type="text" id="file-sign" placeholder="Chọn tập tin">
            <button><i class="fa-solid fa-upload"></i> Chọn</button>
        </div>
        <div class="form-group">
            <label for="privatekey">Private Key</label>
            <input type="text" id="privatekey" placeholder="Chọn Private Key">
            <button><i class="fa-solid fa-upload"></i> Chọn</button>
            <button><i class="fa-solid fa-lock"></i> Mã hóa</button>
        </div>
        <div class="form-group">
            <label for="result-sign">Kết quả mã hóa</label>
            <input type="text" id="result-sign" placeholder="Nội dung">
        </div>
        <div class="form-group actions">
            <button disabled>Xuất kết quả</button>
        </div>
    </div>
    <div class="section-xacminh">
        <h2>Xác thực văn bản</h2>
        <div class="form-group">
            <label for="file-verify">Văn bản đã mã hóa</label>
            <input type="text" id="file-verify" placeholder="Chọn tập tin">
            <button><i class="fa-solid fa-upload"></i> Chọn</button>
        </div>
        <div class="form-group">
            <label for="publickey">Public Key</label>
            <input type="text" id="publickey" placeholder="Chọn Public key">
            <button><i class="fa-solid fa-upload"></i> Chọn</button>
            <button><i class="fa-solid fa-unlock"></i> Giải mã </button>
        </div>
        <div class="form-group">
            <label for="result-verify">Kết quả</label>
            <input type="text" id="result-verify" placeholder="Nội dung">
        </div>
    </div> 

</body>
</html>