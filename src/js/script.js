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

// Modal động dành cho quản lý ở admin
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
            const publicKey = row.cells[4].innerText;

            // Gán nội dung vào dmodal
            dmodalContent.innerHTML = `
                <p><strong>Số thứ tự:</strong> ${soThuTu}</p>
                <p><strong>Chủ sở hữu:</strong> ${chuSoHuu}</p>
                <p><strong>Họ và tên:</strong> ${hoVaTen}</p>
                <p><strong>Số điện thoại:</strong> ${soDienThoai}</p>
                <p><strong>Public Key:</strong> ${publicKey}</p>
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

// Modal động dành cho quản lý ở user
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

// Gắn sự kiện modal khi DOM đã sẵn sàng
document.addEventListener('DOMContentLoaded', function() {
    attachModalEvents();
    attachModal2Events();
    attachdynamicModalEvents();
    attachdynamicModal2Events();
});
