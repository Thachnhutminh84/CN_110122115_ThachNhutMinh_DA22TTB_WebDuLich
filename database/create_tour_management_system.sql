USE travinh_tourism;

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
    
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

USE travinh_tourism;

CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(20) UNIQUE NOT NULL,
    schedule_id INT NOT NULL, 
    user_id INT,             
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address VARCHAR(255),
    num_adults INT NOT NULL,
    num_children INT DEFAULT 0,
    num_infants INT DEFAULT 0,
    total_price DECIMAL(15, 2) NOT NULL,
    special_requests TEXT,
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
    booking_status ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    booking_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    confirmed_at DATETIME,
    notes TEXT
    -- Không khai báo Khóa ngoại ở đây
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng tour_reviews
CREATE TABLE tour_reviews (
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
    
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id),
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng tour_pricing
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
    
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng booking_payments
CREATE TABLE booking_payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT UNIQUE NOT NULL,
    payment_date DATETIME NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    transaction_code VARCHAR(100),
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') NOT NULL,
    notes TEXT,
    
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

USE travinh_tourism;

CREATE TABLE tour_attractions (
    tour_id INT NOT NULL,
    attraction_id VARCHAR(50) NOT NULL,
    visit_order INT NOT NULL,
    visit_duration VARCHAR(50),
    
    PRIMARY KEY (tour_id, attraction_id)
    -- Tạm thời không cần khóa ngoại nếu chúng là nguyên nhân gây lỗi #1005
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;