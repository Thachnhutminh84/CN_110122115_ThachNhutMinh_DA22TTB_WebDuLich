<?php
/**
 * Trang Quản Lý Thanh Toán Dịch Vụ
 * CHỈ ADMIN VÀ MANAGER MỚI TRUY CẬP ĐƯỢC
 */

session_start();

// Kiểm tra quyền truy cập
require_once 'check-auth.php';
requireAdmin();

require_once 'config/database.php';

// Khởi tạo
try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Lấy danh sách thanh toán
    $query = "SELECT sp.*, sb.customer_name, sb.service_date, s.service_name
              FROM service_payments sp
              LEFT JOIN service_bookings sb ON sp.booking_code = sb.booking_code
              LEFT JOIN services s ON sp.service_id = s.service_id
              ORDER BY sp.created_at DESC";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Thống kê
    $statsQuery = "SELECT 
        COUNT(*) as total,
        COUNT(CASE WHEN payment_status = 'pending' THEN 1 END) as pending,
        COUNT(CASE WHEN payment_status = 'paid' THEN 1 END) as paid,
        COUNT(CASE WHEN payment_status = 'failed' THEN 1 END) as failed,
        SUM(CASE WHEN payment_status = 'paid' THEN amount ELSE 0 END) as total_revenue
    FROM service_payments";
    
    $stats = $db->query($statsQuery)->fetch(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $payments = [];
    $stats = ['total' => 0, 'pending' => 0, 'paid' => 0, 'failed' => 0, 'total_revenue' => 0];
}

$statusColors = [
    'pending' => '#f59e0b',
    'paid' => '#10b981',
    'failed' => '#ef4444',
    'refunded' => '#3b82f6',
    'cancelled' => '#6b7280'
];

$statusNames = [
    'pending' => 'Chờ thanh toán',
    'paid' => 'Đã thanh toán',
    'failed' => 'Thất bại',
    'refunded' => 'Đã hoàn tiền',
    'cancelled' => 'Đã hủy'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thanh Toán Dịch Vụ - Du Lịch Trà Vinh</title>
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
            background: #f3f4f6;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            margin-bottom: 30px;
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

        .payments-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .container-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .container-header h2 {
            font-size: 1.3em;
            color: #1f2937;
        }

        .payments-list {
            display: flex;
            flex-direction: column;
        }

        .payment-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            background: white;
        }

        .payment-row:hover {
            background: #f9fafb;
        }

        .payment-row-info {
            flex: 1;
        }

        .payment-row-service {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .payment-row-customer {
            color: #6b7280;
            font-size: 0.9em;
        }

        .payment-row-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            margin: 0 20px;
        }

        .detail-label {
            font-size: 0.75em;
            color: #9ca3af;
            text-transform: uppercase;
            font-weight: 600;
        }

        .detail-value {
            font-weight: 700;
            color: #1f2937;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 700;
            color: white;
            display: inline-block;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9em;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <h1>
                    <i class="fas fa-money-check-alt"></i>
                    Quản Lý Thanh Toán Dịch Vụ
                </h1>
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        </div>
    </div>

    <!-- Container -->
    <div class="container">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['total'] ?? 0; ?></h3>
                    <p>Tổng thanh toán</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['paid'] ?? 0; ?></h3>
                    <p>Đã thanh toán</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo number_format($stats['total_revenue'] ?? 0); ?> VNĐ</h3>
                    <p>Tổng doanh thu</p>
                </div>
            </div>
        </div>

        <!-- Payments Container -->
        <div class="payments-container">
            <div class="container-header">
                <h2>Danh Sách Thanh Toán (<?php echo count($payments); ?>)</h2>
            </div>

            <?php if (!empty($payments)): ?>
            <div class="payments-list">
                <?php foreach ($payments as $p): ?>
                <div class="payment-row">
                    <div class="payment-row-info">
                        <div class="payment-row-service">
                            <?php echo htmlspecialchars($p['service_name'] ?? 'N/A'); ?>
                        </div>
                        <div class="payment-row-customer">
                            <?php echo htmlspecialchars($p['customer_name']); ?>
                        </div>
                    </div>

                    <div class="payment-row-detail">
                        <span class="detail-label">Số tiền</span>
                        <span class="detail-value" style="color: #10b981;">
                            <?php echo number_format($p['amount']); ?> VNĐ
                        </span>
                    </div>

                    <div class="payment-row-detail">
                        <span class="detail-label">Phương thức</span>
                        <span class="detail-value">
                            <?php echo strtoupper($p['payment_method']); ?>
                        </span>
                    </div>

                    <div class="payment-row-detail">
                        <span class="detail-label">Ngày thanh toán</span>
                        <span class="detail-value">
                            <?php echo $p['payment_date'] ? date('d/m/Y', strtotime($p['payment_date'])) : 'Chưa'; ?>
                        </span>
                    </div>

                    <div class="payment-row-detail">
                        <span class="status-badge" style="background: <?php echo $statusColors[$p['payment_status']]; ?>">
                            <?php echo $statusNames[$p['payment_status']]; ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <h3>Chưa có thanh toán nào</h3>
                <p>Các thanh toán từ khách hàng sẽ hiển thị ở đây</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/mobile-menu.js"></script>
</body>
</html>
