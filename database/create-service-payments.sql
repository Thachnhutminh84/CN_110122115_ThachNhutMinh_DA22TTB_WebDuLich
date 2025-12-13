-- Tạo bảng thanh toán cho dịch vụ
CREATE TABLE IF NOT EXISTS service_payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(50) NOT NULL UNIQUE,
    service_id VARCHAR(20),
    customer_name VARCHAR(255),
    customer_phone VARCHAR(20),
    customer_email VARCHAR(255),
    amount DECIMAL(15, 2) NOT NULL,
    payment_method ENUM('vnpay', 'momo', 'zalopay', 'bank_transfer', 'cash') DEFAULT 'vnpay',
    transaction_code VARCHAR(100),
    payment_status ENUM('pending', 'paid', 'failed', 'refunded', 'cancelled') DEFAULT 'pending',
    payment_date DATETIME,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_code) REFERENCES service_bookings(booking_code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm index
CREATE INDEX idx_booking_code ON service_payments(booking_code);
CREATE INDEX idx_payment_status ON service_payments(payment_status);
CREATE INDEX idx_payment_date ON service_payments(payment_date);
CREATE INDEX idx_customer_phone ON service_payments(customer_phone);
