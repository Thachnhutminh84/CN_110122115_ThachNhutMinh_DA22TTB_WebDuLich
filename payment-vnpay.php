<?php
session_start();

// Lấy thông tin booking từ session hoặc POST
$bookingCode = $_POST['booking_code'] ?? $_GET['booking_code'] ?? null;
$amount = $_POST['amount'] ?? $_GET['amount'] ?? 0;
$orderInfo = $_POST['order_info'] ?? $_GET['order_info'] ?? 'Thanh toán booking';

if (!$bookingCode) {
    die('Thiếu mã đặt dịch vụ');
}

// Nếu amount = 0, lấy từ database
if ($amount == 0) {
    require_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT total_price FROM service_bookings WHERE booking_code = :booking_code";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':booking_code', $bookingCode);
    $stmt->execute();
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($booking) {
        $amount = $booking['total_price'];
    }
    
    // Nếu vẫn = 0, set giá mặc định
    if ($amount == 0) {
        $amount = 100000; // 100,000 VNĐ mặc định
    }
}

// Đảm bảo amount >= 10,000 VNĐ (yêu cầu của VNPay)
if ($amount < 10000) {
    $amount = 10000;
}

// Load cấu hình VNPay
$vnpayConfig = require_once 'config/vnpay.php';

$vnp_TmnCode = $vnpayConfig['vnp_TmnCode'];
$vnp_HashSecret = $vnpayConfig['vnp_HashSecret'];
$vnp_Url = $vnpayConfig['vnp_Url'];
$vnp_ReturnUrl = $vnpayConfig['vnp_ReturnUrl'];

// Thông tin giao dịch
$vnp_TxnRef = $bookingCode; // Mã đơn hàng
$vnp_OrderInfo = $orderInfo;
$vnp_OrderType = 'billpayment';
$vnp_Amount = $amount * 100; // VNPay tính theo đơn vị nhỏ nhất (VNĐ * 100)
$vnp_Locale = 'vn';
$vnp_BankCode = $_POST['bank_code'] ?? '';

// Lấy IP address
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
if ($vnp_IpAddr == '::1' || $vnp_IpAddr == '127.0.0.1') {
    $vnp_IpAddr = '127.0.0.1'; // Localhost
}

// Build data để gửi sang VNPay
$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_ReturnUrl,
    "vnp_TxnRef" => $vnp_TxnRef
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

// Sắp xếp dữ liệu theo key
ksort($inputData);

// Tạo query string và hash data
$query = "";
$hashdata = "";
$i = 0;

foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . $key . "=" . $value;
    } else {
        $hashdata .= $key . "=" . $value;
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

// Tạo secure hash (KHÔNG encode khi tạo hash)
$vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

// Build URL cuối cùng
$vnp_Url = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;

// Debug (comment out sau khi test xong)
/*
echo "<h3>Debug Info:</h3>";
echo "<p>Booking Code: $bookingCode</p>";
echo "<p>Amount: $amount VNĐ</p>";
echo "<p>VNPay Amount: $vnp_Amount</p>";
echo "<p>Hash Data: $hashdata</p>";
echo "<p>Secure Hash: $vnpSecureHash</p>";
echo "<hr>";
echo "<p><a href='$vnp_Url'>Click here to continue to VNPay</a></p>";
die();
*/

// Chuyển hướng sang VNPay
header('Location: ' . $vnp_Url);
die();
