<?php
/**
 * Test thêm địa điểm trực tiếp
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <title>Thêm Địa Điểm Mới</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin: 10px 0; }
        .error { background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin: 10px 0; }
        .info { background: #dbeafe; color: #1e40af; padding: 15px; border-radius: 8px; margin: 10px 0; }
        form { background: #f9fafb; padding: 20px; border-radius: 8px; }
        input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; border: 2px solid #e5e7eb; border-radius: 5px; }
        button { background: #10b981; color: white; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }
        button:hover { background: #059669; }
        .btn-back { display: inline-block; background: #6b7280; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; margin-bottom: 20px; }
        .btn-back:hover { background: #4b5563; }
    </style>
</head>
<body>
    <a href='dia-diem-du-lich-dynamic.php' class='btn-back'>← Quay Về Trang Địa Điểm</a>
    <h1>➕ Thêm Địa Điểm Mới</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = new Database();
        $conn = $database->getConnection();
        
        $name = $_POST['name'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        
        // Tạo attraction_id
        $attraction_id = strtolower($name);
        $attraction_id = preg_replace('/[^a-z0-9]+/', '-', $attraction_id);
        $attraction_id = trim($attraction_id, '-') . '-' . time();
        
        echo "<div class='info'>
                <strong>Dữ liệu nhận được:</strong><br>
                - Tên: $name<br>
                - Mô tả: $description<br>
                - Địa chỉ: $location<br>
                - Danh mục: $category<br>
                - Giá: $price<br>
                - ID: $attraction_id
              </div>";
        
        $query = "INSERT INTO attractions 
                 (attraction_id, name, description, location, category, ticket_price, status) 
                 VALUES 
                 (:attraction_id, :name, :description, :location, :category, :ticket_price, 'active')";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':attraction_id', $attraction_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':ticket_price', $price);
        
        if ($stmt->execute()) {
            echo "<div class='success'>
                    <h3>✅ Thêm địa điểm thành công!</h3>
                    <p>ID: <code>$attraction_id</code></p>
                    <p>Đang chuyển về trang địa điểm...</p>
                  </div>
                  <script>
                    setTimeout(function() {
                        window.location.href = 'dia-diem-du-lich-dynamic.php';
                    }, 2000);
                  </script>";
        } else {
            echo "<div class='error'>❌ Không thể thêm vào database</div>";
        }
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ Lỗi: " . $e->getMessage() . "</div>";
    }
}

echo "<form method='POST'>
        <h3>Thêm Địa Điểm Mới</h3>
        
        <label>Tên Địa Điểm *</label>
        <input type='text' name='name' required placeholder='VD: Chùa Âng'>
        
        <label>Mô Tả *</label>
        <textarea name='description' rows='4' required placeholder='Mô tả chi tiết...'></textarea>
        
        <label>Địa Chỉ *</label>
        <input type='text' name='location' required placeholder='VD: TP. Trà Vinh'>
        
        <label>Danh Mục</label>
        <select name='category'>
            <option value='temple'>Chùa</option>
            <option value='historical'>Lịch sử</option>
            <option value='cultural'>Văn hóa</option>
            <option value='nature'>Thiên nhiên</option>
            <option value='beach'>Biển</option>
        </select>
        
        <label>Giá Vé</label>
        <input type='text' name='price' placeholder='VD: Miễn phí' value='Miễn phí'>
        
        <button type='submit'>➕ Thêm Địa Điểm</button>
      </form>
</body>
</html>";
?>
