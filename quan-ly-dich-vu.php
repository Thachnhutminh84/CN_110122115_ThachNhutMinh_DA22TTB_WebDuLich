<?php
/**
 * Trang Quản Lý Đặt Dịch Vụ
 * CHỈ ADMIN MỚI TRUY CẬP ĐƯỢC
 */

session_start();

// Kiểm tra quyền truy cập - CHỈ ADMIN
require_once 'check-auth.php';
requireAdmin();

require_once 'config/database.php';

// Khởi tạo
try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Lấy danh sách đặt dịch vụ
    $query = "SELECT sb.*, s.service_name, s.service_type, s.icon
              FROM service_bookings sb
              LEFT JOIN services s ON sb.service_id = s.service_id
              ORDER BY sb.created_at DESC";
    $stmt = $db->query($query);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Lấy thống kê
    $statsQuery = "SELECT 
        COUNT(*) as total_bookings,
        COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
        COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as confirmed_count,
        COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_count,
        COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_count,
        SUM(total_price) as total_revenue,
        SUM(CASE WHEN status IN ('confirmed', 'completed') THEN total_price ELSE 0 END) as confirmed_revenue
    FROM service_bookings";
    $stats = $db->query($statsQuery)->fetch(PDO::FETCH_ASSOC);
    
    // Thống kê theo loại dịch vụ
    $serviceStatsQuery = "SELECT 
        s.service_type,
        COUNT(sb.id) as booking_count,
        SUM(sb.total_price) as revenue
    FROM service_bookings sb
    LEFT JOIN services s ON sb.service_id = s.service_id
    GROUP BY s.service_type";
    $serviceStats = $db->query($serviceStatsQuery)->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $bookings = [];
    $stats = [];
    $serviceStats = [];
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

$serviceTypeNames = [
    'tour' => 'Tour Du Lịch',
    'hotel' => 'Khách Sạn',
    'car' => 'Thuê Xe',
    'support' => 'Hỗ Trợ'
];

