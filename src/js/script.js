// index.html
// Cuộn đến các phần tương ứng
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

// home.html và admin_home.html
//hàm chuyển hướng người dùng đến trang "section" khác
// function showSection(section) {
//     var sections = document.getElementsByClassName('content-section');
//     for (var i = 0; i < sections.length; i++) {
//         sections[i].classList.remove('active');
//     }
//     document.getElementById(section).classList.add('active');
// }

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
            loadPHPContent(section, phpFiles[sectionId]);
        }
    }
}

function loadPHPContent(section, url) {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            section.innerHTML = data; // Chèn nội dung vào section
        })
        .catch(error => {
            console.error('Error fetching PHP file:', error);
            section.innerHTML = '<p>Không thể tải nội dung. Vui lòng thử lại sau.</p>';
        });
}

