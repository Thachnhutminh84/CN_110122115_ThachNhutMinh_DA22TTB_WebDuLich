<?php
/**
 * Kiểm tra và sửa mật khẩu users
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Kiểm Tra Mật Khẩu Users</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: #f3f4f6;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #1f2937;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 15px;
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
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #10b981;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #ef4444;
        }
        .info {
            background: #dbeafe;
            color: #1e40af;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #3b82f6;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px 5px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #2563eb;
        }
        .btn-danger {
            background: #ef4444;
        }
        .btn-danger:hover {
            background: #dc2626;
        }
        code {
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔐 Kiểm Tra Mật Khẩu Users</h1>";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Lấy tất cả users
    $stmt = $conn->query("SELECT * FROM app_users ORDER BY id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<div class='info'>
            <strong>📊 Tổng số users:</strong> " . count($users) . "
          </div>";
    
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Password Hash</th>
                <th>Trạng Thái</th>
            </tr>";
    
    $needFix = [];
    
    foreach ($users as $user) {
        $passwordHash = $user['password'];
        $isHashed = (strlen($passwordHash) >= 60 && strpos($passwordHash, '$2y$') === 0);
        
        $status = $isHashed ? '✅ Đã hash' : '❌ Chưa hash';
        $statusClass = $isHashed ? 'success' : 'error';
        
        if (!$isHashed) {
            $needFix[] = $user;
        }
        
        echo "<tr>
                <td>{$user['id']}</td>
                <td><strong>{$user['username']}</strong></td>
                <td>{$user['full_name']}</td>
                <td><code>{$user['role']}</code></td>
                <td><code>" . substr($passwordHash, 0, 30) . "...</code></td>
                <td><span style='color: " . ($isHashed ? '#10b981' : '#ef4444') . "'>{$status}</span></td>
              </tr>";
    }
    
    echo "</table>";
    
    // Nếu có users cần sửa
    if (count($needFix) > 0) {
        echo "<div class='error'>
                <h3>⚠️ Có " . count($needFix) . " users cần hash lại mật khẩu</h3>
                <p>Các users này có mật khẩu chưa được hash đúng cách.</p>
              </div>";
        
        echo "<form method='POST'>
                <h3>🔧 Sửa Mật Khẩu</h3>
                <p>Chọn mật khẩu mặc định cho các users chưa hash:</p>
                <input type='text' name='default_password' value='123456' style='padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; width: 200px;'>
                <button type='submit' name='fix_passwords' class='btn btn-danger'>
                    🔧 Hash Lại Mật Khẩu
                </button>
              </form>";
    } else {
        echo "<div class='success'>
                <h3>✅ Tất Cả Mật Khẩu Đã Được Hash Đúng Cách!</h3>
                <p>Bạn có thể đăng nhập bình thường.</p>
              </div>";
    }
    
    // Xử lý fix passwords
    if (isset($_POST['fix_passwords'])) {
        $defaultPassword = $_POST['default_password'];
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
        
        echo "<div class='info'><h3>🔄 Đang cập nhật mật khẩu...</h3></div>";
        
        foreach ($needFix as $user) {
            $stmt = $conn->prepare("UPDATE app_users SET password = :password WHERE id = :id");
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $user['id']);
            
            if ($stmt->execute()) {
                echo "<div class='success'>✅ Đã cập nhật mật khẩu cho: <strong>{$user['username']}</strong> → Mật khẩu mới: <code>$defaultPassword</code></div>";
            } else {
                echo "<div class='error'>❌ Lỗi cập nhật: {$user['username']}</div>";
            }
        }
        
        echo "<div class='success'>
                <h3>🎉 Hoàn Thành!</h3>
                <p>Tất cả mật khẩu đã được hash lại.</p>
                <a href='login.php' class='btn'>🔐 Đăng Nhập Ngay</a>
                <a href='check-users-password.php' class='btn'>🔄 Kiểm Tra Lại</a>
              </div>";
    }
    
    // Hiển thị thông tin đăng nhập
    echo "<div class='info'>
            <h3>📝 Thông Tin Đăng Nhập:</h3>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Mật Khẩu</th>
                    <th>Role</th>
                </tr>";
    
    foreach ($users as $user) {
        echo "<tr>
                <td><code>{$user['username']}</code></td>
                <td><code>123456</code> (mặc định)</td>
                <td><code>{$user['role']}</code></td>
              </tr>";
    }
    
    echo "</table>
          <p><strong>Lưu ý:</strong> Nếu mật khẩu không phải 123456, hãy reset lại bằng nút bên trên.</p>
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
