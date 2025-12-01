<?php
/**
 * Trang Quản Lý Đặt Tour
 * CHỈ ADMIN VÀ MANAGER MỚI TRUY CẬP ĐƯỢC
 */

session_start();

// Kiểm tra quyền truy cập - CHỈ ADMIN
require_once 'check-auth.php';
requireAdmin(); // Chỉ admin mới vào được

require_once 'config/database.php';
require_once 'models/Booking.php';

// Khởi tạo
try {
    $database = new Database();
    $db = $database->getConnection();
    $booking = new Booking($db);
    
    // Lấy danh sách bookings
    $stmt = $booking->readAll();
    $bookings = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $bookings[] = $row;
    }
    
    // Lấy thống kê
    $stats = $booking->getStatistics();
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $bookings = [];
    $stats = [];
}

// Màu sắc theo trạng thái
$statusColors = [
    'pending' => '#f59e0b',
    'confirmed' => '#3b82f6',
    'cancelled' => '#ef4444',
    'completed' => '#10b981'
];

$statusNames = [
    'pending' => 'Chờ xác nhận',
    'confirmed' => 'Đã xác nhận',
    'cancelled' => 'Đã hủy',
    'completed' => 'Hoàn thành'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đặt Tour - Du Lịch Trà Vinh</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/mobile-enhancements.css">
    <link rel="stylesheet" href="css/admin-responsive.css">
    <link rel="stylesheet" href="css/header-responsive-fix.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.8em;
        }

        .header h1 i {
            margin-right: 10px;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8em;
        }

        .stat-info h3 {
            font-size: 2em;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #6b7280;
            font-size: 0.9em;
        }

        .bookings-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            font-size: 1.3em;
            color: #1f2937;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 8px 15px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 0.9em;
        }

        .filter-btn:hover,
        .filter-btn.active {
            border-color: #667eea;
            color: #667eea;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #4b5563;
            font-size: 0.9em;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
        }

        tr:hover {
            background: #f9fafb;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            color: white;
            display: inline-block;
        }

        .customer-info {
            font-weight: 600;
            color: #1f2937;
        }

        .customer-contact {
            color: #6b7280;
            font-size: 0.9em;
            margin-top: 3px;
        }

        .attraction-name {
            font-weight: 600;
            color: #1f2937;
        }

        .attraction-location {
            color: #6b7280;
            font-size: 0.9em;
        }

        .booking-date {
            color: #1f2937;
            font-weight: 500;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85em;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            margin-right: 5px;
            border: none;
            cursor: pointer;
        }

        .btn-confirm {
            background: #3b82f6;
            color: white;
        }

        .btn-confirm:hover {
            background: #2563eb;
        }

        .btn-cancel {
            background: #ef4444;
            color: white;
        }

        .btn-cancel:hover {
            background: #dc2626;
        }

        .btn-complete {
            background: #10b981;
            color: white;
        }

        .btn-complete:hover {
            background: #059669;
        }

        .btn-delete {
            background: #6b7280;
            color: white;
        }

        .btn-delete:hover {
            background: #4b5563;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .no-data i {
            font-size: 4em;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1>
                <i class="fas fa-calendar-check"></i>
                Quản Lý Đặt Tour
            </h1>
            <a href="index.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>

    <!-- Container -->
    <div class="container">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['pending_count'] ?? 0; ?></h3>
                    <p>Chờ xác nhận</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['confirmed_count'] ?? 0; ?></h3>
                    <p>Đã xác nhận</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['total_people'] ?? 0; ?></h3>
                    <p>Tổng khách</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo number_format($stats['total_revenue'] ?? 0); ?></h3>
                    <p>Doanh thu (VNĐ)</p>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="bookings-table">
            <div class="table-header">
                <h2>Danh Sách Đặt Tour (<?php echo count($bookings); ?>)</h2>
                <div class="filter-buttons">
                    <button class="filter-btn active" onclick="filterBookings('all')">Tất cả</button>
                    <button class="filter-btn" onclick="filterBookings('pending')">Chờ xác nhận</button>
                    <button class="filter-btn" onclick="filterBookings('confirmed')">Đã xác nhận</button>
                    <button class="filter-btn" onclick="filterBookings('completed')">Hoàn thành</button>
                </div>
            </div>

            <?php if (!empty($bookings)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Mã đặt</th>
                        <th>Khách hàng</th>
                        <th>Địa điểm</th>
                        <th>Ngày tham quan</th>
                        <th>Số người</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $b): ?>
                    <tr data-status="<?php echo $b['status']; ?>">
                        <td><strong><?php echo htmlspecialchars($b['booking_id']); ?></strong></td>
                        <td>
                            <div class="customer-info"><?php echo htmlspecialchars($b['customer_name']); ?></div>
                            <div class="customer-contact">
                                <i class="fas fa-phone"></i> <?php echo htmlspecialchars($b['customer_phone']); ?>
                            </div>
                            <?php if (!empty($b['customer_email'])): ?>
                            <div class="customer-contact">
                                <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($b['customer_email']); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="attraction-name"><?php echo htmlspecialchars($b['attraction_name'] ?? 'N/A'); ?></div>
                            <div class="attraction-location"><?php echo htmlspecialchars($b['attraction_location'] ?? ''); ?></div>
                        </td>
                        <td class="booking-date">
                            <i class="fas fa-calendar"></i>
                            <?php echo date('d/m/Y', strtotime($b['booking_date'])); ?>
                        </td>
                        <td><strong><?php echo $b['number_of_people']; ?></strong> người</td>
                        <td><strong><?php echo number_format($b['total_price']); ?> VNĐ</strong></td>
                        <td>
                            <span class="status-badge" style="background: <?php echo $statusColors[$b['status']]; ?>">
                                <?php echo $statusNames[$b['status']]; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($b['status'] === 'pending'): ?>
                                <button class="action-btn btn-confirm" onclick="updateStatus('<?php echo $b['booking_id']; ?>', 'confirmed')">
                                    <i class="fas fa-check"></i> Xác nhận
                                </button>
                                <button class="action-btn btn-cancel" onclick="updateStatus('<?php echo $b['booking_id']; ?>', 'cancelled')">
                                    <i class="fas fa-times"></i> Hủy
                                </button>
                            <?php elseif ($b['status'] === 'confirmed'): ?>
                                <button class="action-btn btn-complete" onclick="updateStatus('<?php echo $b['booking_id']; ?>', 'completed')">
                                    <i class="fas fa-check-double"></i> Hoàn thành
                                </button>
                            <?php endif; ?>
                            <button class="action-btn btn-delete" onclick="deleteBooking('<?php echo $b['booking_id']; ?>', '<?php echo htmlspecialchars($b['customer_name'], ENT_QUOTES); ?>')">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-calendar-times"></i>
                <h3>Chưa có đặt tour nào</h3>
                <p>Các đặt tour từ khách hàng sẽ hiển thị ở đây</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Lọc bookings theo trạng thái
        function filterBookings(status) {
            const rows = document.querySelectorAll('tbody tr');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter rows
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || rowStatus === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Cập nhật trạng thái booking
        async function updateStatus(bookingId, newStatus) {
            if (!confirm(`Bạn có chắc muốn cập nhật trạng thái?`)) {
                return;
            }

            try {
                const response = await fetch('api/bookings.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        booking_id: bookingId,
                        status: newStatus
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ ' + result.message);
                    location.reload();
                } else {
                    alert('❌ ' + result.message);
                }
            } catch (error) {
                alert('❌ Có lỗi xảy ra: ' + error.message);
            }
        }

        // Delete booking
        async function deleteBooking(bookingId, customerName) {
            console.log('Delete booking called with:', bookingId, customerName);
            
            if (!confirm(`Bạn có chắc muốn xóa đặt tour của "${customerName}"?\n\nHành động này không thể hoàn tác!`)) {
                console.log('User cancelled delete');
                return;
            }

            console.log('Sending DELETE request...');

            try {
                const response = await fetch('api/bookings.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        booking_id: bookingId
                    })
                });

                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);

                const text = await response.text();
                console.log('Response text:', text);

                let result;
                try {
                    result = JSON.parse(text);
                    console.log('Parsed result:', result);
                } catch (parseError) {
                    console.error('JSON parse error:', parseError);
                    alert('❌ Lỗi: Server trả về dữ liệu không hợp lệ\n\n' + text);
                    return;
                }

                if (result.success) {
                    alert('✅ ' + result.message);
                    location.reload();
                } else {
                    alert('❌ ' + result.message);
                }
            } catch (error) {
                console.error('Fetch error:', error);
                alert('❌ Có lỗi xảy ra: ' + error.message);
            }
        }
    </script>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>
