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
    <title>Quản Lý Tour - Admin</title>
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

        .tours-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
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
        }

        .modal-content {
            background: white;
            max-width: 800px;
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
            min-height: 150px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
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
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1>🚌 Quản Lý Tour Du Lịch</h1>
            <button class="btn-add" onclick="openAddModal()">➕ Thêm Tour Mới</button>
        </div>

        <div class="tours-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Tour</th>
                        <th>Thời Gian</th>
                        <th>Giá</th>
                        <th>Số Người</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody id="toursTableBody">
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px;">
                            Đang tải dữ liệu...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Thêm/Sửa Tour -->
    <div id="tourModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Thêm Tour Mới</h2>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            <form id="tourForm">
                <input type="hidden" id="tourId" name="tour_id">
                
                <div class="form-group">
                    <label>Tên Tour *</label>
                    <input type="text" id="tourName" name="tour_name" required>
                </div>

                <div class="form-group">
                    <label>Mô Tả *</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label>Số Ngày *</label>
                    <input type="number" id="durationDays" name="duration_days" min="1" required>
                </div>

                <div class="form-group">
                    <label>Giá Cơ Bản (VNĐ) *</label>
                    <input type="number" id="basePrice" name="base_price" min="0" required>
                </div>

                <div class="form-group">
                    <label>Số Người Tối Đa *</label>
                    <input type="number" id="maxParticipants" name="max_participants" min="1" required>
                </div>

                <div class="form-group">
                    <label>Lịch Trình Chi Tiết *</label>
                    <textarea id="itinerary" name="itinerary" required></textarea>
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
        let tours = [];

        // Load tours
        async function loadTours() {
            try {
                const response = await fetch('api/tours.php');
                const result = await response.json();

                if (result.success) {
                    tours = result.data;
                    displayTours();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function displayTours() {
            const tbody = document.getElementById('toursTableBody');
            
            if (tours.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Chưa có tour nào</td></tr>';
                return;
            }

            tbody.innerHTML = tours.map(tour => `
                <tr>
                    <td>${tour.tour_id}</td>
                    <td>${tour.tour_name}</td>
                    <td>${tour.duration_days} ngày</td>
                    <td>${formatPrice(tour.base_price)}đ</td>
                    <td>${tour.max_participants} người</td>
                    <td>
                        <span class="status-badge status-${tour.status}">
                            ${tour.status === 'active' ? 'Hoạt động' : 'Tạm ngưng'}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-view" onclick="window.open('chi-tiet-tour.php?id=${tour.tour_id}', '_blank')">
                                👁️
                            </button>
                            <button class="btn-edit" onclick="editTour(${tour.tour_id})">
                                ✏️
                            </button>
                            <button class="btn-delete" onclick="deleteTour(${tour.tour_id})">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price);
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Thêm Tour Mới';
            document.getElementById('tourForm').reset();
            document.getElementById('tourId').value = '';
            document.getElementById('tourModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('tourModal').style.display = 'none';
        }

        function editTour(id) {
            const tour = tours.find(t => t.tour_id == id);
            if (!tour) return;

            document.getElementById('modalTitle').textContent = 'Chỉnh Sửa Tour';
            document.getElementById('tourId').value = tour.tour_id;
            document.getElementById('tourName').value = tour.tour_name;
            document.getElementById('description').value = tour.description;
            document.getElementById('durationDays').value = tour.duration_days;
            document.getElementById('basePrice').value = tour.base_price;
            document.getElementById('maxParticipants').value = tour.max_participants;
            document.getElementById('itinerary').value = tour.itinerary;
            document.getElementById('status').value = tour.status;
            
            document.getElementById('tourModal').style.display = 'block';
        }

        async function deleteTour(id) {
            if (!confirm('Bạn có chắc muốn xóa tour này?')) return;

            try {
                const response = await fetch('api/tours.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ tour_id: id })
                });

                const result = await response.json();
                if (result.success) {
                    alert('Xóa tour thành công!');
                    loadTours();
                } else {
                    alert('Lỗi: ' + result.message);
                }
            } catch (error) {
                alert('Lỗi khi xóa tour');
            }
        }

        // Submit form
        document.getElementById('tourForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = {
                tour_name: document.getElementById('tourName').value,
                description: document.getElementById('description').value,
                duration_days: document.getElementById('durationDays').value,
                base_price: document.getElementById('basePrice').value,
                max_participants: document.getElementById('maxParticipants').value,
                itinerary: document.getElementById('itinerary').value,
                status: document.getElementById('status').value
            };

            const tourId = document.getElementById('tourId').value;
            const method = tourId ? 'PUT' : 'POST';
            
            if (tourId) {
                formData.tour_id = tourId;
            }

            try {
                const response = await fetch('api/tours.php', {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();
                if (result.success) {
                    alert(tourId ? 'Cập nhật thành công!' : 'Thêm tour thành công!');
                    closeModal();
                    loadTours();
                } else {
                    alert('Lỗi: ' + result.message);
                }
            } catch (error) {
                alert('Lỗi khi lưu tour');
            }
        });

        // Load khi trang sẵn sàng
        document.addEventListener('DOMContentLoaded', loadTours);
    </script>
</body>
</html>
