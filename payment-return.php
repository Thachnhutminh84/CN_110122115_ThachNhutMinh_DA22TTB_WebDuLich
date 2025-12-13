<?php
session_start();
require_once 'config/database.php';
require_once 'models/ServiceBooking.php';

$paymentMethod = $_GET['method'] ?? 'unknown';
$success = false;
$message = '';
$bookingCode = '';

// Xử lý callback từ VNPay
if ($paymentMethod === 'vnpay') {
    $vnpayConfig = require_once 'config/vnpay.php';
    $vnp_HashSecret = $vnpayConfig['vnp_HashSecret'];
    
    $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
    $inputData = array();
    
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }
    
    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    
    $hashData = "";
    $i = 0;
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }
    
    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    
    if ($secureHash == $vnp_SecureHash) {
        if ($_GET['vnp_ResponseCode'] == '00') {
            $success = true;
            $message = 'Thanh toán thành công qua VNPay';
            $bookingCode = $_GET['vnp_TxnRef'];
            
            // Cập nhật trạng thái thanh toán
            $database = new Database();
            $db = $database->getConnection();
            $serviceBooking = new ServiceBooking($db);
            $serviceBooking->updatePaymentStatus($bookingCode, 'paid', 'vnpay');
            $serviceBooking->updateStatus($bookingCode, 'confirmed');
        } else {
            $message = 'Thanh toán thất bại. Mã lỗi: ' . $_GET['vnp_ResponseCode'];
        }
    } else {
        $message = 'Chữ ký không hợp lệ';
    }
}

// Xử lý callback từ MoMo
elseif ($paymentMethod === 'momo') {
    $momoConfig = require_once 'config/momo.php';
    $secretKey = $momoConfig['secretKey'];
    
    $partnerCode = $_GET['partnerCode'] ?? '';
    $orderId = $_GET['orderId'] ?? '';
    $requestId = $_GET['requestId'] ?? '';
    $amount = $_GET['amount'] ?? 0;
    $orderInfo = $_GET['orderInfo'] ?? '';
    $orderType = $_GET['orderType'] ?? '';
    $transId = $_GET['transId'] ?? '';
    $resultCode = $_GET['resultCode'] ?? '';
    $message = $_GET['message'] ?? '';
    $payType = $_GET['payType'] ?? '';
    $responseTime = $_GET['responseTime'] ?? '';
    $extraData = $_GET['extraData'] ?? '';
    $signature = $_GET['signature'] ?? '';
    
    // Xác thực chữ ký
    $rawHash = "accessKey=" . $momoConfig['accessKey'] .
               "&amount=" . $amount .
               "&extraData=" . $extraData .
               "&message=" . $message .
               "&orderId=" . $orderId .
               "&orderInfo=" . $orderInfo .
               "&orderType=" . $orderType .
               "&partnerCode=" . $partnerCode .
               "&payType=" . $payType .
               "&requestId=" . $requestId .
               "&responseTime=" . $responseTime .
               "&resultCode=" . $resultCode .
               "&transId=" . $transId;
    
    $checkSignature = hash_hmac("sha256", $rawHash, $secretKey);
    
    if ($signature == $checkSignature) {
        if ($resultCode == '0') {
            $success = true;
            $message = 'Thanh toán thành công qua MoMo';
            $bookingCode = $orderId;
            
            // Cập nhật trạng thái thanh toán
            $database = new Database();
            $db = $database->getConnection();
            $serviceBooking = new ServiceBooking($db);
            $serviceBooking->updatePaymentStatus($bookingCode, 'paid', 'momo');
            $serviceBooking->updateStatus($bookingCode, 'confirmed');
        } else {
            $message = 'Thanh toán thất bại. ' . $message;
        }
    } else {
        $message = 'Chữ ký không hợp lệ';
    }
}

$pageTitle = $success ? 'Thanh toán thành công' : 'Thanh toán thất bại';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Du Lịch Sóc Trăng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body text-center p-5">
                        <?php if ($success): ?>
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                            </div>
                            <h2 class="text-success mb-3">Thanh toán thành công!</h2>
                            <p class="lead"><?php echo htmlspecialchars($message); ?></p>
                            <div class="alert alert-info mt-4">
                                <strong>Mã đặt dịch vụ:</strong> <?php echo htmlspecialchars($bookingCode); ?>
                            </div>
                            <p class="text-muted">Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận dịch vụ.</p>
                        <?php else: ?>
                            <div class="mb-4">
                                <i class="fas fa-times-circle text-danger" style="font-size: 5rem;"></i>
                            </div>
                            <h2 class="text-danger mb-3">Thanh toán thất bại!</h2>
                            <p class="lead"><?php echo htmlspecialchars($message); ?></p>
                            <p class="text-muted">Vui lòng thử lại hoặc liên hệ với chúng tôi để được hỗ trợ.</p>
                        <?php endif; ?>
                        
                        <div class="mt-4">
                            <a href="index.php" class="btn btn-primary btn-lg me-2">
                                <i class="fas fa-home me-2"></i>Về trang chủ
                            </a>
                            <?php if (!$success): ?>
                            <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Thử lại
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
