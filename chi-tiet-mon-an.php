<?php
/**
 * Trang Chi Tiết Món Ăn - PHP Version
 */

session_start();

require_once 'config/database.php';
require_once 'models/Food.php';

// Lấy ID từ URL
$foodId = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($foodId)) {
    header('Location: am-thuc-dynamic.php');
    exit();
}

// Khởi tạo database
try {
    $database = new Database();
    $db = $database->getConnection();
    $food = new Food($db);
    
    $food->food_id = $foodId;
    
    if (!$food->readOne()) {
        header('Location: am-thuc-dynamic.php');
        exit();
    }
    
    // Parse ingredients JSON
    $ingredients = json_decode($food->ingredients, true) ?? [];
    
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($food->name); ?> - Ẩm Thực Trà Vinh</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            background: #ff6b6b;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #ff5252;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .detail-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .hero-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .content {
            padding: 40px;
        }

        .title-section {
            margin-bottom: 30px;
        }

        .food-name {
            font-size: 3em;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .food-name-khmer {
            font-size: 1.5em;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .category-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .info-item {
            background: #f9fafb;
            padding: 20px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-icon {
            font-size: 2em;
            color: #ff6b6b;
        }

        .info-content strong {
            display: block;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .info-content span {
            color: #6b7280;
        }

        .section {
            margin: 40px 0;
        }

        .section-title {
            font-size: 2em;
            color: #1f2937;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #ff6b6b;
        }

        .description {
            color: #4b5563;
            line-height: 1.8;
            font-size: 1.1em;
        }

        .ingredients-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .ingredient-item {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1f2937;
            font-weight: 600;
        }

        .ingredient-item i {
            color: #ff6b6b;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 40px;
        }

        .btn {
            flex: 1;
            padding: 18px;
            border: none;
            border-radius: 15px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
        }

        .btn-secondary {
            background: #10b981;
            color: white;
        }

        .btn-secondary:hover {
            background: #059669;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .food-name {
                font-size: 2em;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <a href="am-thuc-dynamic.php" class="back-btn">
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
    <div class="container">
        <div class="detail-card">
            <img src="<?php echo htmlspecialchars($food->image_url ?? 'images/placeholder-food.jpg'); ?>" 
                 alt="<?php echo htmlspecialchars($food->name); ?>"
                 class="hero-image"
                 onerror="this.src='images/placeholder-food.jpg'">
            
            <div class="content">
                <!-- Title Section -->
                <div class="title-section">
                    <h1 class="food-name"><?php echo htmlspecialchars($food->name); ?></h1>
                    <?php if (!empty($food->name_khmer)): ?>
                    <div class="food-name-khmer"><?php echo htmlspecialchars($food->name_khmer); ?></div>
                    <?php endif; ?>
                    <span class="category-badge">
                        <?php 
                        $catNames = [
                            'mon-chinh' => 'Món Chính',
                            'mon-an-vat' => 'Món Ăn Vặt',
                            'banh-ngot' => 'Bánh Ngọt',
                            'do-uong' => 'Đồ Uống'
                        ];
                        echo $catNames[$food->category] ?? 'Món ăn';
                        ?>
                    </span>
                </div>

                <!-- Info Grid -->
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-tag info-icon"></i>
                        <div class="info-content">
                            <strong>Giá:</strong>
                            <span><?php echo htmlspecialchars($food->price_range ?? 'Liên hệ'); ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-map-marker-alt info-icon"></i>
                        <div class="info-content">
                            <strong>Xuất xứ:</strong>
                            <span><?php echo htmlspecialchars($food->origin ?? 'Trà Vinh'); ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-clock info-icon"></i>
                        <div class="info-content">
                            <strong>Thời gian tốt nhất:</strong>
                            <span><?php echo htmlspecialchars($food->best_time ?? 'Cả ngày'); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Giới Thiệu
                    </h2>
                    <div class="description">
                        <?php echo nl2br(htmlspecialchars($food->description)); ?>
                    </div>
                </div>

                <!-- Ingredients Section -->
                <?php if (!empty($ingredients)): ?>
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-list"></i>
                        Nguyên Liệu Chính
                    </h2>
                    <div class="ingredients-list">
                        <?php foreach ($ingredients as $ingredient): ?>
                        <div class="ingredient-item">
                            <i class="fas fa-check-circle"></i>
                            <?php echo htmlspecialchars($ingredient); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="tim-quan-an.php?food_type=<?php echo urlencode($food->food_id); ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Tìm Quán Phục Vụ Món Này
                    </a>
                    <button onclick="shareFood()" class="btn btn-secondary">
                        <i class="fas fa-share-alt"></i>
                        Chia Sẻ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function shareFood() {
            const url = window.location.href;
            const title = '<?php echo addslashes($food->name); ?>';
            
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Khám phá món ăn đặc sản Trà Vinh!',
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
    </script>
</body>
</html>
