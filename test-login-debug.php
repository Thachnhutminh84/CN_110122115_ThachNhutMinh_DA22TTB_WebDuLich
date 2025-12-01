<?php
/**
 * Debug đăng nhập - Kiểm tra chi tiết
 */

require_once 'config/database.php';

// Test thông tin đăng nhập
$testUsername = 'Nhut Minh'; // Hoặc username bạn đang dùng
$testPassword = '123456'; // Mật khẩu bạn đang nhập

echo "<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Debug Đăng Nhập</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1000px;
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
            border-bottom: 3px solid #ef4444;
            padding-bottom: 15px;
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
        .warning {
            background: #fef3c7;
            color: #78350f;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #f59e0b;
        }
        code {
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }
        pre {
            background: #1f2937;
            color: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔍 Debug Đăng Nhập</h1>";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<div class='info'>
            <h3>📝 Thông Tin Test:</h3>
            <p><strong>Username:</strong> <code>$testUsername</code></p>
            <p><strong>Password:</strong> <code>$testPassword</code></p>
          </div>";
    
    // Bước 1: Tìm user trong database
    echo "<h2>Bước 1: Tìm User Trong Database</h2>";
    
    $query = "SELECT * FROM app_users 
             WHERE (username = :username OR email = :email)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $testUsername);
    $stmt->bindParam(':email', $testUsername);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<div class='success'>
                <h3>✅ Tìm Thấy User!</h3>
                <p><strong>ID:</strong> {$user['id']}</p>
                <p><strong>Username:</strong> {$user['username']}</p>
                <p><strong>Email:</strong> {$user['email']}</p>
                <p><strong>Full Name:</strong> {$user['full_name']}</p>
                <p><strong>Role:</strong> {$user['role']}</p>
                <p><strong>Status:</strong> {$user['status']}</p>
              </div>";
        
        // Bước 2: Kiểm tra status
        echo "<h2>Bước 2: Kiểm Tra Status</h2>";
        
        if ($user['status'] === 'active') {
            echo "<div class='success'>✅ Status: <code>active</code> - OK!</div>";
        } else {
            echo "<div class='error'>❌ Status: <code>{$user['status']}</code> - Tài khoản không active!</div>";
        }
        
        // Bước 3: Kiểm tra mật khẩu
        echo "<h2>Bước 3: Kiểm Tra Mật Khẩu</h2>";
        
        $passwordHash = $user['password'];
        echo "<div class='info'>
                <p><strong>Password Hash trong DB:</strong></p>
                <pre>$passwordHash</pre>
              </div>";
        
        // Kiểm tra định dạng hash
        $isValidHash = (strlen($passwordHash) >= 60 && strpos($passwordHash, '$2y$') === 0);
        
        if ($isValidHash) {
            echo "<div class='success'>✅ Password đã được hash đúng định dạng bcrypt</div>";
        } else {
            echo "<div class='error'>❌ Password CHƯA được hash đúng định dạng!</div>";
        }
        
        // Bước 4: Verify password
        echo "<h2>Bước 4: Verify Password</h2>";
        
        if (password_verify($testPassword, $passwordHash)) {
            echo "<div class='success'>
                    <h3>✅ MẬT KHẨU ĐÚNG!</h3>
                    <p>Password <code>$testPassword</code> khớp với hash trong database.</p>
                  </div>";
            
            echo "<div class='success'>
                    <h3>🎉 KẾT LUẬN: Đăng Nhập Sẽ THÀNH CÔNG!</h3>
                    <p>Thông tin đăng nhập:</p>
                    <ul>
                        <li><strong>Username:</strong> <code>{$user['username']}</code></li>
                        <li><strong>Password:</strong> <code>$testPassword</code></li>
                    </ul>
                    <a href='login.php' style='display: inline-block; padding: 12px 24px; background: #10b981; color: white; text-decoration: none; border-radius: 8px; margin-top: 10px;'>
                        🔐 Đăng Nhập Ngay
                    </a>
                  </div>";
        } else {
            echo "<div class='error'>
                    <h3>❌ MẬT KHẨU SAI!</h3>
                    <p>Password <code>$testPassword</code> KHÔNG khớp với hash trong database.</p>
                  </div>";
            
            echo "<div class='warning'>
                    <h3>🔧 Giải Pháp:</h3>
                    <p>Cần hash lại mật khẩu cho user này.</p>
                    <form method='POST'>
                        <p>Nhập mật khẩu mới:</p>
                        <input type='text' name='new_password' value='123456' style='padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; width: 200px;'>
                        <input type='hidden' name='user_id' value='{$user['id']}'>
                        <button type='submit' name='reset_password' style='padding: 10px 20px; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer; margin-left: 10px;'>
                            🔧 Reset Mật Khẩu
                        </button>
                    </form>
                  </div>";
        }
        
    } else {
        echo "<div class='error'>
                <h3>❌ KHÔNG TÌM THẤY USER!</h3>
                <p>Username hoặc email <code>$testUsername</code> không tồn tại trong database.</p>
              </div>";
        
        // Hiển thị tất cả users
        echo "<h2>📋 Danh Sách Users Trong Database:</h2>";
        
        $stmt = $conn->query("SELECT id, username, email, full_name, role, status FROM app_users");
        $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table style='width: 100%; border-collapse: collapse;'>
                <tr style='background: #f9fafb;'>
                    <th style='padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;'>ID</th>
                    <th style='padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;'>Username</th>
                    <th style='padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;'>Email</th>
                    <th style='padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;'>Full Name</th>
                    <th style='padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;'>Role</th>
                    <th style='padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;'>Status</th>
                </tr>";
        
        foreach ($allUsers as $u) {
            echo "<tr>
                    <td style='padding: 12px; border-bottom: 1px solid #e5e7eb;'>{$u['id']}</td>
                    <td style='padding: 12px; border-bottom: 1px solid #e5e7eb;'><code>{$u['username']}</code></td>
                    <td style='padding: 12px; border-bottom: 1px solid #e5e7eb;'>{$u['email']}</td>
                    <td style='padding: 12px; border-bottom: 1px solid #e5e7eb;'>{$u['full_name']}</td>
                    <td style='padding: 12px; border-bottom: 1px solid #e5e7eb;'><code>{$u['role']}</code></td>
                    <td style='padding: 12px; border-bottom: 1px solid #e5e7eb;'>{$u['status']}</td>
                  </tr>";
        }
        
        echo "</table>";
    }
    
    // Xử lý reset password
    if (isset($_POST['reset_password'])) {
        $userId = $_POST['user_id'];
        $newPassword = $_POST['new_password'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("UPDATE app_users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $userId);
        
        if ($stmt->execute()) {
            echo "<div class='success'>
                    <h3>✅ Đã Reset Mật Khẩu Thành Công!</h3>
                    <p><strong>Mật khẩu mới:</strong> <code>$newPassword</code></p>
                    <a href='test-login-debug.php' style='display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; margin-top: 10px;'>
                        🔄 Kiểm Tra Lại
                    </a>
                    <a href='login.php' style='display: inline-block; padding: 12px 24px; background: #10b981; color: white; text-decoration: none; border-radius: 8px; margin-top: 10px; margin-left: 10px;'>
                        🔐 Đăng Nhập
                    </a>
                  </div>";
        }
    }
    
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
