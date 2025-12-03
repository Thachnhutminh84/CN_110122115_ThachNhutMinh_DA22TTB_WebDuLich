<?php
/**
 * Trang Cấu Hình OAuth - Google & Facebook
 * Du Lịch Trà Vinh
 */
session_start();

$configFile = '../config/oauth.php';
$message = '';
$messageType = '';

// Đọc cấu hình hiện tại
$currentConfig = [
    'google_client_id' => '',
    'google_client_secret' => '',
    'google_redirect_uri' => 'http://localhost/gioithieudulichtravinh/auth/google-callback.php',
    'facebook_app_id' => '',
    'facebook_app_secret' => '',
    'facebook_redirect_uri' => 'http://localhost/gioithieudulichtravinh/auth/facebook-callback.php'
];

if (file_exists($configFile)) {
    $content = file_get_contents($configFile);
    
    // Parse current values
    if (preg_match("/GOOGLE_CLIENT_ID',\s*'([^']+)'/", $content, $matches)) {
        $currentConfig['google_client_id'] = $matches[1];
    }
    if (preg_match("/GOOGLE_CLIENT_SECRET',\s*'([^']+)'/", $content, $matches)) {
        $currentConfig['google_client_secret'] = $matches[1];
    }
    if (preg_match("/GOOGLE_REDIRECT_URI',\s*'([^']+)'/", $content, $matches)) {
        $currentConfig['google_redirect_uri'] = $matches[1];
    }
    if (preg_match("/FACEBOOK_APP_ID',\s*'([^']+)'/", $content, $matches)) {
        $currentConfig['facebook_app_id'] = $matches[1];
    }
    if (preg_match("/FACEBOOK_APP_SECRET',\s*'([^']+)'/", $content, $matches)) {
        $currentConfig['facebook_app_secret'] = $matches[1];
    }
    if (preg_match("/FACEBOOK_REDIRECT_URI',\s*'([^']+)'/", $content, $matches)) {
        $currentConfig['facebook_redirect_uri'] = $matches[1];
    }
}

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $google_client_id = trim($_POST['google_client_id'] ?? '');
    $google_client_secret = trim($_POST['google_client_secret'] ?? '');
    $google_redirect_uri = trim($_POST['google_redirect_uri'] ?? '');
    $facebook_app_id = trim($_POST['facebook_app_id'] ?? '');
    $facebook_app_secret = trim($_POST['facebook_app_secret'] ?? '');
    $facebook_redirect_uri = trim($_POST['facebook_redirect_uri'] ?? '');
    
    // Tạo nội dung file config mới
    $configContent = '<?php
/**
 * OAuth Configuration - Google & Facebook Login
 * Du Lịch Trà Vinh
 * 
 * File này được tạo tự động bởi admin/oauth-config.php
 */

