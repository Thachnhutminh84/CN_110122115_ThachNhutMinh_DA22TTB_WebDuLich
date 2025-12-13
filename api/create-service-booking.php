<?php
session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
    exit;
}

$service_id = $_POST['service_id'] ?? null;
$customer_name = $_POST['customer_name'] ?? null;
$customer_email = $_POST['customer_email'] ?? null;
$customer_phone = $_POST['customer_phone'] ?? null;
$booking_date = $_POST['booking_date'] ?? null;
$start_time = $_POST['start_time'] ?? null;
$quantity = $_POST['quantity'] ?? 1;
$notes = $_POST['notes'] ?? '';

if (!$service_id || !$customer_name || !$customer_email || !$customer_phone || !$booking_date || !$start_time) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin bắt buộc']);
    exit;
}

$query = "SELECT * FROM services WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
$stmt->close();

if (!$service) {
    echo json_encode(['success' => false, 'message' => 'Dịch vụ không tồn tại']);
    exit;
}

$total_price = $service['price'] * $quantity;
$booking_code = 'SB' . date('YmdHis') . rand(100, 999);

$insert_query = "INSERT INTO service_bookings 
                (user_id, service_id, booking_code, customer_name, customer_email, customer_phone, 
                 booking_date, start_time, quantity, total_price, notes, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";

$insert_stmt = $conn->prepare($insert_query);

if (!$insert_stmt) {
    echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị câu lệnh: ' . $conn->error]);
    exit;
}

$user_id = $_SESSION['user_id'];
$quantity_int = (int)$quantity;
$total_price_decimal = (float)$total_price;

$insert_stmt->bind_param("iisssssidi", $user_id, $service_id, $booking_code, 
                         $customer_name, $customer_email, $customer_phone, 
                         $booking_date, $start_time, $quantity_int, $total_price_decimal, $notes);

if (!$insert_stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi tạo booking: ' . $insert_stmt->error]);
    exit;
}

$booking_id = $insert_stmt->insert_id;
$insert_stmt->close();

echo json_encode([
    'success' => true,
    'message' => 'Tạo booking thành công',
    'booking_id' => $booking_id,
    'booking_code' => $booking_code,
    'total_price' => $total_price
]);
?>
