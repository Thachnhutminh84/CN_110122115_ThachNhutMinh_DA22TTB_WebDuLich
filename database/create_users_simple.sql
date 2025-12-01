-- =====================================================
-- TẠO BẢNG USERS ĐƠN GIẢN
-- Chạy file này trong phpMyAdmin
-- =====================================================

USE travinh_tourism;

-- Tạo bảng users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'manager', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm tài khoản Admin (mật khẩu: 123456)
INSERT INTO users (username, password, email, full_name, phone, role, status) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'admin@travinh.edu.vn', 'Quản Trị Viên', '0292.3855.246', 'admin', 'active');

-- Thêm tài khoản User (mật khẩu: 123456)
INSERT INTO users (username, password, email, full_name, phone, role, status) VALUES
('user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'user@example.com', 'Người Dùng', '0901234567', 'user', 'active');

-- Hiển thị kết quả
SELECT 'Đã tạo bảng users thành công!' AS status;
SELECT * FROM users;
