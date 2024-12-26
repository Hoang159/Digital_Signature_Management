<?php
// Hàm tạo cặp khóa RSA
function generateRSAKeys($keySize = 2048) {
    // Cấu hình các thông số cho khóa RSA
    $config = [
        "private_key_bits" => $keySize,  // Kích thước khóa, mặc định là 2048 bit
        "private_key_type" => OPENSSL_KEYTYPE_RSA,  // Loại khóa là RSA
    ];

    // Tạo cặp khóa RSA
    $resource = openssl_pkey_new($config);

    // Kiểm tra xem việc tạo khóa có thành công không
    if (!$resource) {
        return ['error' => 'Không thể tạo cặp khóa RSA'];
    }

    // Lấy khóa riêng (private key)
    openssl_pkey_export($resource, $privatekey);

    // Lấy khóa công khai (public key)
    $publickeyDetails = openssl_pkey_get_details($resource);
    $publickey = $publickeyDetails['key'];

    // Trả về mảng chứa khóa công khai và khóa riêng
    return [
        'publickey' => $publickey,
        'privatekey' => $privatekey
    ];
}
?>