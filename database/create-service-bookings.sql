-- Tạo bảng service_bookings để lưu trữ đặt dịch vụ
CREATE TABLE IF NOT EXISTS service_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(50) UNIQUE NOT NULL,
    service_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_email VARCHAR(255),
    service_date DATE,
    number_of_people INT DEFAULT 1,
    number_of_days INT DEFAULT 1,
    special_requests TEXT,
    total_price DECIMAL(10, 2) DEFAULT 0,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm index để tăng tốc truy vấn
CREATE INDEX idx_booking_code ON service_bookings(booking_code);
CREATE INDEX idx_service_id ON service_bookings(service_id);
CREATE INDEX idx_status ON service_bookings(status);
CREATE INDEX idx_created_at ON service_bookings(created_at);
