<?php
/**
 * Trang chủ Du Lịch Trà Vinh - Bootstrap Version
 */

session_start();

$logoutSuccess = isset($_GET['logout']) && $_GET['logout'] === 'success';

require_once 'config/database.php';
require_once 'models/Attraction.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $attraction = new Attraction($db);
    
    $featuredAttractions = $attraction->getPopularAttractions(3);
    $attractions = [];
    while ($row = $featuredAttractions->fetch(PDO::FETCH_ASSOC)) {
        $attractions[] = $row;
    }
    
    $totalAttractions = $attraction->readAll();
    $attractionCount = $totalAttractions->rowCount();
    
} catch (Exception $e) {
    $attractions = [
        ['attraction_id' => 'aobaom', 'name' => 'Ao Bà Om', 'description' => 'Thắng cảnh quốc gia với truyền thuyết về cuộc thi đắp đập của phụ nữ Khmer.', 'category' => 'Di Tích Quốc Gia', 'image_url' => 'hinhanh/DulichtpTV/aobaom-02-1024x686.jpg'],
        ['attraction_id' => 'chuaang', 'name' => 'Chùa Âng', 'description' => 'Ngôi chùa Khmer cổ kính nhất với niên đại hơn 1000 năm.', 'category' => 'Chùa Khmer Cổ', 'image_url' => 'hinhanh/DulichtpTV/maxresdefault.jpg'],
        ['attraction_id' => 'bienbadong', 'name' => 'Biển Ba Động', 'description' => 'Bãi biển hoang sơ với cát trắng và nước trong xanh.', 'category' => 'Biển Đẹp', 'image_url' => 'hinhanh/DulichtpTV/Kham-pha-Khu-du-lich-Bien-Ba-Dong-Tra-Vinh-2022.jpg.webp']
    ];
    $attractionCount = 15;
}

