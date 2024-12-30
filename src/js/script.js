// Chỉ chạy mã nếu đang ở file index.html
// Cuộn đến các phần tương ứng
if (window.location.pathname.includes('index.html')) {
    document.getElementById('GioiThieu').addEventListener('click', function() {
        document.getElementById('GioiThieuContent').scrollIntoView({ behavior: 'smooth' });
    });

    document.getElementById('TinhNangLink1').addEventListener('click', function() {
        document.getElementById('TinhNangContent').scrollIntoView({ behavior: 'smooth' });
    });

    document.getElementById('TinhNangLink2').addEventListener('click', function() {
        document.getElementById('TinhNangContent').scrollIntoView({ behavior: 'smooth' });
    });

    document.getElementById('HuongDan').addEventListener('click', function() {
        document.getElementById('HuongDanContent').scrollIntoView({ behavior: 'smooth' });
    });

    document.getElementById('LienHe').addEventListener('click', function() {
        document.getElementById('LienHeContent').scrollIntoView({ behavior: 'smooth' });
    });
}

// Hiển thị chào full_name lấy từ database vào file html
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra nếu đây là trang home.html/ admin_home.html
    if (window.location.pathname.includes("home.html")) {
        // Gọi AJAX đến signin.php để lấy thông tin người dùng
        fetch('../../database/signin.php?ajax=true')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Lấy full_name từ response
                    const full_name = data.full_name;
                    const full_name2 = full_name.charAt(0).toUpperCase() + full_name.slice(1);
                    const username = data.username;

                    // Thay thế tất cả các vị trí chứa "Tên tài khoản" bằng full_name
                    document.querySelectorAll('.header .dangxuat .tennguoidung').forEach(element => {
                        element.innerHTML = `Chào ${full_name} <span class="dropdown-arrow"></span>`;
                    });

                    document.querySelector('.sidebar .information .tennguoidung2').textContent = full_name2;
                    document.querySelector('.sidebar .information .tentaikhoan').textContent = username;

                } else {
                    alert(data.message); // Hiển thị lỗi nếu có
                    window.location.href = '../../index.html'; // Chuyển hướng nếu chưa đăng nhập
                }
            })
            .catch(error => {
                console.error('Error fetching user info:', error);
            });
    }
});

// Hàm chuyển giữa các section ở sidebar
function showSection(sectionId) {
    // Ẩn tất cả các section
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });

    // Hiển thị section được chọn
    const section = document.getElementById(sectionId);
    if (section) {
        section.classList.add('active');

        // Tải nội dung PHP nếu cần
        const phpFiles = {
            dangky: '../../functions/users/user_dangky.php',
            quanly: '../../functions/users/user_quanly.php',
            xacminh: '../../functions/users/user_xacminh.php',
            caidat: '../../functions/users/user_caidat.php',
            admin_duyet: '../../functions/admin/admin_duyet.php',
            admin_quanly: '../../functions/admin/admin_quanly.php',
            admin_caidat: '../../functions/admin/admin_caidat.php',

        };

        if (phpFiles[sectionId]) {
            loadPHPContent(section, phpFiles[sectionId], sectionId);
        }
    }
}

// Hàm chèn nội dung php vào section sidebar
function loadPHPContent(section, url, sectionId) {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            section.innerHTML = data; // Chèn nội dung vào section
            // Gắn sự kiện chỉ cho đúng section
            if (sectionId === "quanly") {
                attachdynamicModal2Events(section); 
            }
            if (sectionId === "caidat") {
                attachModalEvents(section); 
                attachModal2Events(section); 
            }
            if (sectionId === "admin_quanly") {
                attachdynamicModalEvents(section); 
            }
            if (sectionId === "xacminh"){
                uploadHashSignEvents(section);
                uploadVerifyEvents(section);
            }
        })
        .catch(error => {
            console.error('Error fetching PHP file:', error);
            section.innerHTML = '<p>Không thể tải nội dung. Vui lòng thử lại sau.</p>';
        });
}

// Tải và xử lý modal đổi mật khẩu
function attachModalEvents() {
    const modal = document.querySelector('.sb4-caidat .modal');
    const openModalButton = document.querySelector('#openModal');
    const closeModalButton = document.querySelector('.sb4-caidat .close');

    if (openModalButton && modal && closeModalButton) {
        openModalButton.addEventListener('click', event => {
            event.preventDefault();
            modal.style.display = 'block';
        });

        closeModalButton.addEventListener('click', () => modal.style.display = 'none');

        window.addEventListener('click', event => {
            if (event.target === modal) modal.style.display = 'none';
        });
    }
}

