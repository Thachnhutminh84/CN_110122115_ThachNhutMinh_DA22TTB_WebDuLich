<?php
session_start();
$tourId = $_GET['id'] ?? null;
if (!$tourId) {
    header('Location: danh-sach-tour.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Tour - Du Lịch Trà Vinh</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        .tour-detail-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }

        .tour-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .tour-title {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .tour-meta {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #7f8c8d;
        }

        .tour-price-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .tour-price-box .price {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .tour-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .main-content, .sidebar {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
        }

        .itinerary {
            white-space: pre-line;
            line-height: 1.8;
            color: #555;
        }

        .attractions-list {
            display: grid;
            gap: 15px;
        }

        .attraction-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .attraction-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .attraction-info h4 {
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .attraction-info p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .schedules-list {
            display: grid;
            gap: 15px;
        }

        .schedule-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #27ae60;
        }

        .schedule-date {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .schedule-info {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .btn-book-now {
            width: 100%;
            padding: 15px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-book-now:hover {
            background: #229954;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .tour-content {
                grid-template-columns: 1fr;
            }

            .tour-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="tour-detail-container">
        <div id="tourDetail">
            <div class="loading" style="text-align: center; padding: 50px;">
                Đang tải thông tin tour...
            </div>
        </div>
    </div>

    <script>
        const tourId = <?php echo json_encode($tourId); ?>;

        async function loadTourDetail() {
            try {
                const response = await fetch(`api/tours.php?id=${tourId}`);
                const result = await response.json();

                if (result.success && result.data) {
                    displayTourDetail(result.data);
                } else {
                    document.getElementById('tourDetail').innerHTML = 
                        '<div class="loading">Tour không tồn tại</div>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('tourDetail').innerHTML = 
                    '<div class="loading">Lỗi khi tải dữ liệu</div>';
            }
        }

        function displayTourDetail(tour) {
            document.getElementById('tourDetail').innerHTML = `
                <div class="tour-header">
                    <h1 class="tour-title">${tour.tour_name}</h1>
                    <div class="tour-meta">
                        <div class="meta-item">
                            <span>⏱️</span>
                            <span><strong>${tour.duration_days}</strong> ngày</span>
                        </div>
                        <div class="meta-item">
                            <span>👥</span>
                            <span>Tối đa <strong>${tour.max_participants}</strong> người</span>
                        </div>
                        <div class="meta-item">
                            <span>📍</span>
                            <span>Khởi hành từ <strong>Trường ĐH Trà Vinh</strong></span>
                        </div>
                    </div>
                    <p style="color: #555; line-height: 1.8;">${tour.description}</p>
                </div>

                <div class="tour-content">
                    <div class="main-content">
                        <h2 class="section-title">📋 Lịch Trình Tour</h2>
                        <div class="itinerary">${tour.itinerary}</div>

                        ${tour.attractions && tour.attractions.length > 0 ? `
                            <h2 class="section-title" style="margin-top: 40px;">📍 Địa Điểm Tham Quan</h2>
                            <div class="attractions-list">
                                ${tour.attractions.map(attr => `
                                    <div class="attraction-item">
                                        <img src="${attr.image_url}" alt="${attr.name}"
                                             onerror="this.src='hinhanh/DulichtpTV/aobaom-02-1024x686.jpg'">
                                        <div class="attraction-info">
                                            <h4>${attr.name}</h4>
                                            <p>⏱️ Thời gian: ${attr.visit_duration}</p>
                                            <p>📍 ${attr.location}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        ` : ''}
                    </div>

                    <div class="sidebar">
                        <div class="tour-price-box">
                            <div style="font-size: 1.1rem; margin-bottom: 10px;">Giá Tour</div>
                            <div class="price">${formatPrice(tour.base_price)}đ</div>
                            <div style="font-size: 0.9rem; margin-top: 5px;">/ người</div>
                        </div>

                        ${tour.schedules && tour.schedules.length > 0 ? `
                            <h3 class="section-title" style="margin-top: 30px; font-size: 1.3rem;">
                                📅 Lịch Khởi Hành
                            </h3>
                            <div class="schedules-list">
                                ${tour.schedules.map(schedule => `
                                    <div class="schedule-item">
                                        <div class="schedule-date">
                                            ${formatDate(schedule.departure_date)}
                                        </div>
                                        <div class="schedule-info">
                                            ⏰ ${schedule.departure_time}<br>
                                            👥 Còn ${schedule.available_slots} chỗ<br>
                                            👨‍🏫 HDV: ${schedule.guide_name}
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        ` : ''}

                        <a href="dat-tour.php?tour_id=${tour.tour_id}" class="btn-book-now" style="margin-top: 30px;">
                            🎫 Đặt Tour Ngay
                        </a>
                    </div>
                </div>
            `;
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }

        document.addEventListener('DOMContentLoaded', loadTourDetail);
    </script>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>
</body>
</html>
