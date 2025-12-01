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

        default:
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
