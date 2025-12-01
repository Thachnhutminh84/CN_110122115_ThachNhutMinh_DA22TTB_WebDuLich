<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../models/Contact.php';

// Khởi tạo response
$response = [
    'success' => false,
    'message' => '',
    'data' => null
];

try {
    // Kết nối database
    $database = new Database();
    $db = $database->getConnection();
    $contact = new Contact($db);

    // Xử lý POST - Tạo liên hệ mới
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form
        $data = json_decode(file_get_contents("php://input"));
        
        // Kiểm tra action (theo tài liệu API)
        $action = $data->action ?? 'create';
        
        if ($action === 'create') {
            // Kiểm tra dữ liệu bắt buộc
            $name = $data->name ?? $data->full_name ?? '';
            
            if (
                !empty($name) &&
                !empty($data->email) &&
                !empty($data->subject) &&
                !empty($data->message)
            ) {
                // Validate email
                if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Email không hợp lệ");
                }

                // Gán dữ liệu
                $contact->contact_id = $contact->generateContactId();
                $contact->full_name = $name;
                $contact->email = $data->email;
                $contact->phone = $data->phone ?? '';
                $contact->subject = $data->subject;
                $contact->message = $data->message;
                $contact->ip_address = $_SERVER['REMOTE_ADDR'] ?? '';

                // Tạo liên hệ
                if ($contact->create()) {
                    $response['success'] = true;
                    $response['message'] = 'Đã gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm!';
                    $response['data'] = [
                        'contact_id' => $contact->contact_id
                    ];
                } else {
                    throw new Exception("Không thể gửi liên hệ. Vui lòng thử lại.");
                }
            } else {
                throw new Exception("Vui lòng điền đầy đủ thông tin bắt buộc");
            }
        } else {
            throw new Exception("Action không hợp lệ");
        }
    }
    // Xử lý GET - Lấy danh sách liên hệ
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['status'])) {
            // Lấy theo trạng thái
            $stmt = $contact->readByStatus($_GET['status']);
        } else {
            // Lấy tất cả
            $stmt = $contact->readAll();
        }

        $contacts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contacts[] = $row;
        }

        $response['success'] = true;
        $response['data'] = $contacts;
    }
    // Xử lý DELETE - Xóa liên hệ
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->contact_id)) {
            $contact->contact_id = $data->contact_id;
            if ($contact->delete()) {
                $response['success'] = true;
                $response['message'] = 'Xóa liên hệ thành công';
            } else {
                throw new Exception("Không thể xóa liên hệ");
            }
        } else {
            throw new Exception("Thiếu thông tin contact_id");
        }
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    
    // Log lỗi
    error_log("Contact API Error: " . $e->getMessage());
}

// Trả về JSON response
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
