<?php
session_start();
require_once 'check-auth.php';

// Kiểm tra quyền admin hoặc manager
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'manager'])) {
    header('Location: dang-nhap.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Địa Điểm - Admin</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin-responsive.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .admin-header h1 {
            font-size: 2rem;
            color: #2c3e50;
        }

        .btn-add {
            padding: 12px 25px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-add:hover {
            background: #229954;
        }

        .attractions-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #3498db;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-edit, .btn-delete, .btn-view {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-view {
            background: #95a5a6;
            color: white;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            overflow-y: auto;
        }

        .modal-content {
            background: white;
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .close-modal {
            font-size: 2rem;
            cursor: pointer;
            color: #7f8c8d;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-submit, .btn-cancel {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-submit {
            background: #27ae60;
            color: white;
        }

        .btn-cancel {
            background: #95a5a6;
            color: white;
        }

        .attraction-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .attractions-table {
                overflow-x: scroll;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1>📍 Quản Lý Địa Điểm Du Lịch</h1>
            <button class="btn-add" onclick="openAddModal()">➕ Thêm Địa Điểm Mới</button>
        </div>

        <div class="attractions-table">
            <table>
                <thead>
                    <tr>
                        <th>Hình Ảnh</th>
                        <th>Tên Địa Điểm</th>
                        <th>Danh Mục</th>
                        <th>Vị Trí</th>
                        <th>Giá Vé</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody id="attractionsTableBody">
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px;">
                            Đang tải dữ liệu...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Thêm/Sửa Địa Điểm -->
    <div id="attractionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Thêm Địa Điểm Mới</h2>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            <form id="attractionForm">
                <input type="hidden" id="attractionId" name="attraction_id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Tên Địa Điểm *</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Danh Mục *</label>
                        <select id="category" name="category" required>
                            <option value="">-- Chọn danh mục --</option>
                            <option value="Di tích lịch sử">Di tích lịch sử</option>
                            <option value="Chùa Khmer">Chùa Khmer</option>
                            <option value="Chùa Phật giáo">Chùa Phật giáo</option>
                            <option value="Di tích kiến trúc">Di tích kiến trúc</option>
                            <option value="Sinh thái">Sinh thái</option>
                            <option value="Văn hóa">Văn hóa</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô Tả *</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Vị Trí *</label>
                        <input type="text" id="location" name="location" required>
                    </div>

                    <div class="form-group">
                        <label>Giá Vé</label>
                        <input type="text" id="ticketPrice" name="ticket_price" placeholder="VD: Miễn phí, 50.000đ">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giờ Mở Cửa</label>
                        <input type="text" id="openingHours" name="opening_hours" placeholder="VD: 6:00 - 18:00">
                    </div>

                    <div class="form-group">
                        <label>Liên Hệ</label>
                        <input type="text" id="contact" name="contact" placeholder="VD: 0292.3855.246">
                    </div>
                </div>

                <div class="form-group">
                    <label>URL Hình Ảnh</label>
                    <input type="text" id="imageUrl" name="image_url" placeholder="hinhanh/DulichtpTV/...">
                </div>

                <div class="form-group">
                    <label>Thời Gian Tốt Nhất</label>
                    <input type="text" id="bestTime" name="best_time" placeholder="VD: Sáng sớm (6:00-8:00)">
                </div>

                <div class="form-group">
                    <label>Điểm Nổi Bật (phân cách bởi |)</label>
                    <textarea id="highlights" name="highlights" placeholder="VD: Kiến trúc đẹp|Không gian yên tĩnh|Lễ hội truyền thống"></textarea>
                </div>

                <div class="form-group">
                    <label>Tiện Ích (phân cách bởi |)</label>
                    <textarea id="facilities" name="facilities" placeholder="VD: Bãi đỗ xe|Nhà vệ sinh|Khu vui chơi"></textarea>
                </div>

                <div class="form-group">
                    <label>Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Tạm ngưng</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Hủy</button>
                    <button type="submit" class="btn-submit">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let attractions = [];

        // Load attractions
        async function loadAttractions() {
            try {
                const response = await fetch('api/attractions.php');
                const result = await response.json();

                if (result.success) {
                    attractions = result.data;
                    displayAttractions();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function displayAttractions() {
            const tbody = document.getElementById('attractionsTableBody');
            
            if (attractions.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Chưa có địa điểm nào</td></tr>';
                return;
            }

            tbody.innerHTML = attractions.map(attr => `
                <tr>
                    <td>
                        <img src="${attr.image_url}" alt="${attr.name}" class="attraction-image"
                             onerror="this.src='hinhanh/DulichtpTV/aobaom-02-1024x686.jpg'">
                    </td>
                    <td><strong>${attr.name}</strong></td>
                    <td>${attr.category || '-'}</td>
                    <td>${attr.location || '-'}</td>
                    <td>${attr.ticket_price || 'Miễn phí'}</td>
                    <td>
                        <span class="status-badge status-${attr.status}">
                            ${attr.status === 'active' ? 'Hoạt động' : 'Tạm ngưng'}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-view" onclick="window.open('chi-tiet-dia-diem.php?id=${attr.attraction_id}', '_blank')">
                                👁️
                            </button>
                            <button class="btn-edit" onclick="editAttraction('${attr.attraction_id}')">
                                ✏️
                            </button>
                            <button class="btn-delete" onclick="deleteAttraction('${attr.attraction_id}')">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Thêm Địa Điểm Mới';
            document.getElementById('attractionForm').reset();
            document.getElementById('attractionId').value = '';
            document.getElementById('attractionModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('attractionModal').style.display = 'none';
        }

        function editAttraction(id) {
            const attr = attractions.find(a => a.attraction_id === id);
            if (!attr) return;

            document.getElementById('modalTitle').textContent = 'Chỉnh Sửa Địa Điểm';
            document.getElementById('attractionId').value = attr.attraction_id;
            document.getElementById('name').value = attr.name;
            document.getElementById('category').value = attr.category || '';
            document.getElementById('description').value = attr.description || '';
            document.getElementById('location').value = attr.location || '';
            document.getElementById('ticketPrice').value = attr.ticket_price || '';
            document.getElementById('openingHours').value = attr.opening_hours || '';
            document.getElementById('contact').value = attr.contact || '';
            document.getElementById('imageUrl').value = attr.image_url || '';
            document.getElementById('bestTime').value = attr.best_time || '';
            document.getElementById('highlights').value = attr.highlights || '';
            document.getElementById('facilities').value = attr.facilities || '';
            document.getElementById('status').value = attr.status || 'active';
            
            document.getElementById('attractionModal').style.display = 'block';
        }

        async function deleteAttraction(id) {
            if (!confirm('Bạn có chắc muốn xóa địa điểm này?')) return;

            try {
                const response = await fetch('api/attractions.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ attraction_id: id })
                });

                const result = await response.json();
                if (result.success) {
                    alert('Xóa địa điểm thành công!');
                    loadAttractions();
                } else {
                    alert('Lỗi: ' + result.message);
                }
            } catch (error) {
                alert('Lỗi khi xóa địa điểm');
            }
        }

        // Submit form
        document.getElementById('attractionForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = {
                attraction_id: document.getElementById('attractionId').value,
                name: document.getElementById('name').value,
                category: document.getElementById('category').value,
                description: document.getElementById('description').value,
                location: document.getElementById('location').value,
                ticket_price: document.getElementById('ticketPrice').value,
                opening_hours: document.getElementById('openingHours').value,
                contact: document.getElementById('contact').value,
                image_url: document.getElementById('imageUrl').value,
                best_time: document.getElementById('bestTime').value,
                highlights: document.getElementById('highlights').value,
                facilities: document.getElementById('facilities').value,
                status: document.getElementById('status').value
            };

            const attractionId = document.getElementById('attractionId').value;
            const method = attractionId ? 'PUT' : 'POST';

            try {
                const response = await fetch('api/attractions.php', {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();
                if (result.success) {
                    alert(attractionId ? 'Cập nhật thành công!' : 'Thêm địa điểm thành công!');
                    closeModal();
                    loadAttractions();
                } else {
                    alert('Lỗi: ' + result.message);
                }
            } catch (error) {
                alert('Lỗi khi lưu địa điểm');
            }
        });

        // Load khi trang sẵn sàng
        document.addEventListener('DOMContentLoaded', loadAttractions);
    </script>
</body>
</html>
