<?php
header("Content-Type: application/json; charset=UTF-8");
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

$response = ['success' => false, 'message' => '', 'data' => null];

if (!$id) {
    $response['message'] = 'Thiếu ID';
    echo json_encode($response);
    exit;
}

try {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT * FROM payment_confirmations WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($payment) {
        $response['success'] = true;
        $response['data'] = $payment;
    } else {
        $response['message'] = 'Không tìm thấy';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