// Tải và xử lý modal2 thay đổi thông tin cá nhân
function attachModal2Events() {
    const modal2 = document.querySelector('.sb4-caidat .modal2');
    const openModal2Button = document.querySelector('#openModal2');
    const closeModal2Button = document.querySelector('.sb4-caidat .close2');

    if (openModal2Button && modal2 && closeModal2Button) {
        openModal2Button.addEventListener('click', event => {
            event.preventDefault();
            modal2.style.display = 'block';
        });

        closeModal2Button.addEventListener('click', () => modal2.style.display = 'none');

        window.addEventListener('click', event => {
            if (event.target === modal2) modal2.style.display = 'none';
        });
    }
}

// Modal động dành cho admin_quanly
function attachdynamicModalEvents() {
    // Lấy tất cả các liên kết "Xem" trong bảng
    const xemLinks = document.querySelectorAll(".table tbody tr td .xemlink");

    // Lấy dmodal
    const dmodal = document.getElementById("dynamicModal");
    const dmodalContent = document.getElementById("dmodalContent");
    const dcloseModal = document.querySelector(".dmodal .dclose");

    // Thêm sự kiện click cho từng nút "Xem"
    xemLinks.forEach((link, index) => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            // // Lấy dữ liệu từ hàng tương ứng
            const row = this.closest("tr");
            const soThuTu = row.cells[0].innerText;
            const chuSoHuu = row.cells[1].innerText;
            const hoVaTen = row.cells[2].innerText;
            const soDienThoai = row.cells[3].innerText;
            const publicKeyuser = row.getAttribute('public-key-user');
            let keyUser = '';
            keyUser = publicKeyuser;

            // Gán nội dung vào dmodal
            dmodalContent.innerHTML = `
                <p><strong>Số thứ tự:</strong> ${soThuTu}</p>
                <p><strong>Chủ sở hữu:</strong> ${chuSoHuu}</p>
                <p><strong>Họ và tên:</strong> ${hoVaTen}</p>
                <p><strong>Số điện thoại:</strong> ${soDienThoai}</p>
                <p><strong>Public Key:</strong> ${keyUser}</p>
            `;

            // Hiển thị dmodal
            dmodal.style.display = "block";
        });
    });

    // Đóng dmodal
    dcloseModal.addEventListener("click", function () {
        dmodal.style.display = "none";
    });

    // Đóng dmodal khi click ra ngoài
    window.addEventListener("click", function (event) {
        if (event.target === dmodal) {
            dmodal.style.display = "none";
        }
    });
}

// Modal động dành cho user_quanly
function attachdynamicModal2Events() {
    // Lấy tất cả các liên kết "Xem" trong bảng
    const xemLinks2 = document.querySelectorAll(".sb2-quanly table tbody tr td .xemlink");
    const downloadLinks = document.querySelectorAll(".sb2-quanly table tbody tr td .downloadLink");

    // Lấy dmodal
    const dmodal2 = document.getElementById("dynamicModal2");
    const dmodal2Content = document.getElementById("dmodal2Content");
    const dcloseModal2 = document.querySelector(".dmodal2 .dclose2");

    // Thêm sự kiện click cho từng nút "Xem"
    xemLinks2.forEach((link, index) => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            // // Lấy dữ liệu từ hàng tương ứng
            const row = this.closest("tr");
            // const soThuTu = row.cells[0].innerText;
            const tieude = row.cells[1].innerText;
            const nguoisohuu = row.cells[3].innerText;
            const publicKey = row.getAttribute('data-public-key');
            const privateKey = row.getAttribute('data-private-key');

            let keyInfo = '';

            // Kiểm tra loại khóa và hiển thị thông tin tương ứng
            if (tieude === 'Public Key') {
                keyInfo = publicKey;
            } else if (tieude === 'Private Key') {
                keyInfo = privateKey;
            }

            // Gán nội dung vào dmodal2
            dmodal2Content.innerHTML = `
                <p><strong>Người sở hữu:</strong> ${nguoisohuu}</p>
                <p><strong>Tiêu đề:</strong> ${tieude}</p>
                <p><strong>Thông tin:</strong> ${keyInfo}</p>
                
            `;

            // Hiển thị dmodal2
            dmodal2.style.display = "block";
        });
    });

    // Khi người dùng click vào Download
    downloadLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            const row = this.closest("tr");

            // Lấy giá trị public_key hoặc private_key từ thuộc tính data của hàng
            const publicKey = row.getAttribute('data-public-key');
            const privateKey = row.getAttribute('data-private-key');
            const tieude = row.cells[1].innerText;

            let keyData = '';

            // Chọn khóa dựa trên tiêu đề
            if (tieude === 'Public Key') {
                keyData = publicKey;
            } else if (tieude === 'Private Key') {
                keyData = privateKey;
            }

            // Tạo file .txt và tải xuống
            const blob = new Blob([keyData], { type: 'text/plain' });
            const linkElement = document.createElement('a');
            linkElement.href = URL.createObjectURL(blob);
            linkElement.download = tieude + '.txt';  // Đặt tên file là Public Key hoặc Private Key
            linkElement.click();
        });
    });

    // Đóng dmodal
    dcloseModal2.addEventListener("click", function () {
        dmodal2.style.display = "none";
    });

    // Đóng dmodal khi click ra ngoài
    window.addEventListener("click", function (event) {
        if (event.target === dmodal2) {
            dmodal2.style.display = "none";
        }
    });
}

