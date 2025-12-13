<?php
session_start();
require_once 'config/database.php';
require_once 'check-auth.php';

$booking_id = $_GET['booking_id'] ?? null;

if (!$booking_id) {
    die('Thiếu thông tin booking');
}

// Khởi tạo database connection
$database = new Database();
$conn = $database->getConnection();

if (!$conn) {
    die('Lỗi kết nối database');
}

// Tìm booking theo booking_code hoặc id
try {
    $query = "SELECT * FROM tour_bookings WHERE booking_code = :code OR id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':code' => $booking_id, ':id' => $booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$booking) {
        die('Không tìm thấy booking');
    }
} catch (Exception $e) {
    die('Lỗi: ' . $e->getMessage());
}

$total_amount = $booking['total_price'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Phương Thức Thanh Toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        .payment-method-container {
            max-width: 700px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .payment-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 40px 30px;
        }
        .payment-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .payment-header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .booking-summary {
            background: #f8f9fa;
            padding: 30px;
            border-bottom: 1px solid #e9ecef;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            font-weight: 600;
            font-size: 18px;
            color: #667eea;
        }
        .summary-row span {
            color: #666;
            font-weight: 500;
        }
        .summary-row strong {
            color: #333;
            font-weight: 600;
        }
        .payment-content {
            padding: 40px 30px;
        }
        .payment-methods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .payment-method-card {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }
        .payment-method-card:hover {
            border-color: #667eea;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
            transform: translateY(-8px);
        }
        .payment-method-card.selected {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }
        .payment-method-card.selected::after {
            content: '✓';
            position: absolute;
            top: 10px;
            right: 10px;
            background: #667eea;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }
        .payment-method-icon {
            font-size: 50px;
            margin-bottom: 15px;
            color: #667eea;
        }
        .payment-method-name {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        .payment-method-desc {
            font-size: 13px;
            color: #999;
            line-height: 1.6;
        }
        .payment-method-card input[type="radio"] {
            display: none;
        }
        .btn-continue {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        .btn-continue:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-continue:active {
            transform: translateY(-1px);
        }
        .btn-back {
            width: 100%;
            padding: 14px;
            background: #f0f0f0;
            color: #666;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 12px;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background: #e0e0e0;
            color: #333;
        }
        @media (max-width: 576px) {
            .payment-methods {
                grid-template-columns: 1fr;
            }
            .payment-header {
                padding: 30px 20px;
            }
            .payment-header h1 {
                font-size: 24px;
            }
            .booking-summary {
                padding: 20px;
            }
            .payment-content {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="payment-method-container">
        <div class="payment-header">
            <h1><i class="fas fa-credit-card me-2"></i>Chọn Phương Thức Thanh Toán</h1>
            <p>Vui lòng chọn phương thức thanh toán phù hợp</p>
        </div>

        <div class="booking-summary">
            <div class="summary-row">
                <span><i class="fas fa-barcode me-2"></i>Mã Booking:</span>
                <strong><?php echo htmlspecialchars($booking['booking_code']); ?></strong>
            </div>
            <div class="summary-row">
                <span><i class="fas fa-calendar me-2"></i>Ngày Khởi Hành:</span>
                <strong><?php echo date('d/m/Y', strtotime($booking['departure_date'])); ?></strong>
            </div>
            <div class="summary-row">
                <span><i class="fas fa-users me-2"></i>Số Người:</span>
                <strong><?php echo ($booking['num_adults'] + $booking['num_children']); ?> người</strong>
            </div>
            <div class="summary-row">
                <span><i class="fas fa-money-bill-wave me-2"></i>Tổng Tiền:</span>
                <strong><?php echo number_format($total_amount, 0, ',', '.'); ?> VNĐ</strong>
            </div>
        </div>

        <div class="payment-content">
            <!-- Phương thức thanh toán -->
            <form id="paymentMethodForm" method="POST" action="payment-tour-form.php">
                <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">

                <div class="payment-methods">
                    <label class="payment-method-card" onclick="selectMethod(this)">
                        <input type="radio" name="method" value="vnpay" required>
                        <div class="payment-method-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="payment-method-name">VNPay</div>
                        <div class="payment-method-desc">Thanh toán qua thẻ ngân hàng</div>
                    </label>

                    <label class="payment-method-card" onclick="selectMethod(this)">
                        <input type="radio" name="method" value="bank_transfer">
                        <div class="payment-method-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="payment-method-name">Chuyển Khoản</div>
                        <div class="payment-method-desc">Chuyển khoản ngân hàng</div>
                    </label>
                </div>

                <button type="submit" class="btn-continue">
                    <i class="fas fa-arrow-right me-2"></i>Tiếp Tục
                </button>
                <button type="button" class="btn-back" onclick="history.back()">
                    <i class="fas fa-arrow-left me-2"></i>Quay Lại
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectMethod(element) {
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('selected');
            });
            element.classList.add('selected');
            element.querySelector('input[type="radio"]').checked = true;
        }

        document.getElementById('paymentMethodForm').addEventListener('submit', function(e) {
            const selectedMethod = document.querySelector('input[name="method"]:checked');
            if (!selectedMethod) {
                e.preventDefault();
                alert('Vui lòng chọn phương thức thanh toán');
            }
        });
    </script>
</body>
</html>
