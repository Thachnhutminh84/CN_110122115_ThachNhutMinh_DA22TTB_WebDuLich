<?php
session_start();
require_once 'config/database.php';
require_once 'check-auth.php';

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Lấy danh sách đặt dịch vụ
$query = "SELECT sb.*, s.name as service_name, s.price as service_price 
          FROM service_bookings sb
          LEFT JOIN services s ON sb.service_id = s.id
          ORDER BY sb.created_at DESC";
$result = $conn->query($query);
$bookings = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

// Thống kê
$stats_query = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
                FROM service_bookings";
$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đặt Dịch Vụ - Du Lịch Campuchia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin-responsive.css">
    <style>
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .stat-card.pending {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card.confirmed {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stat-card.completed {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .stat-card.cancelled {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        .booking-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .booking-table table {
            margin-bottom: 0;
        }
        .booking-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-confirmed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }
        .nav-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-header h2 {
            margin: 0;
            font-size: 24px;
        }
        .nav-links {
            display: flex;
            gap: 10px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="container-fluid mt-5 mb-5">
        <!-- Navigation Header -->
        <div class="nav-header">
            <h2><i class="fas fa-tasks"></i> Quản Lý Đặt Dịch Vụ</h2>
            <div class="nav-links">
                <a href="quan-ly-users.php"><i class="fas fa-users"></i> Quản Lý Users</a>
                <a href="quan-ly-booking.php"><i class="fas fa-calendar"></i> Quản Lý Tour</a>
                <a href="quan-ly-thanh-toan.php"><i class="fas fa-money-bill"></i> Quản Lý Thanh Toán</a>
                <a href="quan-ly-xac-nhan-thanh-toan.php"><i class="fas fa-check-circle"></i> Xác Nhận Thanh Toán</a>
            </div>
        </div>

        <!-- Thống kê -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-label">Tổng Đặt Dịch Vụ</div>
                    <div class="stat-number"><?php echo $stats['total'] ?? 0; ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card pending">
                    <div class="stat-label">Chờ Xác Nhận</div>
                    <div class="stat-number"><?php echo $stats['pending'] ?? 0; ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card confirmed">
                    <div class="stat-label">Đã Xác Nhận</div>
                    <div class="stat-number"><?php echo $stats['confirmed'] ?? 0; ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card completed">
                    <div class="stat-label">Hoàn Thành</div>
                    <div class="stat-number"><?php echo $stats['completed'] ?? 0; ?></div>
                </div>
            </div>
        </div>

        <!-- Danh sách đặt dịch vụ -->
        <div class="booking-table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách Hàng</th>
                        <th>Dịch Vụ</th>
                        <th>Ngày Đặt</th>
                        <th>Ngày Sử Dụng</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td>#<?php echo $booking['id']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($booking['customer_name']); ?></strong><br>
                            <small class="text-muted"><?php echo htmlspecialchars($booking['customer_email']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($booking['service_name'] ?? 'N/A'); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($booking['created_at'])); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($booking['booking_date'] . ' ' . $booking['start_time'])); ?></td>
                        <td><?php echo $booking['quantity']; ?> người</td>
                        <td><?php echo number_format($booking['service_price'] * $booking['quantity'], 0, ',', '.'); ?> VNĐ</td>
                        <td>
                            <span class="status-badge status-<?php echo $booking['status']; ?>">
                                <?php 
                                $status_text = [
                                    'pending' => 'Chờ Xác Nhận',
                                    'confirmed' => 'Đã Xác Nhận',
                                    'completed' => 'Hoàn Thành',
                                    'cancelled' => 'Đã Hủy'
                                ];
                                echo $status_text[$booking['status']] ?? $booking['status'];
                                ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                        data-bs-target="#detailModal" 
                                        onclick="loadBookingDetail(<?php echo $booking['id']; ?>)">
                                    <i class="fas fa-eye"></i> Xem
                                </button>
                                <?php if ($booking['status'] === 'pending'): ?>
                                <button class="btn btn-sm btn-success" 
                                        onclick="updateStatus(<?php echo $booking['id']; ?>, 'confirmed')">
                                    <i class="fas fa-check"></i> Xác Nhận
                                </button>
                                <button class="btn btn-sm btn-danger" 
                                        onclick="updateStatus(<?php echo $booking['id']; ?>, 'cancelled')">
                                    <i class="fas fa-times"></i> Hủy
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Chi Tiết -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi Tiết Đặt Dịch Vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <p class="text-center"><i class="fas fa-spinner fa-spin"></i> Đang tải...</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadBookingDetail(bookingId) {
            fetch(`api/service-bookings.php?id=${bookingId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const booking = data.data;
                        const html = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Thông Tin Khách Hàng</h6>
                                    <p><strong>Tên:</strong> ${booking.customer_name}</p>
                                    <p><strong>Email:</strong> ${booking.customer_email}</p>
                                    <p><strong>Điện Thoại:</strong> ${booking.customer_phone}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Thông Tin Dịch Vụ</h6>
                                    <p><strong>Dịch Vụ:</strong> ${booking.service_name}</p>
                                    <p><strong>Ngày Sử Dụng:</strong> ${booking.booking_date}</p>
                                    <p><strong>Giờ Bắt Đầu:</strong> ${booking.start_time}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><strong>Số Lượng:</strong> ${booking.quantity} người</p>
                                    <p><strong>Giá Dịch Vụ:</strong> ${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(booking.service_price)}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Tổng Tiền:</strong> ${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(booking.service_price * booking.quantity)}</p>
                                    <p><strong>Trạng Thái:</strong> <span class="badge bg-info">${booking.status}</span></p>
                                </div>
                            </div>
                            ${booking.notes ? `<div class="mt-3"><strong>Ghi Chú:</strong><p>${booking.notes}</p></div>` : ''}
                        `;
                        document.getElementById('detailContent').innerHTML = html;
                    }
                })
                .catch(error => {
                    document.getElementById('detailContent').innerHTML = '<p class="text-danger">Lỗi khi tải dữ liệu</p>';
                });
        }

        function updateStatus(bookingId, newStatus) {
            if (!confirm('Bạn chắc chắn muốn cập nhật trạng thái?')) return;

            fetch('api/service-bookings.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'update_status',
                    id: bookingId,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cập nhật thành công');
                    location.reload();
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(error => {
                alert('Lỗi khi cập nhật');
                console.error(error);
            });
        }
    </script>
</body>
</html>
