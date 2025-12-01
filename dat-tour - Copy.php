<?php
/**
 * Trang Đặt Tour - PHP Version
 */

session_start();

require_once 'config/database.php';
require_once 'models/Attraction.php';

// Lấy ID từ URL
$attractionId = isset($_GET['id']) ? $_GET['id'] : '';
$success = false;
$error = '';

if (empty($attractionId)) {
    header('Location: dia-diem-du-lich-dynamic.php');
    exit();
}

// Khởi tạo database
try {
    $database = new Database();
    $db = $database->getConnection();
    $attraction = new Attraction($db);
    
    $attraction->attraction_id = $attractionId;
    
    if (!$attraction->readOne()) {
        header('Location: dia-diem-du-lich-dynamic.php');
        exit();
    }
    
} catch (Exception $e) {
    $error = $e->getMessage();
}

// Không xử lý form submit ở đây nữa - sẽ dùng AJAX
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Tour - <?php echo htmlspecialchars($attraction->name); ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsive.css">
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
            max-width: 800px;
            margin: 0 auto;
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

        .header p {
            font-size: 1.2em;
            opacity: 0.9;
        }

        .back-link {
            display: inline-block;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            transition: all 0.3s;
        }

        .back-link:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .content {
            padding: 40px;
        }

        .attraction-info {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .attraction-info h2 {
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        .attraction-info p {
            opacity: 0.9;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 2px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 2px solid #ef4444;
        }

        .success-message {
            text-align: center;
            padding: 40px;
        }

        .success-message i {
            font-size: 5em;
            color: #10b981;
            margin-bottom: 20px;
        }

        .success-message h2 {
            font-size: 2em;
            color: #1f2937;
            margin-bottom: 15px;
        }

        .success-message p {
            color: #6b7280;
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            text-decoration: none;
            display: inline-block;
            padding: 15px 30px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="chi-tiet-dia-diem.php?id=<?php echo urlencode($attractionId); ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
            <h1>🎫 Đặt Tour Tham Quan</h1>
            <p>Điền thông tin để đặt tour</p>
        </div>

        <div class="content">
            <?php if ($success): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <h2>Đặt Tour Thành Công!</h2>
                    <p>
                        Cảm ơn bạn đã đặt tour tham quan <strong><?php echo htmlspecialchars($attraction->name); ?></strong>.<br>
                        Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận thông tin.
                    </p>
                    <a href="dia-diem-du-lich-dynamic.php" class="btn-secondary">
                        <i class="fas fa-home"></i> Về Trang Chủ
                    </a>
                </div>
            <?php else: ?>
                <div class="attraction-info">
                    <h2><?php echo htmlspecialchars($attraction->name); ?></h2>
                    <p>
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo htmlspecialchars($attraction->location); ?>
                    </p>
                    <p>
                        <i class="fas fa-ticket-alt"></i>
                        Giá vé: <?php echo htmlspecialchars($attraction->ticket_price ?? 'Miễn phí'); ?>
                    </p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <!-- Alert Messages -->
                <div id="alertMessage" class="hidden"></div>

                <form id="bookingForm">
                    <div class="form-group">
                        <label for="customer_name">
                            Họ và Tên <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="customer_name" 
                               name="customer_name" 
                               class="form-control" 
                               placeholder="Nguyễn Văn A"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="customer_phone">
                            Số Điện Thoại <span class="required">*</span>
                        </label>
                        <input type="tel" 
                               id="customer_phone" 
                               name="customer_phone" 
                               class="form-control" 
                               placeholder="0912345678"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="customer_email">
                            Email
                        </label>
                        <input type="email" 
                               id="customer_email" 
                               name="customer_email" 
                               class="form-control" 
                               placeholder="email@example.com">
                    </div>

                    <div class="form-group">
                        <label for="booking_date">
                            Ngày Tham Quan <span class="required">*</span>
                        </label>
                        <input type="date" 
                               id="booking_date" 
                               name="booking_date" 
                               class="form-control"
                               min="<?php echo date('Y-m-d'); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="number_of_people">
                            Số Người
                        </label>
                        <input type="number" 
                               id="number_of_people" 
                               name="number_of_people" 
                               class="form-control" 
                               value="1"
                               min="1"
                               max="100">
                    </div>

                    <div class="form-group">
                        <label for="special_requests">
                            Ghi Chú
                        </label>
                        <textarea id="special_requests" 
                                  name="special_requests" 
                                  class="form-control" 
                                  placeholder="Yêu cầu đặc biệt, câu hỏi..."></textarea>
                    </div>

                    <button type="submit" id="submitBtn" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Xác Nhận Đặt Tour
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Xử lý form submit
        document.getElementById('bookingForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const alertMessage = document.getElementById('alertMessage');
            
            // Disable button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
            
            // Lấy dữ liệu form
            const formData = {
                attraction_id: '<?php echo $attractionId; ?>',
                customer_name: document.getElementById('customer_name').value,
                customer_phone: document.getElementById('customer_phone').value,
                customer_email: document.getElementById('customer_email').value,
                booking_date: document.getElementById('booking_date').value,
                number_of_people: parseInt(document.getElementById('number_of_people').value),
                special_requests: document.getElementById('special_requests').value
            };
            
            try {
                const response = await fetch('api/bookings.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                
                const result = await response.json();
                
                // Hiển thị thông báo
                alertMessage.classList.remove('hidden');
                
                if (result.success) {
                    alertMessage.className = 'alert alert-success';
                    alertMessage.innerHTML = '<i class="fas fa-check-circle"></i>' + result.message;
                    
                    // Redirect sau 2 giây
                    setTimeout(() => {
                        window.location.href = 'dia-diem-du-lich-dynamic.php';
                    }, 2000);
                } else {
                    alertMessage.className = 'alert alert-error';
                    alertMessage.innerHTML = '<i class="fas fa-exclamation-circle"></i>' + result.message;
                    
                    // Enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Xác Nhận Đặt Tour';
                }
                
            } catch (error) {
                alertMessage.classList.remove('hidden');
                alertMessage.className = 'alert alert-error';
                alertMessage.innerHTML = '<i class="fas fa-exclamation-circle"></i>Có lỗi xảy ra. Vui lòng thử lại!';
                
                // Enable button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Xác Nhận Đặt Tour';
            }
        });
    </script>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>
