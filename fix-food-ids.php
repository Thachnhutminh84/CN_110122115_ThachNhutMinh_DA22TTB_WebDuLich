<?php
/**
 * Sửa lại food_id - Bỏ số -2 ở cuối
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Sửa Food IDs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #1f2937;
            border-bottom: 3px solid #f5576c;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #10b981;
        }
        .info {
            background: #dbeafe;
            color: #1e40af;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #3b82f6;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #ef4444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background: #f9fafb;
            font-weight: 600;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #f5576c;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px 5px;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #f093fb;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 Sửa Food IDs</h1>";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<div class='info'>📋 Đang sửa food_id và food_type...</div>";
    
    // Đọc file SQL
    $sqlFile = 'database/fix-food-ids.sql';
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
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        
        if (empty($statement) || stripos($statement, 'SELECT') === 0) {
            continue;
        }
        
        try {
            $conn->exec($statement);
            $successCount++;
            
            if (stripos($statement, 'UPDATE foods') !== false) {
                preg_match("/food_id = '([^']+)' WHERE food_id = '([^']+)'/", $statement, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    echo "<div class='success'>✅ Foods: <code>{$matches[2]}</code> → <code>{$matches[1]}</code></div>";
                }
            } elseif (stripos($statement, 'UPDATE restaurants') !== false) {
                preg_match("/food_type = '([^']+)' WHERE food_type = '([^']+)'/", $statement, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    echo "<div class='success'>✅ Restaurants: <code>{$matches[2]}</code> → <code>{$matches[1]}</code></div>";
                }
            }
            
        } catch (PDOException $e) {
            // Bỏ qua lỗi nếu không có gì để update
            if (strpos($e->getMessage(), 'Rows matched: 0') === false) {
                echo "<div class='error'>❌ Lỗi: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    }
    
    echo "<div class='success'>
            <h3>🎉 Hoàn Thành!</h3>
            <p>✅ Đã sửa thành công <strong>$successCount</strong> câu lệnh</p>
          </div>";
    
    // Kiểm tra kết quả
    echo "<div class='info'>
            <h3>📊 Kiểm Tra Kết Quả:</h3>";
    
    $stmt = $conn->query("
        SELECT 
            f.food_id,
            f.name,
            COUNT(r.id) as so_quan
        FROM foods f
        LEFT JOIN restaurants r ON f.food_id = r.food_type
        WHERE f.food_id IN (
            'com-tam-suon-nuong',
            'hu-tieu-my-tho',
            'banh-mi-thit',
            'ca-phe-sua-da',
            'nuoc-mia',
            'tra-sua',
            'sinh-to-bo',
            'kem-dua',
            'banh-flan'
        )
        GROUP BY f.food_id, f.name
    ");
    
    echo "<table>
            <tr>
                <th>Food ID</th>
                <th>Tên Món</th>
                <th>Số Quán</th>
                <th>Trạng Thái</th>
            </tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $status = $row['so_quan'] > 0 ? '✅ OK' : '❌ Chưa có quán';
        $statusClass = $row['so_quan'] > 0 ? 'success' : 'error';
        
        echo "<tr>
                <td><code>" . htmlspecialchars($row['food_id']) . "</code></td>
                <td><strong>" . htmlspecialchars($row['name']) . "</strong></td>
                <td>" . $row['so_quan'] . "</td>
                <td><span style='color: " . ($row['so_quan'] > 0 ? '#10b981' : '#ef4444') . "'>" . $status . "</span></td>
              </tr>";
    }
    
    echo "</table></div>";
    
    echo "<div style='text-align: center; margin-top: 30px;'>
            <a href='tim-quan-an.php' class='btn'>🔍 Kiểm Tra Trang Tìm Quán</a>
            <a href='check-food-restaurant-match.php' class='btn'>📊 Xem Báo Cáo Đầy Đủ</a>
          </div>";
    
} catch (Exception $e) {
    echo "<div class='error'>
            <h3>❌ Lỗi:</h3>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
}

echo "    </div>
</body>
</html>";
?>
