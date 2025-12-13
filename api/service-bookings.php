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
    
    // Xử lý POST - Tạo booking mới hoặc lấy chi tiết
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"));
        
        // Lấy chi tiết booking
        if (!empty($data->action) && $data->action === 'get_booking') {
            $query = "SELECT sb.*, s.service_name, s.service_type 
                      FROM service_bookings sb
                      LEFT JOIN services s ON sb.service_id = s.service_id
                      WHERE sb.id = :booking_id";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':booking_id', $data->booking_id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $booking = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['success'] = true;
                $response['booking'] = $booking;
            } else {
                throw new Exception("Không tìm thấy đặt dịch vụ");
            }
        }
        // Cập nhật trạng thái
        elseif (!empty($data->action) && $data->action === 'update_status') {
            $query = "UPDATE service_bookings 
                     SET status = :status, 
                         updated_at = CURRENT_TIMESTAMP 
                     WHERE booking_code = :booking_code";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':status', $data->status);
            $stmt->bindParam(':booking_code', $data->booking_id);
            
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
        }
        // Xóa booking
        elseif (!empty($data->action) && $data->action === 'delete') {
            $query = "DELETE FROM service_bookings WHERE booking_code = :booking_code";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':booking_code', $data->booking_id);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Xóa đặt dịch vụ thành công';
            } else {
                throw new Exception("Không thể xóa đặt dịch vụ");
            }
        }
        // Tạo booking mới
        else if (
            !empty($data->service_id) &&
            !empty($data->customer_name) &&
            !empty($data->customer_phone)
        ) {
            // Map service_id từ số sang string nếu cần
            $serviceIdMap = [
                1 => 'SV001',
                2 => 'SV004',
                3 => 'SV007',
                4 => 'SV011'
            ];
            
            $serviceId = isset($serviceIdMap[$data->service_id]) ? $serviceIdMap[$data->service_id] : $data->service_id;
            
            // Lấy thông tin dịch vụ để tính giá
            $serviceQuery = "SELECT price_from, price_to, unit FROM services WHERE service_id = :service_id";
            $serviceStmt = $db->prepare($serviceQuery);
            $serviceStmt->bindParam(':service_id', $serviceId);
            $serviceStmt->execute();
            
            $service = $serviceStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$service) {
                throw new Exception("Dịch vụ không tồn tại (ID: " . $serviceId . ")");
            }
            
            // Tính đơn giá (lấy giá từ nếu có, nếu không lấy giá đến)
            $unitPrice = !empty($service['price_from']) ? $service['price_from'] : $service['price_to'];
            
            // Tính tổng tiền dựa trên số người và số ngày
            $numberOfPeople = !empty($data->number_of_people) ? $data->number_of_people : 1;
            $numberOfDays = !empty($data->number_of_days) ? $data->number_of_days : 1;
            
            // Tính tổng tiền = đơn giá × số người × số ngày
            $totalPrice = $unitPrice * $numberOfPeople * $numberOfDays;
            
            // Tạo booking code
            $bookingCode = 'SB' . date('YmdHis') . rand(100, 999);
            
            $query = "INSERT INTO service_bookings 
                     (booking_code, service_id, customer_name, customer_phone, customer_email, 
                      service_date, number_of_people, number_of_days, special_requests, 
                      unit_price, price_from, price_to, total_price, status) 
                     VALUES 
                     (:booking_code, :service_id, :customer_name, :customer_phone, :customer_email, 
                      :service_date, :number_of_people, :number_of_days, :special_requests, 
                      :unit_price, :price_from, :price_to, :total_price, 'pending')";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':booking_code', $bookingCode);
            $stmt->bindParam(':service_id', $serviceId);
            $stmt->bindParam(':customer_name', $data->customer_name);
            $stmt->bindParam(':customer_phone', $data->customer_phone);
            $stmt->bindParam(':customer_email', $data->customer_email);
            $stmt->bindParam(':service_date', $data->service_date);
            $stmt->bindParam(':number_of_people', $numberOfPeople);
            $stmt->bindParam(':number_of_days', $numberOfDays);
            $stmt->bindParam(':special_requests', $data->special_requests);
            $stmt->bindParam(':unit_price', $unitPrice);
            $stmt->bindParam(':price_from', $service['price_from']);
            $stmt->bindParam(':price_to', $service['price_to']);
            $stmt->bindParam(':total_price', $totalPrice);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Đặt dịch vụ thành công! Chúng tôi sẽ liên hệ với bạn sớm.';
                $response['data'] = [
                    'booking_code' => $bookingCode,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice
                ];
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
