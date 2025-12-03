<?php
/**
 * API xử lý đăng nhập và đăng ký
 */

header('Content-Type: application/json; charset=utf-8');
session_start();

require_once '../config/database.php';
require_once '../models/User.php';

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);
$action = isset($data['action']) ? $data['action'] : '';

try {
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    switch ($action) {
        case 'register':
            // Đăng ký tài khoản mới
            $result = $user->register($data);
            echo json_encode($result);
            break;

        case 'login':
            // Đăng nhập
            $result = $user->login($data['username'], $data['password']);
            
            if ($result['success']) {
                // Lưu thông tin vào session
                $_SESSION['user_id'] = $result['user']['id'];
                $_SESSION['username'] = $result['user']['username'];
                $_SESSION['full_name'] = $result['user']['full_name'];
                $_SESSION['email'] = $result['user']['email'];
                $_SESSION['role'] = $result['user']['role'];
                $_SESSION['logged_in'] = true;
            }
            
            echo json_encode($result);
            break;

        case 'logout':
            // Đăng xuất
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'Đăng xuất thành công']);
            break;

        case 'check_session':
            // Kiểm tra session
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                echo json_encode([
                    'success' => true,
                    'logged_in' => true,
                    'user' => [
                        'id' => $_SESSION['user_id'],
                        'username' => $_SESSION['username'],
                        'full_name' => $_SESSION['full_name'],
                        'email' => $_SESSION['email'],
                        'role' => $_SESSION['role']
                    ]
                ]);
            } else {
                echo json_encode(['success' => true, 'logged_in' => false]);
            }
            break;

        case 'social_login':
            // Đăng nhập bằng mạng xã hội (Google/Facebook)
            $provider = isset($data['provider']) ? $data['provider'] : '';
            $email = isset($data['email']) ? trim($data['email']) : '';
            $fullName = isset($data['full_name']) ? trim($data['full_name']) : '';
            
            if (empty($email) || empty($fullName)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
                break;
            }
            
            // Kiểm tra email hợp lệ
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
                break;
            }
            
            // Kiểm tra user đã tồn tại chưa
            $existingUser = $user->findByEmail($email);
            
            if ($existingUser) {
                // User đã tồn tại - đăng nhập
                $_SESSION['user_id'] = $existingUser['id'];
                $_SESSION['username'] = $existingUser['username'];
                $_SESSION['full_name'] = $existingUser['full_name'];
                $_SESSION['email'] = $existingUser['email'];
                $_SESSION['role'] = $existingUser['role'];
                $_SESSION['logged_in'] = true;
                $_SESSION['login_method'] = $provider;
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Đăng nhập ' . ucfirst($provider) . ' thành công! Chào mừng ' . $existingUser['full_name'],
                    'user' => [
                        'id' => $existingUser['id'],
                        'username' => $existingUser['username'],
                        'full_name' => $existingUser['full_name'],
                        'email' => $existingUser['email'],
                        'role' => $existingUser['role']
                    ]
                ]);
            } else {
                // Tạo user mới
                $username = explode('@', $email)[0] . '_' . substr(uniqid(), -4);
                
                $providerIdField = ($provider === 'google') ? 'google_id' : 'facebook_id';
                $providerId = $provider . '_' . uniqid();
                
                $result = $user->createFromOAuth([
                    'username' => $username,
                    'email' => $email,
                    'full_name' => $fullName,
                    'google_id' => ($provider === 'google') ? $providerId : null,
                    'facebook_id' => ($provider === 'facebook') ? $providerId : null,
                    'avatar_url' => null
                ]);
                
                if ($result['success']) {
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['full_name'] = $fullName;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = 'user';
                    $_SESSION['logged_in'] = true;
                    $_SESSION['login_method'] = $provider;
                    
                    echo json_encode([
                        'success' => true,
                        'message' => '🎉 Tài khoản mới đã được tạo! Chào mừng ' . $fullName,
                        'is_new' => true,
                        'user' => [
                            'id' => $result['user_id'],
                            'username' => $username,
                            'full_name' => $fullName,
                            'email' => $email,
                            'role' => 'user'
                        ]
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => $result['message']]);
                }
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
