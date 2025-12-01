<?php
/**
 * Import dữ liệu nhà hàng - Phiên bản đơn giản
 */

require_once 'config/database.php';

set_time_limit(300); // Tăng thời gian thực thi lên 5 phút

echo "<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Import Dữ Liệu Nhà Hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #1f2937;
            border-bottom: 3px solid #667eea;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 5px 0;
            border-left: 4px solid #10b981;
            font-size: 14px;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 5px 0;
            border-left: 4px solid #ef4444;
            font-size: 14px;
        }
        .info {
            background: #dbeafe;
            color: #1e40af;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #3b82f6;
        }
        .warning {
            background: #fef3c7;
            color: #78350f;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 5px 0;
            border-left: 4px solid #f59e0b;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px 5px;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #764ba2;
        }
        .log {
            max-height: 400px;
            overflow-y: auto;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🍽️ Import Dữ Liệu Nhà Hàng</h1>";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<div class='info'>📋 Bắt đầu import dữ liệu...</div>";
    echo "<div class='log'>";
    
    // Đọc file SQL
    $sqlFile = 'database/insert_restaurants_complete.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("Không tìm thấy file: $sqlFile");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // Loại bỏ comments và USE statement
    $sql = preg_replace('/^--.*$/m', '', $sql);
    $sql = preg_replace('/^USE .*;$/m', '', $sql);
    
    // Tách các câu lệnh
    $statements = explode(';', $sql);
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        
        // Bỏ qua câu lệnh rỗng
        if (empty($statement)) {
            continue;
        }
        
        try {
            $conn->exec($statement);
            $successCount++;
            
            // Hiển thị log
            if (stripos($statement, 'CREATE TABLE') !== false) {
                echo "<div class='success'>✅ Đã tạo bảng restaurants</div>";
            } elseif (stripos($statement, 'DELETE FROM') !== false) {
                echo "<div class='warning'>🗑️ Đã xóa dữ liệu cũ</div>";
            } elseif (stripos($statement, 'ALTER TABLE') !== false) {
                echo "<div class='success'>✅ Đã reset AUTO_INCREMENT</div>";
            } elseif (stripos($statement, 'INSERT INTO') !== false) {
                // Lấy tên nhà hàng
                if (preg_match("/VALUES\\s*\\('([^']+)',\\s*'([^']+)'/", $statement, $matches)) {
                    echo "<div class='success'>✅ Thêm: " . htmlspecialchars($matches[2]) . "</div>";
                }
            }
            
            flush();
            
        } catch (PDOException $e) {
            $errorCount++;
            $errorMsg = $e->getMessage();
            
            // Bỏ qua một số lỗi không quan trọng
            if (strpos($errorMsg, 'Duplicate entry') !== false) {
                echo "<div class='warning'>⚠️ Bỏ qua: Dữ liệu đã tồn tại</div>";
            } else {
                echo "<div class='error'>❌ Lỗi: " . htmlspecialchars($errorMsg) . "</div>";
            }
        }
    }
    
    echo "</div>"; // Close log
    
    echo "<div class='info'>
            <h3>🎉 Hoàn Thành!</h3>
            <p>✅ Thành công: <strong>$successCount</strong> câu lệnh</p>
            <p>❌ Lỗi: <strong>$errorCount</strong> câu lệnh</p>
          </div>";
    
    // Thống kê
    $stmt = $conn->query("SELECT COUNT(*) as total FROM restaurants");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "<div class='success'>
            <h3>📊 Kết Quả:</h3>
            <p><strong>Tổng số nhà hàng trong database:</strong> $total quán</p>
          </div>";
    
    // Hiển thị danh sách món ăn có quán
    $stmt = $conn->query("SELECT food_type, COUNT(*) as count FROM restaurants GROUP BY food_type ORDER BY food_type");
    
    echo "<div class='info'>
            <h3>📋 Danh Sách Món Ăn Có Quán:</h3>
            <ul style='columns: 2; column-gap: 20px;'>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li><strong>" . htmlspecialchars($row['food_type']) . ":</strong> " . $row['count'] . " quán</li>";
    }
    
    echo "</ul></div>";
    
    echo "<div style='text-align: center; margin-top: 30px;'>
            <a href='tim-quan-an.php' class='btn'>🔍 Xem Trang Tìm Quán Ăn</a>
            <a href='am-thuc.php' class='btn'>🍜 Trang Ẩm Thực</a>
          </div>";
    
} catch (Exception $e) {
    echo "<div class='error'>
            <h3>❌ Lỗi Nghiêm Trọng:</h3>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
}

echo "    </div>
</body>
</html>";
?>
