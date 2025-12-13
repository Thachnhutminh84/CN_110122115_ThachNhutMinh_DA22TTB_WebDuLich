<?php
session_start();
require_once 'config/database.php';

$pageTitle = "Quản Lý Xác Nhận Thanh Toán";

// Lấy danh sách xác nhận thanh toán
$database = new Database();
$db = $database->getConnection();

$statusFilter = $_GET['status'] ?? 'all';
$searchQuery = $_GET['search'] ?? '';

$query = "SELECT pc.*, sb.customer_name, sb.customer_phone, s.service_name
          FROM payment_confirmations pc
          LEFT JOIN service_bookings sb ON pc.booking_code = sb.booking_code
          LEFT JOIN services s ON sb.service_id = s.service_id
          WHERE 1=1";

if ($statusFilter !== 'all') {
    $query .= " AND pc.status = :status";
}

if ($searchQuery) {
    $query .= " AND (pc.booking_code LIKE :search OR pc.account_name LIKE :search OR sb.customer_name LIKE :search)";
}

$query .= " ORDER BY pc.created_at DESC";

$stmt = $db->prepare($query);

if ($statusFilter !== 'all') {
    $stmt->bindParam(':status', $statusFilter);
}

if ($searchQuery) {
    $searchTerm = "%{$searchQuery}%";
    $stmt->bindParam(':search', $searchTerm);
}

$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Thống kê
$statsQuery = "SELECT 
                COUNT(*) as total,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending,
                COUNT(CASE WHEN status = 'verified' THEN 1 END) as verified,
                COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected,
                SUM(CASE WHEN status = 'verified' THEN amount ELSE 0 END) as total_verified
               FROM payment_confirmations";
