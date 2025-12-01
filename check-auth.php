<?php
/**
 * File kiểm tra đăng nhập và phân quyền
 * Include file này ở đầu mỗi trang cần bảo vệ
 */

// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Kiểm tra đã đăng nhập chưa
 */
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Kiểm tra có phải admin không
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Kiểm tra có phải manager không
 */
function isManager() {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'manager';
}

/**
 * Kiểm tra có phải admin hoặc manager không
 */
function isAdminOrManager() {
    return isAdmin() || isManager();
}

/**
 * Kiểm tra có phải user thường không
 */
function isUser() {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}

/**
 * Yêu cầu đăng nhập - Chuyển đến trang đăng nhập nếu chưa đăng nhập
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: dang-nhap.php');
        exit;
    }
}

/**
 * Yêu cầu quyền admin - Chuyển đến trang chủ nếu không phải admin
 */
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: index.php');
        exit;
    }
}

/**
 * Yêu cầu quyền admin hoặc manager
 */
function requireAdminOrManager() {
    requireLogin();
    if (!isAdminOrManager()) {
        header('Location: index.php');
        exit;
    }
}

/**
 * Lấy thông tin user hiện tại
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'full_name' => $_SESSION['full_name'] ?? null,
        'email' => $_SESSION['email'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}

/**
 * Lấy tên vai trò bằng tiếng Việt
 */
function getRoleName($role = null) {
    if ($role === null) {
        $role = $_SESSION['role'] ?? 'user';
    }
    
    $roleNames = [
        'admin' => 'Quản trị viên',
        'manager' => 'Quản lý',
        'user' => 'Người dùng'
    ];
    
    return $roleNames[$role] ?? 'Người dùng';
}
?>
