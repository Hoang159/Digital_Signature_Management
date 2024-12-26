<?php
require_once '../../vendor/autoload.php';

// Sử dụng thư viện PDFParser
use Smalot\PdfParser\Parser;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];

        // Kiểm tra định dạng file PDF
        if ($fileType === 'application/pdf') {
            try {
                // Đọc nội dung của tệp PDF và tạo hash SHA-256
                $fileContent = file_get_contents($fileTmpPath);
                $hash = hash('sha256', $fileContent);

                // Khởi tạo đối tượng PDFParser
                $parser = new Parser();
                // Phân tích nội dung file PDF
                $pdf = $parser->parseFile($fileTmpPath);

                // Lấy số trang của PDF
                $pageCount = count($pdf->getPages());

                // Kiểm tra số trang của file PDF
                if ($pageCount > 0) {
                    // Trả về JSON kết quả nếu file hợp lệ
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'File PDF hợp lệ!',
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
?>