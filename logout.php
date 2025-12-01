<?php
/**
 * Trang Đăng Xuất
 * Xóa session và chuyển về trang chủ
 */

session_start();

// Xóa tất cả session variables
$_SESSION = array();

// Xóa session cookie nếu có
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Hủy session
session_destroy();

// Chuyển về trang đăng nhập với thông báo
header('Location: login.php?logout=success');
exit();
?>