$currentDateTime = date('l, d/m/Y - H:i', time());
$currentYear = date('Y');
$stats = ['temples' => '140+', 'visitors' => '3.5M', 'heritage_sites' => '50+', 'ethnic_groups' => '3'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Du Lịch Tỉnh Trà Vinh - Khám Phá Vẻ Đẹp Đất Khmer</title>
    <meta name="description" content="Khám phá vẻ đẹp văn hóa Khmer và thiên nhiên tuyệt vời của Trà Vinh.">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/bootstrap-custom.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/animations.css">
</head>
<body>

    <!-- Logout Notification -->
    <?php if ($logoutSuccess): ?>
    <div class="notification-toast alert alert-success d-flex align-items-center" id="logoutNotification">
        <i class="fas fa-check-circle fs-4 me-3"></i>
        <div>
            <strong>Đăng xuất thành công!</strong>
            <p class="mb-0 small">Hẹn gặp lại bạn</p>
        </div>
        <button type="button" class="btn-close ms-3" onclick="this.parentElement.remove()"></button>
    </div>
    <script>
        setTimeout(() => {
            const notification = document.getElementById('logoutNotification');
            if (notification) notification.remove();
        }, 5000);
    </script>
    <?php endif; ?>

    <!-- Header -->
    <header class="header-main shadow-sm sticky-top">
        <div class="container py-2">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Logo -->
                <a href="index.php" class="d-flex align-items-center text-decoration-none">
                    <img src="hinhanh/logo.jpg" alt="Logo Trà Vinh" class="logo-img me-3">
                    <div class="d-none d-sm-block">
                        <h1 class="h5 mb-0 text-danger fw-bold">TRƯỜNG ĐẠI HỌC TRÀ VINH</h1>
                        <small class="text-muted">
                            <i class="far fa-clock me-1"></i>
                            <span id="currentDateTime"><?php echo $currentDateTime; ?></span>
                        </small>
                    </div>
                </a>

                <!-- User Info / Welcome -->
                <div class="d-none d-md-block">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-light-blue px-4 py-2 rounded-3 shadow-sm">
                            <small class="text-muted">Xin chào,</small>
                            <p class="mb-0 fw-bold text-primary">
                                <i class="fas fa-user-circle me-1"></i>
                                <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                            </p>
                            <span class="badge bg-primary">
                                <?php 
                                $roleNames = ['admin' => 'Quản trị viên', 'manager' => 'Quản lý', 'user' => 'Người dùng'];
                                echo $roleNames[$_SESSION['role']] ?? $_SESSION['role']; 
                                ?>
                            </span>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
                            <a href="quan-ly-users.php" class="btn btn-purple btn-sm">
                                <i class="fas fa-users-cog me-1"></i>Quản Lý
                            </a>
                            <?php endif; ?>
                            <a href="logout.php" class="btn btn-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i>Đăng Xuất
                            </a>
                        </div>
                    </div>
                    <?php else: ?>
                    <p class="mb-0 text-success fw-semibold fst-italic bg-success bg-opacity-10 px-3 py-2 rounded-3">
                        🌴 Chào mừng Đến Với Du Lịch Của Tỉnh Trà Vinh 🌴
                    </p>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button class="btn btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header bg-gradient-primary text-white">
            <h5 class="offcanvas-title">
                <i class="fas fa-compass me-2"></i>Du Lịch Trà Vinh
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="nav flex-column">
                <a class="nav-link active" href="index.php"><i class="fas fa-home me-2"></i>Trang Chủ</a>
                <a class="nav-link" href="dia-diem-du-lich-dynamic.php"><i class="fas fa-map-marker-alt me-2"></i>Địa Điểm Du Lịch</a>
                <a class="nav-link" href="am-thuc.php"><i class="fas fa-utensils me-2"></i>Ẩm Thực</a>
                <a class="nav-link" href="lien-he.php"><i class="fas fa-envelope me-2"></i>Liên Hệ</a>
                
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager')): ?>
                <hr>
                <h6 class="text-muted px-3">Quản Lý</h6>
                <a class="nav-link" href="quan-ly-users.php"><i class="fas fa-users-cog me-2"></i>Quản Lý Tài Khoản</a>
                <a class="nav-link" href="quan-ly-booking.php"><i class="fas fa-calendar-check me-2"></i>Quản Lý Booking</a>
                <a class="nav-link" href="quan-ly-dat-dich-vu.php"><i class="fas fa-concierge-bell me-2"></i>Quản Lý Dịch Vụ</a>
                <a class="nav-link" href="quan-ly-xac-nhan-thanh-toan.php"><i class="fas fa-money-check-alt me-2"></i>Quản Lý Thanh Toán</a>
                <a class="nav-link" href="quan-ly-lien-he.php"><i class="fas fa-envelope me-2"></i>Quản Lý Tin Nhắn</a>
                <?php endif; ?>
            </nav>
            
            <hr>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle p-2 me-2">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong>
                    <br><small class="text-muted"><?php echo $roleNames[$_SESSION['role']] ?? $_SESSION['role']; ?></small>
                </div>
            </div>
            <a href="logout.php" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt me-2"></i>Đăng Xuất
            </a>
            <?php else: ?>
            <a href="dang-nhap.php" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="nav-main py-2 sticky-top" style="top: 60px; z-index: 1000;">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link-custom" href="dia-diem-du-lich-dynamic.php">
                        <i class="fas fa-map-marker-alt me-1"></i>Địa Điểm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-custom" href="am-thuc.php">
                        <i class="fas fa-utensils me-1"></i>Ẩm Thực
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-custom" href="lien-he.php">
                        <i class="fas fa-envelope me-1"></i>Liên Hệ
                    </a>
                </li>
            </ul>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <!-- Background Slider -->
        <div class="bg-slider active" style="background-image: url('hinhanh/bieu-trung-13-tinh-mien-tay.jpg');"></div>
        <div class="bg-slider" style="background-image: url('hinhanh/nhung-mon-an-ngon-dac-san-tra-vinh-nhat-dinh-phai-thu (1).jpg');"></div>
        <div class="bg-slider" style="background-image: url('hinhanh/kham-pha-8-dia-diem-du-lich-tra-vinh-doc-dao-an-tuong(1).jpg');"></div>
        
        <!-- Overlay -->
        <div class="hero-overlay"></div>
        
        <!-- Content -->
        <div class="hero-content d-flex align-items-center justify-content-center min-vh-50 py-5">
            <div class="container text-center text-white">
                <!-- Title -->
                <h1 class="hero-title mb-4 animate-fade-in">
                    <span class="text-gradient-yellow">Du Lịch Trà Vinh</span>
                </h1>
                <p class="fs-4 mb-5 animate-fade-in-delay opacity-75">
                    Khám phá vẻ đẹp văn hóa Khmer và thiên nhiên tuyệt vời
                </p>

                <!-- Navigation Cards -->
                <div class="row g-3 g-md-4 mt-4 justify-content-center">
                    <!-- Địa Điểm -->
                    <div class="col-6 col-lg-3">
                        <a href="dia-diem-du-lich-dynamic.php" class="nav-card text-center">
                            <div class="nav-card-icon text-info">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Địa Điểm</h5>
                            <p class="small opacity-75 d-none d-md-block">Khám phá <?php echo $attractionCount; ?> di tích lịch sử</p>
                            <span class="text-warning small">
                                Xem <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </a>
                    </div>

                    <!-- Ẩm Thực -->
                    <div class="col-6 col-lg-3">
                        <a href="am-thuc.php" class="nav-card text-center">
                            <div class="nav-card-icon text-warning">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Ẩm Thực</h5>
                            <p class="small opacity-75 d-none d-md-block">Đặc sản Khmer độc đáo</p>
                            <span class="text-warning small">
                                Xem <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </a>
                    </div>

                    <!-- Liên Hệ -->
                    <div class="col-6 col-lg-3">
                        <a href="lien-he.php" class="nav-card text-center">
                            <div class="nav-card-icon text-success">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Liên Hệ</h5>
                            <p class="small opacity-75 d-none d-md-block">Tư vấn và hỗ trợ</p>
                            <span class="text-warning small">
                                Xem <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </a>
                    </div>

                    <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
                    <!-- Đăng Nhập -->
                    <div class="col-6 col-lg-3">
                        <a href="dang-nhap.php" class="nav-card text-center">
                            <div class="nav-card-icon text-warning">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Đăng Nhập</h5>
                            <p class="small opacity-75 d-none d-md-block">Truy cập tài khoản</p>
                            <span class="text-warning small">
                                Vào <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager')): ?>
                    <!-- Quản Lý -->
                    <div class="col-6 col-lg-3">
                        <a href="quan-ly-users.php" class="nav-card text-center">
                            <div class="nav-card-icon" style="color: #a855f7;">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Quản Lý</h5>
                            <p class="small opacity-75 d-none d-md-block">Quản lý hệ thống</p>
                            <span class="text-warning small">
                                Vào <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Stats -->
                <div class="row g-3 mt-5 animate-fade-in-delay-2">
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <div class="stat-number"><?php echo $stats['temples']; ?></div>
                            <div class="small opacity-75">Chùa Khmer</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <div class="stat-number"><?php echo $stats['visitors']; ?></div>
                            <div class="small opacity-75">Lượt Khách/Năm</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <div class="stat-number"><?php echo $stats['heritage_sites']; ?></div>
                            <div class="small opacity-75">Di Tích Lịch Sử</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <div class="stat-number"><?php echo $stats['ethnic_groups']; ?></div>
                            <div class="small opacity-75">Dân Tộc</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <div class="scroll-indicator">
                <div class="scroll-indicator-dot"></div>
            </div>
        </div>
    </section>

    <!-- Featured Attractions Section -->
    <section class="py-5 bg-gradient-light-blue">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-3">Điểm Đến Nổi Bật</h2>
                <p class="text-muted fs-5">Khám phá những địa điểm du lịch đặc sắc nhất của Trà Vinh</p>
            </div>

            <div class="row g-4">
                <?php foreach ($attractions as $index => $attraction): ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="card attraction-card shadow h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="<?php echo htmlspecialchars($attraction['image_url'] ?? 'hinhanh/placeholder.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($attraction['name']); ?>"
                                 class="card-img-top attraction-card-img"
                                 onerror="this.src='hinhanh/placeholder.jpg'">
                            <span class="position-absolute top-0 start-0 m-3 badge bg-<?php echo $index === 0 ? 'danger' : ($index === 1 ? 'warning' : 'success'); ?>">
                                <?php echo htmlspecialchars($attraction['category'] ?? 'Địa điểm du lịch'); ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($attraction['name']); ?></h5>
                            <p class="card-text text-muted">
                                <?php echo htmlspecialchars(substr($attraction['description'] ?? '', 0, 100)) . '...'; ?>
                            </p>
                            <a href="chi-tiet-dia-diem.php?id=<?php echo urlencode($attraction['attraction_id']); ?>" 
                               class="btn btn-link text-primary fw-semibold p-0">
                                Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-5">
                <a href="dia-diem-du-lich-dynamic.php" class="btn btn-gradient-primary btn-lg">
                    <i class="fas fa-compass me-2"></i>Khám Phá Tất Cả Địa Điểm
                </a>
            </div>
        </div>
    </section>


    <!-- Services Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-3">Dịch Vụ Du Lịch</h2>
                <p class="text-muted fs-5">Chúng tôi cung cấp đầy đủ các dịch vụ cho chuyến du lịch của bạn</p>
            </div>

            <div class="row g-4">
                <!-- Lập Kế Hoạch Tour -->
                <div class="col-sm-6 col-lg-3">
                    <div class="text-center p-4 card-hover rounded-3" data-bs-toggle="modal" data-bs-target="#tourModal" style="cursor: pointer;">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-route fs-2 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Lập Kế Hoạch Tour</h5>
                        <p class="text-muted small">Tư vấn và thiết kế hành trình phù hợp với nhu cầu</p>
                    </div>
                </div>

                <!-- Đặt Phòng Khách Sạn -->
                <div class="col-sm-6 col-lg-3">
                    <div class="text-center p-4 card-hover rounded-3" data-bs-toggle="modal" data-bs-target="#hotelModal" style="cursor: pointer;">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-hotel fs-2 text-success"></i>
                        </div>
                        <h5 class="fw-bold">Đặt Phòng Khách Sạn</h5>
                        <p class="text-muted small">Hỗ trợ đặt phòng tại các khách sạn uy tín</p>
                    </div>
                </div>

                <!-- Thuê Xe Du Lịch -->
                <div class="col-sm-6 col-lg-3">
                    <div class="text-center p-4 card-hover rounded-3" data-bs-toggle="modal" data-bs-target="#carModal" style="cursor: pointer;">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-car fs-2 text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Thuê Xe Du Lịch</h5>
                        <p class="text-muted small">Dịch vụ thuê xe với tài xế kinh nghiệm</p>
                    </div>
                </div>

                <!-- Hỗ Trợ 24/7 -->
                <div class="col-sm-6 col-lg-3">
                    <div class="text-center p-4 card-hover rounded-3" data-bs-toggle="modal" data-bs-target="#supportModal" style="cursor: pointer;">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-headset fs-2 text-info"></i>
                        </div>
                        <h5 class="fw-bold">Hỗ Trợ 24/7</h5>
                        <p class="text-muted small">Đội ngũ hỗ trợ khách hàng luôn sẵn sàng</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Tại Sao Chọn Chúng Tôi?</h2>
                <p class="text-muted fs-5">Những lý do khiến khách hàng tin tưởng và lựa chọn dịch vụ của chúng tôi</p>
            </div>

            <div class="row g-4">
                <!-- Chuyên Nghiệp -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center p-4" style="cursor: pointer; transition: all 0.3s ease;" data-bs-toggle="modal" data-bs-target="#professionalModal" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 80px; height: 80px;">
                            <i class="fas fa-award fs-2 text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Chuyên Nghiệp</h5>
                        <p class="text-muted small mb-0">Đội ngũ có kinh nghiệm lâu năm trong ngành du lịch</p>
                        <div class="mt-3">
                            <small class="text-primary"><i class="fas fa-hand-pointer me-1"></i>Click để xem chi tiết</small>
                        </div>
                    </div>
                </div>

                <!-- Giá Tốt Nhất -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center p-4" style="cursor: pointer; transition: all 0.3s ease;" data-bs-toggle="modal" data-bs-target="#priceModal" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 80px; height: 80px;">
                            <i class="fas fa-dollar-sign fs-2 text-success"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Giá Tốt Nhất</h5>
                        <p class="text-muted small mb-0">Cam kết giá cạnh tranh nhất thị trường</p>
                        <div class="mt-3">
                            <small class="text-success"><i class="fas fa-hand-pointer me-1"></i>Click để xem chi tiết</small>
                        </div>
                    </div>
                </div>

                <!-- An Toàn -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center p-4" style="cursor: pointer; transition: all 0.3s ease;" data-bs-toggle="modal" data-bs-target="#safetyModal" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 80px; height: 80px;">
                            <i class="fas fa-shield-alt fs-2 text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-3">An Toàn</h5>
                        <p class="text-muted small mb-0">Bảo hiểm và an toàn tuyệt đối cho khách hàng</p>
                        <div class="mt-3">
                            <small class="text-warning"><i class="fas fa-hand-pointer me-1"></i>Click để xem chi tiết</small>
                        </div>
                    </div>
                </div>

                <!-- Tận Tâm -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center p-4" style="cursor: pointer; transition: all 0.3s ease;" data-bs-toggle="modal" data-bs-target="#dedicatedModal" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 80px; height: 80px;">
                            <i class="fas fa-heart fs-2 text-info"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Tận Tâm</h5>
                        <p class="text-muted small mb-0">Phục vụ với trái tim và tâm huyết</p>
                        <div class="mt-3">
                            <small class="text-info"><i class="fas fa-hand-pointer me-1"></i>Click để xem chi tiết</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Service Booking Modals -->
    <?php include 'components/service-modals.php'; ?>

    <!-- Why Choose Us Detail Modals -->
    <!-- Modal Chuyên Nghiệp -->
    <div class="modal fade" id="professionalModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-award me-2"></i>Chuyên Nghiệp</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-users fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Đội Ngũ Giàu Kinh Nghiệm</h6>
                                    <p class="text-muted small mb-0">Hơn 10 năm hoạt động trong lĩnh vực du lịch với đội ngũ hướng dẫn viên chuyên nghiệp, am hiểu văn hóa địa phương.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-certificate fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Chứng Nhận Uy Tín</h6>
                                    <p class="text-muted small mb-0">Được cấp phép và công nhận bởi Sở Du Lịch, đảm bảo chất lượng dịch vụ theo tiêu chuẩn quốc gia.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-graduation-cap fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Đào Tạo Chuyên Sâu</h6>
                                    <p class="text-muted small mb-0">Nhân viên được đào tạo bài bản về kỹ năng phục vụ, kiến thức du lịch và ngoại ngữ.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-star fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Đánh Giá Cao</h6>
                                    <p class="text-muted small mb-0">Hơn 5000+ khách hàng hài lòng với đánh giá trung bình 4.8/5 sao trên các nền tảng.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-primary mt-4 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Cam kết:</strong> Chúng tôi không ngừng nâng cao chất lượng dịch vụ để mang đến trải nghiệm tốt nhất cho khách hàng.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Giá Tốt Nhất -->
    <div class="modal fade" id="priceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-dollar-sign me-2"></i>Giá Tốt Nhất</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-tags fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Giá Cạnh Tranh</h6>
                                    <p class="text-muted small mb-0">So sánh và đảm bảo mức giá tốt nhất thị trường cho cùng chất lượng dịch vụ.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-percent fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Ưu Đãi Thường Xuyên</h6>
                                    <p class="text-muted small mb-0">Chương trình khuyến mãi hấp dẫn theo mùa, giảm giá cho đoàn và khách hàng thân thiết.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-file-invoice-dollar fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Minh Bạch Chi Phí</h6>
                                    <p class="text-muted small mb-0">Báo giá rõ ràng, không phát sinh chi phí ẩn, khách hàng hoàn toàn yên tâm.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-gift fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Quà Tặng Hấp Dẫn</h6>
                                    <p class="text-muted small mb-0">Tặng kèm bảo hiểm du lịch, nón lá, nước suối và nhiều quà tặng giá trị khác.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-success mt-4 mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Cam kết:</strong> Nếu tìm được giá tốt hơn với cùng chất lượng, chúng tôi sẽ hoàn lại 110% chênh lệch.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal An Toàn -->
    <div class="modal fade" id="safetyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-shield-alt me-2"></i>An Toàn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-shield-virus fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Bảo Hiểm Toàn Diện</h6>
                                    <p class="text-muted small mb-0">Mua bảo hiểm du lịch cho 100% khách hàng, bảo vệ tối đa quyền lợi trong suốt hành trình.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-bus fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Phương Tiện Đạt Chuẩn</h6>
                                    <p class="text-muted small mb-0">Xe du lịch đời mới, được kiểm định định kỳ, tài xế có bằng lái và kinh nghiệm lâu năm.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-first-aid fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Y Tế Sẵn Sàng</h6>
                                    <p class="text-muted small mb-0">Trang bị túi y tế cơ bản, hướng dẫn viên được đào tạo sơ cứu cấp cứu ban đầu.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-phone-volume fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Hỗ Trợ Khẩn Cấp 24/7</h6>
                                    <p class="text-muted small mb-0">Đường dây nóng luôn sẵn sàng hỗ trợ mọi tình huống phát sinh trong chuyến đi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning mt-4 mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Ưu tiên hàng đầu:</strong> An toàn của khách hàng luôn được đặt lên hàng đầu trong mọi hoạt động.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tận Tâm -->
    <div class="modal fade" id="dedicatedModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-heart me-2"></i>Tận Tâm</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-headset fs-4 text-info"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Tư Vấn Nhiệt Tình</h6>
                                    <p class="text-muted small mb-0">Lắng nghe và tư vấn chi tiết để thiết kế hành trình phù hợp nhất với nhu cầu của bạn.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-smile-beam fs-4 text-info"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Phục Vụ Chu Đáo</h6>
                                    <p class="text-muted small mb-0">Chăm sóc khách hàng từ những chi tiết nhỏ nhất, mang đến sự hài lòng tối đa.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-comments fs-4 text-info"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Lắng Nghe Phản Hồi</h6>
                                    <p class="text-muted small mb-0">Luôn tiếp nhận và cải thiện dịch vụ dựa trên ý kiến đóng góp của khách hàng.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-hands-helping fs-4 text-info"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">Hỗ Trợ Sau Tour</h6>
                                    <p class="text-muted small mb-0">Tiếp tục chăm sóc và hỗ trợ khách hàng ngay cả sau khi kết thúc chuyến đi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mt-4 mb-0">
                        <i class="fas fa-heart me-2"></i>
                        <strong>Phương châm:</strong> "Khách hàng hài lòng là thành công của chúng tôi" - Chúng tôi phục vụ bằng cả trái tim.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Background Slider
        const slides = document.querySelectorAll('.bg-slider');
        let currentSlide = 0;
        
        function nextSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }
        
        setInterval(nextSlide, 5000);

        // Update DateTime
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            const dateTimeElement = document.getElementById('currentDateTime');
            if (dateTimeElement) {
                dateTimeElement.textContent = now.toLocaleDateString('vi-VN', options);
            }
        }
        
        setInterval(updateDateTime, 60000);

        // Submit booking function
        async function submitBooking(formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            
            const data = {
                service_id: parseInt(formData.get('service_id')),
                customer_name: formData.get('customer_name'),
                customer_phone: formData.get('customer_phone'),
                customer_email: formData.get('customer_email') || '',
                service_date: formData.get('service_date') || null,
                number_of_people: parseInt(formData.get('number_of_people')) || 1,
                number_of_days: parseInt(formData.get('number_of_days')) || 1,
                special_requests: formData.get('special_requests') || '',
                total_price: 0
            };
            
            try {
                const response = await fetch('api/service-bookings.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('✅ ' + result.message);
                    form.reset();
                    bootstrap.Modal.getInstance(form.closest('.modal')).hide();
                } else {
                    alert('❌ ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra. Vui lòng thử lại!');
            }
        }
    </script>
</body>
</html>
