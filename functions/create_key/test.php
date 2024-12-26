<?php
// Bao gồm autoloader của Composer
require_once 'vendor/autoload.php';

use setasign\Fpdi\TcpdfFpdi;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\Hash;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];

        
        if ($fileType === 'application/pdf') {
            try {
                
                $pdf = new TcpdfFpdi();
                $pdf->setSourceFile($fileTmpPath);  // Đọc file PDF từ bộ nhớ tạm
                $pageCount = $pdf->getNumPages();  // Lấy số trang của file PDF

                if ($pageCount > 0) {
                    // Đọc nội dung file PDF (chỉ đọc văn bản của file PDF)
                    $fileContent = file_get_contents($fileTmpPath);

                    // Băm nội dung file PDF bằng SHA-256
                    $hash = hash('sha256', $fileContent);

                    // Hiển thị mã băm (hash) ra terminal
                    echo "Mã băm SHA-256 của file PDF: " . $hash . PHP_EOL;

                    
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'File PDF hợp lệ!',
                        'pageCount' => $pageCount,
                        'hash' => $hash,
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'File PDF không hợp lệ!',
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Lỗi khi đọc file PDF: ' . $e->getMessage(),
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Vui lòng tải lên file PDF hợp lệ!',
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Có lỗi xảy ra khi tải file!',
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Phương thức không hợp lệ!',
    ]);
}
