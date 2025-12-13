<?php
/**
 * Trang Đặt Tour với Thanh Toán VNPay
 */
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Tour - Thanh Toán VNPay</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .form-content {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .form-group label i {
            margin-right: 8px;
            color: #3498db;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .payment-option {
            padding: 15px;
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-option:hover {
            border-color: #3498db;
            background: #f8f9fa;
        }

        .payment-option.selected {
            border-color: #27ae60;
            background: #d4edda;
        }

        .payment-option input[type="radio"] {
            width: auto;
        }

        #bankCodeGroup {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #229954;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .info-box {
            background: #e8f5e9;
            border-left: 4px solid #27ae60;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎫 Đặt Tour Du Lịch</h1>
            <p>Điền thông tin và chọn phương thức thanh toán</p>
        </div>

        <div class="form-content">
            <div class="info-box">
                <strong>💡 Lưu ý:</strong> Chọn thanh toán VNPay để thanh toán online ngay
            </div>

            <form id="bookingForm" method="POST" action="process-booking.php">
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Họ và tên *</label>
                        <input type="text" name="customer_name" required placeholder="Nguyễn Văn A">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Số điện thoại *</label>
                        <input type="tel" name="customer_phone" required placeholder="0901234567">
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email *</label>
                    <input type="email" name="customer_email" required placeholder="email@example.com">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-users"></i> Số người lớn *</label>
                        <input type="number" name="num_adults" required min="1" value="1">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-child"></i> Số trẻ em</label>
                        <input type="number" name="num_children" min="0" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> Ngày khởi hành *</label>
                    <input type="date" name="departure_date" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-comment"></i> Yêu cầu đặc biệt</label>
                    <textarea name="special_requests" rows="3" placeholder="Ghi chú thêm (nếu có)"></textarea>
                </div>

                <input type="hidden" name="payment_method" value="online">

                <button type="submit" class="btn-submit">
                    <i class="fas fa-check-circle"></i> Đặt Tour Ngay
                </button>
            </form>
        </div>
    </div>

    <script>
        // Xử lý submit form - Hiển thị loading
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-submit');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
            submitBtn.disabled = true;
            // Form sẽ submit bình thường đến process-booking.php
        });

        // Set ngày tối thiểu là ngày mai
        const dateInput = document.querySelector('input[name="departure_date"]');
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        dateInput.min = tomorrow.toISOString().split('T')[0];
    </script>
</body>
</html>
