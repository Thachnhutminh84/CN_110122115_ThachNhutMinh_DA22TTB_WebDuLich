<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Tour - Du Lịch Trà Vinh</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/attractions-redesign.css">
    <style>
        .tours-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }

        .tours-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .tours-header h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .tours-header p {
            font-size: 1.1rem;
            color: #7f8c8d;
        }

        .tours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .tour-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .tour-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .tour-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .tour-content {
            padding: 20px;
        }

        .tour-title {
            font-size: 1.4rem;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .tour-duration {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .tour-description {
            color: #7f8c8d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .tour-price {
            font-size: 1.5rem;
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .tour-price small {
            font-size: 0.9rem;
            color: #95a5a6;
            font-weight: normal;
        }

        .tour-actions {
            display: flex;
            gap: 10px;
        }

        .btn-view, .btn-book {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-view {
            background: #ecf0f1;
            color: #2c3e50;
        }

        .btn-view:hover {
            background: #bdc3c7;
        }

        .btn-book {
            background: #27ae60;
            color: white;
        }

        .btn-book:hover {
            background: #229954;
        }

        .loading {
            text-align: center;
            padding: 50px;
            font-size: 1.2rem;
            color: #7f8c8d;
        }

        @media (max-width: 768px) {
            .tours-grid {
                grid-template-columns: 1fr;
            }

            .tours-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <div class="tours-container">
        <div class="tours-header">
            <h1>🚌 Danh Sách Tour Du Lịch</h1>
            <p>Khám phá Trà Vinh với các tour du lịch hấp dẫn</p>
        </div>

        <div id="toursGrid" class="tours-grid">
            <div class="loading">Đang tải danh sách tour...</div>
        </div>
    </div>

    <script>
        // Load tours
        async function loadTours() {
            try {
                const response = await fetch('api/tours.php?action=active');
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    displayTours(result.data);
                } else {
                    document.getElementById('toursGrid').innerHTML = 
                        '<div class="loading">Chưa có tour nào</div>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('toursGrid').innerHTML = 
                    '<div class="loading">Lỗi khi tải dữ liệu</div>';
            }
        }

        function displayTours(tours) {
            const grid = document.getElementById('toursGrid');
            grid.innerHTML = tours.map(tour => `
                <div class="tour-card">
                    <img src="hinhanh/tours/tour-${tour.tour_id}.jpg" 
                         alt="${tour.tour_name}" 
                         class="tour-image"
                         onerror="this.src='hinhanh/DulichtpTV/aobaom-02-1024x686.jpg'">
                    <div class="tour-content">
                        <h3 class="tour-title">${tour.tour_name}</h3>
                        <span class="tour-duration">⏱️ ${tour.duration_days} ngày</span>
                        <p class="tour-description">${tour.description}</p>
                        <div class="tour-price">
                            ${formatPrice(tour.base_price)}đ
                            <small>/người</small>
                        </div>
                        <div class="tour-actions">
                            <a href="chi-tiet-tour.php?id=${tour.tour_id}" class="btn-view">
                                Xem Chi Tiết
                            </a>
                            <a href="dat-tour.php?tour_id=${tour.tour_id}" class="btn-book">
                                Đặt Tour
                            </a>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price);
        }

        // Load khi trang sẵn sàng
        document.addEventListener('DOMContentLoaded', loadTours);
    </script>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>
</body>
</html>
