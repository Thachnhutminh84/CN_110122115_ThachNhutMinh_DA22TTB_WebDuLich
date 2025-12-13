-- =====================================================
-- TẠO BẢNG TOURS
-- Chạy file này TRƯỚC KHI chạy insert-tours-data.sql
-- =====================================================

USE travinh_tourism;

-- Xóa bảng cũ nếu có (cẩn thận với dữ liệu)
DROP TABLE IF EXISTS tour_pricing;
DROP TABLE IF EXISTS tour_attractions;
DROP TABLE IF EXISTS tour_schedules;
DROP TABLE IF EXISTS tour_reviews;
DROP TABLE IF EXISTS tours;

-- Tạo bảng tours
CREATE TABLE tours (
    tour_id INT AUTO_INCREMENT PRIMARY KEY,
    tour_name VARCHAR(255) NOT NULL,
    description TEXT,
    duration_days INT NOT NULL,
    base_price DECIMAL(10, 2) NOT NULL,
    max_participants INT NOT NULL,
    itinerary TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng tour_schedules
CREATE TABLE tour_schedules (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    departure_date DATE NOT NULL,
    departure_time TIME DEFAULT '07:00:00',
    return_date DATE,
    return_time TIME,
    available_slots INT NOT NULL,
    guide_name VARCHAR(100),
    guide_phone VARCHAR(20),
    meeting_point VARCHAR(255) DEFAULT 'Trường Đại học Trà Vinh',
    status ENUM('scheduled', 'confirmed', 'completed', 'cancelled') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng tour_attractions (liên kết tour với địa điểm)
CREATE TABLE tour_attractions (
    tour_id INT NOT NULL,
    attraction_id VARCHAR(50) NOT NULL,
    visit_order INT NOT NULL,
    visit_duration VARCHAR(50),
    
    PRIMARY KEY (tour_id, attraction_id),
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng tour_pricing (giá theo mùa)
CREATE TABLE tour_pricing (
    pricing_id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    season_name VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    adult_price DECIMAL(10, 2) NOT NULL,
    child_price DECIMAL(10, 2) DEFAULT 0,
    infant_price DECIMAL(10, 2) DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng tour_reviews (đánh giá tour)
CREATE TABLE IF NOT EXISTS tour_reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT UNIQUE, 
    tour_id INT NOT NULL,
    user_id INT, 
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_title VARCHAR(255),
    review_content TEXT,
    pros TEXT,
    cons TEXT,
    is_verified BOOLEAN DEFAULT FALSE,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo index để tăng tốc truy vấn
CREATE INDEX idx_tour_status ON tours(status);
CREATE INDEX idx_schedule_date ON tour_schedules(departure_date);
CREATE INDEX idx_schedule_status ON tour_schedules(status);
CREATE INDEX idx_pricing_dates ON tour_pricing(start_date, end_date);

SELECT '✅ ĐÃ TẠO BẢNG TOURS THÀNH CÔNG!' as status;

-- Hiển thị cấu trúc bảng
SHOW TABLES LIKE 'tour%';
DESCRIBE tours;
