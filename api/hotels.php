<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Lấy tất cả khách sạn từ bảng attractions
    $query = "SELECT id, name, location, contact, category 
              FROM attractions 
              WHERE category IS NOT NULL
              LIMIT 50";
    
    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception('Query error: ' . $conn->error);
    }
    
    $hotels = [];
    while ($row = $result->fetch_assoc()) {
        $hotels[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $hotels,
        'count' => count($hotels)
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi: ' . $e->getMessage()
    ]);
}
?>
