<?php
/**
 * Facebook OAuth Callback Handler
 * Du Lịch Trà Vinh
 */
session_start();

require_once '../config/database.php';
require_once '../config/oauth.php';
require_once '../models/User.php';

// Check for error from Facebook
if (isset($_GET['error'])) {
    $_SESSION['oauth_error'] = 'Đăng nhập Facebook bị hủy hoặc có lỗi xảy ra.';
    header('Location: ../dang-nhap.php');
    exit;
}

// Check for authorization code
if (!isset($_GET['code'])) {
    $_SESSION['oauth_error'] = 'Không nhận được mã xác thực từ Facebook.';
    header('Location: ../dang-nhap.php');
    exit;
}

try {
    // Exchange code for access token
    $tokenData = getFacebookAccessToken($_GET['code']);
    
    if (!isset($tokenData['access_token'])) {
        throw new Exception('Không thể lấy access token từ Facebook.');
    }
    
    // Get user info from Facebook
    $fbUser = getFacebookUserInfo($tokenData['access_token']);
    
    if (!isset($fbUser['id'])) {
        throw new Exception('Không thể lấy thông tin từ Facebook.');
    }
    
    // Connect to database
    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);
    
    // Check if user exists with this Facebook ID or email
    $existingUser = $userModel->findByFacebookId($fbUser['id']);
    
    // If not found by FB ID, check by email (if email provided)
    if (!$existingUser && isset($fbUser['email'])) {
        $existingUser = $userModel->findByEmail($fbUser['email']);
    }
    
    $avatarUrl = isset($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : null;
    
    if ($existingUser) {
        // User exists - update Facebook ID if not set
        if (empty($existingUser['facebook_id'])) {
            $userModel->updateOAuthId($existingUser['id'], 'facebook', $fbUser['id'], $avatarUrl);
        }
        
        // Login user
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $existingUser['id'];
        $_SESSION['username'] = $existingUser['username'];
        $_SESSION['email'] = $existingUser['email'];
        $_SESSION['full_name'] = $existingUser['full_name'];
        $_SESSION['role'] = $existingUser['role'];
        $_SESSION['avatar_url'] = $avatarUrl ?? $existingUser['avatar_url'] ?? null;
        $_SESSION['login_method'] = 'facebook';
        
        $_SESSION['oauth_success'] = 'Đăng nhập Facebook thành công! Chào mừng ' . $existingUser['full_name'];
        
    } else {
        // Create new user using model
        $email = isset($fbUser['email']) ? $fbUser['email'] : $fbUser['id'] . '@facebook.com';
        $username = 'fb_' . $fbUser['id'];
        $fullName = $fbUser['name'] ?? 'Facebook User';
        
        $result = $userModel->createFromOAuth([
            'username' => $username,
            'email' => $email,
            'full_name' => $fullName,
            'google_id' => null,
            'facebook_id' => $fbUser['id'],
            'avatar_url' => $avatarUrl
        ]);
        
        if ($result['success']) {
            $newUserId = $result['user_id'];
            
            // Login new user
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $newUserId;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['full_name'] = $fullName;
            $_SESSION['role'] = 'user';
            $_SESSION['avatar_url'] = $avatarUrl;
            $_SESSION['login_method'] = 'facebook';
            
            $_SESSION['oauth_success'] = '🎉 Tài khoản mới đã được tạo! Chào mừng ' . $fullName;
        } else {
            throw new Exception($result['message']);
        }
    }
    
    // Redirect to home page
    header('Location: ../index.php');
    exit;
    
} catch (Exception $e) {
    $_SESSION['oauth_error'] = 'Lỗi đăng nhập Facebook: ' . $e->getMessage();
    header('Location: ../dang-nhap.php');
    exit;
}
?>
