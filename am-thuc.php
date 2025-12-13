<?php
/**
 * Trang Ẩm Thực - Bootstrap Version
 */
session_start();

require_once 'config/database.php';
require_once 'models/Food.php';

$isAdmin = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && 
           isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'manager']);
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];

$foods = [];
$totalFoods = 0;
$error = null;
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

try {
    $database = new Database();
    $db = $database->getConnection();
    $food = new Food($db);
    
    $stmt = $food->readAll();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $foods[] = $row;
    }
    
    // Lọc theo category nếu có
    if (!empty($selectedCategory)) {
        $foods = array_filter($foods, function($item) use ($selectedCategory) {
            $category = str_replace('-', ' ', $selectedCategory);
            return stripos($item['category'] ?? '', $category) !== false;
        });
        $foods = array_values($foods);
    }
    
    $totalFoods = count($foods);
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($selectedCategory) ? str_replace('-', ' ', $selectedCategory) . ' - ' : ''; ?>Ẩm Thực Trà Vinh (<?php echo $totalFoods; ?> món)</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/bootstrap-custom.css">
    <link rel="stylesheet" href="css/food-search.css">
    
    <style>
        .food-card-img { height: 250px; object-fit: cover; transition: transform 0.5s ease; }
        .food-card:hover .food-card-img { transform: scale(1.1); }
        .food-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1050; display: none; align-items: center; justify-content: center; }
        .food-modal-overlay.show { display: flex; }
        .food-modal-content { background: white; border-radius: 1rem; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; }
    </style>
