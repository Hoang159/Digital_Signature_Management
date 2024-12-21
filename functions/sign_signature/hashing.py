import pymysql
import hashlib
import os
from PyPDF2 import PdfReader
from docx import Document
from Crypto.PublicKey import RSA
from Crypto.Signature import pkcs1_15
from Crypto.Hash import SHA256

# # Thông tin kết nối đến MySQL
# timeout = 10
# connection = pymysql.connect(
#     charset="utf8mb4",
#     connect_timeout=timeout,
#     cursorclass=pymysql.cursors.DictCursor,
#     db="defaultdb",
#     host="chuky-chuky12.i.aivencloud.com",
#     password="AVNS_2bScz_n3ex0i5iYM7dZ",
#     read_timeout=timeout,
#     port=28661,
#     user="avnadmin",
#     write_timeout=timeout,
# )

# Hàm băm file
def hash_file(file_path):
    if not os.path.exists(file_path):
        raise FileNotFoundError(f"File '{file_path}' không tồn tại.")

    file_extension = os.path.splitext(file_path)[1].lower()
    content = ""

    if file_extension == ".pdf":
        reader = PdfReader(file_path)
        for page in reader.pages:
            content += page.extract_text()
    elif file_extension == ".docx":
        doc = Document(file_path)
        for paragraph in doc.paragraphs:
            content += paragraph.text
    else:
        raise ValueError("Chỉ hỗ trợ file định dạng PDF và Word (.docx).")
    
    hash_object = hashlib.sha256(content.encode('utf-8'))
    return hash_object.hexdigest()

# Hàm ký mã băm bằng private key
def sign_hash(private_key_data, hashed_data):
    private_key = RSA.import_key(private_key_data)
    hash_obj = SHA256.new(hashed_data.encode('utf-8'))
    signature = pkcs1_15.new(private_key).sign(hash_obj)
    return signature

# Hàm thực hiện ký tài liệu
def sign_document():
    try:
        cursor = connection.cursor()

        # Yêu cầu người dùng nhập thông tin
        username = input("Nhập tên người dùng: ").strip()

        # Kiểm tra người dùng trong cơ sở dữ liệu
        cursor.execute("SELECT private_key, public_key FROM users WHERE name=%s", (username,))
        user_keys = cursor.fetchone()

        if not user_keys:
            print(f"Người dùng '{username}' chưa tồn tại trong cơ sở dữ liệu.")
            return

        private_key, public_key = user_keys["private_key"], user_keys["public_key"]

        # Hiển thị public key
        print("\nPublic Key của bạn (copy):")
        print(public_key)
        print("\nPrivate key được bảo mật và không hiển thị.")

        # Nhập đường dẫn file
        file_path = input("\nNhập đường dẫn file cần ký (PDF hoặc Word): ").strip()
        file_hash = hash_file(file_path)

        # Xác nhận ký
        confirm = input("Bạn có chắc chắn muốn ký tài liệu này không? (y/n): ").lower()
        if confirm != 'y':
            print("Hủy ký tài liệu.")
            return

        # Thực hiện ký mã băm
        signature = sign_hash(private_key, file_hash)
        print("\nTài liệu đã được ký thành công!")
        print("Chữ ký số (dạng hex):")
        print(signature.hex())
    except Exception as e:
        print(f"Lỗi: {e}")
    finally:
        cursor.close()

# Chạy chương trình
if __name__ == "__main__":
    sign_document()