// Google OAuth Configuration
define(\'GOOGLE_CLIENT_ID\', \'' . addslashes($google_client_id) . '\');
define(\'GOOGLE_CLIENT_SECRET\', \'' . addslashes($google_client_secret) . '\');
define(\'GOOGLE_REDIRECT_URI\', \'' . addslashes($google_redirect_uri) . '\');

// Facebook OAuth Configuration  
define(\'FACEBOOK_APP_ID\', \'' . addslashes($facebook_app_id) . '\');
define(\'FACEBOOK_APP_SECRET\', \'' . addslashes($facebook_app_secret) . '\');
define(\'FACEBOOK_REDIRECT_URI\', \'' . addslashes($facebook_redirect_uri) . '\');

// OAuth URLs
define(\'GOOGLE_AUTH_URL\', \'https://accounts.google.com/o/oauth2/v2/auth\');
define(\'GOOGLE_TOKEN_URL\', \'https://oauth2.googleapis.com/token\');
define(\'GOOGLE_USERINFO_URL\', \'https://www.googleapis.com/oauth2/v2/userinfo\');

define(\'FACEBOOK_AUTH_URL\', \'https://www.facebook.com/v18.0/dialog/oauth\');
define(\'FACEBOOK_TOKEN_URL\', \'https://graph.facebook.com/v18.0/oauth/access_token\');
define(\'FACEBOOK_USERINFO_URL\', \'https://graph.facebook.com/me\');

/**
 * Generate Google OAuth URL
 */
function getGoogleAuthUrl() {
    $params = [
        \'client_id\' => GOOGLE_CLIENT_ID,
        \'redirect_uri\' => GOOGLE_REDIRECT_URI,
        \'response_type\' => \'code\',
        \'scope\' => \'email profile\',
        \'access_type\' => \'online\',
        \'prompt\' => \'select_account\'
    ];
    return GOOGLE_AUTH_URL . \'?\' . http_build_query($params);
}

/**
 * Generate Facebook OAuth URL
 */
function getFacebookAuthUrl() {
    $params = [
        \'client_id\' => FACEBOOK_APP_ID,
        \'redirect_uri\' => FACEBOOK_REDIRECT_URI,
        \'response_type\' => \'code\',
        \'scope\' => \'email,public_profile\'
    ];
    return FACEBOOK_AUTH_URL . \'?\' . http_build_query($params);
}

/**
 * Exchange code for Google access token
 */
function getGoogleAccessToken($code) {
    $params = [
        \'client_id\' => GOOGLE_CLIENT_ID,
        \'client_secret\' => GOOGLE_CLIENT_SECRET,
        \'redirect_uri\' => GOOGLE_REDIRECT_URI,
        \'code\' => $code,
        \'grant_type\' => \'authorization_code\'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, GOOGLE_TOKEN_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

/**
 * Get Google user info
 */
function getGoogleUserInfo($accessToken) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, GOOGLE_USERINFO_URL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [\'Authorization: Bearer \' . $accessToken]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

/**
 * Exchange code for Facebook access token
 */
function getFacebookAccessToken($code) {
    $params = [
        \'client_id\' => FACEBOOK_APP_ID,
        \'client_secret\' => FACEBOOK_APP_SECRET,
        \'redirect_uri\' => FACEBOOK_REDIRECT_URI,
        \'code\' => $code
    ];
    
    $url = FACEBOOK_TOKEN_URL . \'?\' . http_build_query($params);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

/**
 * Get Facebook user info
 */
function getFacebookUserInfo($accessToken) {
    $params = [
        \'fields\' => \'id,name,email,picture.type(large)\',
        \'access_token\' => $accessToken
    ];
    
    $url = FACEBOOK_USERINFO_URL . \'?\' . http_build_query($params);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}
?>';

    // Lưu file
    if (file_put_contents($configFile, $configContent)) {
        $message = 'Cấu hình đã được lưu thành công!';
        $messageType = 'success';
        
        // Cập nhật current config
        $currentConfig = [
            'google_client_id' => $google_client_id,
            'google_client_secret' => $google_client_secret,
            'google_redirect_uri' => $google_redirect_uri,
            'facebook_app_id' => $facebook_app_id,
            'facebook_app_secret' => $facebook_app_secret,
            'facebook_redirect_uri' => $facebook_redirect_uri
        ];
    } else {
        $message = 'Không thể lưu file cấu hình. Kiểm tra quyền ghi file.';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấu Hình OAuth - Du Lịch Trà Vinh</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .header p {
            opacity: 0.9;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            transition: all 0.3s;
        }
        .back-link:hover {
            background: rgba(255,255,255,0.3);
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        .card-header i {
            font-size: 2.5em;
        }
        .card-header.google i { color: #ea4335; }
        .card-header.facebook i { color: #1877f2; }
        .card-header h2 {
            font-size: 1.5em;
            color: #333;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-group small {
            display: block;
            margin-top: 6px;
            color: #888;
            font-size: 0.85em;
        }
        .btn-save {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .help-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .help-box h4 {
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .help-box ol {
            margin-left: 20px;
            color: #666;
        }
        .help-box li {
            margin-bottom: 8px;
        }
        .help-box a {
            color: #667eea;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        .status-configured {
            background: #d4edda;
            color: #155724;
        }
        .status-not-configured {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="../dang-nhap.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Quay lại Đăng Nhập
        </a>
        
        <div class="header">
            <h1><i class="fas fa-cog"></i> Cấu Hình OAuth</h1>
            <p>Thiết lập đăng nhập bằng Google và Facebook</p>
        </div>
        
        <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST">
            <!-- Google OAuth -->
            <div class="card">
                <div class="card-header google">
                    <i class="fab fa-google"></i>
                    <div>
                        <h2>Google OAuth</h2>
                        <?php if ($currentConfig['google_client_id'] && strpos($currentConfig['google_client_id'], 'YOUR_') === false): ?>
                        <span class="status-badge status-configured"><i class="fas fa-check"></i> Đã cấu hình</span>
                        <?php else: ?>
                        <span class="status-badge status-not-configured"><i class="fas fa-exclamation"></i> Chưa cấu hình</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Google Client ID</label>
                    <input type="text" name="google_client_id" 
                           value="<?php echo htmlspecialchars($currentConfig['google_client_id']); ?>"
                           placeholder="xxxxxx.apps.googleusercontent.com">
                    <small>Lấy từ Google Cloud Console > Credentials</small>
                </div>
                
                <div class="form-group">
                    <label>Google Client Secret</label>
                    <input type="password" name="google_client_secret" 
                           value="<?php echo htmlspecialchars($currentConfig['google_client_secret']); ?>"
                           placeholder="GOCSPX-xxxxxx">
                    <small>Client Secret từ Google Cloud Console</small>
                </div>
                
                <div class="form-group">
                    <label>Google Redirect URI</label>
                    <input type="text" name="google_redirect_uri" 
                           value="<?php echo htmlspecialchars($currentConfig['google_redirect_uri']); ?>">
                    <small>URL callback - thêm vào Authorized redirect URIs trong Google Console</small>
                </div>
                
                <div class="help-box">
                    <h4><i class="fas fa-question-circle"></i> Hướng dẫn lấy Google Credentials</h4>
                    <ol>
                        <li>Truy cập <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>
                        <li>Tạo project mới hoặc chọn project có sẵn</li>
                        <li>Vào <strong>APIs & Services</strong> > <strong>Credentials</strong></li>
                        <li>Click <strong>Create Credentials</strong> > <strong>OAuth client ID</strong></li>
                        <li>Chọn <strong>Web application</strong></li>
                        <li>Thêm Redirect URI ở trên vào <strong>Authorized redirect URIs</strong></li>
                        <li>Copy Client ID và Client Secret</li>
                    </ol>
                </div>
            </div>
            
            <!-- Facebook OAuth -->
            <div class="card">
                <div class="card-header facebook">
                    <i class="fab fa-facebook"></i>
                    <div>
                        <h2>Facebook Login</h2>
                        <?php if ($currentConfig['facebook_app_id'] && strpos($currentConfig['facebook_app_id'], 'YOUR_') === false): ?>
                        <span class="status-badge status-configured"><i class="fas fa-check"></i> Đã cấu hình</span>
                        <?php else: ?>
                        <span class="status-badge status-not-configured"><i class="fas fa-exclamation"></i> Chưa cấu hình</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Facebook App ID</label>
                    <input type="text" name="facebook_app_id" 
                           value="<?php echo htmlspecialchars($currentConfig['facebook_app_id']); ?>"
                           placeholder="123456789012345">
                    <small>Lấy từ Facebook Developers > Settings > Basic</small>
                </div>
                
                <div class="form-group">
                    <label>Facebook App Secret</label>
                    <input type="password" name="facebook_app_secret" 
                           value="<?php echo htmlspecialchars($currentConfig['facebook_app_secret']); ?>"
                           placeholder="xxxxxxxxxxxxxxxx">
                    <small>App Secret từ Facebook Developers</small>
                </div>
                
                <div class="form-group">
                    <label>Facebook Redirect URI</label>
                    <input type="text" name="facebook_redirect_uri" 
                           value="<?php echo htmlspecialchars($currentConfig['facebook_redirect_uri']); ?>">
                    <small>URL callback - thêm vào Valid OAuth Redirect URIs trong Facebook App</small>
                </div>
                
                <div class="help-box">
                    <h4><i class="fas fa-question-circle"></i> Hướng dẫn lấy Facebook Credentials</h4>
                    <ol>
                        <li>Truy cập <a href="https://developers.facebook.com/" target="_blank">Facebook Developers</a></li>
                        <li>Tạo App mới hoặc chọn App có sẵn</li>
                        <li>Vào <strong>Settings</strong> > <strong>Basic</strong> để lấy App ID và App Secret</li>
                        <li>Thêm sản phẩm <strong>Facebook Login</strong></li>
                        <li>Vào <strong>Facebook Login</strong> > <strong>Settings</strong></li>
                        <li>Thêm Redirect URI ở trên vào <strong>Valid OAuth Redirect URIs</strong></li>
                    </ol>
                </div>
            </div>
            
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Lưu Cấu Hình
            </button>
        </form>
    </div>
</body>
</html>
