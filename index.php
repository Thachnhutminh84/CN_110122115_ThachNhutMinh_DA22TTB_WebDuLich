<?php
/**
 * Trang chủ Du Lịch Trà Vinh - PHP Version
 * Chuyển đổi từ HTML sang PHP để tích hợp database và tính năng động
 */

// Bắt đầu session (không bắt buộc đăng nhập)
session_start();

// Kiểm tra thông báo đăng xuất
$logoutSuccess = isset($_GET['logout']) && $_GET['logout'] === 'success';

// Include các file cần thiết
require_once 'config/database.php';
require_once 'models/Attraction.php';

// Khởi tạo database và models
try {
    $database = new Database();
    $db = $database->getConnection();
    $attraction = new Attraction($db);
    
    // Lấy 3 địa điểm nổi bật nhất
    $featuredAttractions = $attraction->getPopularAttractions(3);
    $attractions = [];
    while ($row = $featuredAttractions->fetch(PDO::FETCH_ASSOC)) {
        $attractions[] = $row;
    }
    
    // Lấy thống kê tổng quan
    $totalAttractions = $attraction->readAll();
    $attractionCount = $totalAttractions->rowCount();
    
} catch (Exception $e) {
    // Nếu có lỗi database, sử dụng dữ liệu mặc định
    $attractions = [
        [
            'attraction_id' => 'aobaom',
            'name' => 'Ao Bà Om',
            'description' => 'Thắng cảnh quốc gia với truyền thuyết về cuộc thi đắp đập của phụ nữ Khmer và hơn 500 cây dầu cổ thụ kỳ dị.',
            'category' => 'Di Tích Quốc Gia',
            'image_url' => 'hinhanh/DulichtpTV/aobaom-02-1024x686.jpg'
        ],
        [
            'attraction_id' => 'chuaang',
            'name' => 'Chùa Âng',
            'description' => 'Ngôi chùa Khmer cổ kính nhất với niên đại hơn 1000 năm, kiến trúc Angkor độc đáo và nghệ thuật điêu khắc tinh xảo.',
            'category' => 'Chùa Khmer Cổ',
            'image_url' => 'hinhanh/DulichtpTV/maxresdefault.jpg'
        ],
        [
            'attraction_id' => 'bienbadong',
            'name' => 'Biển Ba Động',
            'description' => 'Bãi biển hoang sơ với cát trắng và nước trong xanh, là điểm đến lý tưởng cho du lịch nghỉ dưỡng.',
            'category' => 'Biển Đẹp',
            'image_url' => 'hinhanh/DulichtpTV/Kham-pha-Khu-du-lich-Bien-Ba-Dong-Tra-Vinh-2022.jpg.webp'
        ]
    ];
    $attractionCount = 15; // Số mặc định
}

// Lấy thời gian hiện tại
$currentDateTime = date('l, d/m/Y - H:i', time());
$currentYear = date('Y');

// Thống kê website (có thể lấy từ database sau)
$stats = [
    'temples' => '140+',
    'visitors' => '3.5M',
    'heritage_sites' => '50+',
    'ethnic_groups' => '3'
];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Du Lịch Tỉnh Trà Vinh - Khám Phá Vẻ Đẹp Đất Khmer</title>
    <meta name="description" content="Khám phá vẻ đẹp văn hóa Khmer và thiên nhiên tuyệt vời của Trà Vinh. Hơn <?php echo $attractionCount; ?> địa điểm du lịch hấp dẫn đang chờ bạn.">
    <meta name="keywords" content="du lịch Trà Vinh, Khmer, chùa Âng, Ao Bà Om, ẩm thực Khmer">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/datetime.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/mobile-enhancements.css">
    <link rel="stylesheet" href="css/header-responsive-fix.css">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Du Lịch Tỉnh Trà Vinh - Khám Phá Vẻ Đẹp Đất Khmer">
    <meta property="og:description" content="Khám phá vẻ đẹp văn hóa Khmer và thiên nhiên tuyệt vời của Trà Vinh">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
</head>

