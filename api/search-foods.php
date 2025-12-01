<?php
/**
 * API Search Foods - Tìm kiếm món ăn
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once '../config/database.php';
require_once '../models/Food.php';

try {
    // Lấy từ khóa tìm kiếm
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

    if (empty($keyword)) {
        echo json_encode([
            'success' => false,
            'message' => 'Vui lòng nhập từ khóa tìm kiếm',
            'foods' => []
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Kết nối database
    $database = new Database();
    $db = $database->getConnection();
    $food = new Food($db);

    // Tìm kiếm món ăn
    $stmt = $food->search($keyword);
    $foods = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $foods[] = [
            'id' => $row['id'],
            'food_id' => $row['food_id'],
            'name' => $row['name'],
            'name_khmer' => $row['name_khmer'] ?? '',
            'category' => $row['category'],
            'description' => $row['description'],
            'ingredients' => $row['ingredients'] ?? '',
            'price_range' => $row['price_range'],
            'image_url' => $row['image_url'],
            'origin' => $row['origin'] ?? '',
            'best_time' => $row['best_time'] ?? '',
            'status' => $row['status']
        ];
    }

    // Trả về kết quả
    echo json_encode([
        'success' => true,
        'message' => 'Tìm thấy ' . count($foods) . ' món ăn',
        'keyword' => $keyword,
        'total' => count($foods),
        'foods' => $foods
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi: ' . $e->getMessage(),
        'foods' => []
    ], JSON_UNESCAPED_UNICODE);
}
?>
