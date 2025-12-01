<?php
/**
 * Trang Tìm Quán Ăn - PHP Version
 * Sử dụng database thay vì JavaScript
 */

session_start();

require_once 'config/database.php';
require_once 'models/Restaurant.php';
require_once 'models/Food.php';

// Khởi tạo database
$foods = [];
$restaurants = [];
$error = null;

try {
    $database = new Database();
    $db = $database->getConnection();
    $restaurant = new Restaurant($db);
    $food = new Food($db);
    
    // Lấy tham số từ URL
    $foodType = isset($_GET['food_type']) ? $_GET['food_type'] : '';
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    
    // Lấy tất cả món ăn từ database
    $stmt = $food->readAll();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $foods[] = $row;
    }
    
    // Lấy danh sách quán ăn
    if (!empty($foodType)) {
        $stmt = $restaurant->getByFoodType($foodType);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $restaurants[] = $row;
        }
    } elseif (!empty($searchKeyword)) {
        $stmt = $restaurant->search($searchKeyword);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $restaurants[] = $row;
        }
    }
    
} catch (Exception $e) {
    $error = $e->getMessage();
    error_log("Error in tim-quan-an.php: " . $error);
}

// Icon mapping cho các loại món ăn
$categoryIcons = [
    'mon-chinh' => '🍜',
    'mon-an-vat' => '🥟',
    'banh-ngot' => '🍰',
    'do-uong' => '🍹',
    'trang-mieng' => '🍧'
];

