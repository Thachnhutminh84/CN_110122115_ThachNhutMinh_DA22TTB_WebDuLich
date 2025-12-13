<?php
/**
 * API quản lý thanh toán
 */
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once '../config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Lấy filter
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $method = isset($_GET['method']) ? $_GET['method'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';
    
    // Query thanh toán
    $query = "SELECT 
                bp.payment_id,
                bp.booking_id,
                bp.payment_date,
                bp.amount,
                bp.payment_method,
                bp.transaction_code,
                bp.payment_status,
                b.booking_code,
                b.customer_name
              FROM booking_payments bp
              LEFT JOIN bookings b ON bp.booking_id = b.booking_id
              WHERE 1=1";
    
    if ($status) {
        $query .= " AND bp.payment_status = :status";
    }
    if ($method) {
        $query .= " AND bp.payment_method = :method";
    }
    if ($date) {
        $query .= " AND DATE(bp.payment_date) = :date";
    }
    
    $query .= " ORDER BY bp.payment_date DESC LIMIT 100";
    
    $stmt = $db->prepare($query);
    
    if ($status) $stmt->bindParam(':status', $status);
    if ($method) $stmt->bindParam(':method', $method);
    if ($date) $stmt->bindParam(':date', $date);
    
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Thống kê
    $statsQuery = "SELECT 
                    SUM(CASE WHEN payment_status = 'paid' THEN amount ELSE 0 END) as total_revenue,
                    COUNT(CASE WHEN payment_status = 'paid' THEN 1 END) as paid_count,
                    COUNT(CASE WHEN payment_status = 'pending' THEN 1 END) as pending_count,
                    COUNT(CASE WHEN payment_status = 'failed' THEN 1 END) as failed_count
                   FROM booking_payments";
    
    $statsStmt = $db->query($statsQuery);
    $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $payments,
        'stats' => [
            'total_revenue' => (float)$stats['total_revenue'],
            'paid_count' => (int)$stats['paid_count'],
            'pending_count' => (int)$stats['pending_count'],
            'failed_count' => (int)$stats['failed_count']
        ]
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
