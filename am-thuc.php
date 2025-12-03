<?php
/**
 * Trang Ẩm Thực - Hiển thị món ăn từ database
 */
session_start();

require_once 'config/database.php';
require_once 'models/Food.php';

// Kiểm tra quyền admin/manager
$isAdmin = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && 
           isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'manager']);

// Khởi tạo database và lấy dữ liệu
$foods = [];
$totalFoods = 0;
$error = null;

try {
    $database = new Database();
    $db = $database->getConnection();
    $food = new Food($db);
    
    // Lấy tất cả món ăn
    $stmt = $food->readAll();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $foods[] = $row;
    }
    
    $totalFoods = count($foods);
    
} catch (Exception $e) {
    $error = $e->getMessage();
    error_log("Error loading foods: " . $error);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ẩm Thực Trà Vinh - Đặc Sản Khmer (<?php echo $totalFoods; ?> món)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/attractions-style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/restaurant-finder.css">
    <link rel="stylesheet" href="css/attractions-redesign.css">
    <link rel="stylesheet" href="css/datetime.css">
    <link rel="stylesheet" href="css/admin-styles.css">
    <link rel="stylesheet" href="css/food-search.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/mobile-enhancements.css">
    <link rel="stylesheet" href="css/header-responsive-fix.css">

    <!-- Food Admin Styles -->
    <style>
        .food-admin-toggle-btn {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            color: white !important;
            border: none !important;
            padding: 12px !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            margin-left: 10px !important;
            transition: all 0.3s ease !important;
            display: inline-block !important;
            position: relative !important;
            z-index: 100 !important;
        }

        .food-admin-toggle-btn:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important;
            transform: scale(1.1) !important;
        }

        .food-admin-toggle-btn.active {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            animation: foodPulse 2s infinite !important;
        }

        @keyframes foodPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* Override admin toolbar for food theme */
        .food-admin-mode .admin-toolbar {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            border-bottom: 3px solid #f59e0b !important;
        }

        .food-admin-mode .admin-info i {
            color: #fbbf24 !important;
        }

        /* Food card admin mode */
        .food-admin-mode .food-card {
            border: 2px dashed #f59e0b !important;
            background: rgba(245, 158, 11, 0.05) !important;
        }

        .food-admin-mode .food-card::before {
            content: '🍽️ Chế độ chỉnh sửa món ăn' !important;
            position: absolute !important;
            top: -10px !important;
            left: 10px !important;
            background: #f59e0b !important;
            color: white !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 0.25rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            z-index: 10 !important;
        }

        /* Admin actions for food cards */
        .food-admin-actions-card {
            display: flex !important;
            gap: 0.5rem !important;
            margin-top: 0.75rem !important;
            padding-top: 0.75rem !important;
            border-top: 1px solid #e5e7eb !important;
            justify-content: center !important;
        }

        .food-admin-actions-card .btn {
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
        }

        /* DateTime color for food page */
        .header-datetime .text-orange-600 {
            color: #ea580c !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-red-50 min-h-screen">
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo-section">
                <i class="fas fa-home"></i>
                <span class="logo-text">Du Lịch Trà Vinh</span>
            </a>

            <div class="nav-section">
                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn" onclick="toggleMobileNav()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <nav class="main-nav" id="mainNav">
                    <a href="dia-diem-du-lich-dynamic.php" class="nav-link">Địa Điểm</a>
                    <a href="am-thuc.php" class="nav-link active">Ẩm Thực</a>
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
            </div>
        </div>
    </header>
    
    <style>
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        @media (min-width: 768px) {
            .mobile-menu-btn {
                display: none;
            }
        }
        
        /* Header Buttons */
        .header-buttons {
            display: flex;
            gap: 8px;
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
            
            .cta-button {
                padding: 10px 12px !important;
            }
        }
        
        /* Mobile Nav Show */
        .main-nav.show {
            display: flex !important;
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
    </style>
    
    <script>
        function toggleMobileNav() {
            const nav = document.getElementById('mainNav');
            nav.classList.toggle('show');
        }
    </script>

    <!-- Food Admin Toolbar (Hidden by default) -->
    <div id="foodAdminToolbar" class="admin-toolbar hidden">
        <div class="admin-toolbar-content">
            <div class="admin-info">
                <i class="fas fa-utensils"></i>
                <span>Chế độ quản lý ẩm thực đã bật</span>
            </div>
            <div class="admin-actions" style="display: flex; gap: 12px; flex-wrap: wrap;">
                <button onclick="showAddFoodModal()" class="btn btn-success" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 12px 24px; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4); transition: all 0.3s ease;">
                    <i class="fas fa-plus-circle"></i>
                    Thêm Món Ăn Mới
                </button>
                <a href="quan-ly-am-thuc.php" class="btn btn-primary" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 12px 24px; border: none; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); transition: all 0.3s ease;">
                    <i class="fas fa-cogs"></i>
                    Trang Quản Lý
                </a>
                <button onclick="exportFoods()" class="btn btn-secondary" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 12px 24px; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4); transition: all 0.3s ease;">
                    <i class="fas fa-download"></i>
                    Xuất Dữ Liệu
                </button>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-600/20 to-red-600/20"></div>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-gray-800 mb-6">
                    <span class="bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                        Ẩm Thực Trà Vinh
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-6 max-w-3xl mx-auto">
                    Khám phá <?php echo $totalFoods; ?> món ăn đặc trưng của đất Khmer với hương vị truyền thống độc đáo
                </p>
                
                <!-- Nút Thêm Món Ăn - Chỉ hiển thị cho Admin/Manager -->
                <?php if ($isAdmin): ?>
                <div style="margin-bottom: 2rem;">
                    <button onclick="showAddFoodModal()" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 14px 28px; border: none; border-radius: 50px; font-weight: 600; font-size: 1.1em; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4); transition: all 0.3s ease;">
                        <i class="fas fa-plus-circle"></i>
                        Thêm Món Ăn Mới
                    </button>
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-2xl mx-auto mb-4" role="alert">
                    <strong class="font-bold">Lỗi!</strong>
                    <span class="block sm:inline">Không thể tải dữ liệu món ăn: <?php echo htmlspecialchars($error); ?></span>
                </div>
                <?php endif; ?>

                <!-- Search Box -->
                <div class="search-container">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" 
                               id="searchInput" 
                               class="search-input" 
                               placeholder="Tìm kiếm món ăn... (VD: bún nước lèo, bánh xèo, chè khmer)"
                               autocomplete="off">
                        <button id="clearBtn" class="clear-btn" onclick="clearSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <p class="search-hint">
                        <i class="fas fa-lightbulb"></i>
                        Gợi ý: Thử tìm "bún", "bánh", "chè", "cá lóc", "khmer"...
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Food Categories -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="food-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php if (!empty($foods)): ?>
                <?php foreach ($foods as $foodItem): ?>
                    <?php
                    // Xác định màu badge theo category
                    $badgeColors = [
                        'mon-chinh' => 'from-orange-500 to-red-500',
                        'mon-an-vat' => 'from-purple-500 to-pink-500',
                        'banh-ngot' => 'from-yellow-500 to-orange-500',
                        'do-uong' => 'from-cyan-500 to-blue-500',
                        'trang-mieng' => 'from-green-500 to-teal-500'
                    ];
                    
                    $categoryNames = [
                        'mon-chinh' => 'Món Chính',
                        'mon-an-vat' => 'Món Ăn Vặt',
                        'banh-ngot' => 'Bánh Ngọt',
                        'do-uong' => 'Đồ Uống',
                        'trang-mieng' => 'Tráng Miệng'
                    ];
                    
                    $badgeColor = $badgeColors[$foodItem['category']] ?? 'from-gray-500 to-gray-600';
                    $categoryName = $categoryNames[$foodItem['category']] ?? 'Món Ăn';
                    ?>
                    
                    <div data-name="<?php echo htmlspecialchars($foodItem['name']); ?>"
                        data-food-id="<?php echo htmlspecialchars($foodItem['food_id']); ?>"
                        class="food-card bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500">
                        <div class="relative h-64 overflow-hidden">
                            <img src="<?php echo htmlspecialchars($foodItem['image_url'] ?? 'hinhanh/AmThuc/placeholder-food.jpg'); ?>"
                                alt="<?php echo htmlspecialchars($foodItem['name']); ?>"
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-700"
                                onerror="this.src='hinhanh/AmThuc/placeholder-food.jpg'">
                            <div class="absolute top-4 left-4">
                                <span class="bg-gradient-to-r <?php echo $badgeColor; ?> text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <?php echo $categoryName; ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">
                                <?php echo htmlspecialchars($foodItem['name']); ?>
                            </h3>
                            <?php if (!empty($foodItem['name_khmer'])): ?>
                                <p class="text-sm text-gray-500 italic mb-2">
                                    <?php echo htmlspecialchars($foodItem['name_khmer']); ?>
                                </p>
                            <?php endif; ?>
                            <p class="text-gray-600 mb-4">
                                <?php echo htmlspecialchars(substr($foodItem['description'] ?? '', 0, 120)) . '...'; ?>
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-orange-600 font-bold text-lg">
                                    <?php echo htmlspecialchars($foodItem['price_range'] ?? 'Liên hệ'); ?>
                                </span>
                                <button
                                    class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors"
                                    onclick="findRestaurants('<?php echo htmlspecialchars($foodItem['food_id']); ?>')">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Tìm Quán
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-utensils text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-600 mb-2">Chưa có món ăn nào</h3>
                    <p class="text-gray-500">Vui lòng kiểm tra lại kết nối database hoặc thêm dữ liệu món ăn.</p>
                </div>
            <?php endif; ?>

        </div>

        <!-- Food Categories Section -->
        <section class="mt-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Phân Loại Món Ăn</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Khám phá đa dạng ẩm thực Trà Vinh qua các danh mục món ăn đặc
                    trưng</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-gradient-to-br from-orange-100 to-red-100 p-6 rounded-xl text-center hover:shadow-lg transition-all duration-300">
                    <div class="text-4xl mb-4">🍜</div>
                    <h3 class="font-bold text-gray-800 mb-2">Món Bún - Phở</h3>
                    <p class="text-sm text-gray-600">Bún nước lèo, bún suông, phở Khmer</p>
                </div>

                <div
                    class="bg-gradient-to-br from-green-100 to-teal-100 p-6 rounded-xl text-center hover:shadow-lg transition-all duration-300">
                    <div class="text-4xl mb-4">🥞</div>
                    <h3 class="font-bold text-gray-800 mb-2">Bánh Đặc Sản</h3>
                    <p class="text-sm text-gray-600">Bánh xèo, bánh căn, bánh ít</p>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-100 to-pink-100 p-6 rounded-xl text-center hover:shadow-lg transition-all duration-300">
                    <div class="text-4xl mb-4">🍖</div>
                    <h3 class="font-bold text-gray-800 mb-2">Món Thịt</h3>
                    <p class="text-sm text-gray-600">Chù ụ rang me, thịt nướng Khmer</p>
                </div>

                <div
                    class="bg-gradient-to-br from-blue-100 to-indigo-100 p-6 rounded-xl text-center hover:shadow-lg transition-all duration-300">
                    <div class="text-4xl mb-4">🍰</div>
                    <h3 class="font-bold text-gray-800 mb-2">Chè - Tráng Miệng</h3>
                    <p class="text-sm text-gray-600">Chè Khmer, bánh flan, chè thái</p>
                </div>
            </div>
        </section>

        <!-- Popular Restaurants Section -->
        <section class="mt-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Quán Ăn Nổi Tiếng</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Những địa chỉ ẩm thực được yêu thích nhất tại Trà Vinh</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-utensils text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Quán Bún Nước Lèo Cô Ba</h3>
                            <p class="text-sm text-gray-600">Chợ Trà Vinh</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Quán bún nước lèo lâu đời nhất thành phố với hương vị đậm đà truyền
                        thống.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-sm text-gray-600">4.8/5</span>
                        </div>
                        <span class="text-orange-600 font-bold">25.000đ</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-leaf text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Bún Suông Chú Năm</h3>
                            <p class="text-sm text-gray-600">Đường Nguyễn Đáng</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Bún suông tươi ngon với nước dùng trong vắt và rau sống tươi mát.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-sm text-gray-600">4.6/5</span>
                        </div>
                        <span class="text-orange-600 font-bold">22.000đ</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-fire text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Chù Ụ Rang Me Bà Tư</h3>
                            <p class="text-sm text-gray-600">Chợ Cầu Quan</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Món ăn vặt độc đáo với hương vị chua ngọt đặc trưng của người Khmer.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-sm text-gray-600">4.2/5</span>
                        </div>
                        <span class="text-orange-600 font-bold">18.000đ</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Ẩm Thực Trà Vinh</h3>
                    <p class="text-gray-300">Khám phá hương vị đặc trưng của đất Khmer</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Liên Kết</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="index.php" class="hover:text-white transition-colors">Trang Chủ</a></li>
                        <li><a href="dia-diem-du-lich-dynamic.php" class="hover:text-white transition-colors">Địa Điểm</a></li>
                        <li><a href="am-thuc.php" class="hover:text-white transition-colors">Ẩm Thực</a></li>
                        <li><a href="lien-he.php" class="hover:text-white transition-colors">Liên Hệ</a></li>
                        <li><a href="dang-nhap.php" class="hover:text-white transition-colors">Đăng Nhập</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Liên Hệ</h4>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-phone mr-2"></i>0294.3855.246</p>
                        <p><i class="fas fa-envelope mr-2"></i>info@tvu.edu.vn</p>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Thông Tin Tác Giả</h4>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-user mr-2 text-blue-400"></i>Thạch Nhựt Minh</p>
                        <p><i class="fas fa-id-card mr-2 text-green-400"></i>MSSV: 110122115</p>
                        <p><i class="fas fa-graduation-cap mr-2 text-yellow-400"></i>Lớp: Da22TTB</p>
                        <p><i class="fas fa-university mr-2 text-purple-400"></i>Trường ĐH Trà Vinh</p>
                    </div>
                </div>
            </div>
            
            <!-- Copyright & Social Icons -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 mb-4">&copy; 2024 Du Lịch Trà Vinh. All rights reserved.</p>
                <div class="flex justify-center gap-4 mt-4">
                    <a href="https://www.facebook.com/travinh.tourism" target="_blank" rel="noopener noreferrer"
                        class="w-12 h-12 rounded-full bg-blue-600 hover:bg-blue-500 flex items-center justify-center text-white text-xl transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/50" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/travinh.tourism" target="_blank" rel="noopener noreferrer"
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 via-pink-500 to-orange-400 hover:from-purple-500 hover:via-pink-400 hover:to-orange-300 flex items-center justify-center text-white text-xl transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-pink-500/50" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/@travinhtourism" target="_blank" rel="noopener noreferrer"
                        class="w-12 h-12 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white text-xl transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-red-500/50" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Thêm Món Ăn Mới -->
    <div id="addFoodModal" class="food-modal-overlay" style="display: none;">
        <div class="food-modal-content">
            <div class="food-modal-header">
                <h3><i class="fas fa-utensils"></i> Thêm Món Ăn Mới</h3>
                <button type="button" class="food-modal-close" onclick="closeAddFoodModal()">&times;</button>
            </div>
            <form id="addFoodForm" onsubmit="submitAddFood(event)">
                <div class="food-form-grid">
                    <div class="food-form-group">
                        <label><i class="fas fa-hamburger"></i> Tên món ăn *</label>
                        <input type="text" name="name" id="foodName" required placeholder="VD: Bún nước lèo">
                    </div>
                    <div class="food-form-group">
                        <label><i class="fas fa-tags"></i> Danh mục *</label>
                        <select name="category" id="foodCategory" required>
                            <option value="">-- Chọn danh mục --</option>
                            <option value="Món chính">Món chính</option>
                            <option value="Món phụ">Món phụ</option>
                            <option value="Món tráng miệng">Món tráng miệng</option>
                            <option value="Đồ uống">Đồ uống</option>
                            <option value="Đặc sản">Đặc sản</option>
                        </select>
                    </div>
                    <div class="food-form-group">
                        <label><i class="fas fa-money-bill-wave"></i> Giá (VNĐ) *</label>
                        <input type="number" name="price" id="foodPrice" required placeholder="VD: 35000" min="0">
                    </div>
                    <div class="food-form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Địa điểm</label>
                        <input type="text" name="location" id="foodLocation" placeholder="VD: Chợ Trà Vinh">
                    </div>
                    <div class="food-form-group full-width">
                        <label><i class="fas fa-image"></i> URL Hình ảnh</label>
                        <input type="url" name="image_url" id="foodImage" placeholder="https://example.com/image.jpg">
                    </div>
                    <div class="food-form-group full-width">
                        <label><i class="fas fa-align-left"></i> Mô tả *</label>
                        <textarea name="description" id="foodDescription" required rows="4" placeholder="Mô tả chi tiết về món ăn..."></textarea>
                    </div>
                    <div class="food-form-group full-width">
                        <label><i class="fas fa-list"></i> Nguyên liệu (mỗi dòng 1 nguyên liệu)</label>
                        <textarea name="ingredients" id="foodIngredients" rows="3" placeholder="Bún&#10;Thịt heo&#10;Rau sống"></textarea>
                    </div>
                </div>
                <div class="food-form-actions">
                    <button type="button" class="btn-cancel" onclick="closeAddFoodModal()">
                        <i class="fas fa-times"></i> Hủy
                    </button>
                    <button type="submit" class="btn-submit" id="btnSubmitFood">
                        <i class="fas fa-save"></i> Lưu Món Ăn
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Modal Styles */
        .food-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
            padding: 20px;
        }
        .food-modal-content {
            background: white;
            border-radius: 20px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            animation: foodModalSlideIn 0.3s ease;
        }
        @keyframes foodModalSlideIn {
            from { opacity: 0; transform: translateY(-30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .food-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            border-bottom: 2px solid #f0f0f0;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 20px 20px 0 0;
        }
        .food-modal-header h3 {
            font-size: 1.4em;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }
        .food-modal-close {
            background: rgba(255,255,255,0.2);
            border: none;
            font-size: 1.5em;
            color: white;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .food-modal-close:hover {
            background: rgba(255,255,255,0.3);
            transform: rotate(90deg);
        }
        .food-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 30px;
        }
        .food-form-group {
            display: flex;
            flex-direction: column;
        }
        .food-form-group.full-width {
            grid-column: 1 / -1;
        }
        .food-form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .food-form-group label i {
            color: #f97316;
        }
        .food-form-group input,
        .food-form-group select,
        .food-form-group textarea {
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s;
        }
        .food-form-group input:focus,
        .food-form-group select:focus,
        .food-form-group textarea:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        .food-form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding: 20px 30px;
            border-top: 2px solid #f0f0f0;
            background: #f9fafb;
            border-radius: 0 0 20px 20px;
        }
        .btn-cancel {
            padding: 12px 25px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        .btn-cancel:hover {
            background: #4b5563;
        }
        .btn-submit {
            padding: 12px 25px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
        }
        @media (max-width: 600px) {
            .food-form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>

</html>
<!-- Scripts -->
<script src="js/cross-page-navigation.js"></script>
<script src="js/restaurant-finder.js"></script>
<script src="js/setup-restaurant-buttons.js"></script>
<script src="js/datetime.js"></script>
<script src="js/food-admin-controls.js"></script>

<!-- Debug Script for Food Admin -->
<script>
    console.log('🍽️ Food page debug script loaded');

    // Wait for DOM and check elements
    document.addEventListener('DOMContentLoaded', function () {
        console.log('🍽️ DOM loaded, checking food admin elements...');

        setTimeout(() => {
            const foodAdminToggle = document.getElementById('foodAdminToggle');
            const foodAdminToolbar = document.getElementById('foodAdminToolbar');

            console.log('🍽️ Food admin toggle element:', foodAdminToggle);
            console.log('🍽️ Food admin toolbar element:', foodAdminToolbar);

            if (foodAdminToggle) {
                console.log('✅ Food admin toggle found!');
                console.log('🍽️ Toggle classes:', foodAdminToggle.className);

                // Add manual click handler as backup
                foodAdminToggle.addEventListener('click', function () {
                    console.log('🍽️ Food admin toggle clicked via event listener!');
                    if (typeof toggleFoodAdminMode === 'function') {
                        toggleFoodAdminMode();
                    } else {
                        console.error('❌ toggleFoodAdminMode function not found');
                    }
                });
            } else {
                console.error('❌ Food admin toggle not found!');
            }

            if (foodAdminToolbar) {
                console.log('✅ Food admin toolbar found!');
            } else {
                console.error('❌ Food admin toolbar not found!');
            }

            // Check if functions are available
            console.log('🍽️ Checking functions...');
            console.log('toggleFoodAdminMode:', typeof toggleFoodAdminMode);
            console.log('foodAdminControls:', typeof foodAdminControls);

        }, 2000);
    });
</script>

<script>
    // Initialize food page specific functionality
    document.addEventListener('DOMContentLoaded', function () {
        // Add hover effects to food cards
        const foodCards = document.querySelectorAll('.food-card');
        foodCards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Setup restaurant finder buttons
        setupRestaurantButtons();
    });

    // Setup restaurant finder buttons - Cách mới chính xác hơn
    function setupRestaurantButtons() {
        console.log('🔧 Setting up restaurant finder buttons...');

        // Tìm tất cả food cards và setup nút tìm quán cho từng card
        const foodCards = document.querySelectorAll('.food-card');

        foodCards.forEach((card, index) => {
            const button = card.querySelector('button');
            const titleElement = card.querySelector('h3');

            if (button && titleElement) {
                const title = titleElement.textContent.trim();
                let foodType = '';

                // Map tên món ăn với food type
                switch (title) {
                    case 'Bún Nước Lèo':
                        foodType = 'bun-nuoc-leo';
                        break;
                    case 'Bánh Canh Bến Có':
                        foodType = 'banh-canh-ben-co';
                        break;
                    case 'Chù Ụ Rang Me':
                        foodType = 'chu-u-rang-me';
                        break;
                    case 'Bún Suông':
                        foodType = 'bun-suong';
                        break;
                    case 'Bánh Xèo Khmer':
                        foodType = 'banh-xeo-khmer';
                        break;
                    case 'Nom Banh Chok':
                        foodType = 'nom-banh-chok';
                        break;
                    case 'Bánh Ít Lá Gai':
                        foodType = 'banh-it';
                        break;
                    case 'Bánh Căn':
                        foodType = 'banh-can';
                        break;
                    case 'Chè Khmer':
                        foodType = 'che-khmer';
                        break;
                    case 'Cơm Tấm Sườn Nướng':
                        foodType = 'com-tam';
                        break;
                    case 'Cá Lóc Nướng Trui':
                        foodType = 'ca-loc-nuong-trui';
                        break;
                    case 'Lẩu Mắm':
                        foodType = 'lau-mam';
                        break;
                    default:
                        console.warn('Unknown food type:', title);
                        return;
                }

                // Gán sự kiện click
                button.onclick = function (e) {
                    e.preventDefault();
                    console.log('🍽️ Opening restaurant finder for:', foodType);
                    findRestaurants(foodType);
                };

                console.log(`✅ Setup button for: ${title} -> ${foodType}`);
            }
        });

        console.log(`🎯 Setup completed for ${foodCards.length} food cards`);
    }
    });
</script>
    <!-- S
earch Foods Script -->
    <script src="js/search-foods.js"></script>

    <!-- Additional Search Styles -->
    <style>
        #searchResults {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .search-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .clear-search-btn {
            background: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
        }

        .clear-search-btn:hover {
            background: #dc2626;
            transform: scale(1.05);
        }

        .no-results,
        .error-message {
            background: white;
            border-radius: 1rem;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Highlight search keyword */
        .highlight {
            background-color: #fef3c7;
            padding: 0 0.25rem;
            border-radius: 0.25rem;
        }
    </style>

    <script>
        // ========== MODAL THÊM MÓN ĂN ==========
        function showAddFoodModal() {
            document.getElementById('addFoodModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeAddFoodModal() {
            document.getElementById('addFoodModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            document.getElementById('addFoodForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('addFoodModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddFoodModal();
            }
        });

        // Submit form
        async function submitAddFood(event) {
            event.preventDefault();
            
            const btn = document.getElementById('btnSubmitFood');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
            
            const formData = {
                name: document.getElementById('foodName').value,
                category: document.getElementById('foodCategory').value,
                price: document.getElementById('foodPrice').value,
                location: document.getElementById('foodLocation').value,
                image_url: document.getElementById('foodImage').value,
                description: document.getElementById('foodDescription').value,
                ingredients: document.getElementById('foodIngredients').value
            };
            
            try {
                const response = await fetch('api/foods.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'create',
                        ...formData
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('✅ ' + result.message);
                    closeAddFoodModal();
                    location.reload();
                } else {
                    alert('❌ ' + result.message);
                }
            } catch (error) {
                alert('❌ Có lỗi xảy ra: ' + error.message);
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Lưu Món Ăn';
            }
        }

        // Export foods function
        function exportFoods() {
            window.open('api/foods.php?action=export', '_blank');
        }
    </script>
</body>
</html>
