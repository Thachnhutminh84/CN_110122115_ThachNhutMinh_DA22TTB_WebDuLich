<?php
/**
 * API Quản Lý Đặt Dịch Vụ
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';

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

    // Xử lý GET - Lấy danh sách
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $query = "SELECT sb.*, s.service_name, s.service_type 
                  FROM service_bookings sb
                  LEFT JOIN services s ON sb.service_id = s.service_id
                  ORDER BY sb.created_at DESC";
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $response['success'] = true;
        $response['data'] = $bookings;
    }
    
    // Xử lý PUT - Cập nhật trạng thái
    elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->booking_code) && !empty($data->status)) {
            $query = "UPDATE service_bookings 
                     SET status = :status, 
                         updated_at = CURRENT_TIMESTAMP 
                     WHERE booking_code = :booking_code";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':status', $data->status);
            $stmt->bindParam(':booking_code', $data->booking_code);
            
            if ($stmt->execute()) {
                $statusNames = [
                    'confirmed' => 'xác nhận',
                    'cancelled' => 'hủy',
                    'completed' => 'hoàn thành'
                ];
                
                $response['success'] = true;
                $response['message'] = 'Đã ' . ($statusNames[$data->status] ?? 'cập nhật') . ' đặt dịch vụ thành công';
            } else {
                throw new Exception("Không thể cập nhật trạng thái");
            }
        } else {
            throw new Exception("Thiếu thông tin booking_code hoặc status");
        }
    }
    
    // Xử lý DELETE - Xóa booking
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->booking_code)) {
            $query = "DELETE FROM service_bookings WHERE booking_code = :booking_code";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':booking_code', $data->booking_code);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Xóa đặt dịch vụ thành công';
            } else {
                throw new Exception("Không thể xóa đặt dịch vụ");
            }
        } else {
            throw new Exception("Thiếu thông tin booking_code");
        }
    }
    
    // Xử lý POST - Tạo booking mới
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"));
        
        if (
            !empty($data->service_id) &&
            !empty($data->customer_name) &&
            !empty($data->customer_phone)
        ) {
            // Tạo booking code
            $bookingCode = 'SB' . date('YmdHis') . rand(100, 999);
            
            $query = "INSERT INTO service_bookings 
                     (booking_code, service_id, customer_name, customer_phone, customer_email, 
                      service_date, number_of_people, number_of_days, special_requests, total_price, status) 
                     VALUES 
                     (:booking_code, :service_id, :customer_name, :customer_phone, :customer_email, 
                      :service_date, :number_of_people, :number_of_days, :special_requests, :total_price, 'pending')";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':booking_code', $bookingCode);
            $stmt->bindParam(':service_id', $data->service_id);
            $stmt->bindParam(':customer_name', $data->customer_name);
            $stmt->bindParam(':customer_phone', $data->customer_phone);
            $stmt->bindParam(':customer_email', $data->customer_email);
            $stmt->bindParam(':service_date', $data->service_date);
            $stmt->bindParam(':number_of_people', $data->number_of_people);
            $stmt->bindParam(':number_of_days', $data->number_of_days);
            $stmt->bindParam(':special_requests', $data->special_requests);
            $stmt->bindParam(':total_price', $data->total_price);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Đặt dịch vụ thành công! Chúng tôi sẽ liên hệ với bạn sớm.';
                $response['data'] = ['booking_code' => $bookingCode];
            } else {
                throw new Exception("Không thể tạo đặt dịch vụ");
            }
        } else {
            throw new Exception("Vui lòng điền đầy đủ thông tin bắt buộc");
        }
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    
    // Log lỗi
    error_log("Service Bookings API Error: " . $e->getMessage());
}

// Trả về JSON response
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
