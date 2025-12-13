<?php
/**
 * Xử lý đặt tour - File PHP đơn giản
 */
session_start();
require_once 'config/database.php';

// Chỉ chấp nhận POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

try {
    // Lấy dữ liệu từ form
    $customer_name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
    $customer_phone = isset($_POST['customer_phone']) ? trim($_POST['customer_phone']) : '';
    $customer_email = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : '';
    $num_adults = isset($_POST['num_adults']) ? (int)$_POST['num_adults'] : 1;
    $num_children = isset($_POST['num_children']) ? (int)$_POST['num_children'] : 0;
    $departure_date = isset($_POST['departure_date']) ? trim($_POST['departure_date']) : '';
    $special_requests = isset($_POST['special_requests']) ? trim($_POST['special_requests']) : '';
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : 'cash';
    $bank_code = isset($_POST['bank_code']) ? trim($_POST['bank_code']) : '';
    
    // Validate
    if (empty($customer_name) || empty($customer_phone) || empty($customer_email) || empty($departure_date)) {
        throw new Exception('Vui long dien day du thong tin bat buoc');
    }
    
    // Kết nối database
    $database = new Database();
    $db = $database->getConnection();
    
    // Tạo mã booking
    $booking_code = 'TOUR' . date('YmdHis') . rand(100, 999);
    
    // Tính tổng tiền
    $adult_price = 500000;
    $child_price = 300000;
    $total_price = ($num_adults * $adult_price) + ($num_children * $child_price);
    
    // Insert vào bảng tour_bookings
    $query = "INSERT INTO tour_bookings 
              (booking_code, departure_date, customer_name, customer_phone, customer_email,
               num_adults, num_children, total_price,
               booking_status, special_requests, payment_method, payment_status)
              VALUES (:booking_code, :departure_date, :customer_name, :customer_phone, :customer_email,
                      :num_adults, :num_children, :total_price,
                      :booking_status, :special_requests, :payment_method, :payment_status)";
    
    $stmt = $db->prepare($query);
    $success = $stmt->execute(array(
        ':booking_code' => $booking_code,
        ':departure_date' => $departure_date,
        ':customer_name' => $customer_name,
        ':customer_phone' => $customer_phone,
        ':customer_email' => $customer_email,
        ':num_adults' => $num_adults,
        ':num_children' => $num_children,
        ':total_price' => $total_price,
        ':booking_status' => 'pending',
        ':special_requests' => $special_requests,
        ':payment_method' => $payment_method,
        ':payment_status' => 'pending'
    ));
    
    if (!$success) {
        $error = $stmt->errorInfo();
        throw new Exception('Lỗi SQL: ' . $error[2]);
    }
    
    // Chuyển hướng đến trang chọn phương thức thanh toán
    header('Location: payment-tour-method.php?booking_id=' . urlencode($booking_code));
    exit;
    
} catch (Exception $e) {
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Loi</title>
    <style>
        body {
            font-family: Arial;
            padding: 50px;
            text-align: center;
            background: #f8d7da;
        }
        .error {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            margin: 0 auto;
        }
        h1 { color: #e74c3c; }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="error">
        <h1>❌ Có lỗi xảy ra</h1>
        <p><?php echo htmlspecialchars($e->getMessage()); ?></p>
        <a href="dat-tour.php" class="btn">Quay Lại</a>
    </div>
</body>
</html>
<?php
    exit;
}
?>
