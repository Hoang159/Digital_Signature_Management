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

// home.html
//hàm chuyển hướng người dùng đến trang "section" khác
function showSection(section) {
    var sections = document.getElementsByClassName('content-section');
    for (var i = 0; i < sections.length; i++) {
        sections[i].classList.remove('active');
    }
    document.getElementById(section).classList.add('active');
}

