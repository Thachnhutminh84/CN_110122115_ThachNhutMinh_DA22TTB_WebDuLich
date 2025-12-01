<?php
/**
 * Trang Quản Lý Liên Hệ
 * CHỈ ADMIN VÀ MANAGER MỚI TRUY CẬP ĐƯỢC
 */

session_start();

// Kiểm tra quyền truy cập - CHỈ ADMIN
require_once 'check-auth.php';
requireAdmin(); // Chỉ admin mới vào được

require_once 'config/database.php';
require_once 'models/Contact.php';

// Khởi tạo
try {
    $database = new Database();
    $db = $database->getConnection();
    $contact = new Contact($db);
    
    // Lấy danh sách liên hệ
    $stmt = $contact->readAll();
    $contacts = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $contacts[] = $row;
    }
    
    // Đếm theo trạng thái
    $statsStmt = $contact->countByStatus();
    $stats = [];
    while ($row = $statsStmt->fetch(PDO::FETCH_ASSOC)) {
        $stats[$row['status']] = $row['total'];
    }
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $contacts = [];
}

// Màu sắc theo trạng thái
$statusColors = [
    'new' => '#ef4444',
    'read' => '#f59e0b',
    'replied' => '#10b981',
    'closed' => '#6b7280'
];

$statusNames = [
    'new' => 'Mới',
    'read' => 'Đã đọc',
    'replied' => 'Đã trả lời',
    'closed' => 'Đã đóng'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Liên Hệ - Du Lịch Trà Vinh</title>
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
            background: white;
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
            color: #1f2937;
        }

        .header h1 i {
            color: #3b82f6;
            margin-right: 10px;
        }

        .back-btn {
            background: #6b7280;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #4b5563;
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

        .contacts-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
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

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            color: white;
            display: inline-block;
        }

        .contact-name {
            font-weight: 600;
            color: #1f2937;
        }

        .contact-email {
            color: #6b7280;
            font-size: 0.9em;
        }

        .contact-subject {
            color: #1f2937;
            font-weight: 500;
        }

        .contact-message {
            color: #6b7280;
            font-size: 0.9em;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .contact-date {
            color: #6b7280;
            font-size: 0.9em;
        }

        .action-btn {
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9em;
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

        /* Modal Animation */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        #viewModal {
            animation: modalFadeIn 0.3s ease-out;
        }

        #viewModal > div {
            animation: modalSlideIn 0.3s ease-out;
        }

        /* Responsive Modal */
        @media (max-width: 768px) {
            #viewModal > div {
                margin: 20px auto;
            }
            
            #viewModal > div > div:first-child {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1>
                <i class="fas fa-envelope"></i>
                Quản Lý Liên Hệ
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
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['new'] ?? 0; ?></h3>
                    <p>Liên hệ mới</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['read'] ?? 0; ?></h3>
                    <p>Đã đọc</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-reply"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['replied'] ?? 0; ?></h3>
                    <p>Đã trả lời</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(107, 114, 128, 0.1); color: #6b7280;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['closed'] ?? 0; ?></h3>
                    <p>Đã đóng</p>
                </div>
            </div>
        </div>

        <!-- Contacts Table -->
        <div class="contacts-table">
            <div class="table-header">
                <h2>Danh Sách Liên Hệ (<?php echo count($contacts); ?>)</h2>
            </div>

            <?php if (!empty($contacts)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Người gửi</th>
                        <th>Tiêu đề & Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $c): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($c['id']); ?></strong></td>
                        <td>
                            <div class="contact-name"><?php echo htmlspecialchars($c['full_name']); ?></div>
                            <div class="contact-email">
                                <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($c['email']); ?>
                            </div>
                            <?php if (!empty($c['phone'])): ?>
                            <div class="contact-email">
                                <i class="fas fa-phone"></i> <?php echo htmlspecialchars($c['phone']); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="contact-subject"><?php echo htmlspecialchars($c['subject']); ?></div>
                            <div class="contact-message"><?php echo htmlspecialchars($c['message']); ?></div>
                        </td>
                        <td>
                            <span class="status-badge" style="background: <?php echo $statusColors[$c['status']]; ?>">
                                <?php echo $statusNames[$c['status']]; ?>
                            </span>
                        </td>
                        <td class="contact-date">
                            <i class="fas fa-clock"></i>
                            <?php echo date('d/m/Y H:i', strtotime($c['created_at'])); ?>
                        </td>
                        <td>
                            <button type="button" class="action-btn btn-view" 
                                    data-contact='<?php echo json_encode([
                                        'contact_id' => $c['id'],
                                        'full_name' => $c['full_name'],
                                        'email' => $c['email'],
                                        'phone' => $c['phone'] ?? '',
                                        'subject' => $c['subject'],
                                        'message' => $c['message'],
                                        'status' => $c['status'],
                                        'created_at' => $c['created_at'],
                                        'ip_address' => $c['ip_address'] ?? 'N/A'
                                    ], JSON_HEX_APOS | JSON_HEX_QUOT); ?>'
                                    onclick="viewContactModal(this.dataset.contact)">
                                <i class="fas fa-eye"></i> Xem
                            </button>
                            <button type="button" class="action-btn btn-delete" 
                                    data-contact-id="<?php echo htmlspecialchars($c['id']); ?>"
                                    data-name="<?php echo htmlspecialchars($c['full_name']); ?>"
                                    onclick="deleteContact(this.dataset.contactId, this.dataset.name)">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <h3>Chưa có liên hệ nào</h3>
                <p>Các liên hệ từ khách hàng sẽ hiển thị ở đây</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Xem Chi Tiết -->
    <div id="viewModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; padding: 20px; overflow-y: auto;">
        <div style="max-width: 800px; margin: 50px auto; background: white; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <!-- Header -->
            <div style="padding: 25px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0; color: #1f2937; font-size: 1.5em;">
                    <i class="fas fa-envelope-open-text" style="color: #3b82f6; margin-right: 10px;"></i>
                    Chi Tiết Liên Hệ
                </h2>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5em; color: #6b7280; cursor: pointer; padding: 5px 10px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div style="padding: 25px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                            <i class="fas fa-hashtag" style="margin-right: 5px;"></i>Mã Liên Hệ
                        </label>
                        <p id="modalContactId" style="margin: 0; color: #1f2937; font-size: 1.1em; font-weight: 600;"></p>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                            <i class="fas fa-info-circle" style="margin-right: 5px;"></i>Trạng Thái
                        </label>
                        <span id="modalStatus" style="padding: 5px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 600; color: white; display: inline-block;"></span>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                        <i class="fas fa-user" style="margin-right: 5px;"></i>Người Gửi
                    </label>
                    <p id="modalName" style="margin: 0; color: #1f2937; font-size: 1.1em;"></p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                            <i class="fas fa-envelope" style="margin-right: 5px;"></i>Email
                        </label>
                        <p id="modalEmail" style="margin: 0; color: #1f2937;"></p>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                            <i class="fas fa-phone" style="margin-right: 5px;"></i>Số Điện Thoại
                        </label>
                        <p id="modalPhone" style="margin: 0; color: #1f2937;"></p>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                        <i class="fas fa-heading" style="margin-right: 5px;"></i>Tiêu Đề
                    </label>
                    <p id="modalSubject" style="margin: 0; color: #1f2937; font-size: 1.1em; font-weight: 500;"></p>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                        <i class="fas fa-comment-alt" style="margin-right: 5px;"></i>Nội Dung
                    </label>
                    <div id="modalMessage" style="background: #f9fafb; padding: 15px; border-radius: 8px; color: #1f2937; line-height: 1.6; white-space: pre-wrap;"></div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                            <i class="fas fa-clock" style="margin-right: 5px;"></i>Ngày Gửi
                        </label>
                        <p id="modalDate" style="margin: 0; color: #6b7280; font-size: 0.9em;"></p>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 5px; font-size: 0.9em;">
                            <i class="fas fa-network-wired" style="margin-right: 5px;"></i>IP Address
                        </label>
                        <p id="modalIp" style="margin: 0; color: #6b7280; font-size: 0.9em;"></p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div style="padding: 20px 25px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px; justify-content: flex-end;">
                <button onclick="closeModal()" style="background: #6b7280; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-times" style="margin-right: 5px;"></i>Đóng
                </button>
                <button id="modalDeleteBtn" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-trash" style="margin-right: 5px;"></i>Xóa Liên Hệ
                </button>
            </div>
        </div>
    </div>

    <script>
        // Store contact data for modal
        let currentContactData = null;

        // Status colors and names
        const statusColors = {
            'new': '#ef4444',
            'read': '#f59e0b',
            'replied': '#10b981',
            'closed': '#6b7280'
        };

        const statusNames = {
            'new': 'Mới',
            'read': 'Đã đọc',
            'replied': 'Đã trả lời',
            'closed': 'Đã đóng'
        };

        // View contact details in modal
        function viewContactModal(contactJson) {
            try {
                const contact = JSON.parse(contactJson);
                console.log('View contact:', contact);
                
                currentContactData = contact;

                // Populate modal
                document.getElementById('modalContactId').textContent = contact.contact_id;
                document.getElementById('modalName').textContent = contact.full_name;
                document.getElementById('modalEmail').textContent = contact.email;
                document.getElementById('modalPhone').textContent = contact.phone || 'Không có';
                document.getElementById('modalSubject').textContent = contact.subject;
                document.getElementById('modalMessage').textContent = contact.message;
                
                // Format date
                const date = new Date(contact.created_at);
                document.getElementById('modalDate').textContent = date.toLocaleString('vi-VN', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                document.getElementById('modalIp').textContent = contact.ip_address || 'N/A';

                // Set status badge
                const statusBadgeElement = document.getElementById('modalStatus');
                statusBadgeElement.textContent = statusNames[contact.status] || contact.status;
                statusBadgeElement.style.background = statusColors[contact.status] || '#6b7280';

                // Set delete button handler
                document.getElementById('modalDeleteBtn').onclick = function() {
                    closeModal();
                    deleteContact(contact.contact_id, contact.full_name);
                };

                // Show modal
                document.getElementById('viewModal').style.display = 'block';
                document.body.style.overflow = 'hidden';
            } catch (error) {
                console.error('Error parsing contact data:', error);
                alert('❌ Lỗi hiển thị chi tiết liên hệ');
            }
        }

        // Close modal
        function closeModal() {
            document.getElementById('viewModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            currentContactData = null;
        }

        // Close modal when clicking outside
        document.getElementById('viewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('viewModal').style.display === 'block') {
                closeModal();
            }
        });

        // Delete contact
        async function deleteContact(contactId, customerName) {
            console.log('Delete contact called with:', contactId, customerName);
            
            if (!confirm(`Bạn có chắc muốn xóa liên hệ từ "${customerName}"?\n\nHành động này không thể hoàn tác!`)) {
                console.log('User cancelled delete');
                return;
            }

            console.log('Sending DELETE request...');

            try {
                const response = await fetch('api/contact.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        contact_id: contactId
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
