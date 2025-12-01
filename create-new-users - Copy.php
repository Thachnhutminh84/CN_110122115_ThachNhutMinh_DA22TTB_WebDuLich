<?php
/**
 * Tạo users mới: Nhựt Minh và Sóc Na
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Tạo Users Mới</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
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
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #764ba2;
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
        <h1>👥 Tạo Users Mới</h1>";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Mật khẩu đã hash
    $password = '123456';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // User 1: Nhựt Minh
    $username1 = 'nhutminh';
    $email1 = 'nhutminh@gmail.com';
    $fullName1 = 'Nhựt Minh';
    
    // User 2: Sóc Na
    $username2 = 'socna';
    $email2 = 'socna@gmail.com';
    $fullName2 = 'Sóc Na';
    
    echo "<div class='info'>
            <h3>📝 Thông Tin Users Sẽ Tạo:</h3>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Password</th>
                    <th>Role</th>
                </tr>
                <tr>
                    <td><code>$username1</code></td>
                    <td>$email1</td>
                    <td>$fullName1</td>
                    <td><code>$password</code></td>
                    <td>user</td>
                </tr>
                <tr>
                    <td><code>$username2</code></td>
                    <td>$email2</td>
                    <td>$fullName2</td>
                    <td><code>$password</code></td>
                    <td>user</td>
                </tr>
            </table>
          </div>";
    
    // Kiểm tra xem users đã tồn tại chưa
    $checkQuery = "SELECT username FROM app_users WHERE username IN (:user1, :user2)";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bindParam(':user1', $username1);
    $stmt->bindParam(':user2', $username2);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<div class='error'>
                <h3>⚠️ Users Đã Tồn Tại!</h3>
                <p>Một hoặc cả hai username đã có trong database.</p>
              </div>";
        
        // Hiển thị users hiện có
        $existing = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Users đã tồn tại: <code>" . implode(', ', $existing) . "</code></p>";
        
        // Cập nhật mật khẩu cho users đã tồn tại
        echo "<div class='info'>
                <h3>🔧 Cập Nhật Mật Khẩu</h3>
                <p>Đang cập nhật mật khẩu thành <code>123456</code> cho các users này...</p>
              </div>";
        
        foreach ($existing as $existingUser) {
            $updateQuery = "UPDATE app_users SET password = :password WHERE username = :username";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':username', $existingUser);
            
            if ($stmt->execute()) {
                echo "<div class='success'>✅ Đã cập nhật mật khẩu cho: <code>$existingUser</code></div>";
            }
        }
    }
    
    // Tạo User 1: Nhựt Minh
    $insertQuery = "INSERT INTO app_users (username, email, password, full_name, role, status) 
                   VALUES (:username, :email, :password, :full_name, 'user', 'active')
                   ON DUPLICATE KEY UPDATE password = :password2";
    
    $stmt = $conn->prepare($insertQuery);
    $stmt->bindParam(':username', $username1);
    $stmt->bindParam(':email', $email1);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':password2', $hashedPassword);
    $stmt->bindParam(':full_name', $fullName1);
    
    if ($stmt->execute()) {
        echo "<div class='success'>✅ Đã tạo/cập nhật user: <strong>$fullName1</strong></div>";
    }
    
    // Tạo User 2: Sóc Na
    $stmt = $conn->prepare($insertQuery);
    $stmt->bindParam(':username', $username2);
    $stmt->bindParam(':email', $email2);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':password2', $hashedPassword);
    $stmt->bindParam(':full_name', $fullName2);
    
    if ($stmt->execute()) {
        echo "<div class='success'>✅ Đã tạo/cập nhật user: <strong>$fullName2</strong></div>";
    }
    
    // Hiển thị kết quả
    echo "<div class='success'>
            <h3>🎉 Hoàn Thành!</h3>
            <p>Đã tạo thành công 2 users mới.</p>
          </div>";
    
    // Hiển thị thông tin đăng nhập
    echo "<div class='info'>
            <h3>🔐 Thông Tin Đăng Nhập:</h3>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Full Name</th>
                </tr>
                <tr>
                    <td><code>$username1</code></td>
                    <td><code>$password</code></td>
                    <td>$fullName1</td>
                </tr>
                <tr>
                    <td><code>$username2</code></td>
                    <td><code>$password</code></td>
                    <td>$fullName2</td>
                </tr>
            </table>
            <p><strong>Lưu ý:</strong> Sử dụng <code>username</code> để đăng nhập, không phải Full Name!</p>
          </div>";
    
    echo "<div style='text-align: center; margin-top: 30px;'>
            <a href='login.php' class='btn'>🔐 Đăng Nhập Ngay</a>
            <a href='test-login-debug.php' class='btn'>🔍 Kiểm Tra Debug</a>
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
