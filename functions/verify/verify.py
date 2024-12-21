import pymysql
import hashlib
import os
from PyPDF2 import PdfReader
from docx import Document
from Crypto.PublicKey import RSA
from Crypto.Signature import pkcs1_15
from Crypto.Hash import SHA256

# Thông tin kết nối đến MySQL
timeout = 10
connection = pymysql.connect(
    charset="utf8mb4",
    connect_timeout=timeout,
    cursorclass=pymysql.cursors.DictCursor,
    db="defaultdb",
    host="chuky-chuky12.i.aivencloud.com",
    password="AVNS_2bScz_n3ex0i5iYM7dZ",
    read_timeout=timeout,
    port=28661,
    user="avnadmin",
    write_timeout=timeout,
)

# Hàm băm nội dung file
def hash_file(file_path):
    """
    Băm file PDF hoặc Word (.docx) để tạo mã băm SHA-256.
    """
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


# Hàm xác minh chữ ký
def verify_signature(file_path, signature_hex, public_key_pem):
    """
    Xác minh chữ ký số bằng cách:
    - Tạo mã băm của file nhận được
    - Dùng khóa công khai để kiểm tra chữ ký
    """
    try:
        # Băm nội dung file
        file_hash = hash_file(file_path)

        # Tạo đối tượng hash từ nội dung
        hash_obj = SHA256.new(file_hash.encode('utf-8'))

        # Tải khóa công khai
        public_key = RSA.import_key(public_key_pem)

        # Chuyển đổi chữ ký từ hex sang bytes
        signature = bytes.fromhex(signature_hex)

        # Xác minh chữ ký
        pkcs1_15.new(public_key).verify(hash_obj, signature)
        print("\nKết quả: Văn bản không bị thay đổi và chữ ký hợp lệ!")
    except ValueError:
        print("\nKết quả: Sai chữ ký. Chữ ký không khớp với tài liệu.")
    except TypeError:
        print("\nKết quả: Văn bản đã bị thay đổi.")
    except Exception as e:
        print(f"\nCó lỗi xảy ra: {e}")


# Chương trình chính
def main():
    try:
        cursor = connection.cursor()

        # Nhập thông tin người dùng
        username = input("Nhập tên người dùng xác minh: ").strip()
        email = input("Nhập email người dùng xác minh: ").strip()

        # Kiểm tra thông tin người dùng trong cơ sở dữ liệu
        cursor.execute("SELECT public_key FROM users WHERE name=%s AND email=%s", (username, email))
        user_data = cursor.fetchone()

        if not user_data:
            print(f"Không tìm thấy người dùng '{username}' với email '{email}' trong cơ sở dữ liệu.")
            return

        public_key_pem = user_data["public_key"]
        print("\nPublic Key từ cơ sở dữ liệu:")
        print(public_key_pem)

        # Nhập đường dẫn file (PDF hoặc Word)
        file_path = input("Nhập đường dẫn file văn bản cần xác minh (PDF hoặc Word): ").strip()

        # Nhập chữ ký số dạng hex
        signature_hex = input("Nhập chữ ký số (dạng hex): ").strip()

        # Xác minh chữ ký
        verify_signature(file_path, signature_hex, public_key_pem)
    except Exception as e:
        print(f"Lỗi khi xác minh: {e}")
    finally:
        cursor.close()


# Đảm bảo rằng chương trình sẽ gọi main khi chạy
if __name__ == "__main__":
    main()
