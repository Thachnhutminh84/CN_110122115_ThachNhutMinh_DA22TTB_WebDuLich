<?php
/**
 * Trang Đăng Nhập - Du Lịch Trà Vinh
 */
session_start();

// Nếu đã đăng nhập, chuyển về trang chủ
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Du Lịch Trà Vinh</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
        }

        /* Header Navigation */
        .top-nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #1f2937;
            font-size: 1.3em;
            font-weight: bold;
        }

        .logo i {
            color: #3b82f6;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #6b7280;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-links a:hover {
            color: #3b82f6;
        }

        .nav-links a.active {
            color: #3b82f6;
            font-weight: 600;
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .dropdown-toggle:hover {
            background: #f3f4f6;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 220px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 10px;
            margin-top: 10px;
            z-index: 1000;
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s;
            border-bottom: 1px solid #f3f4f6;
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a:hover {
            background: #f9fafb;
            color: #3b82f6;
            padding-left: 25px;
        }

        .dropdown-menu a i {
            width: 20px;
            text-align: center;
        }

        /* Login Container */
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 80px);
            padding: 40px 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            max-width: 450px;
            width: 100%;
            padding: 50px 40px;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 2em;
        }

        .login-container h2 {
            text-align: center;
            color: #1f2937;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .login-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-forgot label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            cursor: pointer;
            font-size: 0.95em;
        }

        .remember-forgot a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.95em;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            color: #9ca3af;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #e5e7eb;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .social-login {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .social-btn {
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .social-btn:hover {
            border-color: #d1d5db;
            background: #f9fafb;
        }

        .social-btn.google {
            color: #ea4335;
        }

        .social-btn.facebook {
            color: #1877f2;
        }

        .register-link {
            text-align: center;
            color: #6b7280;
        }

        .register-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        @media (max-width: 768px) {
            .nav-links {
                gap: 15px;
                font-size: 0.9em;
            }

            .login-container {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-home"></i>
                Trang Chủ
            </a>
            <div class="nav-links">
                <a href="index.php">Trang Chủ</a>
                <a href="dia-diem-du-lich-dynamic.php">Địa Điểm</a>
                <a href="am-thuc.php">Ẩm Thực</a>
                <a href="lien-he.php">Liên Hệ</a>
                <a href="dang-nhap.php" class="active">Đăng Nhập</a>
                
                <!-- Dropdown Quản Lý -->
                <div class="dropdown">
                    <div class="dropdown-toggle" onclick="toggleDropdown()">
                        <i class="fas fa-cog"></i>
                        <span>Quản Lý</span>
                        <i class="fas fa-chevron-down" style="font-size: 0.8em;"></i>
                    </div>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="quan-ly-users.php">
                            <i class="fas fa-users-cog"></i>
                            <span>Quản Lý Tài Khoản</span>
                        </a>
                        <a href="quan-ly-booking.php">
                            <i class="fas fa-calendar-check"></i>
                            <span>Quản Lý Booking</span>
                        </a>
                        <a href="quan-ly-lien-he.php">
                            <i class="fas fa-envelope-open-text"></i>
                            <span>Quản Lý Liên Hệ</span>
                        </a>
                        <a href="quan-ly-dia-diem.php">
                            <i class="fas fa-map-marked-alt"></i>
                            <span>Quản Lý Địa Điểm</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-icon">
                <i class="fas fa-user"></i>
            </div>

            <h2>Đăng Nhập</h2>
            <p class="login-subtitle">Truy cập vào tài khoản của bạn</p>

            <div id="alert" class="alert"></div>

            <form id="loginForm">
                <div class="form-group">
                    <label>Email hoặc Tên đăng nhập</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="username" required placeholder="Nhập email hoặc tên đăng nhập">
                    </div>
                </div>

                <div class="form-group">
                    <label>Mật khẩu</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" required placeholder="Nhập mật khẩu">
                    </div>
                </div>

                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember">
                        Ghi nhớ đăng nhập
                    </label>
                    <a href="#">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                </button>
            </form>

            <div class="divider">Hoặc đăng nhập với</div>

            <div class="social-login">
                <button class="social-btn google" onclick="alert('Chức năng đang phát triển')">
                    <i class="fab fa-google"></i> Google
                </button>
                <button class="social-btn facebook" onclick="alert('Chức năng đang phát triển')">
                    <i class="fab fa-facebook"></i> Facebook
                </button>
            </div>

            <div class="register-link">
                Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
            </div>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const btnLogin = document.getElementById('btnLogin');
        const alertBox = document.getElementById('alert');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Disable button
            btnLogin.disabled = true;
            btnLogin.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

            try {
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'login',
                        username: username,
                        password: password
                    })
                });

                const result = await response.json();

                if (result.success) {
                    // Kiểm tra nếu là tài khoản mới
                    if (result.is_new) {
                        showAlert('success', '🎉 ' + result.message + '\n✅ Tài khoản: ' + result.user.username + '\n📧 Email: ' + result.user.email);
                    } else {
                        showAlert('success', '✅ ' + result.message + ' - Đang chuyển hướng...');
                    }
                    
                    // Chuyển hướng dựa vào role
                    setTimeout(() => {
                        if (result.user.role === 'admin' || result.user.role === 'manager') {
                            window.location.href = 'quan-ly-users.php';
                        } else {
                            window.location.href = 'index.php';
                        }
                    }, result.is_new ? 3000 : 1500);
                } else {
                    showAlert('error', '❌ ' + result.message);
                    btnLogin.disabled = false;
                    btnLogin.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng Nhập';
                }
            } catch (error) {
                showAlert('error', '❌ Có lỗi xảy ra. Vui lòng thử lại!');
                btnLogin.disabled = false;
                btnLogin.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng Nhập';
            }
        });

        function showAlert(type, message) {
            alertBox.className = 'alert alert-' + type;
            alertBox.textContent = message;
            alertBox.style.display = 'block';

            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 5000);
        }

        // Toggle Dropdown Menu
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                const dropdown = document.getElementById('dropdownMenu');
                if (dropdown) {
                    dropdown.classList.remove('show');
                }
            }
        });
    </script>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>
