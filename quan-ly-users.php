<?php
/**
 * Trang Quản Lý Tài Khoản
 * CHỈ ADMIN VÀ MANAGER MỚI TRUY CẬP ĐƯỢC
 */

session_start();

// Kiểm tra quyền truy cập - CHỈ ADMIN
require_once 'check-auth.php';
requireAdmin(); // Chỉ admin mới vào được

require_once 'config/database.php';

// Khởi tạo
try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Lấy danh sách users từ bảng app_users
    $stmt = $db->query("SELECT * FROM app_users ORDER BY created_at DESC");
    $users = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }
    
    // Lấy thống kê
    $statsQuery = "SELECT 
        COUNT(*) as total_users,
        COUNT(CASE WHEN role = 'admin' THEN 1 END) as admin_count,
        COUNT(CASE WHEN role = 'manager' THEN 1 END) as manager_count,
        COUNT(CASE WHEN role = 'user' THEN 1 END) as user_count,
        COUNT(CASE WHEN status = 'active' THEN 1 END) as active_count,
        COUNT(CASE WHEN status = 'inactive' THEN 1 END) as inactive_count,
        COUNT(CASE WHEN status = 'banned' THEN 1 END) as banned_count
    FROM app_users";
    $stats = $db->query($statsQuery)->fetch(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $users = [];
    $stats = [];
}

// Màu sắc theo vai trò
$roleColors = [
    'admin' => '#ef4444',
    'manager' => '#3b82f6',
    'user' => '#10b981'
];

$roleNames = [
    'admin' => 'Quản trị viên',
    'manager' => 'Quản lý',
    'user' => 'Người dùng'
];

// Màu sắc theo trạng thái
$statusColors = [
    'active' => '#10b981',
    'inactive' => '#f59e0b',
    'banned' => '#ef4444'
];