$serviceTypeIcons = [
    'tour' => 'fa-route',
    'hotel' => 'fa-hotel',
    'car' => 'fa-car',
    'support' => 'fa-headset'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đặt Dịch Vụ - Du Lịch Trà Vinh</title>
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
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        .service-type-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .service-type-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .service-type-card h4 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: #1f2937;
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
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h2 {
            font-size: 1.3em;
            color: #1f2937;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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

        .service-type-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            display: inline-block;
            background: #e0e7ff;
            color: #4338ca;
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

        .btn-view {
            background: #6b7280;
            color: white;
        }

        .btn-view:hover {
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

            .filter-buttons {
                width: 100%;
            }

            .filter-btn {
                flex: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1>
                <i class="fas fa-concierge-bell"></i>
                Quản Lý Đặt Dịch Vụ
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
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['completed_count'] ?? 0; ?></h3>
                    <p>Hoàn thành</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo number_format($stats['total_revenue'] ?? 0); ?></h3>
                    <p>Tổng doanh thu (VNĐ)</p>
                </div>
            </div>
        </div>

        <!-- Service Type Statistics -->
        <div class="service-type-stats">
            <?php foreach ($serviceStats as $serviceStat): ?>
            <div class="service-type-card">
                <h4>
                    <i class="fas <?php echo $serviceTypeIcons[$serviceStat['service_type']] ?? 'fa-star'; ?>"></i>
                    <?php echo $serviceTypeNames[$serviceStat['service_type']] ?? $serviceStat['service_type']; ?>
                </h4>
                <p><strong><?php echo $serviceStat['booking_count']; ?></strong> booking</p>
                <p><strong><?php echo number_format($serviceStat['revenue']); ?> VNĐ</strong></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Bookings Table -->
        <div class="bookings-table">
            <div class="table-header">
                <h2>Danh Sách Đặt Dịch Vụ (<?php echo count($bookings); ?>)</h2>
                <div class="filter-buttons">
                    <button class="filter-btn active" onclick="filterBookings('all')">Tất cả</button>
                    <button class="filter-btn" onclick="filterBookings('pending')">Chờ xác nhận</button>
                    <button class="filter-btn" onclick="filterBookings('confirmed')">Đã xác nhận</button>
                    <button class="filter-btn" onclick="filterBookings('completed')">Hoàn thành</button>
                </div>
            </div>

            <?php if (!empty($bookings)): ?>
            <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Mã đặt</th>
                        <th>Dịch vụ</th>
                        <th>Khách hàng</th>
                        <th>Ngày sử dụng</th>
                        <th>Số người/ngày</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $b): ?>
                    <tr data-status="<?php echo $b['status']; ?>">
                        <td><strong><?php echo htmlspecialchars($b['booking_code']); ?></strong></td>
                        <td>
                            <div>
                                <span class="service-type-badge">
                                    <i class="fas <?php echo $serviceTypeIcons[$b['service_type']] ?? 'fa-star'; ?>"></i>
                                    <?php echo $serviceTypeNames[$b['service_type']] ?? ''; ?>
                                </span>
                            </div>
                            <div style="margin-top: 5px; font-size: 0.9em;">
                                <?php echo htmlspecialchars($b['service_name']); ?>
                            </div>
                        </td>
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
                            <?php if ($b['service_date']): ?>
                            <i class="fas fa-calendar"></i>
                            <?php echo date('d/m/Y', strtotime($b['service_date'])); ?>
                            <?php else: ?>
                            <span style="color: #9ca3af;">Chưa xác định</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo $b['number_of_people']; ?></strong> người<br>
                            <strong><?php echo $b['number_of_days']; ?></strong> ngày
                        </td>
                        <td><strong><?php echo number_format($b['total_price']); ?> VNĐ</strong></td>
                        <td>
                            <span class="status-badge" style="background: <?php echo $statusColors[$b['status']]; ?>">
                                <?php echo $statusNames[$b['status']]; ?>
                            </span>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewBooking('<?php echo $b['booking_code']; ?>')">
                                <i class="fas fa-eye"></i> Xem
                            </button>
                            <?php if ($b['status'] === 'pending'): ?>
                                <button class="action-btn btn-confirm" onclick="updateStatus('<?php echo $b['booking_code']; ?>', 'confirmed')">
                                    <i class="fas fa-check"></i> Xác nhận
                                </button>
                                <button class="action-btn btn-cancel" onclick="updateStatus('<?php echo $b['booking_code']; ?>', 'cancelled')">
                                    <i class="fas fa-times"></i> Hủy
                                </button>
                            <?php elseif ($b['status'] === 'confirmed'): ?>
                                <button class="action-btn btn-complete" onclick="updateStatus('<?php echo $b['booking_code']; ?>', 'completed')">
                                    <i class="fas fa-check-double"></i> Hoàn thành
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <h3>Chưa có đặt dịch vụ nào</h3>
                <p>Các đặt dịch vụ từ khách hàng sẽ hiển thị ở đây</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Xem Chi Tiết -->
    <div id="viewModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
        <div style="background: white; margin: 5% auto; padding: 0; border-radius: 15px; max-width: 700px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 30px; border-radius: 15px 15px 0 0; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.5em; margin: 0;"><i class="fas fa-info-circle"></i> Chi Tiết Đặt Dịch Vụ</h3>
                <span onclick="closeModal()" style="color: white; font-size: 2em; font-weight: bold; cursor: pointer; line-height: 1;">&times;</span>
            </div>
            <div id="modalBody" style="padding: 30px;">
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 3em; color: #667eea;"></i>
                    <p style="margin-top: 20px; color: #6b7280;">Đang tải...</p>
                </div>
            </div>
            <div style="padding: 20px 30px; background: #f9fafb; border-radius: 0 0 15px 15px; text-align: right;">
                <button onclick="closeModal()" style="background: #6b7280; color: white; padding: 10px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-times"></i> Đóng
                </button>
            </div>
        </div>
    </div>

    <script>
        // Xem chi tiết booking
        function viewBooking(bookingCode) {
            const modal = document.getElementById('viewModal');
            const modalBody = document.getElementById('modalBody');
            
            modal.style.display = 'block';
            
            // Tìm booking trong danh sách
            const bookings = <?php echo json_encode($bookings); ?>;
            const booking = bookings.find(b => b.booking_code === bookingCode);
            
            if (booking) {
                const statusNames = {
                    'pending': 'Chờ xác nhận',
                    'confirmed': 'Đã xác nhận',
                    'completed': 'Hoàn thành',
                    'cancelled': 'Đã hủy'
                };
                
                const statusColors = {
                    'pending': '#f59e0b',
                    'confirmed': '#3b82f6',
                    'completed': '#10b981',
                    'cancelled': '#ef4444'
                };
                
                const serviceTypeNames = {
                    'tour': 'Tour Du Lịch',
                    'hotel': 'Khách Sạn',
                    'car': 'Thuê Xe',
                    'support': 'Hỗ Trợ'
                };
                
                modalBody.innerHTML = `
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-barcode"></i> Mã đặt:</div>
                        <div style="color: #1f2937; flex: 1;"><strong>${booking.booking_code}</strong></div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-concierge-bell"></i> Dịch vụ:</div>
                        <div style="color: #1f2937; flex: 1;">
                            <strong>${booking.service_name}</strong><br>
                            <span style="padding: 3px 10px; background: #e0e7ff; color: #4338ca; border-radius: 5px; font-size: 0.85em; margin-top: 5px; display: inline-block;">
                                ${serviceTypeNames[booking.service_type] || booking.service_type}
                            </span>
                        </div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-user"></i> Khách hàng:</div>
                        <div style="color: #1f2937; flex: 1;"><strong>${booking.customer_name}</strong></div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-phone"></i> Điện thoại:</div>
                        <div style="color: #1f2937; flex: 1;">${booking.customer_phone}</div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-envelope"></i> Email:</div>
                        <div style="color: #1f2937; flex: 1;">${booking.customer_email || 'Không có'}</div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-calendar"></i> Ngày sử dụng:</div>
                        <div style="color: #1f2937; flex: 1;">${booking.service_date ? new Date(booking.service_date).toLocaleDateString('vi-VN') : 'Chưa xác định'}</div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-users"></i> Số người:</div>
                        <div style="color: #1f2937; flex: 1;"><strong>${booking.number_of_people}</strong> người</div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-clock"></i> Số ngày:</div>
                        <div style="color: #1f2937; flex: 1;"><strong>${booking.number_of_days}</strong> ngày</div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-money-bill-wave"></i> Tổng tiền:</div>
                        <div style="color: #1f2937; flex: 1;"><strong style="font-size: 1.2em; color: #10b981;">${parseInt(booking.total_price).toLocaleString('vi-VN')} VNĐ</strong></div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-info-circle"></i> Trạng thái:</div>
                        <div style="color: #1f2937; flex: 1;">
                            <span style="padding: 5px 12px; background: ${statusColors[booking.status]}; color: white; border-radius: 20px; font-weight: 600;">
                                ${statusNames[booking.status]}
                            </span>
                        </div>
                    </div>
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-comment"></i> Yêu cầu đặc biệt:</div>
                        <div style="color: #1f2937; flex: 1;">${booking.special_requests || 'Không có'}</div>
                    </div>
                    <div style="display: flex; padding: 15px 0;">
                        <div style="font-weight: 600; color: #6b7280; width: 180px;"><i class="fas fa-calendar-plus"></i> Ngày đặt:</div>
                        <div style="color: #1f2937; flex: 1;">${new Date(booking.created_at).toLocaleString('vi-VN')}</div>
                    </div>
                `;
            }
        }
        
        // Đóng modal
        function closeModal() {
            document.getElementById('viewModal').style.display = 'none';
        }
        
        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            const modal = document.getElementById('viewModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

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

        // Cập nhật trạng thái
        async function updateStatus(bookingCode, newStatus) {
            const statusText = {
                'confirmed': 'xác nhận',
                'cancelled': 'hủy',
                'completed': 'hoàn thành'
            };

            if (!confirm(`Bạn có chắc muốn ${statusText[newStatus]} đặt dịch vụ này?`)) {
                return;
            }

            try {
                const response = await fetch('api/service-bookings.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        booking_code: bookingCode,
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
    </script>

    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>
