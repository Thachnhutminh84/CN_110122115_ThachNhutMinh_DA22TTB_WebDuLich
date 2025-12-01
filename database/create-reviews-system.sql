-- HỆ THỐNG ĐÁNH GIÁ & BÌNH LUẬN
-- Database: travinh_tourism

USE travinh_tourism;

-- Bảng đánh giá địa điểm
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    review_id VARCHAR(50) UNIQUE NOT NULL,
    attraction_id VARCHAR(50) NOT NULL,
    user_id INT,
    user_name VARCHAR(100) NOT NULL,
    user_email VARCHAR(100),
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(255),
    content TEXT NOT NULL,
    visit_date DATE,
    is_verified BOOLEAN DEFAULT FALSE,
    helpful_count INT DEFAULT 0,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_attraction (attraction_id),
    INDEX idx_user (user_id),
    INDEX idx_rating (rating),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng hình ảnh review
CREATE TABLE IF NOT EXISTS review_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    review_id VARCHAR(50) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (review_id) REFERENCES reviews(review_id) ON DELETE CASCADE,
    INDEX idx_review (review_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng helpful votes (người dùng vote review hữu ích)
CREATE TABLE IF NOT EXISTS review_helpful (
    id INT AUTO_INCREMENT PRIMARY KEY,
    review_id VARCHAR(50) NOT NULL,
    user_id INT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (review_id) REFERENCES reviews(review_id) ON DELETE CASCADE,
    UNIQUE KEY unique_vote (review_id, user_id, ip_address),
    INDEX idx_review (review_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng thống kê rating cho mỗi địa điểm
CREATE TABLE IF NOT EXISTS attraction_ratings (
    attraction_id VARCHAR(50) PRIMARY KEY,
    total_reviews INT DEFAULT 0,
    average_rating DECIMAL(3,2) DEFAULT 0.00,
    rating_5_star INT DEFAULT 0,
    rating_4_star INT DEFAULT 0,
    rating_3_star INT DEFAULT 0,
    rating_2_star INT DEFAULT 0,
    rating_1_star INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_avg_rating (average_rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Trigger tự động cập nhật thống kê khi có review mới
DELIMITER //

CREATE TRIGGER after_review_insert
AFTER INSERT ON reviews
FOR EACH ROW
BEGIN
    IF NEW.status = 'approved' THEN
        -- Cập nhật hoặc tạo mới thống kê
        INSERT INTO attraction_ratings (attraction_id, total_reviews, average_rating)
        VALUES (NEW.attraction_id, 1, NEW.rating)
        ON DUPLICATE KEY UPDATE
            total_reviews = total_reviews + 1,
            average_rating = (
                SELECT AVG(rating) 
                FROM reviews 
                WHERE attraction_id = NEW.attraction_id 
                AND status = 'approved'
            );
        
        -- Cập nhật số lượng theo từng sao
        UPDATE attraction_ratings
        SET 
            rating_5_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 5 AND status = 'approved'),
            rating_4_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 4 AND status = 'approved'),
            rating_3_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 3 AND status = 'approved'),
            rating_2_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 2 AND status = 'approved'),
            rating_1_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 1 AND status = 'approved')
        WHERE attraction_id = NEW.attraction_id;
    END IF;
END//

CREATE TRIGGER after_review_update
AFTER UPDATE ON reviews
FOR EACH ROW
BEGIN
    -- Cập nhật thống kê khi status thay đổi
    IF OLD.status != NEW.status OR OLD.rating != NEW.rating THEN
        UPDATE attraction_ratings
        SET 
            total_reviews = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND status = 'approved'),
            average_rating = (SELECT COALESCE(AVG(rating), 0) FROM reviews WHERE attraction_id = NEW.attraction_id AND status = 'approved'),
            rating_5_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 5 AND status = 'approved'),
            rating_4_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 4 AND status = 'approved'),
            rating_3_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 3 AND status = 'approved'),
            rating_2_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 2 AND status = 'approved'),
            rating_1_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = NEW.attraction_id AND rating = 1 AND status = 'approved')
        WHERE attraction_id = NEW.attraction_id;
    END IF;
END//

CREATE TRIGGER after_review_delete
AFTER DELETE ON reviews
FOR EACH ROW
BEGIN
    IF OLD.status = 'approved' THEN
        UPDATE attraction_ratings
        SET 
            total_reviews = (SELECT COUNT(*) FROM reviews WHERE attraction_id = OLD.attraction_id AND status = 'approved'),
            average_rating = (SELECT COALESCE(AVG(rating), 0) FROM reviews WHERE attraction_id = OLD.attraction_id AND status = 'approved'),
            rating_5_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = OLD.attraction_id AND rating = 5 AND status = 'approved'),
            rating_4_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = OLD.attraction_id AND rating = 4 AND status = 'approved'),
            rating_3_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = OLD.attraction_id AND rating = 3 AND status = 'approved'),
            rating_2_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = OLD.attraction_id AND rating = 2 AND status = 'approved'),
            rating_1_star = (SELECT COUNT(*) FROM reviews WHERE attraction_id = OLD.attraction_id AND rating = 1 AND status = 'approved')
        WHERE attraction_id = OLD.attraction_id;
    END IF;
END//

DELIMITER ;

-- Thêm dữ liệu mẫu
INSERT INTO reviews (review_id, attraction_id, user_name, user_email, rating, title, content, visit_date, status) VALUES
('REV001', 'ATTR001', 'Nguyễn Văn A', 'nguyenvana@gmail.com', 5, 'Tuyệt vời!', 'Địa điểm rất đẹp, không gian yên tĩnh. Rất phù hợp để tham quan và chụp ảnh.', '2024-11-01', 'approved'),
('REV002', 'ATTR001', 'Trần Thị B', 'tranthib@gmail.com', 4, 'Khá tốt', 'Nơi này khá đẹp nhưng hơi xa trung tâm. Nên đi vào buổi sáng sớm.', '2024-11-05', 'approved'),
('REV003', 'ATTR001', 'Lê Văn C', 'levanc@gmail.com', 5, 'Rất đáng để ghé thăm', 'Kiến trúc độc đáo, văn hóa Khmer đậm đà. Hướng dẫn viên nhiệt tình.', '2024-11-10', 'approved');

-- Khởi tạo thống kê cho các địa điểm hiện có
INSERT INTO attraction_ratings (attraction_id)
SELECT DISTINCT attraction_id FROM attractions
ON DUPLICATE KEY UPDATE attraction_id = attraction_id;
