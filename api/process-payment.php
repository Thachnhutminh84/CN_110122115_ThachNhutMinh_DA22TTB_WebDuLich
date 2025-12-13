<?php
/**
 * API Xử Lý Thanh Toán
 */

header('Content-Type: application/json; charset=utf-8');
session_start();

require_once '../config/database.php';

$response = [
    'success' => false,
    'message' => '',
    'data' => null
];

try {
    $database = new Database();
    $db = $database->getConnection();

    // Lấy dữ liệu từ POST
    $bookingCode = isset($_POST['booking_code']) ? htmlspecialchars($_POST['booking_code']) : null;
    $method = isset($_POST['method']) ? htmlspecialchars($_POST['method']) : 'vnpay';
    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
    $accountHolder = isset($_POST['account_holder']) ? htmlspecialchars($_POST['account_holder']) : '';
    $accountNumber = isset($_POST['account_number']) ? htmlspecialchars($_POST['account_number']) : '';
    $bank = isset($_POST['bank']) ? htmlspecialchars($_POST['bank']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $notes = isset($_POST['notes']) ? htmlspecialchars($_POST['notes']) : '';

    if (!$bookingCode) {
        throw new Exception('Thiếu mã đặt dịch vụ');
    }

    if (!$accountHolder || !$accountNumber) {
        throw new Exception('Vui lòng nhập đầy đủ thông tin tài khoản');
    }

    // Kiểm tra booking tồn tại
    $bookingQuery = "SELECT * FROM service_bookings WHERE booking_code = :booking_code";
    $bookingStmt = $db->prepare($bookingQuery);
    $bookingStmt->bindParam(':booking_code', $bookingCode);
    $bookingStmt->execute();

    if ($bookingStmt->rowCount() === 0) {
        throw new Exception('Không tìm thấy đặt dịch vụ');
    }

    $booking = $bookingStmt->fetch(PDO::FETCH_ASSOC);

    // Tạo mã giao dịch
    $transactionCode = strtoupper($method) . date('YmdHis') . rand(1000, 9999);

    // Lưu thông tin thanh toán vào bảng payment_confirmations
    $transferNote = $transactionCode . ' - ' . strtoupper($method);
    $fullNotes = ($bank ? 'Ngân hàng: ' . $bank . ' | ' : '') . ($notes ? 'Ghi chú: ' . $notes : '');
    
    $paymentQuery = "INSERT INTO payment_confirmations 
                   (booking_code, account_name, account_number, bank_name, amount, 
                    transfer_note, status, notes) 
                   VALUES 
                   (:booking_code, :account_name, :account_number, :bank_name, :amount, 
                    :transfer_note, 'pending', :notes)
                   ON DUPLICATE KEY UPDATE 
                   account_name = VALUES(account_name),
                   account_number = VALUES(account_number),
                   bank_name = VALUES(bank_name),
                   amount = VALUES(amount),
                   transfer_note = VALUES(transfer_note),
                   notes = VALUES(notes)";

    $paymentStmt = $db->prepare($paymentQuery);
    $paymentStmt->bindParam(':booking_code', $bookingCode);
    $paymentStmt->bindParam(':account_name', $accountHolder);
    $paymentStmt->bindParam(':account_number', $accountNumber);
    $paymentStmt->bindParam(':bank_name', $bank);
    $paymentStmt->bindParam(':amount', $amount);
    $paymentStmt->bindParam(':transfer_note', $transferNote);
    $paymentStmt->bindParam(':notes', $fullNotes);

    if (!$paymentStmt->execute()) {
        throw new Exception('Không thể lưu thông tin thanh toán: ' . implode(', ', $paymentStmt->errorInfo()));
    }

    // Cập nhật trạng thái booking thành confirmed
    $updateQuery = "UPDATE service_bookings SET status = 'confirmed' WHERE booking_code = :booking_code";
    $updateStmt = $db->prepare($updateQuery);
    $updateStmt->bindParam(':booking_code', $bookingCode);
    $updateStmt->execute();

    $response['success'] = true;
    $response['message'] = 'Thanh toán thành công! Thông tin đã được lưu.';
    $response['data'] = [
        'booking_code' => $bookingCode,
        'transaction_code' => $transactionCode,
        'amount' => $amount,
        'method' => $method
    ];

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    
    error_log("Payment Processing Error: " . $e->getMessage());
}

// Luôn trả về JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
