<?php
session_start();
require_once 'check-auth.php';

if (!isset($_SESSION['user'])) {
    header('Location: dang-nhap.php');
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân - <?php echo htmlspecialchars($user['full_name']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        .profile-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .profile-info h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .profile-info p {
            opacity: 0.9;
            margin: 5px 0;
        }

        .profile-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid #ecf0f1;
        }

        .tab-button {
            padding: 15px 30px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #7f8c8d;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }

        .tab-button.active {
            color: #3498db;
            border-bottom-color: #3498db;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .info-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .info-label {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .info-value {
            color: #2c3e50;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .booking-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .booking-code {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .booking-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .booking-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .detail-item {
            display: flex;
            gap: 10px;
        }

        .detail-label {
            color: #7f8c8d;
            min-width: 120px;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 500;
        }

        .btn-edit-profile {
            padding: 12px 30px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 20px;
        }

        .btn-edit-profile:hover {
            background: #2980b9;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            color: #7f8c8d;
        }

        .empty-state img {
            width: 200px;
            opacity: 0.5;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .info-grid,
            .booking-details {
                grid-template-columns: 1fr;
            }

            .profile-tabs {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user['full_name']); ?></h1>
                <p>📧 <?php echo htmlspecialchars($user['email']); ?></p>
                <p>📱 <?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?></p>
                <p>👤 Vai trò: <strong><?php 
                    $roles = ['admin' => 'Quản trị viên', 'manager' => 'Quản lý', 'user' => 'Người dùng'];
                    echo $roles[$user['role']] ?? $user['role']; 
                ?></strong></p>
            </div>
        </div>

        <div class="profile-tabs">
            <button class="tab-button active" onclick="switchTab('info')">
                📋 Thông Tin Cá Nhân
            </button>
            <button class="tab-button" onclick="switchTab('bookings')">
                🎫 Lịch Sử Đặt Tour
            </button>
            <button class="tab-button" onclick="switchTab('services')">
                🛎️ Lịch Sử Đặt Dịch Vụ
            </button>
        </div>

        <!-- Tab Thông Tin -->
        <div id="tab-info" class="tab-content active">
            <div class="info-card">
                <h2 style="margin-bottom: 20px;">Thông Tin Tài Khoản</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Tên đăng nhập</div>
                        <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Họ và tên</div>
                        <div class="info-value"><?php echo htmlspecialchars($user['full_name']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Số điện thoại</div>
                        <div class="info-value"><?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Vai trò</div>
                        <div class="info-value"><?php 
                            $roles = ['admin' => 'Quản trị viên', 'manager' => 'Quản lý', 'user' => 'Người dùng'];
                            echo $roles[$user['role']] ?? $user['role']; 
                        ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ngày tạo</div>
                        <div class="info-value"><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></div>
                    </div>
                </div>
                <button class="btn-edit-profile" onclick="alert('Chức năng đang phát triển')">
                    ✏️ Chỉnh Sửa Thông Tin
                </button>
            </div>
        </div>

        <!-- Tab Lịch Sử Đặt Tour -->
        <div id="tab-bookings" class="tab-content">
            <div id="bookingsList">
                <div class="empty-state">Đang tải...</div>
            </div>
        </div>

        <!-- Tab Lịch Sử Đặt Dịch Vụ -->
        <div id="tab-services" class="tab-content">
            <div id="servicesList">
                <div class="empty-state">Đang tải...</div>
            </div>
        </div>
    </div>

    <script>
        const userId = <?php echo $user['id']; ?>;

        function switchTab(tabName) {
            // Ẩn tất cả tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Hiện tab được chọn
            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.classList.add('active');

            // Load dữ liệu nếu chưa load
            if (tabName === 'bookings' && !window.bookingsLoaded) {
                loadBookings();
                window.bookingsLoaded = true;
            } else if (tabName === 'services' && !window.servicesLoaded) {
                loadServices();
                window.servicesLoaded = true;
            }
        }

        async function loadBookings() {
            try {
                const response = await fetch(`api/bookings.php?user_id=${userId}`);
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    displayBookings(result.data);
                } else {
                    document.getElementById('bookingsList').innerHTML = `
                        <div class="empty-state">
                            <p style="font-size: 3rem;">🎫</p>
                            <h3>Chưa có booking nào</h3>
                            <p>Bạn chưa đặt tour nào. Hãy khám phá các tour du lịch hấp dẫn!</p>
                            <a href="danh-sach-tour.php" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: #3498db; color: white; text-decoration: none; border-radius: 8px;">
                                Xem Tour
                            </a>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('bookingsList').innerHTML = 
                    '<div class="empty-state">Lỗi khi tải dữ liệu</div>';
            }
        }

        function displayBookings(bookings) {
            document.getElementById('bookingsList').innerHTML = bookings.map(booking => `
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="booking-code">📋 ${booking.booking_code}</div>
                        <span class="booking-status status-${booking.booking_status}">
                            ${getStatusText(booking.booking_status)}
                        </span>
                    </div>
                    <div class="booking-details">
                        <div class="detail-item">
                            <span class="detail-label">Ngày đặt:</span>
                            <span class="detail-value">${formatDate(booking.booking_date)}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Số người:</span>
                            <span class="detail-value">
                                ${booking.num_adults} người lớn, ${booking.num_children} trẻ em
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tổng tiền:</span>
                            <span class="detail-value" style="color: #e74c3c; font-size: 1.2rem;">
                                ${formatPrice(booking.total_price)}đ
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Thanh toán:</span>
                            <span class="detail-value">${getPaymentStatusText(booking.payment_status)}</span>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        async function loadServices() {
            try {
                const response = await fetch('api/service-bookings.php');
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    // Filter by customer email (vì service_bookings không có user_id)
                    const userEmail = '<?php echo $user['email']; ?>';
                    const userServices = result.data.filter(s => s.customer_email === userEmail);
                    
                    if (userServices.length > 0) {
                        displayServices(userServices);
                    } else {
                        showEmptyServices();
                    }
                } else {
                    showEmptyServices();
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('servicesList').innerHTML = 
                    '<div class="empty-state">Lỗi khi tải dữ liệu</div>';
            }
        }

        function showEmptyServices() {
            document.getElementById('servicesList').innerHTML = `
                <div class="empty-state">
                    <p style="font-size: 3rem;">🛎️</p>
                    <h3>Chưa có dịch vụ nào</h3>
                    <p>Bạn chưa đặt dịch vụ nào.</p>
                    <a href="dat-dich-vu.php" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: #3498db; color: white; text-decoration: none; border-radius: 8px;">
                        Đặt Dịch Vụ
                    </a>
                </div>
            `;
        }

        function displayServices(services) {
            document.getElementById('servicesList').innerHTML = services.map(service => `
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="booking-code">🛎️ ${service.booking_code}</div>
                        <span class="booking-status status-${service.status}">
                            ${getStatusText(service.status)}
                        </span>
                    </div>
                    <div class="booking-details">
                        <div class="detail-item">
                            <span class="detail-label">Ngày đặt:</span>
                            <span class="detail-value">${formatDate(service.created_at)}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Ngày sử dụng:</span>
                            <span class="detail-value">${formatDate(service.service_date)}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Số người:</span>
                            <span class="detail-value">${service.number_of_people} người</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tổng tiền:</span>
                            <span class="detail-value" style="color: #e74c3c; font-size: 1.2rem;">
                                ${formatPrice(service.total_price)}đ
                            </span>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function getStatusText(status) {
            const statusMap = {
                'pending': 'Chờ xác nhận',
                'confirmed': 'Đã xác nhận',
                'completed': 'Hoàn thành',
                'cancelled': 'Đã hủy'
            };
            return statusMap[status] || status;
        }

        function getPaymentStatusText(status) {
            const statusMap = {
                'pending': 'Chưa thanh toán',
                'paid': 'Đã thanh toán',
                'failed': 'Thất bại',
                'refunded': 'Đã hoàn tiền'
            };
            return statusMap[status] || status;
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }
    </script>
</body>
</html>