// Tìm món ăn hiện tại nếu có foodType
$currentFood = null;
if (!empty($foodType)) {
    foreach ($foods as $f) {
        if ($f['food_id'] === $foodType) {
            $currentFood = $f;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Quán Ăn - Trà Vinh</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/restaurant-finder.css">
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
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.2em;
            opacity: 0.9;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .content {
            padding: 40px;
        }

        .search-section {
            margin-bottom: 40px;
        }

        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
        }

        .search-btn {
            padding: 15px 30px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
        }

        .food-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .food-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 15px;
            padding: 20px;
            color: white;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 200px;
        }

        .food-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 40px rgba(240, 147, 251, 0.4);
        }

        .food-card h3 {
            font-size: 1.3em;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .food-card p {
            margin-bottom: 15px;
            opacity: 0.9;
            font-size: 0.9em;
            line-height: 1.4;
        }

        .food-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .food-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .restaurants-section {
            margin-top: 40px;
        }

        .restaurants-section h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .restaurant-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .restaurant-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .restaurant-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .restaurant-name {
            font-size: 1.5em;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .restaurant-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #ffa500;
            font-size: 1.2em;
            font-weight: 600;
        }

        .restaurant-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
        }

        .info-item i {
            color: #4facfe;
            width: 20px;
        }

        .specialties {
            margin-bottom: 15px;
        }

        .specialties strong {
            color: #333;
            display: block;
            margin-bottom: 10px;
        }

        .specialty-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .specialty-tag {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            color: #333;
        }

        .restaurant-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .restaurant-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-call {
            background: #10b981;
            color: white;
        }

        .btn-direction {
            background: #3b82f6;
            color: white;
        }

        .btn-share {
            background: #8b5cf6;
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .no-results i {
            font-size: 4em;
            color: #ddd;
            margin-bottom: 20px;
        }

        .no-results h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="am-thuc.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Quay Lại Trang Ẩm Thực
            </a>
            <h1>🍽️ Tìm Quán Ăn Trà Vinh</h1>
            <p>Khám phá các quán ăn ngon cho từng món đặc sản</p>
        </div>

        <div class="content">
            <?php if ($error): ?>
            <div style="background: #fee2e2; border: 2px solid #ef4444; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <strong><i class="fas fa-exclamation-triangle"></i> Lỗi:</strong> 
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($foods)): ?>
            <div style="background: #dbeafe; border: 2px solid #3b82f6; color: #1e40af; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
                <strong><i class="fas fa-info-circle"></i> Có <?php echo count($foods); ?> món ăn đặc sản Trà Vinh</strong>
                <p style="margin-top: 5px; font-size: 0.9em;">Chọn món ăn bên dưới để tìm quán phục vụ</p>
            </div>
            <?php endif; ?>

            <!-- Search Section -->
            <div class="search-section">
                <form method="GET" action="" class="search-box">
                    <input type="text" name="search" class="search-input" 
                           placeholder="🔍 Tìm kiếm quán ăn, món ăn, địa chỉ..."
                           value="<?php echo htmlspecialchars($searchKeyword); ?>">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Tìm Kiếm
                    </button>
                </form>
            </div>

            <?php if (empty($foodType) && empty($searchKeyword)): ?>
            <!-- Food Type Grid - Lấy từ Database -->
            <?php if (!empty($foods)): ?>
            <div class="food-grid">
                <?php foreach ($foods as $foodItem): 
                    $icon = $categoryIcons[$foodItem['category']] ?? '🍽️';
                    $shortDesc = substr($foodItem['description'], 0, 80) . '...';
                ?>
                <a href="?food_type=<?php echo urlencode($foodItem['food_id']); ?>" class="food-card">
                    <h3><?php echo $icon; ?> <?php echo htmlspecialchars($foodItem['name']); ?></h3>
                    <?php if (!empty($foodItem['name_khmer'])): ?>
                        <p style="font-size: 0.9em; opacity: 0.8; font-style: italic; margin-bottom: 10px;">
                            <?php echo htmlspecialchars($foodItem['name_khmer']); ?>
                        </p>
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($shortDesc); ?></p>
                    <div class="food-btn">
                        <i class="fas fa-search"></i>
                        Tìm Quán <?php echo htmlspecialchars($foodItem['name']); ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="no-results">
                <i class="fas fa-utensils"></i>
                <h3>Chưa có món ăn nào</h3>
                <p>Vui lòng import dữ liệu từ file database/insert_foods_simple.sql</p>
            </div>
            <?php endif; ?>
            <?php endif; ?>

            <!-- Restaurants Results -->
            <?php if (!empty($restaurants)): ?>
            <div class="restaurants-section">
                <h2>
                    <?php if (!empty($foodType) && $currentFood): ?>
                        Tìm thấy <?php echo count($restaurants); ?> quán phục vụ <?php echo htmlspecialchars($currentFood['name']); ?>
                    <?php elseif (!empty($searchKeyword)): ?>
                        Kết quả tìm kiếm cho "<?php echo htmlspecialchars($searchKeyword); ?>" (<?php echo count($restaurants); ?> quán)
                    <?php endif; ?>
                </h2>

                <?php foreach ($restaurants as $rest): 
                    $specialties = json_decode($rest['specialties'], true);
                ?>
                <div class="restaurant-card">
                    <!-- Restaurant Image -->
                    <div class="restaurant-image" style="width: 100%; height: 200px; border-radius: 10px; overflow: hidden; margin-bottom: 20px;">
                        <img src="<?php echo htmlspecialchars($rest['image_url'] ?? 'hinhanh/QuanAn/placeholder-restaurant.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($rest['name']); ?>"
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;"
                             onerror="this.src='hinhanh/QuanAn/placeholder-restaurant.jpg'"
                             onmouseover="this.style.transform='scale(1.1)'"
                             onmouseout="this.style.transform='scale(1)'">
                    </div>
                    
                    <div class="restaurant-header">
                        <div>
                            <div class="restaurant-name"><?php echo htmlspecialchars($rest['name']); ?></div>
                        </div>
                        <div class="restaurant-rating">
                            <i class="fas fa-star"></i>
                            <span><?php echo number_format($rest['rating'], 1); ?></span>
                        </div>
                    </div>

                    <div class="restaurant-info">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($rest['address']); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span><?php echo htmlspecialchars($rest['phone']); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span><?php echo htmlspecialchars($rest['open_time']); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span><?php echo htmlspecialchars($rest['price_range']); ?></span>
                        </div>
                    </div>

                    <?php if (!empty($specialties)): ?>
                    <div class="specialties">
                        <strong>Món đặc biệt:</strong>
                        <div class="specialty-tags">
                            <?php foreach ($specialties as $specialty): ?>
                            <span class="specialty-tag"><?php echo htmlspecialchars($specialty); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="restaurant-description">
                        <?php echo htmlspecialchars($rest['description']); ?>
                    </div>

                    <div class="restaurant-actions">
                        <a href="tel:<?php echo htmlspecialchars($rest['phone']); ?>" class="action-btn btn-call">
                            <i class="fas fa-phone"></i>
                            Gọi Điện
                        </a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $rest['latitude']; ?>,<?php echo $rest['longitude']; ?>" 
                           target="_blank" class="action-btn btn-direction">
                            <i class="fas fa-directions"></i>
                            Chỉ Đường
                        </a>
                        <button onclick="shareRestaurant('<?php echo htmlspecialchars($rest['name']); ?>', '<?php echo htmlspecialchars($rest['address']); ?>')" 
                                class="action-btn btn-share">
                            <i class="fas fa-share"></i>
                            Chia Sẻ
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php elseif (!empty($foodType) || !empty($searchKeyword)): ?>
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h3>Không tìm thấy quán ăn</h3>
                <p>Hiện tại chưa có thông tin quán ăn cho món này. Chúng tôi sẽ cập nhật sớm nhất!</p>
                <a href="tim-quan-an.php" class="search-btn" style="display: inline-block; margin-top: 20px; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function shareRestaurant(name, address) {
            const shareText = `🍽️ ${name}\n📍 ${address}`;
            
            if (navigator.share) {
                navigator.share({
                    title: name,
                    text: shareText,
                    url: window.location.href
                }).catch(err => console.log('Error sharing:', err));
            } else {
                navigator.clipboard.writeText(shareText).then(() => {
                    alert('✅ Đã sao chép thông tin quán vào clipboard!');
                }).catch(err => {
                    alert('❌ Không thể sao chép. Vui lòng thử lại!');
                });
            }
        }
    </script>
</body>
</html>
