<?php
/**
 * Trang Đăng Ký
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
    <title>Đăng Ký - Du Lịch Trà Vinh</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/mobile-enhancements.css">
    <link rel="stylesheet" href="css/header-responsive-fix.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Top Navigation */
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
            color: #667eea;
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
            color: #667eea;
        }

        .nav-links a.active {
            color: #667eea;
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
            color: #6b7280;
            font-weight: 500;
        }

        .dropdown-toggle:hover {
            background: #f3f4f6;
            color: #667eea;
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
            color: #667eea;
            padding-left: 25px;
        }

        .dropdown-menu a i {
            width: 20px;
            text-align: center;
        }

        .register-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 80px);
            padding: 40px 20px;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .register-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-left h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .register-left p {
            font-size: 1.1em;
            line-height: 1.6;
            opacity: 0.9;
        }

        .register-left .icon {
            font-size: 5em;
            margin-bottom: 30px;
            opacity: 0.3;
        }

        .register-right {
            padding: 60px 40px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .register-right h2 {
            font-size: 2em;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .register-right .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
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
            padding: 12px 15px 12px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-register {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-register:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-home a {
            color: #6b7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .back-home a:hover {
            color: #667eea;
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
            .register-container {
                grid-template-columns: 1fr;
            }

            .register-left {
                display: none;
            }

            .register-right {
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
                <a href="dang-nhap.php">Đăng Nhập</a>
                
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

    <div class="register-wrapper">
        <div class="register-container">
        <!-- Left Side -->
        <div class="register-left">
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>Tham gia cùng chúng tôi!</h1>
            <p>Tạo tài khoản để trải nghiệm đầy đủ các dịch vụ du lịch Trà Vinh.</p>
        </div>

        <!-- Right Side - Register Form -->
        <div class="register-right">
            <h2>Đăng Ký</h2>
            <p class="subtitle">Tạo tài khoản mới</p>

            <div id="alert" class="alert"></div>

            <form id="registerForm">
                <div class="form-group">
                    <label>Họ và tên <span style="color: red;">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="full_name" id="full_name" required placeholder="Nhập họ và tên">
                    </div>
                </div>

                <div class="form-group">
                    <label>Tên đăng nhập <span style="color: red;">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-circle"></i>
                        <input type="text" name="username" id="username" required placeholder="Nhập tên đăng nhập">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email <span style="color: red;">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" required placeholder="Nhập email">
                    </div>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone"></i>
                        <input type="tel" name="phone" id="phone" placeholder="Nhập số điện thoại">
                    </div>
                </div>

                <div class="form-group">
                    <label>Mật khẩu <span style="color: red;">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" required placeholder="Nhập mật khẩu">
                    </div>
                </div>

                <div class="form-group">
                    <label>Xác nhận mật khẩu <span style="color: red;">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm_password" id="confirm_password" required placeholder="Nhập lại mật khẩu">
                    </div>
                </div>

                <button type="submit" class="btn-register" id="btnRegister">
                    <i class="fas fa-user-plus"></i> Đăng Ký
                </button>
            </form>

            <div class="login-link">
                Đã có tài khoản? <a href="dang-nhap.php">Đăng nhập ngay</a>
            </div>
        </div>
    </div>
    </div>

    <script>
        const registerForm = document.getElementById('registerForm');
        const btnRegister = document.getElementById('btnRegister');
        const alertBox = document.getElementById('alert');

        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const full_name = document.getElementById('full_name').value;
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;

            // Validate
            if (password !== confirm_password) {
                showAlert('error', 'Mật khẩu xác nhận không khớp!');
                return;
            }

            if (password.length < 6) {
                showAlert('error', 'Mật khẩu phải có ít nhất 6 ký tự!');
                return;
            }

            // Disable button
            btnRegister.disabled = true;
            btnRegister.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

            try {
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'register',
                        full_name: full_name,
                        username: username,
                        email: email,
                        phone: phone,
                        password: password
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('success', result.message + ' - Đang chuyển đến trang đăng nhập...');
                    setTimeout(() => {
                        window.location.href = 'dang-nhap.php';
                    }, 2000);
                } else {
                    showAlert('error', result.message);
                    btnRegister.disabled = false;
                    btnRegister.innerHTML = '<i class="fas fa-user-plus"></i> Đăng Ký';
                }
            } catch (error) {
                showAlert('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
                btnRegister.disabled = false;
                btnRegister.innerHTML = '<i class="fas fa-user-plus"></i> Đăng Ký';
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
