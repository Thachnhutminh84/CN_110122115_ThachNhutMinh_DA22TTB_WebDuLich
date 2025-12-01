<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../models/Booking.php';
require_once '../models/Attraction.php';

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

    // Xử lý POST - Tạo booking mới
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form
        $data = json_decode(file_get_contents("php://input"));

        // Kiểm tra dữ liệu bắt buộc
        if (
            !empty($data->attraction_id) &&
            !empty($data->customer_name) &&
            !empty($data->customer_phone) &&
            !empty($data->booking_date) &&
            !empty($data->number_of_people)
        ) {
            // Validate email nếu có
            if (!empty($data->customer_email) && !filter_var($data->customer_email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email không hợp lệ");
            }

            // Validate số người
            if ($data->number_of_people < 1 || $data->number_of_people > 100) {
                throw new Exception("Số người phải từ 1 đến 100");
            }

            // Validate ngày đặt (không được trong quá khứ)
            $bookingDate = new DateTime($data->booking_date);
            $today = new DateTime();
            $today->setTime(0, 0, 0);
            
            if ($bookingDate < $today) {
                throw new Exception("Ngày đặt tour không được trong quá khứ");
            }

            // Gán dữ liệu
            $booking->booking_id = $booking->generateBookingId();
            $booking->attraction_id = $data->attraction_id;
            $booking->customer_name = $data->customer_name;
            $booking->customer_email = $data->customer_email ?? '';
            $booking->customer_phone = $data->customer_phone;
            $booking->booking_date = $data->booking_date;
            $booking->number_of_people = $data->number_of_people;
            $booking->special_requests = $data->special_requests ?? '';
            
            // Tính tổng giá (có thể lấy từ attraction)
            $attraction = new Attraction($db);
            $attraction->attraction_id = $data->attraction_id;
            if ($attraction->readOne()) {
                // Parse ticket price (VD: "50,000 VNĐ" -> 50000)
                $price = 0;
                if (!empty($attraction->ticket_price) && $attraction->ticket_price !== 'Miễn phí') {
                    $price = (int) preg_replace('/[^0-9]/', '', $attraction->ticket_price);
                }
                $booking->total_price = $price * $data->number_of_people;
            } else {
                $booking->total_price = 0;
            }

            // Tạo booking
            if ($booking->create()) {
                $response['success'] = true;
                $response['message'] = 'Đặt tour thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.';
                $response['data'] = [
                    'booking_id' => $booking->booking_id,
                    'total_price' => $booking->total_price
                ];
            } else {
                throw new Exception("Không thể đặt tour. Vui lòng thử lại.");
            }
        } else {
            throw new Exception("Vui lòng điền đầy đủ thông tin bắt buộc");
        }
    }
    // Xử lý GET - Lấy danh sách bookings
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['booking_id'])) {
            // Lấy một booking
            $booking->booking_id = $_GET['booking_id'];
            if ($booking->readOne()) {
                $response['success'] = true;
                $response['data'] = [
                    'booking_id' => $booking->booking_id,
                    'attraction_id' => $booking->attraction_id,
                    'customer_name' => $booking->customer_name,
                    'customer_email' => $booking->customer_email,
                    'customer_phone' => $booking->customer_phone,
                    'booking_date' => $booking->booking_date,
                    'number_of_people' => $booking->number_of_people,
                    'total_price' => $booking->total_price,
                    'special_requests' => $booking->special_requests,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at
                ];
            } else {
                throw new Exception("Không tìm thấy booking");
            }
        } elseif (isset($_GET['status'])) {
            // Lấy theo trạng thái
            $stmt = $booking->readByStatus($_GET['status']);
            $bookings = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $bookings[] = $row;
            }
            
            $response['success'] = true;
            $response['data'] = $bookings;
        } elseif (isset($_GET['attraction_id'])) {
            // Lấy theo attraction
            $stmt = $booking->readByAttraction($_GET['attraction_id']);
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
            // Lấy tất cả
            $stmt = $booking->readAll();
            $bookings = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $bookings[] = $row;
            }
            
            $response['success'] = true;
            $response['data'] = $bookings;
        }
    }
    // Xử lý PUT - Cập nhật trạng thái
    elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->booking_id) && !empty($data->status)) {
            if ($booking->updateStatus($data->booking_id, $data->status)) {
                $response['success'] = true;
                $response['message'] = 'Cập nhật trạng thái thành công';
            } else {
                throw new Exception("Không thể cập nhật trạng thái");
            }
        } else {
            throw new Exception("Thiếu thông tin booking_id hoặc status");
        }
    }
    // Xử lý DELETE - Xóa booking
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->booking_id)) {
            $booking->booking_id = $data->booking_id;
            if ($booking->delete()) {
                $response['success'] = true;
                $response['message'] = 'Xóa booking thành công';
            } else {
                throw new Exception("Không thể xóa booking");
            }
        } else {
            throw new Exception("Thiếu thông tin booking_id");
        }
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    
    // Log lỗi
    error_log("Bookings API Error: " . $e->getMessage());
}

// Trả về JSON response
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