</head>
<body class="bg-gradient-light-orange">

    <!-- Header -->
    <header class="header-main shadow-sm sticky-top">
        <div class="container py-2">
            <div class="d-flex align-items-center justify-content-between">
                <a href="index.php" class="d-flex align-items-center text-decoration-none">
                    <i class="fas fa-home fs-4 text-primary me-2"></i>
                    <span class="fw-bold text-primary">Du Lịch Trà Vinh</span>
                </a>

                <nav class="d-none d-md-flex gap-2">
                    <a href="dia-diem-du-lich-dynamic.php" class="btn btn-outline-primary btn-sm">Địa Điểm</a>
                    <a href="am-thuc.php" class="btn btn-warning btn-sm text-white">Ẩm Thực</a>
                    <a href="lien-he.php" class="btn btn-outline-primary btn-sm">Liên Hệ</a>
                </nav>

                <div class="d-flex gap-2">
                    <?php if ($isLoggedIn): ?>
                        <a href="logout.php" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="d-none d-sm-inline ms-1">Đăng Xuất</span>
                        </a>
                    <?php else: ?>
                        <a href="dang-nhap.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="d-none d-sm-inline ms-1">Đăng Nhập</span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($isAdmin): ?>
                        <a href="quan-ly-users.php" class="btn btn-purple btn-sm">
                            <i class="fas fa-users-cog"></i>
                            <span class="d-none d-sm-inline ms-1">Quản Lý</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-5 bg-gradient-orange text-white position-relative">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                <span class="text-gradient-orange" style="color: #fff !important;">Ẩm Thực Trà Vinh</span>
            </h1>
            <p class="fs-5 mb-4 opacity-75">
                Khám phá <?php echo $totalFoods; ?> món ăn đặc trưng của đất Khmer với hương vị truyền thống độc đáo
            </p>
            
            <!-- Nút Thêm Món Ăn - Hiển thị cho tất cả user đã đăng nhập -->
            <?php if ($isLoggedIn): ?>
            <div class="mb-4">
                <button onclick="showAddFoodModal()" class="btn btn-gradient-success btn-lg">
                    <i class="fas fa-plus-circle me-2"></i>Thêm Món Ăn Mới
                </button>
            </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
            <div class="alert alert-danger mx-auto" style="max-width: 600px;">
                <strong>Lỗi!</strong> Không thể tải dữ liệu món ăn: <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <!-- Search Box -->
            <div class="search-box-custom mx-auto mb-3">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Tìm kiếm món ăn... (VD: bún nước lèo, bánh xèo)" autocomplete="off">
                <button class="btn btn-link text-muted" onclick="clearSearch()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="small opacity-75">
                <i class="fas fa-lightbulb me-1"></i>
                Gợi ý: Thử tìm "bún", "bánh", "chè", "cá lóc", "khmer"...
            </p>
        </div>
    </section>

    <!-- Food Grid -->
    <main class="container py-5">
        <div class="row g-4" id="foodGrid">
            <?php if (!empty($foods)): ?>
                <?php foreach ($foods as $foodItem): ?>
                    <?php
                    $badgeColors = [
                        'mon-chinh' => 'danger',
                        'mon-an-vat' => 'purple',
                        'banh-ngot' => 'warning',
                        'do-uong' => 'info',
                        'trang-mieng' => 'success'
                    ];
                    $categoryNames = [
                        'mon-chinh' => 'Món Chính',
                        'mon-an-vat' => 'Món Ăn Vặt',
                        'banh-ngot' => 'Bánh Ngọt',
                        'do-uong' => 'Đồ Uống',
                        'trang-mieng' => 'Tráng Miệng'
                    ];
                    $badgeColor = $badgeColors[$foodItem['category']] ?? 'secondary';
                    $categoryName = $categoryNames[$foodItem['category']] ?? 'Món Ăn';
                    ?>
                    
                    <div class="col-sm-6 col-lg-4" data-name="<?php echo htmlspecialchars($foodItem['name']); ?>">
                        <div class="card food-card shadow h-100">
                            <div class="position-relative overflow-hidden">
                                <img src="<?php echo htmlspecialchars($foodItem['image_url'] ?? 'hinhanh/AmThuc/placeholder-food.jpg'); ?>"
                                     alt="<?php echo htmlspecialchars($foodItem['name']); ?>"
                                     class="card-img-top food-card-img"
                                     onerror="this.src='hinhanh/AmThuc/placeholder-food.jpg'">
                                <span class="position-absolute top-0 start-0 m-3 badge bg-<?php echo $badgeColor; ?>">
                                    <?php echo $categoryName; ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo htmlspecialchars($foodItem['name']); ?></h5>
                                <?php if (!empty($foodItem['name_khmer'])): ?>
                                    <p class="text-muted small fst-italic mb-2"><?php echo htmlspecialchars($foodItem['name_khmer']); ?></p>
                                <?php endif; ?>
                                <p class="card-text text-muted small">
                                    <?php echo htmlspecialchars(substr($foodItem['description'] ?? '', 0, 120)) . '...'; ?>
                                </p>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <span class="text-warning fw-bold fs-5">
                                        <?php echo htmlspecialchars($foodItem['price_range'] ?? 'Liên hệ'); ?>
                                    </span>
                                    <button class="btn btn-warning btn-sm" onclick="findRestaurants('<?php echo htmlspecialchars($foodItem['food_id']); ?>')">
                                        <i class="fas fa-map-marker-alt me-1"></i>Tìm Quán
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-utensils display-1 text-muted mb-3"></i>
                    <h3 class="text-muted">Chưa có món ăn nào</h3>
                    <p class="text-muted">Vui lòng kiểm tra lại kết nối database hoặc thêm dữ liệu món ăn.</p>
                </div>
            <?php endif; ?>
        </div>


        <!-- Food Categories -->
        <section class="mt-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Phân Loại Món Ăn</h2>
                <p class="text-muted">Khám phá đa dạng ẩm thực Trà Vinh qua các danh mục món ăn đặc trưng</p>
            </div>

            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="bg-gradient-light-orange p-4 rounded-3 text-center card-hover">
                        <div class="display-4 mb-2">🍜</div>
                        <h6 class="fw-bold">Món Bún - Phở</h6>
                        <small class="text-muted">Bún nước lèo, bún suông, phở Khmer</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="bg-gradient-light-blue p-4 rounded-3 text-center card-hover">
                        <div class="display-4 mb-2">🥞</div>
                        <h6 class="fw-bold">Bánh Đặc Sản</h6>
                        <small class="text-muted">Bánh xèo, bánh căn, bánh ít</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="bg-gradient-light-purple p-4 rounded-3 text-center card-hover">
                        <div class="display-4 mb-2">🍖</div>
                        <h6 class="fw-bold">Món Thịt</h6>
                        <small class="text-muted">Chù ụ rang me, thịt nướng Khmer</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="bg-light p-4 rounded-3 text-center card-hover">
                        <div class="display-4 mb-2">🍰</div>
                        <h6 class="fw-bold">Chè - Tráng Miệng</h6>
                        <small class="text-muted">Chè Khmer, bánh flan, chè thái</small>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Restaurants -->
        <section class="mt-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Quán Ăn Nổi Tiếng</h2>
                <p class="text-muted">Những địa chỉ ẩm thực được yêu thích nhất tại Trà Vinh</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-utensils text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Quán Bún Nước Lèo Cô Ba</h6>
                                    <small class="text-muted">Chợ Trà Vinh</small>
                                </div>
                            </div>
                            <p class="text-muted small">Quán bún nước lèo lâu đời nhất thành phố với hương vị đậm đà truyền thống.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <small class="text-muted ms-1">4.8/5</small>
                                </div>
                                <span class="text-warning fw-bold">25.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-leaf text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Bún Suông Chú Năm</h6>
                                    <small class="text-muted">Đường Nguyễn Đáng</small>
                                </div>
                            </div>
                            <p class="text-muted small">Bún suông tươi ngon với nước dùng trong vắt và rau sống tươi mát.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <small class="text-muted ms-1">4.6/5</small>
                                </div>
                                <span class="text-warning fw-bold">22.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-fire text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Chù Ụ Rang Me Bà Tư</h6>
                                    <small class="text-muted">Chợ Cầu Quan</small>
                                </div>
                            </div>
                            <p class="text-muted small">Món ăn vặt độc đáo với hương vị chua ngọt đặc trưng của người Khmer.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <small class="text-muted ms-1">4.2/5</small>
                                </div>
                                <span class="text-warning fw-bold">18.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Modal Thêm Món Ăn -->
    <div id="addFoodModal" class="food-modal-overlay">
        <div class="food-modal-content">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title"><i class="fas fa-utensils me-2"></i>Thêm Món Ăn Mới</h5>
                <button type="button" class="btn-close btn-close-white" onclick="closeAddFoodModal()"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addFoodForm" onsubmit="submitAddFood(event)">
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-hamburger me-1"></i>Tên món ăn *</label>
                        <input type="text" name="name" class="form-control" required placeholder="VD: Bún nước lèo">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-language me-1"></i>Tên tiếng Khmer</label>
                        <input type="text" name="name_khmer" class="form-control" placeholder="VD: នំបញ្ចុក">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-list me-1"></i>Danh mục *</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Chọn danh mục --</option>
                            <option value="mon-chinh">Món Chính</option>
                            <option value="mon-an-vat">Món Ăn Vặt</option>
                            <option value="banh-ngot">Bánh Ngọt</option>
                            <option value="do-uong">Đồ Uống</option>
                            <option value="trang-mieng">Tráng Miệng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-align-left me-1"></i>Mô tả *</label>
                        <textarea name="description" class="form-control" rows="3" required placeholder="Mô tả món ăn..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-tag me-1"></i>Giá</label>
                        <input type="text" name="price_range" class="form-control" placeholder="VD: 25.000đ - 35.000đ">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-image me-1"></i>URL Hình ảnh</label>
                        <input type="text" name="image_url" class="form-control" placeholder="hinhanh/AmThuc/ten-hinh.jpg">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-fill">
                            <i class="fas fa-save me-1"></i>Lưu Món Ăn
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeAddFoodModal()">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('[data-name]').forEach(card => {
                const name = card.dataset.name.toLowerCase();
                card.style.display = name.includes(query) ? '' : 'none';
            });
        });

        function clearSearch() {
            searchInput.value = '';
            document.querySelectorAll('[data-name]').forEach(card => card.style.display = '');
        }

        // Modal functions
        function showAddFoodModal() {
            document.getElementById('addFoodModal').classList.add('show');
        }

        function closeAddFoodModal() {
            document.getElementById('addFoodModal').classList.remove('show');
        }

        function submitAddFood(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            
            fetch('api/foods.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Thêm món ăn thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + (data.message || 'Không thể thêm món ăn'));
                }
            })
            .catch(err => {
                alert('Lỗi kết nối: ' + err.message);
            });
        }

        function findRestaurants(foodId) {
            window.location.href = 'tim-quan-an.php?food_id=' + foodId;
        }
    </script>
</body>
</html>
