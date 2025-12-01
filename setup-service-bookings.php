<?php
/**
 * Script để tạo bảng service_bookings
 */

require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "Đang tạo bảng service_bookings...\n";
    
    // Đọc file SQL
    $sql = file_get_contents('database/create-service-bookings.sql');
    
    // Tách các câu lệnh SQL
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && strpos($stmt, '--') !== 0;
        }
    );
    
    // Thực thi từng câu lệnh
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $db->exec($statement);
            echo "✓ Đã thực thi: " . substr($statement, 0, 50) . "...\n";
        }
    }
    
    echo "\n✅ Tạo bảng service_bookings thành công!\n";
    echo "Bạn có thể xóa file này sau khi chạy xong.\n";
    
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "\n";
    exit(1);
}
?>