$statsStmt = $db->prepare($statsQuery);
$statsStmt->execute();
$stats = $statsStmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-styles.css">
    <style>
        .stats-card {
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .stats-card.pending { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: white; }
        .stats-card.verified { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; }
        .stats-card.rejected { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; }
        .stats-card.total { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .payment-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .badge-pending { background: #ffc107; color: #000; }
        .badge-verified { background: #28a745; }
        .badge-rejected { background: #dc3545; }
        
        .action-buttons .btn {
            margin: 0 0.25rem;
        }
    </style>
</head>
<body style="background: #f5f5f5;">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem; border-radius: 15px; color: white;">
                    <h1 style="margin: 0; font-size: 1.8rem;">
                        <i class="fas fa-money-check-alt me-2"></i><?php echo $pageTitle; ?>
                    </h1>
                    <div style="display: flex; gap: 10px;">
                        <a href="quan-ly-users.php" class="btn btn-light">
                            <i class="fas fa-users-cog"></i> Quản Lý Tài Khoản
                        </a>
                        <a href="quan-ly-booking.php" class="btn btn-light">
                            <i class="fas fa-calendar-check"></i> Quản Lý Booking
                        </a>
                        <a href="quan-ly-dat-dich-vu.php" class="btn btn-light">
                            <i class="fas fa-concierge-bell"></i> Quản Lý Dịch Vụ
                        </a>
                        <a href="quan-ly-lien-he.php" class="btn btn-light">
                            <i class="fas fa-envelope"></i> Quản Lý Tin Nhắn
                        </a>
                        <a href="index.php" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left"></i> Quay Lại
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card total">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number"><?php echo $stats['total']; ?></div>
                            <div>Tổng giao dịch</div>
                        </div>
                        <i class="fas fa-list fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card pending">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number"><?php echo $stats['pending']; ?></div>
                            <div>Chờ xác nhận</div>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card verified">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number"><?php echo $stats['verified']; ?></div>
                            <div>Đã xác nhận</div>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card rejected">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number"><?php echo number_format($stats['total_verified']); ?></div>
                            <div>Tổng đã thu (VNĐ)</div>
                        </div>
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>Tất cả</option>
                            <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                            <option value="verified" <?php echo $statusFilter === 'verified' ? 'selected' : ''; ?>>Đã xác nhận</option>
                            <option value="rejected" <?php echo $statusFilter === 'rejected' ? 'selected' : ''; ?>>Đã từ chối</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tìm kiếm</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Mã booking, tên khách hàng..." 
                               value="<?php echo htmlspecialchars($searchQuery); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Lọc
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Table -->
        <div class="payment-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Mã Booking</th>
                            <th>Khách hàng</th>
                            <th>Ngân hàng</th>
                            <th>Số TK</th>
                            <th>Chủ TK</th>
                            <th>Số tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($payments)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Không có dữ liệu</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($payments as $payment): ?>
                                <tr>
                                    <td><?php echo $payment['id']; ?></td>
                                    <td>
                                        <strong><?php echo $payment['booking_code']; ?></strong>
                                        <?php if ($payment['service_name']): ?>
                                            <br><small class="text-muted"><?php echo $payment['service_name']; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($payment['customer_name'] ?? 'N/A'); ?>
                                        <?php if ($payment['customer_phone']): ?>
                                            <br><small class="text-muted"><?php echo $payment['customer_phone']; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($payment['bank_name']); ?></td>
                                    <td><code><?php echo htmlspecialchars($payment['account_number']); ?></code></td>
                                    <td><?php echo htmlspecialchars($payment['account_name']); ?></td>
                                    <td><strong class="text-primary"><?php echo number_format($payment['amount']); ?> đ</strong></td>
                                    <td>
                                        <span class="badge badge-<?php echo $payment['status']; ?>">
                                            <?php 
                                            $statusText = [
                                                'pending' => 'Chờ xác nhận',
                                                'verified' => 'Đã xác nhận',
                                                'rejected' => 'Đã từ chối'
                                            ];
                                            echo $statusText[$payment['status']] ?? $payment['status'];
                                            ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($payment['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-info" 
                                                    onclick="viewDetail(<?php echo $payment['id']; ?>)"
                                                    title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if ($payment['status'] === 'pending'): ?>
                                                <button class="btn btn-sm btn-success" 
                                                        onclick="updateStatus(<?php echo $payment['id']; ?>, 'verified')"
                                                        title="Xác nhận">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" 
                                                        onclick="updateStatus(<?php echo $payment['id']; ?>, 'rejected')"
                                                        title="Từ chối">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button class="btn btn-sm btn-danger" 
                                                    onclick="deletePayment(<?php echo $payment['id']; ?>)"
                                                    title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Chi tiết -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi Tiết Xác Nhận Thanh Toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Content loaded by JS -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewDetail(id) {
            // Load chi tiết qua AJAX
            fetch(`api/payment-detail.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const payment = data.data;
                        document.getElementById('detailContent').innerHTML = `
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Mã Booking:</strong><br>
                                    ${payment.booking_code}
                                </div>
                                <div class="col-md-6">
                                    <strong>Ngân hàng:</strong><br>
                                    ${payment.bank_name}
                                </div>
                                <div class="col-md-6">
                                    <strong>Số tài khoản:</strong><br>
                                    <code>${payment.account_number}</code>
                                </div>
                                <div class="col-md-6">
                                    <strong>Chủ tài khoản:</strong><br>
                                    ${payment.account_name}
                                </div>
                                <div class="col-md-6">
                                    <strong>Số tiền:</strong><br>
                                    <span class="text-primary fs-5">${parseInt(payment.amount).toLocaleString()} VNĐ</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Nội dung CK:</strong><br>
                                    ${payment.transfer_note || 'N/A'}
                                </div>
                                <div class="col-12">
                                    <strong>Trạng thái:</strong><br>
                                    <span class="badge badge-${payment.status}">${payment.status}</span>
                                </div>
                                <div class="col-12">
                                    <strong>Ngày tạo:</strong><br>
                                    ${new Date(payment.created_at).toLocaleString('vi-VN')}
                                </div>
                            </div>
                        `;
                        new bootstrap.Modal(document.getElementById('detailModal')).show();
                    }
                });
        }

        function updateStatus(id, status) {
            const statusText = status === 'verified' ? 'xác nhận' : 'từ chối';
            if (!confirm(`Bạn có chắc muốn ${statusText} giao dịch này?`)) return;

            fetch('api/update-payment-status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cập nhật thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + data.message);
                }
            });
        }

        function deletePayment(id) {
            if (!confirm('Bạn có chắc muốn xóa giao dịch này? Hành động này không thể hoàn tác!')) return;

            fetch('api/delete-payment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Xóa thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + data.message);
                }
            });
        }
    </script>
</body>
</html>
