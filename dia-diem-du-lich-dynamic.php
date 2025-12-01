<?php
/**
 * Trang Địa Điểm Du Lịch - PHP Dynamic Version
 * Lấy dữ liệu từ database thay vì hardcode
 */

session_start();

require_once 'config/database.php';
require_once 'models/Attraction.php';

// Khởi tạo database
try {
    $database = new Database();
    $db = $database->getConnection();
    $attraction = new Attraction($db);
    
    // Lấy tham số filter từ URL
    $category = isset($_GET['category']) ? $_GET['category'] : 'all';
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    
    // Lấy danh sách attractions
    $attractions = [];
    if (!empty($searchKeyword)) {
        $stmt = $attraction->search($searchKeyword);
    } elseif ($category !== 'all') {
        $stmt = $attraction->readByCategory($category);
    } else {
        $stmt = $attraction->readAll();
    }
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $attractions[] = $row;
    }
    
    // Lấy danh sách categories từ database
    $categoriesStmt = $attraction->getCategories();
    $dbCategories = [];
    while ($row = $categoriesStmt->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['category'])) {
            $dbCategories[] = $row['category'];
        }
    }
    
    // Thống kê
    $totalAttractions = count($attractions);
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $attractions = [];
}

// Mapping category icons - Cập nhật để khớp với database
$categoryIcons = [
    'all' => 'fa-globe-asia',
    'Chùa Chiền' => 'fa-place-of-worship',
    'Di Tích Lịch Sử' => 'fa-monument',
    'Thiên Nhiên' => 'fa-tree',
    'Văn Hóa' => 'fa-masks-theater',
    'Chùa Khmer Cổ' => 'fa-place-of-worship',
    'Di Tích Quốc Gia' => 'fa-landmark',
    'Biển Đẹp' => 'fa-water',
    'Làng Nghề' => 'fa-industry'
];

