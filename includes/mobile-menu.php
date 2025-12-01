<?php
/**
 * Mobile Menu Component
 * Include file này vào các trang để có mobile menu
 */

// Đảm bảo đã có session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy thông tin user
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$userName = $_SESSION['full_name'] ?? 'Khách';
$userRole = $_SESSION['role'] ?? 'user';
$isAdmin = $userRole === 'admin' || $userRole === 'manager';

// Current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

// Role names
$roleNames = [
    'admin' => 'Quản trị viên',
    'manager' => 'Quản lý',
    'user' => 'Người dùng'
];
?>

<!-- Mobile Menu Overlay -->
<div class="mobile-nav-overlay" id="mobileNavOverlay"></div>

<!-- Mobile Menu Container -->
<div class="mobile-menu-container" id="mobileMenuContainer">
    <div class="mobile-menu-header">
        <div class="mobile-menu-logo">
            <img src="hinhanh/logo.jpg" alt="Logo" style="height: 40px; border-radius: 8px;" onerror="this.style.display='none'">
            <span>Du Lịch Trà Vinh</span>
        </div>
        <button class="mobile-menu-close" aria-label="Đóng menu">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="mobile-menu-links">
        <a href="index.php" class="mobile-menu-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
            <i class="fas fa-home"></i>
            <span>Trang Chủ</span>
        </a>
        <a href="dia-diem-du-lich-dynamic.php" class="mobile-menu-link <?php echo $currentPage === 'dia-diem-du-lich-dynamic.php' ? 'active' : ''; ?>">
            <i class="fas fa-map-marker-alt"></i>
            <span>Địa Điểm Du Lịch</span>
        </a>
        <a href="am-thuc.php" class="mobile-menu-link <?php echo $currentPage === 'am-thuc.php' ? 'active' : ''; ?>">
            <i class="fas fa-utensils"></i>
            <span>Ẩm Thực</span>
        </a>
        <a href="lien-he.php" class="mobile-menu-link <?php echo $currentPage === 'lien-he.php' ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i>
            <span>Liên Hệ</span>
        </a>
        
        <?php if ($isAdmin): ?>
        <div class="mobile-menu-divider"></div>
        <div class="mobile-menu-section-title">Quản Lý</div>
        <a href="quan-ly-users.php" class="mobile-menu-link <?php echo $currentPage === 'quan-ly-users.php' ? 'active' : ''; ?>">
            <i class="fas fa-users-cog"></i>
            <span>Quản Lý Tài Khoản</span>
        </a>
        <a href="quan-ly-booking.php" class="mobile-menu-link <?php echo $currentPage === 'quan-ly-booking.php' ? 'active' : ''; ?>">
            <i class="fas fa-calendar-check"></i>
            <span>Quản Lý Booking</span>
        </a>
        <a href="quan-ly-am-thuc.php" class="mobile-menu-link <?php echo $currentPage === 'quan-ly-am-thuc.php' ? 'active' : ''; ?>">
            <i class="fas fa-utensils"></i>
            <span>Quản Lý Ẩm Thực</span>
        </a>
        <a href="quan-ly-lien-he.php" class="mobile-menu-link <?php echo $currentPage === 'quan-ly-lien-he.php' ? 'active' : ''; ?>">
            <i class="fas fa-envelope-open-text"></i>
            <span>Quản Lý Liên Hệ</span>
        </a>
        <?php endif; ?>
    </div>
    
    <div class="mobile-menu-user">
        <?php if ($isLoggedIn): ?>
        <div class="mobile-menu-user-info">
            <div class="mobile-menu-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="mobile-menu-user-details">
                <div class="mobile-menu-user-name"><?php echo htmlspecialchars($userName); ?></div>
                <div class="mobile-menu-user-role"><?php echo $roleNames[$userRole] ?? 'Người dùng'; ?></div>
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

<!-- Hamburger Button Style (nếu chưa có trong CSS) -->
<style>
.hamburger-btn {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 44px;
    height: 44px;
    background: #f3f4f6;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    padding: 10px;
    z-index: 10000;
    gap: 5px;
}

.hamburger-line {
    width: 22px;
    height: 2px;
    background: #374151;
    border-radius: 2px;
    transition: all 0.3s ease;
}

@media (max-width: 767px) {
    .hamburger-btn {
        display: flex !important;
    }
}
</style>
