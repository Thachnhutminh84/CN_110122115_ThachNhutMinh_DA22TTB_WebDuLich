<?php
/**
 * Test Service Bookings - Kiểm tra và tạo dữ liệu mẫu
 */

require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<h2>🔍 Kiểm tra bảng services</h2>";
    
    // Kiểm tra bảng services
    $query = "SELECT * FROM services";
    $stmt = $db->query($query);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($services)) {
        echo "<p style='color: orange;'>⚠️ Bảng services chưa có dữ liệu. Đang thêm dữ liệu mẫu...</p>";
        
        // Thêm dữ liệu mẫu cho bảng services
        $insertServices = "
            INSERT INTO services (service_id, service_name, service_type, description, icon, price_from, price_to) VALUES
            (1, 'Lập Kế Hoạch Tour Du Lịch - Tour 1 Ngày', 'tour', 'Dịch vụ tư vấn và thiết kế hành trình du lịch chuyên nghiệp', 'fa-route', 500000, 500000),
            (2, 'Đặt Phòng Khách Sạn - Khách Sạn 2-3 Sao', 'hotel', 'Hỗ trợ đặt phòng tại các khách sạn uy tín', 'fa-hotel', 300000, 600000),
            (3, 'Thuê Xe Du Lịch - Xe 4-7 Chỗ', 'car', 'Dịch vụ cho thuê xe du lịch với tài xế kinh nghiệm', 'fa-car', 800000, 1200000),
            (4, 'Hỗ Trợ Khách Hàng 24/7 - Hỗ Trợ Cơ Bản', 'support', 'Đội ngũ hỗ trợ khách hàng chuyên nghiệp', 'fa-headset', 0, 0)
            ON DUPLICATE KEY UPDATE service_name = VALUES(service_name)
        ";
        
        $db->exec($insertServices);
        echo "<p style='color: green;'>✅ Đã thêm dữ liệu mẫu vào bảng services</p>";
    } else {
        echo "<p style='color: green;'>✅ Bảng services đã có " . count($services) . " dịch vụ</p>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Tên dịch vụ</th><th>Loại</th></tr>";
        foreach ($services as $service) {
            echo "<tr>";
            echo "<td>" . $service['service_id'] . "</td>";
            echo "<td>" . htmlspecialchars($service['service_name']) . "</td>";
            echo "<td>" . $service['service_type'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<hr>";
    echo "<h2>🔍 Kiểm tra bảng service_bookings</h2>";
    
    // Kiểm tra bảng service_bookings
    $checkTable = "SHOW TABLES LIKE 'service_bookings'";
    $result = $db->query($checkTable);
    
    if ($result->rowCount() == 0) {
        echo "<p style='color: red;'>❌ Bảng service_bookings chưa tồn tại!</p>";
        echo "<p>Vui lòng chạy SQL trong file: <strong>database/create-service-bookings.sql</strong></p>";
    } else {
        echo "<p style='color: green;'>✅ Bảng service_bookings đã tồn tại</p>";
        
        // Lấy danh sách bookings
        $query = "SELECT sb.*, s.service_name, s.service_type 
                  FROM service_bookings sb
                  LEFT JOIN services s ON sb.service_id = s.service_id
                  ORDER BY sb.created_at DESC";
        $stmt = $db->query($query);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<p>Số lượng booking: <strong>" . count($bookings) . "</strong></p>";
        
        if (!empty($bookings)) {
            echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
            echo "<tr><th>Mã đặt</th><th>Dịch vụ</th><th>Khách hàng</th><th>SĐT</th><th>Trạng thái</th><th>Ngày tạo</th></tr>";
            foreach ($bookings as $booking) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($booking['booking_code']) . "</td>";
                echo "<td>" . htmlspecialchars($booking['service_name']) . "</td>";
                echo "<td>" . htmlspecialchars($booking['customer_name']) . "</td>";
                echo "<td>" . htmlspecialchars($booking['customer_phone']) . "</td>";
                echo "<td>" . $booking['status'] . "</td>";
                echo "<td>" . $booking['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
    echo "<hr>";
    echo "<h2>🧪 Test API</h2>";
    echo "<p>Bạn có thể test API bằng cách:</p>";
    echo "<ol>";
    echo "<li>Mở trang chủ và click vào một dịch vụ</li>";
    echo "<li>Điền form và gửi yêu cầu</li>";
    echo "<li>Kiểm tra trang <a href='quan-ly-dich-vu.php' target='_blank'>Quản lý dịch vụ</a></li>";
    echo "</ol>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
?>
