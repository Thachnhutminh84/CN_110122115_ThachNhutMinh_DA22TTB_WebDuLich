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

        .users-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .user-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.3s;
            background: white;
        }

        .user-row:hover {
            background: #f9fafb;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .user-row:nth-child(even) {
            background: #fafbfc;
        }

        .user-row:nth-child(even):hover {
            background: #f3f4f6;
        }

        .user-row-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            min-width: 0;
        }

        .user-row-id {
            flex-shrink: 0;
        }

        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1em;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .user-row-info {
            flex: 1;
            min-width: 0;
        }

        .user-row-username {
            font-weight: 700;
            color: #1f2937;
            font-size: 1em;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-row-username i {
            color: #667eea;
            font-size: 1.1em;
        }

        .user-row-name {
            color: #6b7280;
            font-size: 0.9em;
            margin-bottom: 6px;
        }

        .user-row-contact {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #6b7280;
            font-size: 0.85em;
        }

        .contact-item i {
            color: #3b82f6;
            width: 14px;
        }

        .user-row-middle {
            display: flex;
            gap: 12px;
            margin: 0 20px;
            flex-shrink: 0;
        }

        .user-row-badge {
            display: flex;
            align-items: center;
        }

        .user-row-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 700;
            color: white;
            display: inline-block;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .user-info {
            font-weight: 700;
            color: #1f2937;
            font-size: 1em;
        }

        .user-email {
            color: #6b7280;
            font-size: 0.88em;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-email i {
            width: 16px;
        }

        .action-btn {
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1em;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            width: 40px;
            height: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        .action-btn:active {
            transform: translateY(0);
        }

        .action-btn i {
            font-size: 1.1em;
        }

        .btn-view {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        }

        .btn-ban {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-ban:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }

        .btn-unlock {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-unlock:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
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

        @media (max-width: 1024px) {
            .user-row {
                flex-wrap: wrap;
                gap: 12px;
            }

            .user-row-left {
                width: 100%;
                order: 1;
            }

            .user-row-middle {
                order: 2;
                margin: 0;
            }

            .user-row-actions {
                order: 3;
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .user-row {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .user-row-left {
                width: 100%;
                gap: 12px;
            }

            .id-badge {
                width: 45px;
                height: 45px;
                font-size: 1em;
            }

            .user-row-username {
                font-size: 0.95em;
            }

            .user-row-name {
                font-size: 0.85em;
            }

            .contact-item {
                font-size: 0.8em;
            }

            .user-row-middle {
                width: 100%;
                margin: 8px 0;
            }

            .user-row-actions {
                width: 100%;
                gap: 6px;
            }

            .action-btn {
                width: 36px;
                height: 36px;
                padding: 8px;
            }

            .action-btn i {
                font-size: 1em;
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

            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .header-content > div {
                flex-wrap: wrap;
                justify-content: center;
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
            <div style="display: flex; gap: 10px;">
                <a href="quan-ly-booking.php" class="back-btn">
                    <i class="fas fa-calendar-check"></i> Quản Lý Booking
                </a>
                <a href="quan-ly-dat-dich-vu.php" class="back-btn">
                    <i class="fas fa-concierge-bell"></i> Quản Lý Dịch Vụ
                </a>
                <a href="quan-ly-xac-nhan-thanh-toan.php" class="back-btn">
                    <i class="fas fa-money-check-alt"></i> Quản Lý Thanh Toán
                </a>
                <a href="quan-ly-lien-he.php" class="back-btn">
                    <i class="fas fa-envelope"></i> Quản Lý Tin Nhắn
                </a>
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
            <div class="users-list">
                <?php foreach ($users as $u): ?>
                <div class="user-row">
                    <div class="user-row-left">
                        <div class="user-row-id">
                            <span class="id-badge"><?php echo htmlspecialchars($u['id']); ?></span>
                        </div>
                        <div class="user-row-info">
                            <div class="user-row-username">
                                <i class="fas fa-user-circle"></i>
                                <?php echo htmlspecialchars($u['username']); ?>
                            </div>
                            <div class="user-row-name">
                                <?php echo htmlspecialchars($u['full_name'] ?? 'N/A'); ?>
                            </div>
                            <div class="user-row-contact">
                                <span class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <?php echo htmlspecialchars($u['email']); ?>
                                </span>
                                <?php if (!empty($u['phone'])): ?>
                                <span class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <?php echo htmlspecialchars($u['phone']); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="user-row-middle">
                        <div class="user-row-badge">
                            <span class="badge" style="background: <?php echo $roleColors[$u['role']]; ?>">
                                <?php echo $roleNames[$u['role']]; ?>
                            </span>
                        </div>
                        <div class="user-row-badge">
                            <span class="badge" style="background: <?php echo $statusColors[$u['status']]; ?>">
                                <?php echo $statusNames[$u['status']]; ?>
                            </span>
                        </div>
                    </div>

                    <div class="user-row-actions">
                        <button class="action-btn btn-view" onclick="viewUser(<?php echo $u['id']; ?>)" title="Xem chi tiết">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn btn-edit" onclick="editUser(<?php echo $u['id']; ?>)" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                        </button>
                        <?php if ($u['status'] !== 'banned'): ?>
                        <button class="action-btn btn-ban" onclick="toggleBanUser(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username']); ?>', 'banned')" title="Khóa tài khoản">
                            <i class="fas fa-ban"></i>
                        </button>
                        <?php else: ?>
                        <button class="action-btn btn-unlock" onclick="toggleBanUser(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username']); ?>', 'active')" title="Mở khóa">
                            <i class="fas fa-unlock"></i>
                        </button>
                        <?php endif; ?>
                        <button class="action-btn btn-delete" onclick="deleteUser(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username']); ?>')" title="Xóa tài khoản">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
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
                <span class="close" onclick="closeModal('viewModal')">&times;</span>
            </div>
            <div class="modal-body" id="modalBody">
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 3em; color: #667eea;"></i>
                    <p style="margin-top: 20px; color: #6b7280;">Đang tải...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-close-modal" onclick="closeModal('viewModal')">
                    <i class="fas fa-times"></i> Đóng
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Chỉnh Sửa -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user-edit"></i> Chỉnh Sửa Tài Khoản</h3>
                <span class="close" onclick="closeModal('editModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="editForm" style="display: grid; gap: 20px;">
                    <input type="hidden" id="edit_user_id">
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">
                            <i class="fas fa-user"></i> Tên đăng nhập *
                        </label>
                        <input type="text" id="edit_username" required
                               style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1em;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">
                            <i class="fas fa-signature"></i> Họ và tên *
                        </label>
                        <input type="text" id="edit_full_name" required
                               style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1em;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">
                            <i class="fas fa-envelope"></i> Email *
                        </label>
                        <input type="email" id="edit_email" required
                               style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1em;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">
                            <i class="fas fa-phone"></i> Số điện thoại
                        </label>
                        <input type="tel" id="edit_phone"
                               style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1em;">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">
                            <i class="fas fa-user-tag"></i> Vai trò *
                        </label>
                        <select id="edit_role" required
                                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1em;">
                            <option value="user">Người dùng</option>
                            <option value="manager">Quản lý</option>
                            <option value="admin">Quản trị viên</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">
                            <i class="fas fa-toggle-on"></i> Trạng thái *
                        </label>
                        <select id="edit_status" required
                                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1em;">
                            <option value="active">Đang hoạt động</option>
                            <option value="inactive">Không hoạt động</option>
                            <option value="banned">Bị khóa</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">
                            <i class="fas fa-lock"></i> Mật khẩu mới (để trống nếu không đổi)
                        </label>
                        <input type="password" id="edit_password" placeholder="Nhập mật khẩu mới..."
                               style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1em;">
                        <small style="color: #6b7280; display: block; margin-top: 5px;">
                            Chỉ nhập nếu muốn thay đổi mật khẩu
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-close-modal" onclick="closeModal('editModal')" style="background: #6b7280; margin-right: 10px;">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <button class="btn-close-modal" onclick="saveUser()" style="background: #10b981;">
                    <i class="fas fa-save"></i> Lưu Thay Đổi
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

        // Chỉnh sửa user
        async function editUser(userId) {
            const modal = document.getElementById('editModal');
            modal.style.display = 'block';

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
                    document.getElementById('edit_user_id').value = user.id;
                    document.getElementById('edit_username').value = user.username;
                    document.getElementById('edit_full_name').value = user.full_name || '';
                    document.getElementById('edit_email').value = user.email;
                    document.getElementById('edit_phone').value = user.phone || '';
                    document.getElementById('edit_role').value = user.role;
                    document.getElementById('edit_status').value = user.status;
                    document.getElementById('edit_password').value = '';
                } else {
                    alert('Không thể tải thông tin user');
                    closeModal('editModal');
                }
            } catch (error) {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
                closeModal('editModal');
            }
        }

        // Lưu thay đổi
        async function saveUser() {
            const userId = document.getElementById('edit_user_id').value;
            const username = document.getElementById('edit_username').value.trim();
            const fullName = document.getElementById('edit_full_name').value.trim();
            const email = document.getElementById('edit_email').value.trim();
            const phone = document.getElementById('edit_phone').value.trim();
            const role = document.getElementById('edit_role').value;
            const status = document.getElementById('edit_status').value;
            const password = document.getElementById('edit_password').value;

            // Validate
            if (!username || !fullName || !email) {
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
                return;
            }

            if (!confirm('Bạn có chắc muốn lưu thay đổi?')) {
                return;
            }

            try {
                const data = {
                    action: 'update',
                    user_id: userId,
                    username: username,
                    full_name: fullName,
                    email: email,
                    phone: phone,
                    role: role,
                    status: status
                };

                // Chỉ gửi password nếu có nhập
                if (password) {
                    data.password = password;
                }

                const response = await fetch('api/users.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    closeModal('editModal');
                    location.reload();
                } else {
                    alert('Lỗi: ' + result.message);
                }
            } catch (error) {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            }
        }

        // Đóng modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            const viewModal = document.getElementById('viewModal');
            const editModal = document.getElementById('editModal');
            
            if (event.target == viewModal) {
                viewModal.style.display = 'none';
            }
            if (event.target == editModal) {
                editModal.style.display = 'none';
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
