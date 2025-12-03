<?php
/**
 * Google OAuth Callback Handler
 * Du Lịch Trà Vinh
 */
session_start();

require_once '../config/database.php';
require_once '../config/oauth.php';
require_once '../models/User.php';

// Check for error from Google
if (isset($_GET['error'])) {
    $_SESSION['oauth_error'] = 'Đăng nhập Google bị hủy hoặc có lỗi xảy ra.';
    header('Location: ../dang-nhap.php');
    exit;
}

// Check for authorization code
if (!isset($_GET['code'])) {
    $_SESSION['oauth_error'] = 'Không nhận được mã xác thực từ Google.';
    header('Location: ../dang-nhap.php');
    exit;
}

try {
    // Exchange code for access token
    $tokenData = getGoogleAccessToken($_GET['code']);
    
    if (!isset($tokenData['access_token'])) {
        throw new Exception('Không thể lấy access token từ Google.');
    }
    
    // Get user info from Google
    $googleUser = getGoogleUserInfo($tokenData['access_token']);
    
    if (!isset($googleUser['email'])) {
        throw new Exception('Không thể lấy thông tin email từ Google.');
    }
    
    // Connect to database
    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);
    
    // Check if user exists with this email
    $existingUser = $userModel->findByEmail($googleUser['email']);
    
    if ($existingUser) {
        // User exists - update Google ID if not set
        if (empty($existingUser['google_id'])) {
            $userModel->updateOAuthId($existingUser['id'], 'google', $googleUser['id'], $googleUser['picture'] ?? null);
        }
        
        // Login user
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $existingUser['id'];
        $_SESSION['username'] = $existingUser['username'];
        $_SESSION['email'] = $existingUser['email'];
        $_SESSION['full_name'] = $existingUser['full_name'];
        $_SESSION['role'] = $existingUser['role'];
        $_SESSION['avatar_url'] = $googleUser['picture'] ?? $existingUser['avatar_url'] ?? null;
        $_SESSION['login_method'] = 'google';
        
        $_SESSION['oauth_success'] = 'Đăng nhập Google thành công! Chào mừng ' . $existingUser['full_name'];
        
    } else {
        // Create new user using model
        $username = explode('@', $googleUser['email'])[0] . '_' . substr(uniqid(), -4);
        $fullName = $googleUser['name'] ?? $username;
        
        $result = $userModel->createFromOAuth([
            'username' => $username,
            'email' => $googleUser['email'],
            'full_name' => $fullName,
            'google_id' => $googleUser['id'],
            'facebook_id' => null,
            'avatar_url' => $googleUser['picture'] ?? null
        ]);
        
        if ($result['success']) {
            $newUserId = $result['user_id'];
            
            // Login new user
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $newUserId;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $googleUser['email'];
            $_SESSION['full_name'] = $fullName;
            $_SESSION['role'] = 'user';
            $_SESSION['avatar_url'] = $googleUser['picture'] ?? null;
            $_SESSION['login_method'] = 'google';
            
            $_SESSION['oauth_success'] = '🎉 Tài khoản mới đã được tạo! Chào mừng ' . $fullName;
        } else {
            throw new Exception($result['message']);
        }
    }
    
    // Redirect to home page
    header('Location: ../index.php');
    exit;
    
} catch (Exception $e) {
    $_SESSION['oauth_error'] = 'Lỗi đăng nhập Google: ' . $e->getMessage();
    header('Location: ../dang-nhap.php');
    exit;
}
?>
