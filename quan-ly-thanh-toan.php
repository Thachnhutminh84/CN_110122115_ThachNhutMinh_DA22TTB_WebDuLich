<?php
session_start();
require_once 'check-auth.php';
requireAdminOrManager();
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thanh Toán</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin-responsive.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 100px auto 50px;
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
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
        }
        .payments-table {
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
        .status-paid {
            background: #d4edda;
            color: #155724;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }
        .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .filter-bar select, .filter-bar input {
            padding: 10px;
            border: 2px solid #ecf0f1;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="admin-container">
        <h1>💳 Quản Lý Thanh Toán</h1>

        <!-- Thống kê -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Tổng doanh thu</h3>
                <div class="value" id="totalRevenue">0đ</div>
            </div>
            <div class="stat-card">
                <h3>Đã thanh toán</h3>
                <div class="value" id="paidCount">0</div>
            </div>
            <div class="stat-card">
                <h3>Chờ thanh toán</h3>
                <div class="value" id="pendingCount">0</div>
            </div>
            <div class="stat-card">
                <h3>Thất bại</h3>
                <div class="value" id="failedCount">0</div>
            </div>
        </div>

        <!-- Filter -->
        <div class="filter-bar">
            <select id="filterStatus" onchange="loadPayments()">
                <option value="">Tất cả trạng thái</option>
                <option value="paid">Đã thanh toán</option>
                <option value="pending">Chờ thanh toán</option>
                <option value="failed">Thất bại</option>
            </select>
            <select id="filterMethod" onchange="loadPayments()">
                <option value="">Tất cả phương thức</option>
                <option value="VNPay">VNPay</option>
                <option value="cash">Tiền mặt</option>
            </select>
            <input type="date" id="filterDate" onchange="loadPayments()">
        </div>

        <!-- Bảng thanh toán -->
        <div class="payments-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã Booking</th>
                        <th>Khách hàng</th>
                        <th>Số tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Ngày thanh toán</th>
                        <th>Mã GD</th>
                    </tr>
                </thead>
                <tbody id="paymentsBody">
                    <tr>
                        <td colspan="8" style="text-align: center;">Đang tải...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Load thanh toán
        async function loadPayments() {
            const status = document.getElementById('filterStatus').value;
            const method = document.getElementById('filterMethod').value;
            const date = document.getElementById('filterDate').value;
            
            let url = 'api/payments.php?';
            if (status) url += `status=${status}&`;
            if (method) url += `method=${method}&`;
            if (date) url += `date=${date}&`;
            
            try {
                const response = await fetch(url);
                const result = await response.json();
                
                if (result.success) {
                    displayPayments(result.data);
                    updateStats(result.stats);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function displayPayments(payments) {
            const tbody = document.getElementById('paymentsBody');
            
            if (payments.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">Không có dữ liệu</td></tr>';
                return;
            }
            
            tbody.innerHTML = payments.map(p => `
                <tr>
                    <td>${p.payment_id}</td>
                    <td><strong>${p.booking_code}</strong></td>
                    <td>${p.customer_name}</td>
                    <td><strong>${formatMoney(p.amount)}</strong></td>
                    <td>${p.payment_method}</td>
                    <td><span class="status-badge status-${p.payment_status}">${getStatusText(p.payment_status)}</span></td>
                    <td>${formatDate(p.payment_date)}</td>
                    <td>${p.transaction_code || '-'}</td>
                </tr>
            `).join('');
        }

        function updateStats(stats) {
            document.getElementById('totalRevenue').textContent = formatMoney(stats.total_revenue);
            document.getElementById('paidCount').textContent = stats.paid_count;
            document.getElementById('pendingCount').textContent = stats.pending_count;
            document.getElementById('failedCount').textContent = stats.failed_count;
        }

        function formatMoney(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleString('vi-VN');
        }

        function getStatusText(status) {
            const texts = {
                'paid': 'Đã thanh toán',
                'pending': 'Chờ thanh toán',
                'failed': 'Thất bại'
            };
            return texts[status] || status;
        }

        // Load khi trang load
        loadPayments();
    </script>
</body>
</html>
