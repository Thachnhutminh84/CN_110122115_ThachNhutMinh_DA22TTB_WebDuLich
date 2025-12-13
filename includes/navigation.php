<?php
/**
 * Navigation Menu - Hiển thị theo role
 * Include file này vào các trang cần menu
 * Version 2.0 - Responsive Enhanced
 */

// Đảm bảo đã có session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include check-auth nếu chưa có
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/../check-auth.php';
}

// Lấy thông tin user
$currentUser = getCurrentUser();
$isAdminOrMgr = isAdminOrManager();
$isLoggedIn = isLoggedIn();
$userRole = $currentUser['role'] ?? 'user';
$userName = $currentUser['full_name'] ?? 'Khách';

// Current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Data attributes for JavaScript -->
<script>
    document.body.dataset.loggedIn = '<?php echo $isLoggedIn ? 'true' : 'false'; ?>';
    document.body.dataset.userName = '<?php echo htmlspecialchars($userName); ?>';
    document.body.dataset.userRole = '<?php echo htmlspecialchars($userRole); ?>';
</script>

<!-- Navigation Menu -->
<nav class="bg-white shadow-lg sticky top-0 z-50 transition-all duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-3 md:py-4">
            <!-- Logo -->
            <div class="flex items-center space-x-2 md:space-x-3">
                <a href="index.php" class="flex items-center space-x-2 md:space-x-3">
                    <img src="hinhanh/logo.jpg" alt="Logo" class="h-10 md:h-12 w-auto rounded-lg">
                    <div class="hidden sm:block">
                        <h1 class="text-lg md:text-xl font-bold text-red-600">Du Lịch Trà Vinh</h1>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-4 lg:space-x-6">
                <a href="index.php" class="nav-link-desktop <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home mr-2"></i>Trang Chủ
                </a>
                <a href="dia-diem-du-lich-dynamic.php" class="nav-link-desktop <?php echo $currentPage === 'dia-diem-du-lich-dynamic.php' ? 'active' : ''; ?>">
                    <i class="fas fa-map-marked-alt mr-2"></i>Địa Điểm
                </a>
                <a href="am-thuc.php" class="nav-link-desktop <?php echo $currentPage === 'am-thuc.php' ? 'active' : ''; ?>">
                    <i class="fas fa-utensils mr-2"></i>Ẩm Thực
                </a>
                <a href="danh-sach-dich-vu.php" class="nav-link-desktop <?php echo $currentPage === 'danh-sach-dich-vu.php' ? 'active' : ''; ?>">
                    <i class="fas fa-concierge-bell mr-2"></i>Dịch Vụ
                </a>
                <a href="lich-dat-cua-toi.php" class="nav-link-desktop <?php echo $currentPage === 'lich-dat-cua-toi.php' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-check mr-2"></i>Lịch Đặt
                </a>
                <a href="lien-he.php" class="nav-link-desktop <?php echo $currentPage === 'lien-he.php' ? 'active' : ''; ?>">
                    <i class="fas fa-envelope mr-2"></i>Liên Hệ
                </a>

                <?php if ($isAdminOrMgr): ?>
                <!-- Menu quản lý - Chỉ admin/manager thấy -->
                <div class="relative group">
                    <button class="nav-link-desktop flex items-center">
                        <i class="fas fa-cog mr-2"></i>Quản Lý
                        <i class="fas fa-chevron-down ml-2 text-sm transition-transform group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 border border-gray-100">
                        <div class="py-2">
                            <a href="quan-ly-dia-diem.php" class="dropdown-link">
                                <i class="fas fa-map-marker-alt"></i>Quản Lý Địa Điểm
                            </a>
                            <a href="quan-ly-am-thuc.php" class="dropdown-link">
                                <i class="fas fa-utensils"></i>Quản Lý Ẩm Thực
                            </a>
                            <a href="quan-ly-users.php" class="dropdown-link">
                                <i class="fas fa-users-cog"></i>Quản Lý Tài Khoản
                            </a>
                            <a href="quan-ly-booking.php" class="dropdown-link">
                                <i class="fas fa-calendar-check"></i>Quản Lý Booking
                            </a>
                            <a href="quan-ly-xac-nhan-thanh-toan.php" class="dropdown-link">
                                <i class="fas fa-money-check-alt"></i>Quản Lý Thanh Toán
                            </a>
                            <a href="quan-ly-lien-he.php" class="dropdown-link">
                                <i class="fas fa-envelope-open-text"></i>Quản Lý Liên Hệ
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- User Info -->
                <?php if ($isLoggedIn): ?>
                <div class="flex items-center space-x-3 border-l pl-4 lg:pl-6">
                    <div class="text-right hidden lg:block">
                        <p class="text-sm text-gray-600">Xin chào,</p>
                        <p class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($userName); ?></p>
                    </div>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 lg:px-4 py-2 rounded-lg transition-all text-sm font-medium">
                        <i class="fas fa-sign-out-alt mr-1 lg:mr-2"></i>
                        <span class="hidden lg:inline">Đăng xuất</span>
                    </a>
                </div>
                <?php else: ?>
                <a href="dang-nhap.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all text-sm font-medium">
                    <i class="fas fa-sign-in-alt mr-2"></i>Đăng Nhập
                </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button class="hamburger-btn md:hidden" id="hamburgerBtn" aria-label="Mở menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
    </div>
</nav>

<style>
/* Navigation Desktop Styles */
.nav-link-desktop {
    color: #4b5563;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

.nav-link-desktop:hover,
.nav-link-desktop.active {
    color: #2563eb;
    background: rgba(37, 99, 235, 0.1);
}

.dropdown-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: #4b5563;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.dropdown-link:hover {
    background: #eff6ff;
    color: #2563eb;
}

.dropdown-link i {
    width: 1.25rem;
    text-align: center;
    color: #3b82f6;
}

/* Hamburger Button */
.hamburger-btn {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 44px;
    height: 44px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 10000;
    border-radius: 8px;
    transition: background 0.3s ease;
}

.hamburger-btn:hover {
    background: rgba(0, 0, 0, 0.05);
}

.hamburger-line {
    width: 24px;
    height: 3px;
    background: #374151;
    border-radius: 3px;
    transition: all 0.3s ease;
    margin: 2px 0;
}

.hamburger-btn.active .hamburger-line:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.hamburger-btn.active .hamburger-line:nth-child(2) {
    opacity: 0;
}

.hamburger-btn.active .hamburger-line:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -5px);
}

/* Header scroll effects */
nav.scrolled {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

nav.header-hidden {
    transform: translateY(-100%);
}

/* Hide hamburger on desktop */
@media (min-width: 768px) {
    .hamburger-btn {
        display: none !important;
    }
}
</style>
