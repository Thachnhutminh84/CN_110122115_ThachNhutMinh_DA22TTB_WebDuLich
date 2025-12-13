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
    <title>Dashboard - Quản Trị Hệ Thống</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin-responsive.css">
    <style>
        .dashboard-container {
            max-width: 1400px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }

        .dashboard-header {
            margin-bottom: 40px;
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon.green { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-icon.orange { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stat-icon.red { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

        .stat-info h3 {
            color: #7f8c8d;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .stat-info .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .chart-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .chart-title {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        /* Recent Activities */
        .recent-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        .recent-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .activity-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }

        .activity-item:last-child {
            margin-bottom: 0;
        }

        .activity-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .activity-meta {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 40px;
        }

        .action-btn {
            padding: 20px;
            background: white;
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #2c3e50;
            display: block;
        }

        .action-btn:hover {
            border-color: #3498db;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.2);
        }

        .action-btn .icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .action-btn .label {
            font-weight: 500;
        }

        @media (max-width: 1024px) {
            .charts-section,
            .recent-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>📊 Dashboard Quản Trị</h1>
            <p>Chào mừng trở lại, <?php echo htmlspecialchars($_SESSION['user']['full_name']); ?>!</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">🎫</div>
                <div class="stat-info">
                    <h3>Tổng Booking</h3>
                    <div class="stat-value" id="totalBookings">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">💰</div>
                <div class="stat-info">
                    <h3>Doanh Thu</h3>
                    <div class="stat-value" id="totalRevenue">0đ</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">👥</div>
                <div class="stat-info">
                    <h3>Người Dùng</h3>
                    <div class="stat-value" id="totalUsers">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon red">🚌</div>
                <div class="stat-info">
                    <h3>Tours Hoạt Động</h3>
                    <div class="stat-value" id="totalTours">0</div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-card">
                <h2 class="chart-title">📈 Thống Kê Booking Theo Tháng</h2>
                <canvas id="bookingChart" style="max-height: 300px;"></canvas>
            </div>

            <div class="chart-card">
                <h2 class="chart-title">📊 Trạng Thái Booking</h2>
                <canvas id="statusChart" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="recent-section">
            <div class="recent-card">
                <h2 class="chart-title">🔔 Booking Gần Đây</h2>
                <div id="recentBookings">
                    <div style="text-align: center; padding: 20px; color: #7f8c8d;">
                        Đang tải...
                    </div>
                </div>
            </div>

            <div class="recent-card">
                <h2 class="chart-title">📧 Liên Hệ Mới</h2>
                <div id="recentContacts">
                    <div style="text-align: center; padding: 20px; color: #7f8c8d;">
                        Đang tải...
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="quan-ly-tour.php" class="action-btn">
                <div class="icon">🚌</div>
                <div class="label">Quản Lý Tour</div>
            </a>
            <a href="quan-ly-booking.php" class="action-btn">
                <div class="icon">🎫</div>
                <div class="label">Quản Lý Booking</div>
            </a>
            <a href="quan-ly-users.php" class="action-btn">
                <div class="icon">👥</div>
                <div class="label">Quản Lý Users</div>
            </a>
            <a href="quan-ly-dich-vu.php" class="action-btn">
                <div class="icon">🛎️</div>
                <div class="label">Quản Lý Dịch Vụ</div>
            </a>
            <a href="quan-ly-lien-he.php" class="action-btn">
                <div class="icon">📧</div>
                <div class="label">Quản Lý Liên Hệ</div>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Load statistics
        async function loadStats() {
            try {
                // Load bookings
                const bookingsRes = await fetch('api/bookings.php');
                const bookingsData = await bookingsRes.json();
                
                if (bookingsData.success) {
                    const bookings = bookingsData.data;
                    document.getElementById('totalBookings').textContent = bookings.length;
                    
                    // Calculate revenue
                    const revenue = bookings.reduce((sum, b) => sum + parseFloat(b.total_price || 0), 0);
                    document.getElementById('totalRevenue').textContent = formatPrice(revenue) + 'đ';
                    
                    // Display recent bookings
                    displayRecentBookings(bookings.slice(0, 5));
                    
                    // Create charts
                    createBookingChart(bookings);
                    createStatusChart(bookings);
                }

                // Load users
                const usersRes = await fetch('api/users.php');
                const usersData = await usersRes.json();
                if (usersData.success) {
                    document.getElementById('totalUsers').textContent = usersData.data.length;
                }

                // Load tours
                const toursRes = await fetch('api/tours.php?action=active');
                const toursData = await toursRes.json();
                if (toursData.success) {
                    document.getElementById('totalTours').textContent = toursData.data.length;
                }

                // Load contacts
                const contactsRes = await fetch('api/contact.php');
                const contactsData = await contactsRes.json();
                if (contactsData.success) {
                    displayRecentContacts(contactsData.data.slice(0, 5));
                }

            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        function displayRecentBookings(bookings) {
            const container = document.getElementById('recentBookings');
            
            if (bookings.length === 0) {
                container.innerHTML = '<div style="text-align: center; padding: 20px; color: #7f8c8d;">Chưa có booking nào</div>';
                return;
            }

            container.innerHTML = bookings.map(booking => `
                <div class="activity-item">
                    <div class="activity-title">${booking.booking_code}</div>
                    <div class="activity-meta">
                        ${booking.customer_name} - ${formatPrice(booking.total_price)}đ
                        <br>
                        ${formatDate(booking.booking_date)}
                    </div>
                </div>
            `).join('');
        }

        function displayRecentContacts(contacts) {
            const container = document.getElementById('recentContacts');
            
            if (contacts.length === 0) {
                container.innerHTML = '<div style="text-align: center; padding: 20px; color: #7f8c8d;">Chưa có liên hệ nào</div>';
                return;
            }

            container.innerHTML = contacts.map(contact => `
                <div class="activity-item">
                    <div class="activity-title">${contact.name}</div>
                    <div class="activity-meta">
                        ${contact.subject}
                        <br>
                        ${formatDate(contact.created_at)}
                    </div>
                </div>
            `).join('');
        }

        function createBookingChart(bookings) {
            const ctx = document.getElementById('bookingChart').getContext('2d');
            
            // Group by month
            const monthlyData = {};
            bookings.forEach(booking => {
                const month = new Date(booking.booking_date).toLocaleDateString('vi-VN', { month: 'short', year: 'numeric' });
                monthlyData[month] = (monthlyData[month] || 0) + 1;
            });

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Object.keys(monthlyData),
                    datasets: [{
                        label: 'Số lượng booking',
                        data: Object.values(monthlyData),
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        function createStatusChart(bookings) {
            const ctx = document.getElementById('statusChart').getContext('2d');
            
            // Count by status
            const statusCount = {};
            bookings.forEach(booking => {
                statusCount[booking.booking_status] = (statusCount[booking.booking_status] || 0) + 1;
            });

            const statusLabels = {
                'pending': 'Chờ xác nhận',
                'confirmed': 'Đã xác nhận',
                'completed': 'Hoàn thành',
                'cancelled': 'Đã hủy'
            };

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusCount).map(k => statusLabels[k] || k),
                    datasets: [{
                        data: Object.values(statusCount),
                        backgroundColor: ['#f39c12', '#27ae60', '#3498db', '#e74c3c']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true
                }
            });
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }

        // Load when ready
        document.addEventListener('DOMContentLoaded', loadStats);
    </script>
</body>
</html>
