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

// Hiển thị chào username lấy từ database vào file html
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra nếu đây là trang home.html
    if (window.location.pathname.includes("home.html") || window.location.pathname.includes("admin_home.html")) {
        // Gọi AJAX đến signin.php để lấy thông tin người dùng
        fetch('../../database/signin.php?ajax=true')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Lấy username từ response
                    const username = data.username;
                    const username2 = username.charAt(0).toUpperCase() + username.slice(1);

                    // Thay thế tất cả các vị trí chứa "Tên tài khoản" bằng username
                    document.querySelectorAll('.header .dangxuat button').forEach(element => {
                        element.innerHTML = `Chào ${username} <span class="dropdown-arrow"></span>`;
                    });

                    document.querySelector('.sidebar .information h2').textContent = username2;

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
            if (sectionId === "caidat") {
                attachModalEvents(section); 
                attachModal2Events(section); 
            }
        })
        .catch(error => {
            console.error('Error fetching PHP file:', error);
            section.innerHTML = '<p>Không thể tải nội dung. Vui lòng thử lại sau.</p>';
        });
}

// Tải và xử lý modal
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

document.addEventListener('DOMContentLoaded', function() {
    attachModal2Events(); // Gắn sự kiện modal khi DOM đã sẵn sàng
});

// Tải và xử lý modal2
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

document.addEventListener('DOMContentLoaded', function() {
    attachModal2Events(); // Gắn sự kiện modal khi DOM đã sẵn sàng
});