// Hàm Upload và lấy nội dung văn bản + Băm + Mã hóa (Ký) bằng private key trong user_xacminh
function uploadHashSignEvents() {
    // DOM elements
    const fileInput = document.getElementById('file-input');
    const hashBtn = document.getElementById('hash-btn');
    const fileInputPri = document.getElementById('file-input-prikey');
    const signBtn = document.getElementById('sign-btn');
    const downloadLinks2 = document.querySelectorAll(".sb3-xacminh .section-xacminh .form-group.actions .downloadLink2");

    let hashHex = ''; // Khai báo hashHex ở phạm vi toàn cục

    // Hàm băm dùng SHA-256
    hashBtn.addEventListener('click', () => {
        const fileIn = fileInput.files[0]; // Get the selected file
        if (fileIn) {
            const reader = new FileReader();

            reader.onload = async (e) => {
                const fileContents = e.target.result;

                // Calculate SHA-256 hash
                const hashBuffer = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(fileContents));
                const hashArray = Array.from(new Uint8Array(hashBuffer)); // Convert buffer to byte array
                hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join(''); // Convert bytes to hex string

                // Display hash in the input field
                document.getElementById('result-hash').value = hashHex;
            };

            reader.readAsText(fileIn); // Read the file as text (for this example)
        } else {
            alert("Vui lòng chọn file trước.");
        }
    });

    // Ký bằng Private Key
    signBtn.addEventListener('click', () => {
        const fileInPri = fileInputPri.files[0]; // Get the selected file
        if (fileInPri) {
            const readerPri = new FileReader();

            readerPri.onload = async (e) => {

                const fileContentsPri = e.target.result;

                const keyData = fileContentsPri
                    .replace(/-----BEGIN PRIVATE KEY-----/, '')
                    .replace(/-----END PRIVATE KEY-----/, '')
                    .replace(/\n/g, '');

                const binaryDer = Uint8Array.from(atob(keyData), c => c.charCodeAt(0));

                const privateKeyObj = await crypto.subtle.importKey(
                    'pkcs8',
                    binaryDer.buffer,
                    {
                        name: 'RSASSA-PKCS1-v1_5',
                        hash: { name: 'SHA-256' }
                    },
                    true,
                    ['sign']
                );

                const encodedMessage = new TextEncoder().encode(hashHex);
                // const encodedMessage = new Uint8Array(hashHex.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));
                const resultSign = await crypto.subtle.sign(
                    {
                        name: 'RSASSA-PKCS1-v1_5'
                    },
                    privateKeyObj,
                    encodedMessage
                );
                 // Chuyển chữ ký sang dạng base64 và hiển thị
                 const base64Signature = btoa(String.fromCharCode(...new Uint8Array(resultSign)));
                
                // document.getElementById('result-sign').value = base64Signature;
                document.getElementById('result-sign').value = base64Signature;
            };

            readerPri.readAsText(fileInPri); // Read the file as text (for this example)
        } else {
            alert("Vui lòng chọn file trước.");
        }
    });

    // Khi người dùng click vào Download
    downloadLinks2.forEach(link => {
        link.addEventListener("click", function (event) {
             // Lấy nội dung từ ô result-sign
             const resultSignContent = document.getElementById('result-sign').value;

             if (resultSignContent) {
                 // Tạo Blob từ nội dung
                 const blob2 = new Blob([resultSignContent], { type: 'text/plain' });
                 const link2 = document.createElement('a');
 
                 // Tạo URL cho Blob và trigger tải xuống
                 link2.href = URL.createObjectURL(blob2);
                 link2.download = 'Signed Document.txt'; // Tên file khi tải xuống
                 link2.click();
             } else {
                 alert("Không có kết quả để tải xuống.");
             }
        });
    });

}

