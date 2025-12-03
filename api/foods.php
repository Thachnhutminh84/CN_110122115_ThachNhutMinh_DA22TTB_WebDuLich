<?php
/**
 * API Quản lý Món Ăn
 * Du Lịch Trà Vinh
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';
require_once '../models/Food.php';

// Lấy action từ request
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
$action = isset($data['action']) ? $data['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

try {
    $database = new Database();
    $db = $database->getConnection();
    $food = new Food($db);

    switch ($action) {
        case 'create':
            // Thêm món ăn mới
            $result = $food->create([
                'name' => $data['name'] ?? '',
                'category' => $data['category'] ?? '',
                'price' => $data['price'] ?? 0,
                'description' => $data['description'] ?? '',
                'image_url' => $data['image_url'] ?? '',
                'location' => $data['location'] ?? '',
                'ingredients' => $data['ingredients'] ?? ''
            ]);
            
            echo json_encode($result);
            break;

        case 'read':
            // Lấy danh sách món ăn
            $foods = $food->readAll();
            echo json_encode([
                'success' => true,
                'data' => $foods
            ]);
            break;

        case 'read_one':
            // Lấy chi tiết 1 món ăn
            $id = isset($data['id']) ? $data['id'] : (isset($_GET['id']) ? $_GET['id'] : 0);
            $foodData = $food->readOne($id);
            
            if ($foodData) {
                echo json_encode([
                    'success' => true,
                    'data' => $foodData
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy món ăn'
                ]);
            }
            break;

        case 'update':
            // Cập nhật món ăn
            $result = $food->update($data['id'], [
                'name' => $data['name'] ?? '',
                'category' => $data['category'] ?? '',
                'price' => $data['price'] ?? 0,
                'description' => $data['description'] ?? '',
                'image_url' => $data['image_url'] ?? '',
                'location' => $data['location'] ?? '',
                'ingredients' => $data['ingredients'] ?? ''
            ]);
            
            echo json_encode($result);
            break;

        case 'delete':
            // Xóa món ăn
            $id = isset($data['id']) ? $data['id'] : 0;
            $result = $food->delete($id);
            echo json_encode($result);
            break;

        case 'search':
            // Tìm kiếm món ăn
            $keyword = isset($data['keyword']) ? $data['keyword'] : (isset($_GET['keyword']) ? $_GET['keyword'] : '');
            $foods = $food->search($keyword);
            echo json_encode([
                'success' => true,
                'data' => $foods
            ]);
            break;

        case 'by_category':
            // Lấy món ăn theo danh mục
            $category = isset($data['category']) ? $data['category'] : (isset($_GET['category']) ? $_GET['category'] : '');
            $foods = $food->readByCategory($category);
            echo json_encode([
                'success' => true,
                'data' => $foods
            ]);
            break;

        case 'export':
            // Xuất dữ liệu
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="foods_export_' . date('Y-m-d') . '.csv"');
            
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            // Header
            fputcsv($output, ['ID', 'Tên món', 'Danh mục', 'Giá', 'Mô tả', 'Địa điểm', 'Hình ảnh']);
            
            // Data
            $foods = $food->readAll();
            foreach ($foods as $f) {
                fputcsv($output, [
                    $f['food_id'] ?? $f['id'],
                    $f['name'],
                    $f['category'],
                    $f['price'],
                    $f['description'],
                    $f['location'] ?? '',
                    $f['image_url'] ?? ''
                ]);
            }
            
            fclose($output);
            exit;

        default:
            // Mặc định: lấy tất cả
            if ($method === 'GET') {
                $foods = $food->readAll();
                echo json_encode([
                    'success' => true,
                    'data' => $foods
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Action không hợp lệ'
                ]);
            }
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi: ' . $e->getMessage()
    ]);
}
?>
