-- Tạo bảng lưu thông tin xác nhận thanh toán
CREATE TABLE IF NOT EXISTS payment_confirmations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(50) NOT NULL,
    bank_name VARCHAR(100) NOT NULL,
    account_number VARCHAR(20) NOT NULL,
    account_name VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transfer_note VARCHAR(255),
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    verified_by INT NULL,
    verified_at TIMESTAMP NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_booking_code (booking_code),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu
INSERT INTO payment_confirmations (booking_code, bank_name, account_number, account_name, amount, transfer_note, status) VALUES
('SB20241210001', 'Vietcombank', '1234567890', 'NGUYEN VAN A', 500000, 'DV SB20241210001', 'verified'),
('SB20241210002', 'VietinBank', '9876543210', 'TRAN THI B', 1000000, 'DV SB20241210002', 'pending'),
('SB20241210003', 'BIDV', '5555666677', 'LE VAN C', 750000, 'DV SB20241210003', 'verified');