// Hàm Upload và lấy nội dung văn bản + giải mã bằng publickey trong user_xacminh
function uploadVerifyEvents() {
    // DOM elements
    const fileInput2 = document.getElementById('file-input2');
    const verifyBtn = document.getElementById('verify-btn');
    const fileInputPub = document.getElementById('file-input-pubkey');
    const fileInputOri = document.getElementById('file-input-original');
    let fileContents2 = '';
    let hashHex2 = '';

    // Nút giải mã
    verifyBtn.addEventListener('click', () => {
        const fileIn2 = fileInput2.files[0]; // Get the selected file
        const fileInPub = fileInputPub.files[0]; // Get the selected file
        const fileInOri = fileInputOri.files[0]; // Get the selected file
        if (fileIn2 && fileInPub && fileInOri) {
            const reader2 = new FileReader();
            const readerPub = new FileReader();
            const readerOri = new FileReader();

            readerOri.onload = async (e) => {
                const fileContentsOri = e.target.result;

                // Calculate SHA-256 hash
                const hashBuffer2 = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(fileContentsOri));
                const hashArray2 = Array.from(new Uint8Array(hashBuffer2)); // Convert buffer to byte array
                hashHex2 = hashArray2.map(byte => byte.toString(16).padStart(2, '0')).join(''); // Convert bytes to hex string
            };

            reader2.onload = async (e) => {
                fileContents2 = e.target.result;
            };
            readerPub.onload = async (e) => {
                const fileContentsPub = e.target.result;

                const keyData2 = fileContentsPub
                    .replace(/-----BEGIN PUBLIC KEY-----/, '')
                    .replace(/-----END PUBLIC KEY-----/, '')
                    .replace(/\n/g, '');

                const binaryDer2 = Uint8Array.from(atob(keyData2), c => c.charCodeAt(0));

                const publicKeyObj = await crypto.subtle.importKey(
                    'spki', // Xác định loại khóa công khai
                    binaryDer2.buffer,
                    {
                        name: 'RSASSA-PKCS1-v1_5',
                        hash: { name: 'SHA-256' }
                    },
                    true,
                    ['verify'] // Chỉ định phép toán có thể thực hiện với khóa
                );

                // // Chuyển đổi chữ ký từ base64 (fileContents2) sang mảng byte
                const binarySignature = new Uint8Array(atob(fileContents2).split('').map(c => c.charCodeAt(0)));

                // const encodedMessage2 = new TextEncoder().encode(binarySignature);

                const encodedMessage2 = new TextEncoder().encode(hashHex2);

                // Xác minh chữ ký
                const resultVerify = await crypto.subtle.verify(
                    {
                        name: 'RSASSA-PKCS1-v1_5'
                    },
                    publicKeyObj, // Public key để xác minh
                    binarySignature,
                    encodedMessage2 // Thông điệp gốc
                );

                // Hiển thị kết quả xác minh
                if (resultVerify) {
                    document.getElementById('result-verify').value = 'Văn bản và chữ ký đều hợp lệ.';
                } else {
                    document.getElementById('result-verify').value = 'Chữ ký không hợp lệ hoặc văn bản đã bị thay đổi!';
                }

                // // Display kết quả sau khi giải mã
                // document.getElementById('result-verify').value = resultVerify;
            };
            readerOri.readAsText(fileInOri); 
            reader2.readAsText(fileIn2); 
            readerPub.readAsText(fileInPub); 
        } else {
            alert("Vui lòng chọn đầy đủ cả 3 file trước.");
        }
    });
    
}

// Gắn sự kiện modal khi DOM đã sẵn sàng
document.addEventListener('DOMContentLoaded', function() {
    attachModalEvents();
    attachModal2Events();
    attachdynamicModalEvents();
    attachdynamicModal2Events();
    uploadHashSignEvents();
    uploadVerifyEvents();
});
