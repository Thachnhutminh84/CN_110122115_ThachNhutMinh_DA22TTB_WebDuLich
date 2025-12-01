<?php
/**
 * Trang Ẩm Thực - PHP Dynamic Version
 * Lấy dữ liệu từ database
 */

session_start();

require_once 'config/database.php';
require_once 'models/Food.php';

// Khởi tạo database
try {
    $database = new Database();
    $db = $database->getConnection();
    $food = new Food($db);
    
    // Lấy tham số từ URL
    $category = isset($_GET['category']) ? $_GET['category'] : 'all';
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    
    // Lấy danh sách món ăn
    $foods = [];
    if (!empty($searchKeyword)) {
        $stmt = $food->search($searchKeyword);
    } elseif ($category !== 'all') {
        $stmt = $food->getByCategory($category);
    } else {
        $stmt = $food->readAll();
    }
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $foods[] = $row;
    }
    
    // Lấy danh sách categories
    $categoriesStmt = $food->getCategories();
    $categories = [];
    while ($row = $categoriesStmt->fetch(PDO::FETCH_ASSOC)) {
        $categories[] = $row['category'];
    }
    
    $totalFoods = count($foods);
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $foods = [];
}

// Category names
$categoryNames = [
    'all' => 'Tất Cả',
    'mon-chinh' => 'Món Chính',
    'mon-an-vat' => 'Món Ăn Vặt',
    'banh-ngot' => 'Bánh Ngọt',
    'do-uong' => 'Đồ Uống'
];

$categoryIcons = [
    'all' => '🍽️',
    'mon-chinh' => '🍜',
    'mon-an-vat' => '🥟',
    'banh-ngot' => '🍰',
    'do-uong' => '🍹'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ẩm Thực Trà Vinh - Đặc Sản Khmer</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/mobile-enhancements.css">
    <link rel="stylesheet" href="css/header-responsive-fix.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8em;
            font-weight: 700;
            color: #ff6b6b;
            text-decoration: none;
        }

        .nav {
            display: flex;
            gap: 30px;
        }

        .nav a {
            color: #333;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .nav a:hover {
            color: #ff6b6b;
        }

        .hero {
            text-align: center;
            padding: 60px 20px;
            color: white;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.3em;
            margin-bottom: 30px;
        }

        .search-box {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            gap: 10px;
        }

        .search-input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
        }

        .search-btn {
            padding: 15px 30px;
            background: white;
            color: #ff6b6b;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .search-btn:hover {
            background: #f0f0f0;
        }

        .filter-section {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .filter-tabs {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-btn {
            padding: 12px 25px;
            background: white;
            border: 2px solid transparent;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: white;
            border-color: #ff6b6b;
            color: #ff6b6b;
            transform: translateY(-2px);
        }

        .food-grid {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }

        .food-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        .food-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .food-image {
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .food-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .food-card:hover .food-image img {
            transform: scale(1.1);
        }

        .food-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 107, 107, 0.9);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .food-content {
            padding: 25px;
        }

        .food-name {
            font-size: 1.5em;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .food-name-khmer {
            color: #6b7280;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .food-description {
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .food-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 2px solid #f3f4f6;
        }

        .food-price {
            font-weight: 700;
            color: #10b981;
            font-size: 1.1em;
        }

        .food-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #ff6b6b;
            color: white;
        }

        .btn-primary:hover {
            background: #ff5252;
        }

        .btn-secondary {
            background: #10b981;
            color: white;
        }

        .btn-secondary:hover {
            background: #059669;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: white;
        }

        .no-results i {
            font-size: 4em;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2em;
            }

            .food-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <a href="index.php" class="logo">
                <i class="fas fa-utensils"></i> Ẩm Thực Trà Vinh
            </a>
            <nav class="nav">
                <a href="index.php">Trang Chủ</a>
                <a href="dia-diem-du-lich-dynamic.php">Địa Điểm</a>
                <a href="am-thuc-dynamic.php">Ẩm Thực</a>
                <a href="lien-he.php">Liên Hệ</a>
            </nav>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <h1>🍜 Ẩm Thực Trà Vinh</h1>
        <p>Khám phá <?php echo $totalFoods; ?> món ăn đặc sản Khmer độc đáo</p>

        <!-- Search Box -->
        <form method="GET" action="" class="search-box">
            <input type="text" name="search" class="search-input" 
                   placeholder="🔍 Tìm kiếm món ăn..."
                   value="<?php echo htmlspecialchars($searchKeyword); ?>">
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i> Tìm Kiếm
            </button>
        </form>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-tabs">
            <?php foreach ($categoryNames as $cat => $name): ?>
            <a href="?category=<?php echo $cat; ?>" 
               class="filter-btn <?php echo ($category === $cat) ? 'active' : ''; ?>">
                <span><?php echo $categoryIcons[$cat]; ?></span>
                <?php echo $name; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Food Grid -->
    <div class="food-grid">
        <?php if (!empty($foods)): ?>
            <?php foreach ($foods as $foodItem): ?>
            <div class="food-card">
                <div class="food-image">
                    <img src="<?php echo htmlspecialchars($foodItem['image_url'] ?? 'hinhanh/AmThuc/placeholder-food.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($foodItem['name']); ?>"
                         onerror="this.src='hinhanh/AmThuc/placeholder-food.jpg'">
                    <div class="food-badge">
                        <?php echo htmlspecialchars($categoryNames[$foodItem['category']] ?? 'Món ăn'); ?>
                    </div>
                </div>

                <div class="food-content">
                    <h3 class="food-name"><?php echo htmlspecialchars($foodItem['name']); ?></h3>
                    <?php if (!empty($foodItem['name_khmer'])): ?>
                    <div class="food-name-khmer"><?php echo htmlspecialchars($foodItem['name_khmer']); ?></div>
                    <?php endif; ?>

                    <p class="food-description">
                        <?php echo htmlspecialchars(substr($foodItem['description'] ?? '', 0, 120)) . '...'; ?>
                    </p>

                    <div class="food-info">
                        <div class="food-price">
                            <i class="fas fa-tag"></i>
                            <?php echo htmlspecialchars($foodItem['price_range'] ?? 'Liên hệ'); ?>
                        </div>

                        <div class="food-actions">
                            <a href="chi-tiet-mon-an.php?id=<?php echo urlencode($foodItem['food_id']); ?>" 
                               class="btn btn-primary">
                                <i class="fas fa-eye"></i>
                                Chi Tiết
                            </a>
                            <a href="tim-quan-an.php?food_type=<?php echo urlencode($foodItem['food_id']); ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-search"></i>
                                Tìm Quán
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h3>Không tìm thấy món ăn nào</h3>
                <p>Vui lòng thử lại với từ khóa khác</p>
                <a href="am-thuc-dynamic.php" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>
