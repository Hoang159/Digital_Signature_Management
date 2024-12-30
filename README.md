# Digital Signature Management

Đây là dự án quản lý chữ ký số
---

## Yêu cầu hệ thống
1. Cài đặt VS Code.
2. Cài đặt XAMPP để sử dụng cơ sở dữ liệu.
3. Cài đặt ngrok để tạo đường dẫn trên Internet tới dự án.
4. Cài đặt OpenSSL để tạo Private Key, Public Key (chức năng cho admin)

## Hướng dẫn cài đặt
1. **Fork** dự án từ link: **https://github.com/Hoang159/Digital_Signature_Management.git**
2. Vào phần dự án của bạn và **git clone** dự án bạn vừa fork về.
(Dự án chính Master, tôi là master - Dự án fork về Branch, bạn là master)
3. Code thêm, thay đổi thư mục,...
4. Sau đó mở **git bash** ở thư mục chính (Digital_Signature_Management) hoặc mở **terminal git bash** trong vscode rồi gõ các lệnh sau: 
**git add .** (dấu chấm để add tất cả)
**git commit -m"mô tả thay đổi"** (bắt buộc có mô tả)
**git push origin master** (đẩy lên github)
Lúc này các thay đổi sẽ được đẩy lên Branch
5. Muốn gửi commit vào Master thì nhấn **Contribute** thì sẽ thành Pull Request và chờ duyệt
Muốn đồng bộ code đã có thay đổi từ Master về Branch thì có **Sync Fork**
6. Còn muốn lấy những thay đổi từ Branch sau khi Sync Fork thì gõ lệnh **git pull origin master**

**Lưu ý:** 
- Các file test.txt thêm vào để đẩy những folder trống lên được github, khi code thì có thể xóa. 
- Trước khi code có thể clone về rồi thử thay đổi và làm các bước như trên để xem cách hoạt động. 
- Nếu xảy ra xung đột thì bên Branch phải sửa cho phù hợp trước rồi Contribute qua. Bên Master sẽ đọc và xem xét để Merge.
- Chỉ muốn chạy thử dự án thì đọc thêm phần Guide.txt ở thư mục docs.

## Danh sách thư mục
```
Digital_Signature_Management/
├── src/                    # Chứa giao diện phần mềm
│   ├── components      
│   ├── css  
│   ├── js        
├── database/               # Cơ sở dữ liệu và kết nối
├── functions/              # Chức năng của phần mềm (PHP thuần)
│   ├── main_functions 
│   ├── admin  
│   ├── users    
├── assets/                 # Phần chung của dự án (Font chữ, hình ảnh, videos, ...)
│   ├── fonts  
│   ├── images
│   ├── videos
├── docs/                   # Chứa tài liệu hoặc hướng dẫn,...
├── index.html              # Trang chính của dự án
└── README.md               # Hướng dẫn chi tiết
```