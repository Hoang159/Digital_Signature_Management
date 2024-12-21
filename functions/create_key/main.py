import pymysql

# Kết nối đến MySQL server trên Aiven
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

try:
    cursor = connection.cursor()
    
    # Tạo bảng users với các cột đầy đủ
    create_users_table = """
    CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    public_key TEXT DEFAULT NULL,
    private_key TEXT DEFAULT NULL
     )
      """
    cursor.execute(create_users_table)
    print("Bảng users được tạo thành công.")
    
    # Tạo bảng documents với các cột cần thiết
    create_documents_table = """
    CREATE TABLE IF NOT EXISTS documents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        owner_id INT NOT NULL,
        file_name VARCHAR(255) NOT NULL,
        file_path VARCHAR(500) NOT NULL,
        hash VARCHAR(256) NOT NULL,
        signature TEXT NOT NULL,
        verified_by INT DEFAULT NULL,
        verification_status ENUM('valid', 'invalid', 'pending') DEFAULT 'pending',
        FOREIGN KEY (owner_id) REFERENCES users(id)
    )
    """
    cursor.execute(create_documents_table)
    print("Bảng documents được tạo thành công.")
    
    # Commit thay đổi
    connection.commit()

    # Truy vấn và hiển thị dữ liệu từ bảng users
    print("\nDữ liệu trong bảng users:")
    cursor.execute("SELECT * FROM users")
    users = cursor.fetchall()
    if users:
        for user in users:
            print(user)
    else:
        print("Không có dữ liệu trong bảng users.")

    # Truy vấn và hiển thị dữ liệu từ bảng documents
    print("\nDữ liệu trong bảng documents:")
    cursor.execute("SELECT * FROM documents")
    documents = cursor.fetchall()
    if documents:
        for doc in documents:
            print(doc)
    else:
        print("Không có dữ liệu trong bảng documents.")
        
finally:
    # Đóng kết nối
    connection.close()
    print("\nĐã đóng kết nối đến MySQL server.")