$statusNames = [
    'active' => 'Hoạt động',
    'inactive' => 'Không hoạt động',
    'banned' => 'Bị khóa'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản - Du Lịch Trà Vinh</title>
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

        .users-table {
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

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            color: white;
            display: inline-block;
        }

        .user-info {
            font-weight: 600;
            color: #1f2937;
        }

        .user-email {
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

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background: #2563eb;
        }

        .btn-ban {
            background: #f59e0b;
            color: white;
        }

        .btn-ban:hover {
            background: #d97706;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideDown 0.3s;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.5em;
            margin: 0;
        }

        .close {
            color: white;
            font-size: 2em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            line-height: 1;
        }

        .close:hover {
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px;
        }

        .detail-row {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
            width: 150px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #1f2937;
            flex: 1;
        }

        .modal-footer {
            padding: 20px 30px;
            background: #f9fafb;
            border-radius: 0 0 15px 15px;
            text-align: right;
        }

        .btn-close-modal {
            background: #6b7280;
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-close-modal:hover {
            background: #4b5563;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 0.9em;
            }

            .modal-content {
                margin: 10% auto;
                width: 95%;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1>
                <i class="fas fa-users-cog"></i>
                Quản Lý Tài Khoản
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
                <div class="stat-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['total_users'] ?? 0; ?></h3>
                    <p>Tổng tài khoản</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['admin_count'] ?? 0; ?></h3>
                    <p>Quản trị viên</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['manager_count'] ?? 0; ?></h3>
                    <p>Quản lý</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-user"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['user_count'] ?? 0; ?></h3>
                    <p>Người dùng</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['active_count'] ?? 0; ?></h3>
                    <p>Đang hoạt động</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['banned_count'] ?? 0; ?></h3>
                    <p>Bị khóa</p>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="users-table">
            <div class="table-header">
                <h2>Danh Sách Tài Khoản (<?php echo count($users); ?>)</h2>
            </div>

            <?php if (!empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Thông tin</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Đăng nhập</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($u['id']); ?></strong></td>
                        <td><strong><?php echo htmlspecialchars($u['username']); ?></strong></td>
                        <td>
                            <div class="user-info"><?php echo htmlspecialchars($u['full_name'] ?? 'N/A'); ?></div>
                            <div class="user-email">
                                <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($u['email']); ?>
                            </div>
                            <?php if (!empty($u['phone'])): ?>
                            <div class="user-email">
                                <i class="fas fa-phone"></i> <?php echo htmlspecialchars($u['phone']); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge" style="background: <?php echo $roleColors[$u['role']]; ?>">
                                <?php echo $roleNames[$u['role']]; ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge" style="background: <?php echo $statusColors[$u['status']]; ?>">
                                <?php echo $statusNames[$u['status']]; ?>
                            </span>
                        </td>
                        <td>
                            <div><strong><?php echo $u['login_count'] ?? 0; ?></strong> lần</div>
                            <?php if (!empty($u['last_login'])): ?>
                            <div class="user-email">
                                <?php echo date('d/m/Y H:i', strtotime($u['last_login'])); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($u['created_at'])); ?></td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewUser(<?php echo $u['id']; ?>)">
                                <i class="fas fa-eye"></i> Xem
                            </button>
                            <?php if ($u['status'] !== 'banned'): ?>
                            <button class="action-btn btn-ban" onclick="toggleBanUser(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username']); ?>', 'banned')">
                                <i class="fas fa-ban"></i> Khóa
                            </button>
                            <?php else: ?>
                            <button class="action-btn btn-view" onclick="toggleBanUser(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username']); ?>', 'active')">
                                <i class="fas fa-unlock"></i> Mở
                            </button>
                            <?php endif; ?>
                            <button class="action-btn btn-delete" onclick="deleteUser(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username']); ?>')">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-users-slash"></i>
                <h3>Chưa có tài khoản nào</h3>
                <p>Các tài khoản sẽ hiển thị ở đây</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Xem Chi Tiết -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user-circle"></i> Chi Tiết Tài Khoản</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body" id="modalBody">
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 3em; color: #667eea;"></i>
                    <p style="margin-top: 20px; color: #6b7280;">Đang tải...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-close-modal" onclick="closeModal()">
                    <i class="fas fa-times"></i> Đóng
                </button>
            </div>
        </div>
    </div>

    <script>
        // Xem chi tiết user
        async function viewUser(userId) {
            const modal = document.getElementById('viewModal');
            const modalBody = document.getElementById('modalBody');
            
            modal.style.display = 'block';
            modalBody.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 3em; color: #667eea;"></i>
                    <p style="margin-top: 20px; color: #6b7280;">Đang tải...</p>
                </div>
            `;

            try {
                const response = await fetch('api/users.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'get_user',
                        user_id: userId
                    })
                });

                const result = await response.json();

                if (result.success) {
                    const user = result.user;
                    const roleNames = {
                        'admin': 'Quản trị viên',
                        'manager': 'Quản lý',
                        'user': 'Người dùng'
                    };
                    const statusNames = {
                        'active': 'Đang hoạt động',
                        'inactive': 'Không hoạt động',
                        'banned': 'Bị khóa'
                    };
                    const roleColors = {
                        'admin': '#ef4444',
                        'manager': '#3b82f6',
                        'user': '#10b981'
                    };
                    const statusColors = {
                        'active': '#10b981',
                        'inactive': '#f59e0b',
                        'banned': '#ef4444'
                    };

                    modalBody.innerHTML = `
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-id-card"></i> Mã User:</div>
                            <div class="detail-value"><strong>${user.user_id}</strong></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-user"></i> Tên đăng nhập:</div>
                            <div class="detail-value"><strong>${user.username}</strong></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-signature"></i> Họ và tên:</div>
                            <div class="detail-value">${user.full_name}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-envelope"></i> Email:</div>
                            <div class="detail-value">${user.email}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-phone"></i> Số điện thoại:</div>
                            <div class="detail-value">${user.phone || 'Chưa cập nhật'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-user-tag"></i> Vai trò:</div>
                            <div class="detail-value">
                                <span class="badge" style="background: ${roleColors[user.role]}">
                                    ${roleNames[user.role]}
                                </span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-toggle-on"></i> Trạng thái:</div>
                            <div class="detail-value">
                                <span class="badge" style="background: ${statusColors[user.status]}">
                                    ${statusNames[user.status]}
                                </span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-sign-in-alt"></i> Số lần đăng nhập:</div>
                            <div class="detail-value"><strong>${user.login_count}</strong> lần</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-clock"></i> Đăng nhập cuối:</div>
                            <div class="detail-value">${user.last_login ? formatDate(user.last_login) : 'Chưa đăng nhập'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-calendar-plus"></i> Ngày tạo:</div>
                            <div class="detail-value">${formatDate(user.created_at)}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="fas fa-calendar-check"></i> Cập nhật:</div>
                            <div class="detail-value">${formatDate(user.updated_at)}</div>
                        </div>
                    `;
                } else {
                    modalBody.innerHTML = `
                        <div style="text-align: center; padding: 40px;">
                            <i class="fas fa-exclamation-circle" style="font-size: 3em; color: #ef4444;"></i>
                            <p style="margin-top: 20px; color: #991b1b;">${result.message}</p>
                        </div>
                    `;
                }
            } catch (error) {
                modalBody.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-times-circle" style="font-size: 3em; color: #ef4444;"></i>
                        <p style="margin-top: 20px; color: #991b1b;">Có lỗi xảy ra. Vui lòng thử lại!</p>
                    </div>
                `;
            }
        }

        // Khóa/Mở khóa user
        async function toggleBanUser(userId, username, newStatus) {
            const action = newStatus === 'banned' ? 'khóa' : 'mở khóa';
            
            if (!confirm(`Bạn có chắc muốn ${action} tài khoản "${username}"?`)) {
                return;
            }

            try {
                const response = await fetch('api/users.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'update_status',
                        user_id: userId,
                        status: newStatus
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert('Lỗi: ' + result.message);
                }
            } catch (error) {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            }
        }

        // Xóa user
        async function deleteUser(userId, username) {
            if (!confirm(`⚠️ BẠN CÓ CHẮC MUỐN XÓA TÀI KHOẢN "${username}"?\n\nHành động này KHÔNG THỂ HOÀN TÁC!`)) {
                return;
            }

            if (!confirm(`Xác nhận lần cuối: Xóa tài khoản "${username}"?`)) {
                return;
            }

            try {
                const response = await fetch('api/users.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        user_id: userId
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert('Lỗi: ' + result.message);
                }
            } catch (error) {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
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

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${day}/${month}/${year} ${hours}:${minutes}`;
        }
    </script>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>
