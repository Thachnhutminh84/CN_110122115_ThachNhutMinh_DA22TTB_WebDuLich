<?php
session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
    exit;
}

$booking_id = $_POST['booking_id'] ?? null;
$payment_method = $_POST['payment_method'] ?? null;
$amount = $_POST['amount'] ?? 0;
$bank_name = $_POST['bank_name'] ?? null;
$account_number = $_POST['account_number'] ?? null;
$account_holder = $_POST['account_holder'] ?? null;
$payer_name = $_POST['payer_name'] ?? null;
$payer_email = $_POST['payer_email'] ?? null;
$payer_phone = $_POST['payer_phone'] ?? null;

if (!$booking_id || !$payment_method || !$amount || !$bank_name || !$account_number || !$account_holder) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin thanh toán']);
    exit;
}

$query = "SELECT * FROM service_bookings WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();

if (!$booking) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy booking']);
    exit;
}

$insert_query = "INSERT INTO service_payments 
                (booking_id, payment_method, amount, bank_name, account_number, account_holder, 
                 payer_name, payer_email, payer_phone, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";

$insert_stmt = $conn->prepare($insert_query);

if (!$insert_stmt) {
    echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị câu lệnh: ' . $conn->error]);
    exit;
}

$amount_decimal = (float)$amount;
$insert_stmt->bind_param("isdsssss", $booking_id, $payment_method, $amount_decimal, $bank_name, 
                         $account_number, $account_holder, $payer_name, $payer_email, $payer_phone);

if (!$insert_stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi lưu thông tin thanh toán: ' . $insert_stmt->error]);
    exit;
}

$payment_id = $insert_stmt->insert_id;
$insert_stmt->close();

$update_query = "UPDATE service_bookings SET status = 'pending_payment', payment_id = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("ii", $payment_id, $booking_id);
$update_stmt->execute();
$update_stmt->close();

if ($payment_method === 'vnpay') {
    $redirect_url = 'payment-vnpay.php?booking_code=' . $booking['booking_code'] . 
                   '&amount=' . $amount . 
                   '&order_info=Thanh%20toan%20dich%20vu%20' . $booking['booking_code'];
    
    echo json_encode([
        'success' => true,
        'message' => 'Chuyển hướng đến VNPay',
        'redirect_url' => $redirect_url
    ]);
} elseif ($payment_method === 'momo') {
    $redirect_url = 'payment-momo.php?booking_code=' . $booking['booking_code'] . 
                   '&amount=' . $amount . 
                   '&order_info=Thanh%20toan%20dich%20vu%20' . $booking['booking_code'];
    
    echo json_encode([
        'success' => true,
        'message' => 'Chuyển hướng đến MoMo',
        'redirect_url' => $redirect_url
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức thanh toán không hợp lệ'
    ]);
}
?>