<body class="bg-gray-100">
    <!-- Thông báo đăng xuất thành công -->
    <?php if ($logoutSuccess): ?>
    <div id="logoutNotification" class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 animate-slide-in">
        <i class="fas fa-check-circle text-2xl"></i>
        <div>
            <p class="font-bold">Đăng xuất thành công!</p>
            <p class="text-sm">Hẹn gặp lại bạn</p>
        </div>
        <button onclick="closeNotification()" class="ml-4 hover:bg-green-600 rounded-full p-1">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <script>
        // Tự động ẩn sau 5 giây
        setTimeout(() => {
            const notification = document.getElementById('logoutNotification');
            if (notification) {
                notification.style.animation = 'slide-out 0.5s ease-out';
                setTimeout(() => notification.remove(), 500);
            }
        }, 5000);
        
        function closeNotification() {
            const notification = document.getElementById('logoutNotification');
            notification.style.animation = 'slide-out 0.5s ease-out';
            setTimeout(() => notification.remove(), 500);
        }
    </script>
    <style>
        @keyframes slide-in {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slide-out {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        .animate-slide-in {
            animation: slide-in 0.5s ease-out;
        }
    </style>
    <?php endif; ?>
    
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 transition-all duration-300 hover:shadow-xl">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo Section -->
                <div class="flex items-center space-x-3">
                    <a href="index.php" class="flex items-center space-x-3">
                        <img src="hinhanh/logo.jpg" alt="Logo Trà Vinh"
                            class="h-12 md:h-16 w-auto object-contain hover:scale-105 transition-transform duration-300">
                        <div class="hidden sm:block">
                            <h1 class="text-lg md:text-2xl font-bold text-red-600 hover:text-red-700 transition-colors">
                                TRƯỜNG ĐẠI HỌC TRÀ VINH
                            </h1>
                            <p class="text-gray-600 text-xs md:text-sm mt-1" id="headerDateTime">
                                <i class="far fa-clock mr-2"></i>
                                <span id="currentDateTime"><?php echo $currentDateTime; ?></span>
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Desktop: Welcome Message / User Info -->
                <div class="hidden md:block">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <!-- User Logged In -->
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-3 rounded-xl shadow-md">
                                <p class="text-sm text-gray-600">Xin chào,</p>
                                <p class="text-lg font-bold text-blue-700">
                                    <i class="fas fa-user-circle mr-2"></i>
                                    <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                                        <?php 
                                        $roleNames = ['admin' => 'Quản trị viên', 'manager' => 'Quản lý', 'user' => 'Người dùng'];
                                        echo $roleNames[$_SESSION['role']] ?? $_SESSION['role']; 
                                        ?>
                                    </span>
                                </p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
                                <a href="quan-ly-users.php" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-md hover:shadow-lg">
                                    <i class="fas fa-users-cog mr-2"></i>Quản Lý
                                </a>
                                <?php endif; ?>
                                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-md hover:shadow-lg">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Đăng Xuất
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Not Logged In -->
                        <p class="text-lg font-semibold text-green-700 italic animate-pulse bg-green-50 px-4 py-2 rounded-xl shadow-sm">
                            🌴 Chào mừng Đến Với Du Lịch Của Tỉnh Trà Vinh 🌴
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Mobile: Hamburger Button -->
                <button class="hamburger-btn md:hidden" id="hamburgerBtn" aria-label="Mở menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
    
    <!-- Mobile Menu Container -->
    <div class="mobile-menu-container" id="mobileMenuContainer">
        <div class="mobile-menu-header">
            <div class="mobile-menu-logo">
                <img src="hinhanh/logo.jpg" alt="Logo" style="height: 40px; border-radius: 8px;">
                <span>Du Lịch Trà Vinh</span>
            </div>
            <button class="mobile-menu-close" aria-label="Đóng menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="mobile-menu-links">
            <a href="index.php" class="mobile-menu-link active">
                <i class="fas fa-home"></i>
                <span>Trang Chủ</span>
            </a>
            <a href="dia-diem-du-lich-dynamic.php" class="mobile-menu-link">
                <i class="fas fa-map-marker-alt"></i>
                <span>Địa Điểm Du Lịch</span>
            </a>
            <a href="am-thuc.php" class="mobile-menu-link">
                <i class="fas fa-utensils"></i>
                <span>Ẩm Thực</span>
            </a>
            <a href="lien-he.php" class="mobile-menu-link">
                <i class="fas fa-envelope"></i>
                <span>Liên Hệ</span>
            </a>
            
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager')): ?>
            <div class="mobile-menu-divider"></div>
            <div class="mobile-menu-section-title">Quản Lý</div>
            <a href="quan-ly-users.php" class="mobile-menu-link">
                <i class="fas fa-users-cog"></i>
                <span>Quản Lý Tài Khoản</span>
            </a>
            <a href="quan-ly-booking.php" class="mobile-menu-link">
                <i class="fas fa-calendar-check"></i>
                <span>Quản Lý Booking</span>
            </a>
            <?php endif; ?>
        </div>
        
        <div class="mobile-menu-user">
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <div class="mobile-menu-user-info">
                <div class="mobile-menu-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="mobile-menu-user-details">
                    <div class="mobile-menu-user-name"><?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
                    <div class="mobile-menu-user-role">
                        <?php 
                        $roleNames = ['admin' => 'Quản trị viên', 'manager' => 'Quản lý', 'user' => 'Người dùng'];
                        echo $roleNames[$_SESSION['role']] ?? $_SESSION['role']; 
                        ?>
                    </div>
                </div>
            </div>
            <a href="logout.php" class="mobile-menu-logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Đăng Xuất</span>
            </a>
            <?php else: ?>
            <a href="dang-nhap.php" class="mobile-menu-logout" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                <i class="fas fa-sign-in-alt"></i>
                <span>Đăng Nhập</span>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Navigation Menu Bar -->
    <nav class="bg-gradient-to-r from-blue-600 to-green-600 shadow-md sticky top-[60px] md:top-[88px] z-40">
        <div class="container mx-auto px-2 md:px-4">
            <div class="flex items-center justify-center overflow-x-auto">
                <ul class="flex items-center gap-1 py-2 md:py-3">
                    <!-- Địa Điểm Du Lịch -->
                    <li>
                        <a href="dia-diem-du-lich-dynamic.php" 
                           class="flex items-center gap-1 md:gap-2 px-3 md:px-6 py-2 md:py-3 text-white font-semibold hover:bg-white/20 rounded-lg transition-all duration-300 text-sm md:text-base whitespace-nowrap">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Địa Điểm</span>
                        </a>
                    </li>

                    <!-- Ẩm Thực -->
                    <li>
                        <a href="am-thuc.php" 
                           class="flex items-center gap-1 md:gap-2 px-3 md:px-6 py-2 md:py-3 text-white font-semibold hover:bg-white/20 rounded-lg transition-all duration-300 text-sm md:text-base whitespace-nowrap">
                            <i class="fas fa-utensils"></i>
                            <span>Ẩm Thực</span>
                        </a>
                    </li>

                    <!-- Liên Hệ -->
                    <li>
                        <a href="lien-he.php" 
                           class="flex items-center gap-1 md:gap-2 px-3 md:px-6 py-2 md:py-3 text-white font-semibold hover:bg-white/20 rounded-lg transition-all duration-300 text-sm md:text-base whitespace-nowrap">
                            <i class="fas fa-envelope"></i>
                            <span>Liên Hệ</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Navigation Hero -->
    <div class="main-content-wrapper">
        <nav class="relative w-full min-h-[400px] md:h-[600px] overflow-hidden shadow-lg">
            <!-- Background Images with Animation -->
            <div class="absolute inset-0 bg-cover bg-center bg1"
                style="background-image: url('hinhanh/bieu-trung-13-tinh-mien-tay.jpg');">
            </div>
            <div class="absolute inset-0 bg-cover bg-center bg2"
                style="background-image: url('hinhanh/nhung-mon-an-ngon-dac-san-tra-vinh-nhat-dinh-phai-thu (1).jpg');">
            </div>
            <div class="absolute inset-0 bg-cover bg-center bg3"
                style="background-image: url('hinhanh/kham-pha-8-dia-diem-du-lich-tra-vinh-doc-dao-an-tuong(1).jpg');">
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>

            <!-- Navigation Content -->
            <div class="absolute inset-0 flex items-center justify-center py-8">
                <div class="text-center text-white max-w-6xl mx-auto px-4">
                    <!-- Main Title -->
                    <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-8xl font-bold mb-4 md:mb-8 animate-fade-in">
                        <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                            Du Lịch Trà Vinh
                        </span>
                    </h1>

                    <p class="text-base sm:text-lg md:text-2xl lg:text-3xl mb-6 md:mb-12 animate-fade-in-delay opacity-90 px-2">
                        Khám phá vẻ đẹp văn hóa Khmer và thiên nhiên tuyệt vời
                    </p>

                    <!-- Navigation Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mt-6 md:mt-12 px-2">

                        <!-- Địa Điểm Du Lịch -->
                        <a href="dia-diem-du-lich-dynamic.php" class="nav-card group">
                            <div class="bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl p-4 md:p-8 hover:bg-white/20 transition-all duration-500 transform hover:scale-105 shadow-xl">
                                <div class="text-3xl md:text-6xl mb-2 md:mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-map-marker-alt text-blue-400"></i>
                                </div>
                                <h3 class="text-sm md:text-2xl font-bold mb-1 md:mb-3">Địa Điểm</h3>
                                <p class="text-xs md:text-lg opacity-90 mb-2 md:mb-4 hidden md:block">Khám phá <?php echo $attractionCount; ?> di tích lịch sử</p>
                                <div class="flex items-center justify-center text-yellow-400 text-xs md:text-base">
                                    <span class="mr-1 md:mr-2">Xem</span>
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Ẩm Thực -->
                        <a href="am-thuc.php" class="nav-card group">
                            <div class="bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl p-4 md:p-8 hover:bg-white/20 transition-all duration-500 transform hover:scale-105 shadow-xl">
                                <div class="text-3xl md:text-6xl mb-2 md:mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-utensils text-orange-400"></i>
                                </div>
                                <h3 class="text-sm md:text-2xl font-bold mb-1 md:mb-3">Ẩm Thực</h3>
                                <p class="text-xs md:text-lg opacity-90 mb-2 md:mb-4 hidden md:block">Đặc sản Khmer độc đáo</p>
                                <div class="flex items-center justify-center text-yellow-400 text-xs md:text-base">
                                    <span class="mr-1 md:mr-2">Xem</span>
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Liên Hệ -->
                        <a href="lien-he.php" class="nav-card group">
                            <div class="bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl p-4 md:p-8 hover:bg-white/20 transition-all duration-500 transform hover:scale-105 shadow-xl">
                                <div class="text-3xl md:text-6xl mb-2 md:mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-envelope text-green-400"></i>
                                </div>
                                <h3 class="text-sm md:text-2xl font-bold mb-1 md:mb-3">Liên Hệ</h3>
                                <p class="text-xs md:text-lg opacity-90 mb-2 md:mb-4 hidden md:block">Tư vấn và hỗ trợ</p>
                                <div class="flex items-center justify-center text-yellow-400 text-xs md:text-base">
                                    <span class="mr-1 md:mr-2">Xem</span>
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>

                        <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
                        <!-- Đăng Nhập (chỉ hiện khi chưa đăng nhập) -->
                        <a href="dang-nhap.php" class="nav-card group">
                            <div class="bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl p-4 md:p-8 hover:bg-white/20 transition-all duration-500 transform hover:scale-105 shadow-xl">
                                <div class="text-3xl md:text-6xl mb-2 md:mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-sign-in-alt text-yellow-400"></i>
                                </div>
                                <h3 class="text-sm md:text-2xl font-bold mb-1 md:mb-3">Đăng Nhập</h3>
                                <p class="text-xs md:text-lg opacity-90 mb-2 md:mb-4 hidden md:block">Truy cập tài khoản</p>
                                <div class="flex items-center justify-center text-yellow-400 text-xs md:text-base">
                                    <span class="mr-1 md:mr-2">Vào</span>
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager')): ?>
                        <!-- Quản Lý Tài Khoản (chỉ hiện cho admin/manager) -->
                        <a href="quan-ly-users.php" class="nav-card group">
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 hover:bg-white/20 transition-all duration-500 transform hover:scale-105 hover:-translate-y-2 shadow-2xl">
                                <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-users-cog text-purple-400"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-3">Quản Lý Tài Khoản</h3>
                                <p class="text-lg opacity-90 mb-4">Quản lý users và phân quyền</p>
                                <div class="flex items-center justify-center text-yellow-400 group-hover:text-yellow-300">
                                    <span class="mr-2">Quản lý</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Quản Lý Booking -->
                        <a href="quan-ly-booking.php" class="nav-card group">
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 hover:bg-white/20 transition-all duration-500 transform hover:scale-105 hover:-translate-y-2 shadow-2xl">
                                <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-calendar-check text-green-400"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-3">Quản Lý Booking</h3>
                                <p class="text-lg opacity-90 mb-4">Quản lý đặt tour và lịch trình</p>
                                <div class="flex items-center justify-center text-yellow-400 group-hover:text-yellow-300">
                                    <span class="mr-2">Quản lý</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Quản Lý Dịch Vụ -->
                        <a href="quan-ly-dich-vu.php" class="nav-card group">
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 hover:bg-white/20 transition-all duration-500 transform hover:scale-105 hover:-translate-y-2 shadow-2xl">
                                <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-concierge-bell text-purple-400"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-3">Quản Lý Dịch Vụ</h3>
                                <p class="text-lg opacity-90 mb-4">Quản lý đặt dịch vụ du lịch</p>
                                <div class="flex items-center justify-center text-yellow-400 group-hover:text-yellow-300">
                                    <span class="mr-2">Quản lý</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Quản Lý Liên Hệ -->
                        <a href="quan-ly-lien-he.php" class="nav-card group">
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 hover:bg-white/20 transition-all duration-500 transform hover:scale-105 hover:-translate-y-2 shadow-2xl">
                                <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-envelope-open-text text-pink-400"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-3">Quản Lý Liên Hệ</h3>
                                <p class="text-lg opacity-90 mb-4">Quản lý tin nhắn và phản hồi</p>
                                <div class="flex items-center justify-center text-yellow-400 group-hover:text-yellow-300">
                                    <span class="mr-2">Quản lý</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 mt-8 md:mt-16 animate-fade-in-delay-2 px-2">
                        <div class="text-center bg-white/10 rounded-lg p-3 md:p-4">
                            <div class="text-xl md:text-4xl font-bold text-yellow-400 mb-1 md:mb-2"><?php echo $stats['temples']; ?></div>
                            <div class="text-xs md:text-lg opacity-90">Chùa Khmer</div>
                        </div>
                        <div class="text-center bg-white/10 rounded-lg p-3 md:p-4">
                            <div class="text-xl md:text-4xl font-bold text-yellow-400 mb-1 md:mb-2"><?php echo $stats['visitors']; ?></div>
                            <div class="text-xs md:text-lg opacity-90">Lượt Khách/Năm</div>
                        </div>
                        <div class="text-center bg-white/10 rounded-lg p-3 md:p-4">
                            <div class="text-xl md:text-4xl font-bold text-yellow-400 mb-1 md:mb-2"><?php echo $stats['heritage_sites']; ?></div>
                            <div class="text-xs md:text-lg opacity-90">Di Tích Lịch Sử</div>
                        </div>
                        <div class="text-center bg-white/10 rounded-lg p-3 md:p-4">
                            <div class="text-xl md:text-4xl font-bold text-yellow-400 mb-1 md:mb-2"><?php echo $stats['ethnic_groups']; ?></div>
                            <div class="text-xs md:text-lg opacity-90">Dân Tộc</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <div class="w-6 h-10 border-2 border-white rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-white rounded-full mt-2 animate-pulse"></div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Featured Attractions Section -->
    <section class="py-10 md:py-20 bg-gradient-to-br from-blue-50 to-green-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-8 md:mb-16">
                <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-2 md:mb-4">Điểm Đến Nổi Bật</h2>
                <p class="text-sm md:text-xl text-gray-600 max-w-3xl mx-auto">
                    Khám phá những địa điểm du lịch đặc sắc nhất của Trà Vinh
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
                <?php foreach ($attractions as $index => $attraction): ?>
                <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group">
                    <div class="relative h-48 md:h-64 overflow-hidden">
                        <img src="<?php echo htmlspecialchars($attraction['image_url'] ?? 'hinhanh/placeholder.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($attraction['name']); ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             onerror="this.src='hinhanh/placeholder.jpg'">
                        <div class="absolute top-3 left-3 md:top-4 md:left-4">
                            <span class="bg-<?php echo $index === 0 ? 'red' : ($index === 1 ? 'orange' : 'green'); ?>-500 text-white px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-semibold">
                                <?php echo htmlspecialchars($attraction['category'] ?? 'Địa điểm du lịch'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="p-4 md:p-6">
                        <h3 class="text-lg md:text-2xl font-bold text-gray-800 mb-2 md:mb-3">
                            <?php echo htmlspecialchars($attraction['name']); ?>
                        </h3>
                        <p class="text-sm md:text-base text-gray-600 mb-3 md:mb-4 line-clamp-2">
                            <?php echo htmlspecialchars(substr($attraction['description'] ?? '', 0, 100)) . '...'; ?>
                        </p>
                        <a href="chi-tiet-dia-diem.php?id=<?php echo urlencode($attraction['attraction_id']); ?>"
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold text-sm md:text-base">
                            Xem chi tiết <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-12">
                <a href="dia-diem-du-lich-dynamic.php"
                   class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-8 py-4 rounded-full font-semibold text-lg hover:from-blue-700 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-compass mr-2"></i>Khám Phá Tất Cả Địa Điểm
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Navigation Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Dịch Vụ Du Lịch</h2>
                <p class="text-xl text-gray-600">Chúng tôi cung cấp đầy đủ các dịch vụ cho chuyến du lịch của bạn</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Lập Kế Hoạch Tour -->
                <div class="text-center group cursor-pointer service-card" onclick="openServiceModal('tour-planning')">
                    <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-all duration-300 group-hover:scale-110">
                        <i class="fas fa-route text-3xl text-blue-600 group-hover:animate-pulse"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Lập Kế Hoạch Tour</h3>
                    <p class="text-gray-600 group-hover:text-gray-700">Tư vấn và thiết kế hành trình phù hợp với nhu cầu</p>
                    <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="text-blue-600 font-semibold">Nhấp để xem chi tiết →</span>
                    </div>
                </div>

                <!-- Đặt Phòng Khách Sạn -->
                <div class="text-center group cursor-pointer service-card" onclick="openServiceModal('hotel-booking')">
                    <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-all duration-300 group-hover:scale-110">
                        <i class="fas fa-hotel text-3xl text-green-600 group-hover:animate-pulse"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">Đặt Phòng Khách Sạn</h3>
                    <p class="text-gray-600 group-hover:text-gray-700">Hỗ trợ đặt phòng tại các khách sạn uy tín</p>
                    <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="text-green-600 font-semibold">Nhấp để xem chi tiết →</span>
                    </div>
                </div>

                <!-- Thuê Xe Du Lịch -->
                <div class="text-center group cursor-pointer service-card" onclick="openServiceModal('car-rental')">
                    <div class="bg-orange-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-200 transition-all duration-300 group-hover:scale-110">
                        <i class="fas fa-car text-3xl text-orange-600 group-hover:animate-pulse"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-orange-600 transition-colors">Thuê Xe Du Lịch</h3>
                    <p class="text-gray-600 group-hover:text-gray-700">Dịch vụ thuê xe với tài xế kinh nghiệm</p>
                    <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="text-orange-600 font-semibold">Nhấp để xem chi tiết →</span>
                    </div>
                </div>

                <!-- Hỗ Trợ 24/7 -->
                <div class="text-center group cursor-pointer service-card" onclick="openServiceModal('support')">
                    <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-all duration-300 group-hover:scale-110">
                        <i class="fas fa-headset text-3xl text-purple-600 group-hover:animate-pulse"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">Hỗ Trợ 24/7</h3>
                    <p class="text-gray-600 group-hover:text-gray-700">Đội ngũ hỗ trợ khách hàng luôn sẵn sàng</p>
                    <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="text-purple-600 font-semibold">Nhấp để xem chi tiết →</span>
                    </div>
                </div>
            </div>

            <!-- Service Details Modal Container -->
            <div id="serviceModalContainer" class="hidden"></div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Du Lịch Trà Vinh</h3>
                    <p class="text-gray-300 mb-4">Khám phá vẻ đẹp văn hóa Khmer và thiên nhiên tuyệt vời của Trà Vinh.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-2xl hover:text-blue-400 transition-colors"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-pink-400 transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-2xl hover:text-red-400 transition-colors"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Liên Kết Nhanh</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="index.php" class="hover:text-white transition-colors">Trang Chủ</a></li>
                        <li><a href="dia-diem-du-lich-dynamic.php" class="hover:text-white transition-colors">Địa Điểm Du Lịch</a></li>
                        <li><a href="am-thuc.php" class="hover:text-white transition-colors">Ẩm Thực</a></li>
                        <li><a href="lien-he.php" class="hover:text-white transition-colors">Liên Hệ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Liên Hệ</h4>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Trường ĐH Trà Vinh</p>
                        <p><i class="fas fa-phone mr-2"></i>0294.3855.246</p>
                        <p><i class="fas fa-envelope mr-2"></i>info@tvu.edu.vn</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Kết Nối Với Chúng Tôi</h4>
                    <div class="flex gap-4">
                        <a href="https://www.facebook.com/travinh.tourism" 
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:-translate-y-1"
                           title="Facebook">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="https://www.instagram.com/travinh.tourism" 
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-12 h-12 bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 hover:from-purple-700 hover:via-pink-700 hover:to-orange-600 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:-translate-y-1"
                           title="Instagram">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="https://www.youtube.com/@travinhtravel" 
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-12 h-12 bg-red-600 hover:bg-red-700 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:-translate-y-1"
                           title="YouTube">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                    <div class="mt-4 space-y-2 text-gray-300 text-sm">
                        <p>Thứ 2 - Thứ 6: 7:30 - 17:00</p>
                        <p>Thứ 7: 7:30 - 11:30</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; <?php echo $currentYear; ?> Du Lịch Trà Vinh. Tất cả quyền được bảo lưu.</p>
                <div class="flex justify-center gap-6 mt-4">
                    <a href="https://www.facebook.com/travinh.tourism" target="_blank" class="hover:text-blue-400 transition-colors">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                    <a href="https://www.instagram.com/travinh.tourism" target="_blank" class="hover:text-pink-400 transition-colors">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="https://www.youtube.com/@travinhtravel" target="_blank" class="hover:text-red-400 transition-colors">
                        <i class="fab fa-youtube text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="js/cross-page-navigation.js"></script>
    <script src="js/main.js"></script>
    <script src="js/datetime.js"></script>
    <script src="js/index-effects.js"></script>
    <script src="js/service-modal.js"></script>
    <script src="js/booking-system-php.js"></script>
    
    <script>
        // Update current date time
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            const dateTimeString = now.toLocaleDateString('vi-VN', options);
            const dateTimeElement = document.getElementById('currentDateTime');
            if (dateTimeElement) {
                dateTimeElement.textContent = dateTimeString;
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            updateDateTime();
            setInterval(updateDateTime, 60000); // Update every minute
            
            // Initialize booking system
            if (typeof tourBookingPHP !== 'undefined') {
                console.log('✅ Tour booking system loaded');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>

</html>