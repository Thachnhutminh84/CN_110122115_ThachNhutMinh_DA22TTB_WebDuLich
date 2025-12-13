<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
require_once '../config/database.php';

$response = ['success' => false, 'message' => ''];

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    $response['message'] = 'Thiếu ID';
    echo json_encode($response);
    exit;
}

try {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "DELETE FROM payment_confirmations WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $data->id);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Xóa thành công';
    } else {
        $response['message'] = 'Không thể xóa';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
