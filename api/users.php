<?php
/**
 * API quản lý users
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
        case 'get_user':
            // Lấy thông tin user
            $userId = $data['user_id'];
            $userData = $user->getUserById($userId);
            
            if ($userData) {
                echo json_encode(['success' => true, 'user' => $userData]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy user']);
            }
            break;

        case 'update_status':
            // Cập nhật trạng thái user
            $userId = $data['user_id'];
            $status = $data['status'];
            
            if ($user->updateStatus($userId, $status)) {
                $statusName = $status === 'banned' ? 'khóa' : 'mở khóa';
                echo json_encode(['success' => true, 'message' => 'Đã ' . $statusName . ' tài khoản thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Cập nhật trạng thái thất bại']);
            }
            break;

        case 'update':
            // Cập nhật thông tin user
            $userId = $data['user_id'];
            $updateData = [
                'username' => $data['username'] ?? null,
                'email' => $data['email'] ?? null,
                'full_name' => $data['full_name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'role' => $data['role'] ?? null,
                'status' => $data['status'] ?? null,
                'password' => $data['password'] ?? null
            ];
            
            // Loại bỏ các giá trị null
            $updateData = array_filter($updateData, function($value) {
                return $value !== null;
            });
            
            $result = $user->updateUser($userId, $updateData);
            echo json_encode($result);
            break;

        case 'delete':
            // Xóa user
            $userId = $data['user_id'];
            
            if ($user->deleteUser($userId)) {
                echo json_encode(['success' => true, 'message' => 'Đã xóa tài khoản thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Xóa tài khoản thất bại']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
