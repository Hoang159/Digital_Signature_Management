# Digital Signature Management

Đây là dự án quản lý chữ ký số
---

## Yêu cầu hệ thống

## Hướng dẫn cài đặt
1. **git clone https://github.com/Hoang159/Digital_Signature_Management.git**
2. Code thêm, thay đổi thư mục,... (Mỗi người mỗi thư mục khác nhau khỏi chia nhánh trên git và tránh xung đột )
3. Sau đó mở git bash ở thư mục chính digital_signature_management hoặc mở terminal git bash trong vscode rồi gõ các lệnh sau 
**git add .** (dấu chấm để add tất cả)
**git commit -m"mô tả thay đổi"** (hình như bắt buộc phải điền mô tả thay đổi, để trống không được đâu)
**git push origin master** (đẩy lên github)
4. Còn muốn lấy những thay đổi về máy mình thì gõ lệnh **git pull origin master**

Lưu ý: Các file test.txt thêm vào để đẩy những folder trống lên được github, khi code thì có thể xóa. Trước khi code có thể clone về rồi thử thay đổi và làm các bước như trên để xem cách hoạt động.

## Danh sách thư mục
```
project/
├── src/            # Chứa giao diện phần mềm
│   ├── components      
│   ├── css  
│   ├── js        
│   ├── index.html   
├── database/       # Cơ sở dữ liệu
├── functions/      # Chức năng của phần mềm (chia ra users và admin)
│   ├── admin  
│   ├── users    
├── assets/         # Phần chung của dự án (Font chữ, hình ảnh, icons, ...)
│   ├── fonts  
│   ├── images         
├── doc/            # Chứa tài liệu hoặc các thư viện,...
└── README.md       # Hướng dẫn chi tiết
...
```