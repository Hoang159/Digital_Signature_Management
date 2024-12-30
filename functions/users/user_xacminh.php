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

    <div class="section-xacminh">
        <h2>Ký văn bản</h2>
        <div class="form-group">
            <label for="file-input">Upload văn bản</label>
            <input type="file" id="file-input"> <br>
            <button id="hash-btn" type="button"><i class="fa-solid fa-file-lines"></i> Hash </button> <br>
            <!-- <label for="result-hash">Băm văn bản</label> -->
            <input type="text" id="result-hash" placeholder="Kết quả băm" readonly>
        </div>
        <br>
        <div class="form-group">
            <label for="file-input-prikey">Upload Private Key</label>
            <input type="file" id="file-input-prikey"> <br>
            <button id="sign-btn"><i class="fa-solid fa-lock"></i> Sign </button> <br>
            <!-- <label for="result-sign"> Ký bằng Private Key</label> -->
            <input type="text" id="result-sign" placeholder="Kết quả ký" readonly>
            <!-- <button><i class="fa-solid fa-upload"></i> Chọn</button> -->
        </div>
        <!-- <div class="form-group">
            <label for="result-sign">Kết quả mã hóa</label>
            <input type="text" id="result-sign" placeholder="Nội dung">
        </div> -->
        <div class="form-group actions">
            <a href="#" class="downloadLink2">
            <button>Xuất kết quả</button>
            </a>
        </div>
    </div>

    <div class="section-xacminh">
        <h2>Xác thực người gửi</h2>
        <div class="form-group">
            <label for="file-input-original">Upload văn bản gốc</label>
            <input type="file" id="file-input-original"> <br> <br>
            <label for="file-input2">Upload văn bản đã ký</label>
            <input type="file" id="file-input2"> <br> <br>
            <label for="file-input-pubkey">Upload Public Key</label>
            <input type="file" id="file-input-pubkey"> <br>
            <button id="verify-btn"><i class="fa-solid fa-unlock"></i> Verify</button> <br>
            <!-- <label for="result-verify">Kết quả xác thực</label> -->
            <input type="text" id="result-verify" placeholder="Kết quả giải mã">
        </div>
        <!-- <div class="form-group">
            <label for="publickey">Public Key</label>
            <input type="text" id="publickey" placeholder="Chọn Public key">
            <button><i class="fa-solid fa-upload"></i> Chọn</button>
            <button><i class="fa-solid fa-unlock"></i> Giải mã </button>
        </div> -->
        <!-- <div class="form-group">
            <label for="result-verify">Kết quả</label>
            <input type="text" id="result-verify" placeholder="Nội dung">
        </div> -->
    </div> 

    <script src="../../src/js/script.js"></script>
 
</body>
</html>