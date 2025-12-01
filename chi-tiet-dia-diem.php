<?php
/**
 * Trang Chi Tiết Địa Điểm Du Lịch - PHP Version
 */

session_start();

require_once 'config/database.php';
require_once 'models/Attraction.php';

// Lấy ID từ URL
$attractionId = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($attractionId)) {
    header('Location: dia-diem-du-lich-dynamic.php');
    exit();
}

// Khởi tạo database
try {
    $database = new Database();
    $db = $database->getConnection();
    $attraction = new Attraction($db);
    
    $attraction->attraction_id = $attractionId;
    
    if (!$attraction->readOne()) {
        header('Location: dia-diem-du-lich-dynamic.php');
        exit();
    }
    
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($attraction->name); ?> - Du Lịch Trà Vinh</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/mobile-enhancements.css">
    <link rel="stylesheet" href="css/header-responsive-fix.css">
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&language=vi"></script>
    
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
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #2563eb;
        }

        .detail-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .detail-hero {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .hero-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .hero-content {
            padding: 40px;
        }

        .hero-title {
            font-size: 2.5em;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .hero-category {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .detail-main {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .detail-sidebar {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .section-title {
            font-size: 1.8em;
            color: #1f2937;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #3b82f6;
        }

        .description {
            color: #4b5563;
            line-height: 1.8;
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .info-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
        }

        .info-icon {
            font-size: 1.5em;
            color: #3b82f6;
            width: 30px;
        }

        .info-content strong {
            display: block;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .info-content span {
            color: #6b7280;
        }

        .booking-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .booking-card h3 {
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        .booking-card .price {
            font-size: 2em;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: white;
            color: #3b82f6;
            margin-bottom: 10px;
        }

        .btn-primary:hover {
            background: #f3f4f6;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .quick-info {
            padding: 20px;
            background: #f9fafb;
            border-radius: 10px;
        }

        .quick-info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .quick-info-item:last-child {
            border-bottom: none;
        }

        .quick-info-label {
            color: #6b7280;
        }

        .quick-info-value {
            font-weight: 600;
            color: #1f2937;
        }

        .highlights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .highlight-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 10px;
            border-left: 4px solid #f59e0b;
        }

        .highlight-item i {
            color: #f59e0b;
            font-size: 1.2em;
        }

        .highlight-item span {
            color: #78350f;
            font-weight: 500;
        }

        .facilities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-top: 20px;
        }

        .facility-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            background: #f0fdf4;
            border-radius: 8px;
            border-left: 3px solid #10b981;
        }

        .facility-item i {
            color: #10b981;
            font-size: 1em;
        }

        .facility-item span {
            color: #065f46;
            font-weight: 500;
        }

        /* Google Maps Styles */
        #map {
            width: 100%;
            height: 450px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .map-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .map-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .map-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            font-size: 14px;
        }

        .map-btn-primary {
            background: #3b82f6;
            color: white;
        }

        .map-btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .map-btn-secondary {
            background: #10b981;
            color: white;
        }

        .map-btn-secondary:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .map-btn-outline {
            background: white;
            color: #6b7280;
            border: 2px solid #e5e7eb;
        }

        .map-btn-outline:hover {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        @media (max-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .hero-title {
                font-size: 1.8em;
            }

            .highlights-grid,
            .facilities-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <a href="dia-diem-du-lich-dynamic.php" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Quay Lại Danh Sách
            </a>
            <a href="index.php" class="back-btn">
                <i class="fas fa-home"></i>
                Trang Chủ
            </a>
        </div>
    </div>

    <!-- Detail Container -->
    <div class="detail-container">
        <!-- Hero Section -->
        <div class="detail-hero">
            <img src="<?php echo htmlspecialchars($attraction->image_url ?? 'hinhanh/placeholder.jpg'); ?>" 
                 alt="<?php echo htmlspecialchars($attraction->name); ?>"
                 class="hero-image"
                 onerror="this.src='hinhanh/placeholder.jpg'">
            
            <div class="hero-content">
                <span class="hero-category">
                    <?php echo htmlspecialchars($attraction->category ?? 'Địa điểm du lịch'); ?>
                </span>
                <h1 class="hero-title"><?php echo htmlspecialchars($attraction->name); ?></h1>
            </div>
        </div>

        <!-- Detail Grid -->
        <div class="detail-grid">
            <!-- Main Content -->
            <div class="detail-main">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Giới Thiệu
                </h2>
                
                <div class="description">
                    <?php echo nl2br(htmlspecialchars($attraction->description)); ?>
                </div>

                <!-- Thông tin chi tiết -->
                <div class="info-grid" style="margin-top: 30px;">
                    <?php if (!empty($attraction->year_built)): ?>
                    <div class="info-item">
                        <i class="fas fa-calendar-alt info-icon"></i>
                        <div class="info-content">
                            <strong>Năm xây dựng:</strong>
                            <span><?php echo htmlspecialchars($attraction->year_built); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($attraction->cultural_significance)): ?>
                    <div class="info-item">
                        <i class="fas fa-landmark info-icon"></i>
                        <div class="info-content">
                            <strong>Đặc trưng văn hóa:</strong>
                            <span><?php echo htmlspecialchars($attraction->cultural_significance); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($attraction->historical_value)): ?>
                    <div class="info-item">
                        <i class="fas fa-book-open info-icon"></i>
                        <div class="info-content">
                            <strong>Giá trị lịch sử:</strong>
                            <span><?php echo htmlspecialchars($attraction->historical_value); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($attraction->architecture_style)): ?>
                    <div class="info-item">
                        <i class="fas fa-building info-icon"></i>
                        <div class="info-content">
                            <strong>Kiến trúc:</strong>
                            <span><?php echo htmlspecialchars($attraction->architecture_style); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($attraction->notable_features)): ?>
                    <div class="info-item">
                        <i class="fas fa-star info-icon"></i>
                        <div class="info-content">
                            <strong>Điểm nổi bật:</strong>
                            <span><?php echo htmlspecialchars($attraction->notable_features); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($attraction->religious_significance)): ?>
                    <div class="info-item">
                        <i class="fas fa-praying-hands info-icon"></i>
                        <div class="info-content">
                            <strong>Ý nghĩa tôn giáo:</strong>
                            <span><?php echo htmlspecialchars($attraction->religious_significance); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <h2 class="section-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Thông Tin Tham Quan
                </h2>

                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt info-icon"></i>
                        <div class="info-content">
                            <strong>Địa chỉ:</strong>
                            <span><?php echo htmlspecialchars($attraction->location); ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-clock info-icon"></i>
                        <div class="info-content">
                            <strong>Giờ mở cửa:</strong>
                            <span><?php echo htmlspecialchars($attraction->opening_hours ?? 'Liên hệ để biết thêm'); ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-ticket-alt info-icon"></i>
                        <div class="info-content">
                            <strong>Vé tham quan:</strong>
                            <span><?php echo htmlspecialchars($attraction->ticket_price ?? 'Miễn phí'); ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-sun info-icon"></i>
                        <div class="info-content">
                            <strong>Thời gian tốt nhất:</strong>
                            <span><?php echo htmlspecialchars($attraction->best_time ?? 'Cả năm'); ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-phone info-icon"></i>
                        <div class="info-content">
                            <strong>Liên hệ:</strong>
                            <span><?php echo htmlspecialchars($attraction->contact ?? '0294.3855.246'); ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-tag info-icon"></i>
                        <div class="info-content">
                            <strong>Danh mục:</strong>
                            <span><?php echo htmlspecialchars($attraction->category ?? 'Địa điểm du lịch'); ?></span>
                        </div>
                    </div>
                </div>

                <?php if (!empty($attraction->highlights)): ?>
                <h2 class="section-title" style="margin-top: 40px;">
                    <i class="fas fa-star"></i>
                    Điểm Nổi Bật
                </h2>
                <div class="highlights-grid">
                    <?php 
                    $highlights = explode('|', $attraction->highlights);
                    foreach ($highlights as $highlight): 
                    ?>
                    <div class="highlight-item">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo htmlspecialchars(trim($highlight)); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($attraction->facilities)): ?>
                <h2 class="section-title" style="margin-top: 40px;">
                    <i class="fas fa-concierge-bell"></i>
                    Tiện Ích & Dịch Vụ
                </h2>
                <div class="facilities-grid">
                    <?php 
                    $facilities = explode('|', $attraction->facilities);
                    foreach ($facilities as $facility): 
                    ?>
                    <div class="facility-item">
                        <i class="fas fa-check"></i>
                        <span><?php echo htmlspecialchars(trim($facility)); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Google Maps Section -->
                <div class="map-container">
                    <h2 class="section-title">
                        <i class="fas fa-map-location-dot"></i>
                        Bản Đồ & Vị Trí
                    </h2>
                    
                    <div id="map"></div>
                    
                    <div class="map-actions">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $attraction->latitude ?? '9.9347'; ?>,<?php echo $attraction->longitude ?? '106.3428'; ?>" 
                           target="_blank"
                           class="map-btn map-btn-primary">
                            <i class="fas fa-directions"></i>
                            Chỉ Đường
                        </a>
                        
                        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($attraction->name . ', ' . $attraction->location); ?>" 
                           target="_blank"
                           class="map-btn map-btn-secondary">
                            <i class="fas fa-external-link-alt"></i>
                            Xem Trên Google Maps
                        </a>
                        
                        <button onclick="copyCoordinates()" class="map-btn map-btn-outline">
                            <i class="fas fa-copy"></i>
                            Sao Chép Tọa Độ
                        </button>
                    </div>
                    
                    <div style="margin-top: 15px; padding: 15px; background: #f9fafb; border-radius: 8px;">
                        <p style="margin: 0; color: #6b7280; font-size: 14px;">
                            <i class="fas fa-info-circle" style="color: #3b82f6;"></i>
                            <strong>Tọa độ:</strong> 
                            <span id="coordinates">
                                <?php echo $attraction->latitude ?? '9.9347'; ?>, 
                                <?php echo $attraction->longitude ?? '106.3428'; ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="detail-sidebar">
                <!-- Booking Card -->
                <div class="booking-card">
                    <h3>Đặt Tour Tham Quan</h3>
                    <div class="price">
                        <?php echo htmlspecialchars($attraction->ticket_price ?? 'Miễn phí'); ?>
                    </div>
                    <a href="dat-tour.php?id=<?php echo urlencode($attraction->attraction_id); ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i>
                        Đặt Tour Ngay
                    </a>
                    <a href="tel:0294.3855.246" class="btn btn-secondary">
                        <i class="fas fa-phone"></i>
                        Gọi Tư Vấn
                    </a>
                </div>

                <!-- Quick Info -->
                <div class="quick-info">
                    <h3 style="margin-bottom: 15px; color: #1f2937;">Thông Tin Nhanh</h3>
                    
                    <div class="quick-info-item">
                        <span class="quick-info-label">Trạng thái:</span>
                        <span class="quick-info-value" style="color: #10b981;">
                            <?php echo ($attraction->status === 'active') ? 'Đang hoạt động' : 'Tạm đóng'; ?>
                        </span>
                    </div>

                    <div class="quick-info-item">
                        <span class="quick-info-label">Danh mục:</span>
                        <span class="quick-info-value">
                            <?php echo htmlspecialchars($attraction->category ?? 'N/A'); ?>
                        </span>
                    </div>
                </div>

                <!-- Share Buttons -->
                <div style="margin-top: 20px; text-align: center;">
                    <button onclick="shareAttraction()" class="btn btn-secondary">
                        <i class="fas fa-share-alt"></i>
                        Chia Sẻ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/google-maps.js"></script>
    <script>
        // Khởi tạo Google Maps
        document.addEventListener('DOMContentLoaded', function() {
            const lat = <?php echo $attraction->latitude ?? '9.9347'; ?>;
            const lng = <?php echo $attraction->longitude ?? '106.3428'; ?>;
            const title = '<?php echo addslashes($attraction->name); ?>';
            const address = '<?php echo addslashes($attraction->location); ?>';
            
            // Kiểm tra nếu Google Maps đã load
            if (typeof google !== 'undefined') {
                initMap(lat, lng, title, address);
            } else {
                console.error('❌ Google Maps API chưa được load');
                document.getElementById('map').innerHTML = `
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f3f4f6; border-radius: 15px;">
                        <div style="text-align: center; padding: 40px;">
                            <i class="fas fa-map-marked-alt" style="font-size: 3em; color: #d1d5db; margin-bottom: 15px;"></i>
                            <p style="color: #6b7280; margin: 0;">Không thể tải bản đồ. Vui lòng kiểm tra API key.</p>
                        </div>
                    </div>
                `;
            }
        });

        function shareAttraction() {
            const url = window.location.href;
            const title = '<?php echo addslashes($attraction->name); ?>';
            
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Khám phá địa điểm du lịch tuyệt vời này!',
                    url: url
                }).catch(err => console.log('Error sharing:', err));
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    alert('✅ Đã sao chép link chia sẻ!');
                }).catch(err => {
                    alert('❌ Không thể sao chép link!');
                });
            }
        }

        function copyCoordinates() {
            const coords = document.getElementById('coordinates').textContent.trim();
            navigator.clipboard.writeText(coords).then(() => {
                alert('✅ Đã sao chép tọa độ: ' + coords);
            }).catch(err => {
                alert('❌ Không thể sao chép tọa độ!');
            });
        }
    </script>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>
