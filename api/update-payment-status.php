<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
require_once '../config/database.php';

$response = ['success' => false, 'message' => ''];

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->status)) {
    $response['message'] = 'Thiếu thông tin';
    echo json_encode($response);
    exit;
}

try {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "UPDATE payment_confirmations 
              SET status = :status, 
                  verified_at = NOW(),
                  updated_at = NOW()
              WHERE id = :id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':status', $data->status);
    $stmt->bindParam(':id', $data->id);
    
    if ($stmt->execute()) {
        // Nếu xác nhận thành công, cập nhật trạng thái booking
        if ($data->status === 'verified') {
            $getBookingQuery = "SELECT booking_code FROM payment_confirmations WHERE id = :id";
            $getStmt = $db->prepare($getBookingQuery);
            $getStmt->bindParam(':id', $data->id);
            $getStmt->execute();
            $payment = $getStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($payment) {
                $updateBookingQuery = "UPDATE service_bookings 
                                      SET status = 'confirmed' 
                                      WHERE booking_code = :booking_code";
                $updateStmt = $db->prepare($updateBookingQuery);
                $updateStmt->bindParam(':booking_code', $payment['booking_code']);
                $updateStmt->execute();
            }
        }
        
        $response['success'] = true;
        $response['message'] = 'Cập nhật thành công';
    } else {
        $response['message'] = 'Không thể cập nhật';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