$categoryNames = [
    'all' => 'Tất Cả',
    'Chùa Chiền' => 'Chùa Chiền',
    'Di Tích Lịch Sử' => 'Di Tích Lịch Sử',
    'Thiên Nhiên' => 'Thiên Nhiên',
    'Văn Hóa' => 'Văn Hóa'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Địa Điểm Du Lịch - Trà Vinh</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/attractions-redesign.css">
    <link rel="stylesheet" href="css/datetime.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/mobile-enhancements.css">
    <link rel="stylesheet" href="css/header-responsive-fix.css">
    <style>
        .attraction-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            padding: 40px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .attraction-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease, opacity 0.3s ease, transform 0.3s ease;
            opacity: 1;
        }

        .attraction-card:hover {
            transform: translateY(-10px) !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .card-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .attraction-card:hover .card-image img {
            transform: scale(1.1);
        }

        .card-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(59, 130, 246, 0.9);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .card-content {
            padding: 25px;
        }

        .card-title {
            font-size: 1.5em;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .card-location {
            color: #6b7280;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-description {
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .card-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .card-price {
            font-weight: 600;
            color: #10b981;
        }

        .card-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: #10b981;
            color: white;
        }

        .btn-secondary:hover {
            background: #059669;
        }

        .filter-section {
            background: white;
            padding: 20px;
            margin: 20px auto;
            max-width: 1400px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-tabs {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-btn {
            padding: 12px 25px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #6b7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .filter-btn:hover {
            background: #f3f4f6;
            border-color: #3b82f6;
            color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-color: #3b82f6;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            transform: translateY(-2px);
        }

        .filter-btn:active {
            transform: translateY(0);
        }

        .filter-btn i {
            font-size: 16px;
        }

        .search-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .search-form {
            width: 100%;
        }

        .search-wrapper {
            display: flex;
            gap: 10px;
            background: white;
            padding: 8px;
            border-radius: 50px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 25px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 20px;
            z-index: 1;
        }

        .search-input {
            flex: 1;
            padding: 15px 20px 15px 50px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            outline: none;
        }

        .search-btn {
            padding: 15px 35px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex !important;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        .search-results-info {
            text-align: center;
            margin-top: 20px;
            padding: 15px 25px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 50px;
            color: #1f2937;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-results-info i {
            color: #3b82f6;
        }

        .search-results-info strong {
            color: #3b82f6;
            font-size: 1.2em;
        }

        .clear-search-link {
            background: #ef4444;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.3s;
            margin-left: 10px;
        }

        .clear-search-link:hover {
            background: #dc2626;
            transform: scale(1.05);
        }

        .clear-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .clear-btn:hover {
            background: #dc2626;
            transform: translateY(-50%) scale(1.1);
        }

        .clear-btn.show {
            display: flex;
        }

        .search-btn {
            padding: 15px 35px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            transform: translateY(-2px);
        }

        .search-btn:active {
            transform: translateY(0);
        }

        .search-results-info {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 10px;
            color: #1f2937;
            font-weight: 600;
        }

        .search-results-info i {
            color: #3b82f6;
            margin-right: 8px;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .no-results i {
            font-size: 4em;
            color: #d1d5db;
            margin-bottom: 20px;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-btn:hover {
            transform: scale(1.05);
        }
        
        @media (min-width: 768px) {
            .mobile-menu-btn {
                display: none;
            }
        }
        
        /* Mobile Nav Show */
        .main-nav.show {
            display: flex;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            flex-direction: column;
            padding: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .main-nav.show .nav-link {
            padding: 12px 15px;
            border-radius: 8px;
            margin: 2px 0;
        }
        
        /* Header Buttons */
        .header-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .cta-login {
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
        }
        
        .cta-admin {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed) !important;
        }
        
        @media (max-width: 480px) {
            .btn-text {
                display: none;
            }
            
            .header-buttons {
                gap: 6px;
            }
            
            .cta-button {
                padding: 10px 12px !important;
            }
        }
        
        /* Hero responsive */
        .hero-header {
            display: flex;
            flex-direction: column;
            gap: 15px;
            text-align: center;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .hero-title {
            font-size: 1.75rem;
            margin: 0;
        }
        
        @media (min-width: 768px) {
            .hero-header {
                flex-direction: row;
                justify-content: space-between;
                text-align: left;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
        }
        
        @media (min-width: 992px) {
            .hero-title {
                font-size: 3rem;
            }
        }
        
        .btn-add-attraction {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        
        .btn-add-attraction:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        @media (max-width: 480px) {
            .btn-add-attraction {
                padding: 8px 12px;
                font-size: 0.8rem;
            }
        }
    </style>
    
    <script>
        function toggleMobileNav() {
            const nav = document.getElementById('mainNav');
            nav.classList.toggle('show');
        }
    </script>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo-section">
                <i class="fas fa-home"></i>
                <span class="logo-text">Du Lịch Trà Vinh</span>
            </a>

            <div class="nav-section">
                <nav class="main-nav" id="mainNav">
                    <a href="dia-diem-du-lich-dynamic.php" class="nav-link active">Địa Điểm</a>
                    <a href="am-thuc.php" class="nav-link">Ẩm Thực</a>
                    <a href="lien-he.php" class="nav-link">Liên Hệ</a>
                </nav>

                <div class="header-buttons">
                    <a href="dang-nhap.php" class="cta-button cta-login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="btn-text">Đăng Nhập</span>
                    </a>
                    <a href="quan-ly-users.php" class="cta-button cta-admin">
                        <i class="fas fa-users-cog"></i>
                        <span class="btn-text">Quản Lý</span>
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="Mở menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </header>
    
    <?php include 'includes/mobile-menu.php'; ?>

    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-header">
                <h1 class="hero-title">Khám Phá Trà Vinh</h1>
                <a href="test-add-attraction.php" class="btn-add-attraction">
                    <i class="fas fa-plus-circle"></i>
                    <span>Thêm Địa Điểm</span>
                </a>
            </div>
        <p class="hero-subtitle">
            Hành trình khám phá những di tích lịch sử, văn hóa Khmer độc đáo và thiên nhiên tuyệt đẹp của vùng đất
            Trà Vinh thân yêu
        </p>

        <!-- Search Bar -->
        <div class="search-container">
            <form method="GET" action="" class="search-form">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           name="search"
                           id="searchInput" 
                           class="search-input"
                           placeholder="Tìm kiếm địa điểm, chùa chiền, thiên nhiên..."
                           value="<?php echo htmlspecialchars($searchKeyword); ?>"
                           autocomplete="off">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                        <span>Tìm Kiếm</span>
                    </button>
                </div>
            </form>
            
            <?php if (!empty($searchKeyword)): ?>
            <div class="search-results-info">
                <i class="fas fa-info-circle"></i>
                Tìm thấy <strong><?php echo $totalAttractions; ?></strong> kết quả cho 
                "<strong><?php echo htmlspecialchars($searchKeyword); ?></strong>"
                <a href="dia-diem-du-lich-dynamic.php" class="clear-search-link">
                    <i class="fas fa-times"></i> Xóa tìm kiếm
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-tabs">
            <!-- Nút Tất Cả -->
            <button type="button"
                    data-category="all" 
                    class="filter-btn <?php echo ($category === 'all') ? 'active' : ''; ?>">
                <i class="fas fa-globe-asia"></i>
                Tất Cả
            </button>
            
            <!-- Các nút category từ database -->
            <?php foreach ($dbCategories as $cat): ?>
            <button type="button"
                    data-category="<?php echo htmlspecialchars($cat); ?>" 
                    class="filter-btn <?php echo ($category === $cat) ? 'active' : ''; ?>">
                <i class="fas <?php echo $categoryIcons[$cat] ?? 'fa-map-marker-alt'; ?>"></i>
                <?php echo htmlspecialchars($cat); ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Attractions Grid -->
    <main class="attraction-grid">
        <?php if (!empty($attractions)): ?>
            <?php foreach ($attractions as $attr): ?>
            <div class="attraction-card" 
                 data-name="<?php echo htmlspecialchars($attr['name']); ?>"
                 data-category="<?php echo htmlspecialchars($attr['category'] ?? ''); ?>">
                <div class="card-image">
                    <img src="<?php echo htmlspecialchars($attr['image_url'] ?? 'hinhanh/placeholder.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($attr['name']); ?>"
                         onerror="this.src='hinhanh/placeholder.jpg'">
                    <div class="card-badge">
                        <?php echo htmlspecialchars($attr['category'] ?? 'Địa điểm'); ?>
                    </div>
                </div>

                <div class="card-content">
                    <h3 class="card-title"><?php echo htmlspecialchars($attr['name']); ?></h3>
                    
                    <div class="card-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo htmlspecialchars($attr['location']); ?></span>
                    </div>

                    <p class="card-description">
                        <?php echo htmlspecialchars(substr($attr['description'] ?? '', 0, 150)) . '...'; ?>
                    </p>

                    <div class="card-info">
                        <div class="card-price">
                            <i class="fas fa-ticket-alt"></i>
                            <?php echo htmlspecialchars($attr['ticket_price'] ?? 'Miễn phí'); ?>
                        </div>

                        <div class="card-actions">
                            <a href="chi-tiet-dia-diem.php?id=<?php echo urlencode($attr['attraction_id']); ?>" 
                               class="btn btn-primary">
                                <i class="fas fa-eye"></i>
                                Chi Tiết
                            </a>
                            <a href="dat-tour.php?id=<?php echo urlencode($attr['attraction_id']); ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-calendar-alt"></i>
                                Đặt Tour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h3>Không tìm thấy địa điểm nào</h3>
                <p>Vui lòng thử lại với từ khóa khác</p>
                <a href="dia-diem-du-lich-dynamic.php" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> Du Lịch Trà Vinh. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <script src="js/datetime.js"></script>
    <script src="js/search-attractions.js"></script>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>
