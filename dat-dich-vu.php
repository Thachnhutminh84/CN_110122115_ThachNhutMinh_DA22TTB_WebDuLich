<?php
session_start();
require_once 'config/database.php';
require_once 'check-auth.php';

$query = "SELECT * FROM services WHERE status = 'active' ORDER BY name ASC";
$result = $conn->query($query);
$services = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Dịch Vụ - Du Lịch Campuchia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/booking-system-new.css">
    <style>
        .service-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .service-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .service-card.selected {
            border-color: #007bff;
            background-color: #f0f7ff;
        }
        .service-price {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            margin: 10px 0;
        }
        .booking-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            margin-top: 30px;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .form-section h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }
        .btn-book {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .alert-info {
            background-color: #e7f3ff;
            border-color: #b3d9ff;
            color: #004085;
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">
                    <i class="fas fa-concierge-bell"></i> Đặt Dịch Vụ
                </h1>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Chọn dịch vụ bạn muốn đặt và điền thông tin chi tiết
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h4 class="mb-4">Chọn Dịch Vụ</h4>
                <div id="servicesList">
                    <?php foreach ($services as $service): ?>
                    <div class="service-card" data-service-id="<?php echo $service['id']; ?>" 
                         data-service-name="<?php echo htmlspecialchars($service['name']); ?>"
                         data-service-price="<?php echo $service['price']; ?>">
                        <h5><?php echo htmlspecialchars($service['name']); ?></h5>
                        <p class="text-muted"><?php echo htmlspecialchars($service['description']); ?></p>
                        <div class="service-price">
                            <?php echo number_format($service['price'], 0, ',', '.'); ?> VNĐ
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Thời gian: <?php echo $service['duration']; ?> giờ
                        </small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="booking-form">
                    <form id="bookingForm">
                        <div class="form-section">
                            <h5>Thông Tin Dịch Vụ</h5>
                            <div class="mb-3">
                                <label class="form-label">Dịch Vụ Được Chọn</label>
                                <input type="text" class="form-control" id="selectedService" readonly>
                                <input type="hidden" name="service_id" id="serviceId">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giá Dịch Vụ</label>
                                <input type="text" class="form-control" id="servicePrice" readonly>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5>Thông Tin Khách Hàng</h5>
                            <div class="mb-3">
                                <label class="form-label">Họ Tên</label>
                                <input type="text" class="form-control" name="customer_name" 
                                       value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="customer_email" 
                                       value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số Điện Thoại</label>
                                <input type="tel" class="form-control" name="customer_phone" 
                                       value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5>Chi Tiết Đặt Dịch Vụ</h5>
                            <div class="mb-3">
                                <label class="form-label">Du Lịch Ở Đâu</label>
                                <input type="text" class="form-control" name="destination" 
                                       placeholder="VD: Hà Nội, Sapa, Hạ Long, Đà Nẵng..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày Sử Dụng</label>
                                <input type="date" class="form-control" name="booking_date" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giờ Bắt Đầu</label>
                                <input type="time" class="form-control" name="start_time" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số Lượng Người</label>
                                <input type="number" class="form-control" name="quantity" min="1" value="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ghi Chú Thêm</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Nhập ghi chú nếu có..."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-book btn-lg w-100">
                            <i class="fas fa-check-circle"></i> Xác Nhận Đặt Dịch Vụ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                
                const serviceId = this.dataset.serviceId;
                const serviceName = this.dataset.serviceName;
                const servicePrice = this.dataset.servicePrice;
                
                document.getElementById('serviceId').value = serviceId;
                document.getElementById('selectedService').value = serviceName;
                document.getElementById('servicePrice').value = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(servicePrice);
            });
        });

        const today = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="booking_date"]').setAttribute('min', today);

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!document.getElementById('serviceId').value) {
                alert('Vui lòng chọn dịch vụ');
                return false;
            }

            const formData = new FormData(this);
            
            fetch('api/create-service-booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'payment-service-method.php?booking_id=' + data.booking_id;
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(error => {
                alert('Lỗi khi tạo booking');
                console.error(error);
            });
        });
    </script>
</body>
</html>
