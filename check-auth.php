<?php
/**
 * File kiểm tra xác thực và phân quyền
 */

// Kiểm tra đã đăng nhập chưa
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: dang-nhap.php');
        exit;
    }
}

// Kiểm tra quyền admin
function requireAdmin() {
    requireLogin();
    
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        die('Bạn không có quyền truy cập trang này!');
    }
}

// Kiểm tra quyền admin hoặc manager
function requireAdminOrManager() {
    requireLogin();
    
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'manager'])) {
        die('Bạn không có quyền truy cập trang này!');
    }
}

// Lấy thông tin user hiện tại
function getCurrentUser() {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    
    return [
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'] ?? '',
        'email' => $_SESSION['email'] ?? '',
        'full_name' => $_SESSION['full_name'] ?? '',
        'role' => $_SESSION['role'] ?? 'user'
    ];
}

// Kiểm tra có phải admin không
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Kiểm tra có phải manager không
function isManager() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'manager';
}

// Kiểm tra đã đăng nhập chưa
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Kiểm tra có phải admin hoặc manager không
function isAdminOrManager() {
    return isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'manager']);
}
?>
