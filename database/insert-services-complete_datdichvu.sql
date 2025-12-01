-- =============================================
-- DỮ LIỆU ĐẦY ĐỦ - HỆ THỐNG DỊCH VỤ DU LỊCH
-- =============================================

USE travinh_tourism;

-- =============================================
-- 1. TẠO BẢNG DỊCH VỤ
-- =============================================

CREATE TABLE IF NOT EXISTS services (
    service_id VARCHAR(20) PRIMARY KEY,
    service_name VARCHAR(200) NOT NULL,
    service_type ENUM('tour', 'hotel', 'car', 'support') NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    price_from DECIMAL(15,2) DEFAULT 0,
    price_to DECIMAL(15,2) DEFAULT 0,
    unit VARCHAR(50),
    features TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 2. INSERT DỊCH VỤ
-- =============================================

TRUNCATE TABLE services;

-- DỊCH VỤ TOUR
INSERT INTO services VALUES
('SV001', 'Lập Kế Hoạch Tour 1 Ngày', 'tour', 'Tư vấn thiết kế hành trình 1 ngày', 'fa-route', 500000, 2000000, 'tour', 'Tư vấn miễn phí|Thiết kế lịch trình|Gợi ý địa điểm', TRUE, NOW()),
('SV002', 'Lập Kế Hoạch Tour 2-3 Ngày', 'tour', 'Thiết kế tour 2-3 ngày khám phá Trà Vinh', 'fa-route', 1500000, 5000000, 'tour', 'Lịch trình chi tiết|Đặt khách sạn|Gợi ý nhà hàng', TRUE, NOW()),
('SV003', 'Tour Trọn Gói All-Inclusive', 'tour', 'Tour trọn gói bao gồm tất cả', 'fa-route', 5000000, 15000000, 'tour', 'Vé máy bay|Khách sạn 5 sao|Ăn uống|Hướng dẫn viên', TRUE, NOW());

-- DỊCH VỤ KHÁCH SẠN
INSERT INTO services VALUES
('SV004', 'Đặt Phòng Khách Sạn 2-3 Sao', 'hotel', 'Khách sạn 2-3 sao giá tốt', 'fa-hotel', 300000, 800000, 'đêm', 'Giá tốt|Vị trí trung tâm|Wifi|Bữa sáng', TRUE, NOW()),
('SV005', 'Đặt Phòng Khách Sạn 4-5 Sao', 'hotel', 'Khách sạn cao cấp 4-5 sao', 'fa-hotel', 1000000, 3000000, 'đêm', 'Dịch vụ 5 sao|Spa|Hồ bơi|Nhà hàng', TRUE, NOW()),
('SV006', 'Đặt Phòng Homestay & Resort', 'hotel', 'Homestay gần biển', 'fa-hotel', 500000, 1500000, 'đêm', 'Gần biển|Không gian riêng|Giá hợp lý', TRUE, NOW());

-- DỊCH VỤ THUÊ XE
INSERT INTO services VALUES
('SV007', 'Thuê Xe 4-7 Chỗ', 'car', 'Xe 4-7 chỗ với tài xế', 'fa-car', 800000, 1500000, 'ngày', 'Xe đời mới|Tài xế kinh nghiệm|Bảo hiểm', TRUE, NOW()),
('SV008', 'Thuê Xe 16-29 Chỗ', 'car', 'Xe 16-29 chỗ cho đoàn', 'fa-bus', 2000000, 3500000, 'ngày', 'Xe đời mới|Điều hòa|Wifi', TRUE, NOW()),
('SV009', 'Thuê Xe 45 Chỗ', 'car', 'Xe khách 45 chỗ', 'fa-bus', 4000000, 6000000, 'ngày', 'Xe cao cấp|Ghế ngả|Tivi', TRUE, NOW()),
('SV010', 'Thuê Xe Máy', 'car', 'Xe máy tự lái', 'fa-motorcycle', 100000, 150000, 'ngày', 'Xe đời mới|Bảo hiểm|Mũ bảo hiểm', TRUE, NOW());

-- DỊCH VỤ HỖ TRỢ
INSERT INTO services VALUES
('SV011', 'Hỗ Trợ 24/7', 'support', 'Hỗ trợ khách hàng 24/7', 'fa-headset', 0, 0, 'miễn phí', 'Hỗ trợ 24/7|Tư vấn miễn phí|Hotline', TRUE, NOW()),
('SV012', 'Hướng Dẫn Viên', 'support', 'Hướng dẫn viên chuyên nghiệp', 'fa-user-tie', 500000, 1000000, 'ngày', 'Chuyên nghiệp|Kiến thức sâu|Ngoại ngữ', TRUE, NOW()),
('SV013', 'Chụp Ảnh Du Lịch', 'support', 'Photographer chuyên nghiệp', 'fa-camera', 1000000, 3000000, 'buổi', 'Chuyên nghiệp|Chỉnh sửa ảnh|Giao nhanh', TRUE, NOW());

-- =============================================
-- HOÀN THÀNH
-- =============================================
