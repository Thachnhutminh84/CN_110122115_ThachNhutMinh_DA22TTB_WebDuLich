<?php
session_start();
require_once 'config/database.php';
require_once 'check-auth.php';

$booking_id = $_POST['booking_id'] ?? $_GET['booking_id'] ?? null;

if (!$booking_id) {
    die('Thiếu thông tin booking');
}

// Khởi tạo database connection
$database = new Database();
$conn = $database->getConnection();

if (!$conn) {
    die('Lỗi kết nối database');
}

// Tìm booking
try {
    $query = "SELECT * FROM tour_bookings WHERE id = :id OR booking_code = :code";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $booking_id, ':code' => $booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$booking) {
        die('Không tìm thấy booking');
    }
} catch (Exception $e) {
    die('Lỗi: ' . $e->getMessage());
}

$total_amount = $booking['total_price'];

// Xử lý AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    
    $bank_name = $_POST['bank_name'] ?? '';
    $account_number = $_POST['account_number'] ?? '';
    $account_holder = $_POST['account_holder'] ?? '';
    
    try {
        $insert_query = "INSERT INTO payment_confirmations 
                         (booking_code, bank_name, account_number, account_name, amount, status, created_at) 
                         VALUES (:booking_code, :bank_name, :account_number, :account_holder, :amount, 'pending', NOW())";
        
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->execute([
            ':booking_code' => $booking['booking_code'],
            ':bank_name' => $bank_name,
            ':account_number' => $account_number,
            ':account_holder' => $account_holder,
            ':amount' => $total_amount
        ]);
        
        echo json_encode(['success' => true]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .payment-container {
            max-width: 600px;
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
        .payment-header h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .payment-header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .total-amount {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }
        .total-amount-value {
            font-size: 32px;
            font-weight: 700;
        }
        .form-section {
            margin-bottom: 25px;
        }
        .form-section h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .btn-payment {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-payment:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .btn-back {
            width: 100%;
            padding: 12px;
            background: #f0f0f0;
            color: #333;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-back:hover {
            background: #e0e0e0;
        }
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .success-box {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
        }
        .success-icon {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        .required {
            color: #dc3545;
        }
        .payment-content {
            padding: 40px 30px;
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="payment-container">
        <div class="payment-header">
            <h2><i class="fas fa-money-check-alt me-2"></i>Thanh Toán Tour</h2>
            <p>Vui lòng nhập thông tin tài khoản chuyển khoản</p>
        </div>
        
        <div class="payment-content">
            <div id="successMessage" style="display: none;" class="success-box">
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

            <div id="formContent">
                <div class="total-amount">
                    <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Tổng Tiền Thanh Toán</div>
                    <div class="total-amount-value"><?php echo number_format($total_amount, 0, ',', '.'); ?> VNĐ</div>
                </div>

                <div id="errorMessage" style="display: none;" class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><span id="errorText"></span>
                </div>

                <form id="paymentForm">
                    <div class="form-section">
                        <h5>Thông Tin Tài Khoản Chuyển Khoản</h5>

                        <div class="form-group">
                            <label>Chọn Ngân Hàng <span class="required">*</span></label>
                            <select name="bank_name" required>
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
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Số Tài Khoản <span class="required">*</span></label>
                            <input type="text" name="account_number" placeholder="Nhập số tài khoản" required>
                        </div>

                        <div class="form-group">
                            <label>Tên Chủ Tài Khoản <span class="required">*</span></label>
                            <input type="text" name="account_holder" placeholder="Nhập tên chủ tài khoản" required>
                        </div>

                        <div class="form-group">
                            <label>Số Tiền Cần Chuyển <span class="required">*</span></label>
                            <input type="number" name="transfer_amount" placeholder="Nhập số tiền" value="<?php echo $total_amount; ?>" required min="1000" step="1000">
                            <small style="color: #999; margin-top: 5px; display: block;">Số tiền phải khớp với tổng tiền: <?php echo number_format($total_amount, 0, ',', '.'); ?> VNĐ</small>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5>Thông Tin Người Thanh Toán</h5>

                        <div class="form-group">
                            <label>Họ Tên <span class="required">*</span></label>
                            <input type="text" name="payer_name" placeholder="Nhập họ và tên" required>
                        </div>

                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="payer_email" placeholder="Nhập email" required>
                        </div>

                        <div class="form-group">
                            <label>Số Điện Thoại <span class="required">*</span></label>
                            <input type="tel" name="payer_phone" placeholder="Nhập số điện thoại" required>
                        </div>
                    </div>

                    <div class="alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Lưu ý:</strong> Vui lòng nhập đúng thông tin tài khoản bạn đã chuyển khoản.
                    </div>

                    <button type="submit" class="btn-payment">
                        <i class="fas fa-check-circle me-2"></i>Xác Nhận Đã Chuyển Khoản
                    </button>
                </form>

                <button type="button" class="btn-back" onclick="history.back()">
                    <i class="fas fa-arrow-left me-2"></i>Quay Lại
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.getElementById('paymentForm');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('ajax', '1');
            formData.append('booking_id', '<?php echo htmlspecialchars($booking['id']); ?>');

            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';

            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('formContent').style.display = 'none';
                    document.getElementById('successMessage').style.display = 'block';
                } else {
                    document.getElementById('errorText').textContent = data.error || 'Có lỗi xảy ra';
                    document.getElementById('errorMessage').style.display = 'block';
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Xác Nhận Đã Chuyển Khoản';
                }
            })
            .catch(error => {
                document.getElementById('errorText').textContent = 'Lỗi kết nối';
                document.getElementById('errorMessage').style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Xác Nhận Đã Chuyển Khoản';
            });
        });

        // Xử lý input số tài khoản
        const accountInputs = document.querySelectorAll('input[name="account_number"]');
        accountInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });

        // Xử lý input tên chủ tài khoản
        const holderInputs = document.querySelectorAll('input[name="account_holder"]');
        holderInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
</body>
</html>
