-- Tạo bảng payment_confirmations cho dịch vụ
-- Chạy file này nếu bảng chưa tồn tại

CREATE TABLE IF NOT EXISTS payment_confirmations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(50) NOT NULL UNIQUE,
    bank_name VARCHAR(100),
    account_number VARCHAR(50),
    account_name VARCHAR(100),
    amount DECIMAL(12, 2),
    status ENUM('pending', 'confirmed', 'rejected') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_booking_code (booking_code),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm cột nếu chưa có
ALTER TABLE payment_confirmations 
ADD COLUMN IF NOT EXISTS payer_name VARCHAR(100),
ADD COLUMN IF NOT EXISTS payer_email VARCHAR(100),
ADD COLUMN IF NOT EXISTS payer_phone VARCHAR(20);
