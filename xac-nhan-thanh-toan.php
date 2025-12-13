<?php
session_start();
require_once 'config/database.php';

// Lấy booking code từ URL
$bookingCode = $_GET['booking_code'] ?? null;

if (!$bookingCode) {
    header('Location: index.php');
    exit;
}

// Lấy thông tin booking
$database = new Database();
$db = $database->getConnection();

$query = "SELECT sb.*, s.service_name 
          FROM service_bookings sb
          LEFT JOIN services s ON sb.service_id = s.service_id
          WHERE sb.booking_code = :booking_code";
$stmt = $db->prepare($query);
$stmt->bindParam(':booking_code', $bookingCode);
$stmt->execute();
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    header('Location: index.php');
    exit;
}

$amount = $booking['total_price'] > 0 ? $booking['total_price'] : 100000;

// Xử lý submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bankName = $_POST['bank_name'] ?? '';
    $accountNumber = $_POST['account_number'] ?? '';
    $accountName = $_POST['account_name'] ?? '';
    $transferAmount = $_POST['transfer_amount'] ?? 0;
    $transferNote = $_POST['transfer_note'] ?? '';
    
    // Lưu thông tin thanh toán vào database
    $query = "INSERT INTO payment_confirmations 
              (booking_code, bank_name, account_number, account_name, amount, transfer_note, status, created_at) 
              VALUES 
              (:booking_code, :bank_name, :account_number, :account_name, :amount, :transfer_note, 'pending', NOW())";
    
    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':booking_code', $bookingCode);
        $stmt->bindParam(':bank_name', $bankName);
        $stmt->bindParam(':account_number', $accountNumber);
        $stmt->bindParam(':account_name', $accountName);
        $stmt->bindParam(':amount', $transferAmount);
        $stmt->bindParam(':transfer_note', $transferNote);
        $stmt->execute();
        
        $success = true;
    } catch (Exception $e) {
        $error = "Có lỗi xảy ra: " . $e->getMessage();
    }
}

$pageTitle = "Xác Nhận Thanh Toán";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .payment-container {
            max-width: 700px;
            margin: 0 auto;
        }
        
        .payment-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .payment-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .form-section {
            padding: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .amount-display {
            background: #f8f9fa;
            border: 2px dashed #667eea;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .amount-value {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
        }
        
        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-card">
            <!-- Header -->
            <div class="payment-header">
                <h2 class="mb-2"><i class="fas fa-money-check-alt me-2"></i>Xác Nhận Thanh Toán</h2>
                <p class="mb-0">Mã đặt dịch vụ: <strong><?php echo $bookingCode; ?></strong></p>
            </div>

            <div class="form-section">
                <?php if (isset($success) && $success): ?>
                    <!-- Success Message -->
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h4>Xác Nhận Thành Công!</h4>
                        <p class="mb-3">Chúng tôi đã nhận được thông tin thanh toán của bạn.</p>
                        <p class="mb-4">Chúng tôi sẽ kiểm tra và xác nhận trong vòng 30 phút.</p>
                        <a href="index.php" class="btn btn-success btn-lg">
                            <i class="fas fa-home me-2"></i>Về Trang Chủ
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Payment Form -->
                    <div class="amount-display">
                        <div style="font-size: 0.9rem; color: #6c757d; margin-bottom: 0.5rem;">
                            Số tiền cần thanh toán
                        </div>
                        <div class="amount-value"><?php echo number_format($amount); ?> VNĐ</div>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="paymentForm">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-university me-2"></i>Ngân hàng *
                            </label>
                            <select class="form-select" name="bank_name" required>
                                <option value="">-- Chọn ngân hàng --</option>
                                <option value="Vietcombank">Vietcombank</option>
                                <option value="VietinBank">VietinBank</option>
                                <option value="BIDV">BIDV</option>
                                <option value="Agribank">Agribank</option>
                                <option value="Techcombank">Techcombank</option>
                                <option value="MB Bank">MB Bank</option>
                                <option value="ACB">ACB</option>
                                <option value="VPBank">VPBank</option>
                                <option value="TPBank">TPBank</option>
                                <option value="Sacombank">Sacombank</option>
                                <option value="HDBank">HDBank</option>
                                <option value="SHB">SHB</option>
                                <option value="VIB">VIB</option>
                                <option value="OCB">OCB</option>
                                <option value="MSB">MSB</option>
                                <option value="Khác">Ngân hàng khác</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-credit-card me-2"></i>Số tài khoản *
                            </label>
                            <input type="text" class="form-control" name="account_number" 
                                   placeholder="Nhập số tài khoản" required
                                   pattern="[0-9]{9,16}" title="Số tài khoản từ 9-16 chữ số">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>Tên chủ tài khoản *
                            </label>
                            <input type="text" class="form-control" name="account_name" 
                                   placeholder="VD: NGUYEN VAN A" required
                                   style="text-transform: uppercase;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Số tiền chuyển khoản *
                            </label>
                            <input type="number" class="form-control" name="transfer_amount" 
                                   value="<?php echo $amount; ?>" required min="1000" step="1000"
                                   placeholder="Nhập số tiền">
                            <small class="text-muted">Số tiền phải khớp với số tiền cần thanh toán</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-comment-alt me-2"></i>Nội dung chuyển khoản
                            </label>
                            <input type="text" class="form-control" name="transfer_note" 
                                   value="DV <?php echo $bookingCode; ?>" readonly
                                   style="background: #f8f9fa;">
                            <small class="text-muted">Vui lòng ghi đúng nội dung này khi chuyển khoản</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Lưu ý:</strong> Vui lòng nhập đúng thông tin tài khoản bạn đã chuyển khoản. 
                            Chúng tôi sẽ kiểm tra và xác nhận thanh toán của bạn.
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-check-circle me-2"></i>Xác Nhận Đã Chuyển Khoản
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php" class="btn btn-link text-muted">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại trang chủ
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Auto uppercase tên chủ tài khoản
        document.querySelector('input[name="account_name"]').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });

        // Validate form
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const amount = parseInt(document.querySelector('input[name="transfer_amount"]').value);
            const expectedAmount = <?php echo $amount; ?>;
            
            if (amount !== expectedAmount) {
                if (!confirm(`Số tiền bạn nhập (${amount.toLocaleString()} VNĐ) khác với số tiền cần thanh toán (${expectedAmount.toLocaleString()} VNĐ). Bạn có chắc chắn muốn tiếp tục?`)) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>
