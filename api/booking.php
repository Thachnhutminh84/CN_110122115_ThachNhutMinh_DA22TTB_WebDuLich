<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../models/Booking.php';
require_once '../models/Attraction.php';

// Lấy method HTTP
$method = $_SERVER['REQUEST_METHOD'];

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
    
    $booking = new Booking($db);
    $attraction = new Attraction($db);

    switch ($method) {
        case 'POST':
            // Tạo booking mới
            $data = json_decode(file_get_contents("php://input"));
            
            if (!$data) {
                throw new Exception("Dữ liệu không hợp lệ");
            }

            // Kiểm tra attraction có tồn tại không
            $attraction->attraction_id = $data->attraction_id;
            if (!$attraction->readOne()) {
                throw new Exception("Địa điểm du lịch không tồn tại");
            }

            // Gán dữ liệu cho booking
            $booking->booking_id = $booking->generateUniqueBookingId();
            $booking->attraction_id = $data->attraction_id;
            $booking->attraction_name = $attraction->name;
            $booking->customer_name = $data->customer_name ?? '';
            $booking->customer_phone = $data->customer_phone ?? '';
            $booking->customer_email = $data->customer_email ?? '';
            $booking->tour_date = $data->tour_date ?? '';
            $booking->number_of_people = $data->number_of_people ?? 0;
            $booking->tour_time = $data->tour_time ?? 'flexible';
            $booking->special_requests = $data->special_requests ?? '';
            $booking->notes = $data->notes ?? '';
            $booking->total_amount = $data->total_amount ?? 0;
            $booking->status = 'pending';

            // Validate dữ liệu
            $validation_errors = $booking->validate();
            if (!empty($validation_errors)) {
                throw new Exception(implode(', ', $validation_errors));
            }

            // Tạo booking
            if ($booking->create()) {
                $response['success'] = true;
                $response['message'] = 'Đặt tour thành công!';
                $response['data'] = [
                    'booking_id' => $booking->booking_id,
                    'attraction_name' => $booking->attraction_name,
                    'customer_name' => $booking->customer_name,
                    'tour_date' => $booking->tour_date,
                    'number_of_people' => $booking->number_of_people
                ];
            } else {
                throw new Exception("Không thể tạo booking");
            }
            break;

        case 'GET':
            if (isset($_GET['booking_id'])) {
                // Lấy booking theo ID
                $booking->booking_id = $_GET['booking_id'];
                if ($booking->readOne()) {
                    $response['success'] = true;
                    $response['data'] = [
                        'id' => $booking->id,
                        'booking_id' => $booking->booking_id,
                        'attraction_id' => $booking->attraction_id,
                        'attraction_name' => $booking->attraction_name,
                        'customer_name' => $booking->customer_name,
                        'customer_phone' => $booking->customer_phone,
                        'customer_email' => $booking->customer_email,
                        'tour_date' => $booking->tour_date,
                        'number_of_people' => $booking->number_of_people,
                        'tour_time' => $booking->tour_time,
                        'special_requests' => $booking->special_requests,
                        'notes' => $booking->notes,
                        'total_amount' => $booking->total_amount,
                        'status' => $booking->status,
                        'booking_time' => $booking->booking_time
                    ];
                } else {
                    throw new Exception("Không tìm thấy booking");
                }
            } elseif (isset($_GET['search'])) {
                // Tìm kiếm bookings
                $keyword = $_GET['search'] ?? '';
                $status = $_GET['status'] ?? null;
                $date_from = $_GET['date_from'] ?? null;
                $date_to = $_GET['date_to'] ?? null;
                
                $stmt = $booking->search($keyword, $status, $date_from, $date_to);
                $bookings = [];
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $bookings[] = $row;
                }
                
                $response['success'] = true;
                $response['data'] = $bookings;
            } elseif (isset($_GET['statistics'])) {
                // Lấy thống kê
                $stats = $booking->getStatistics();
                $response['success'] = true;
                $response['data'] = $stats;
            } else {
                // Lấy tất cả bookings
                $limit = $_GET['limit'] ?? 100;
                $offset = $_GET['offset'] ?? 0;
                
                $stmt = $booking->readAll($limit, $offset);
                $bookings = [];
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $bookings[] = $row;
                }
                
                $response['success'] = true;
                $response['data'] = $bookings;
            }
            break;

        case 'PUT':
            // Cập nhật booking
            $data = json_decode(file_get_contents("php://input"));
            
            if (!$data || !isset($data->booking_id)) {
                throw new Exception("Dữ liệu không hợp lệ");
            }

            $booking->booking_id = $data->booking_id;
            
            if (!$booking->readOne()) {
                throw new Exception("Không tìm thấy booking");
            }

            if (isset($data->status)) {
                // Cập nhật trạng thái
                $changed_by = $data->changed_by ?? 'Admin';
                $reason = $data->reason ?? '';
                
                if ($booking->updateStatus($data->status, $changed_by, $reason)) {
                    $response['success'] = true;
                    $response['message'] = 'Cập nhật trạng thái thành công';
                } else {
                    throw new Exception("Không thể cập nhật trạng thái");
                }
            } else {
                // Cập nhật thông tin booking
                $booking->attraction_name = $data->attraction_name ?? $booking->attraction_name;
                $booking->customer_name = $data->customer_name ?? $booking->customer_name;
                $booking->customer_phone = $data->customer_phone ?? $booking->customer_phone;
                $booking->customer_email = $data->customer_email ?? $booking->customer_email;
                $booking->tour_date = $data->tour_date ?? $booking->tour_date;
                $booking->number_of_people = $data->number_of_people ?? $booking->number_of_people;
                $booking->tour_time = $data->tour_time ?? $booking->tour_time;
                $booking->special_requests = $data->special_requests ?? $booking->special_requests;
                $booking->notes = $data->notes ?? $booking->notes;
                $booking->total_amount = $data->total_amount ?? $booking->total_amount;

                // Validate dữ liệu
                $validation_errors = $booking->validate();
                if (!empty($validation_errors)) {
                    throw new Exception(implode(', ', $validation_errors));
                }

                if ($booking->update()) {
                    $response['success'] = true;
                    $response['message'] = 'Cập nhật booking thành công';
                } else {
                    throw new Exception("Không thể cập nhật booking");
                }
            }
            break;

        case 'DELETE':
            // Xóa booking
            $data = json_decode(file_get_contents("php://input"));
            
            if (!$data || !isset($data->booking_id)) {
                throw new Exception("Booking ID không hợp lệ");
            }

            $booking->booking_id = $data->booking_id;
            
            if ($booking->delete()) {
                $response['success'] = true;
                $response['message'] = 'Xóa booking thành công';
            } else {
                throw new Exception("Không thể xóa booking");
            }
            break;

        default:
            throw new Exception("Method không được hỗ trợ");
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    
    // Log lỗi
    error_log("Booking API Error: " . $e->getMessage());
}

// Trả về JSON response
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>