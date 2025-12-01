-- =============================================
-- DỮ LIỆU ĐẦY ĐỦ - HỆ THỐNG ĐẶT DỊCH VỤ
-- =============================================
-- Bao gồm: Bảng service_bookings + Dữ liệu mẫu
-- =============================================

USE travinh_tourism;

-- =============================================
-- 1. TẠO BẢNG ĐẶT DỊCH VỤ
-- =============================================

CREATE TABLE IF NOT EXISTS service_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(50) UNIQUE NOT NULL,
    service_id VARCHAR(20) NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_email VARCHAR(100),
    service_date DATE,
    number_of_people INT DEFAULT 1,
    number_of_days INT DEFAULT 1,
    special_requests TEXT,
    total_price DECIMAL(15,2) DEFAULT 0,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 2. XÓA DỮ LIỆU CŨ (NẾU CÓ)
-- =============================================

TRUNCATE TABLE service_bookings;

-- =============================================
-- 3. INSERT DỮ LIỆU ĐẶT DỊCH VỤ MẪU
-- =============================================

-- Đặt dịch vụ Tour
INSERT INTO service_bookings (booking_code, service_id, customer_name, customer_phone, customer_email, service_date, number_of_people, number_of_days, special_requests, total_price, status, created_at) VALUES
('SB20250001', 'SV001', 'Nguyễn Văn An', '0901234567', 'nguyenvanan@gmail.com', '2025-01-15', 4, 1, 'Muốn tham quan chùa Âng và Ao Bà Om', 800000, 'confirmed', '2024-12-01 09:30:00'),
('SB20250002', 'SV002', 'Trần Thị Bình', '0912345678', 'tranthibinh@gmail.com', '2025-01-20', 2, 3, 'Honeymoon, muốn tour lãng mạn', 3500000, 'pending', '2024-12-05 14:20:00'),
('SB20250003', 'SV003', 'Lê Văn Cường', '0923456789', 'levancuong@gmail.com', '2025-02-01', 6, 5, 'Đoàn gia đình, có trẻ nhỏ', 12000000, 'confirmed', '2024-12-10 10:15:00');

-- Đặt phòng khách sạn
INSERT INTO service_bookings (booking_code, service_id, customer_name, customer_phone, customer_email, service_date, number_of_people, number_of_days, special_requests, total_price, status, created_at) VALUES
('SB20250004', 'SV004', 'Phạm Thị Dung', '0934567890', 'phamthidung@gmail.com', '2025-01-18', 2, 2, 'Cần phòng đôi, gần trung tâm', 1200000, 'confirmed', '2024-12-08 16:45:00'),
('SB20250005', 'SV005', 'Hoàng Văn Em', '0945678901', 'hoangvanem@gmail.com', '2025-01-25', 2, 3, 'Phòng view biển, có bồn tắm', 6000000, 'pending', '2024-12-12 11:30:00'),
('SB20250006', 'SV006', 'Võ Thị Phương', '0956789012', 'vothiphuong@gmail.com', '2025-02-05', 4, 2, 'Homestay gần biển, có bếp', 2000000, 'confirmed', '2024-12-15 08:00:00');

-- Thuê xe
INSERT INTO service_bookings (booking_code, service_id, customer_name, customer_phone, customer_email, service_date, number_of_people, number_of_days, special_requests, total_price, status, created_at) VALUES
('SB20250007', 'SV007', 'Đặng Văn Giang', '0967890123', 'dangvangiang@gmail.com', '2025-01-22', 5, 1, 'Cần xe 7 chỗ, đón tại sân bay', 1200000, 'confirmed', '2024-12-18 13:20:00'),
('SB20250008', 'SV008', 'Bùi Thị Hoa', '0978901234', 'buithihoa@gmail.com', '2025-02-10', 20, 2, 'Đoàn công ty, cần xe 29 chỗ', 6000000, 'pending', '2024-12-20 15:40:00'),
('SB20250009', 'SV009', 'Ngô Văn Inh', '0989012345', 'ngovaninh@gmail.com', '2025-02-15', 40, 3, 'Đoàn du lịch, cần xe 45 chỗ', 15000000, 'confirmed', '2024-12-22 09:10:00'),
('SB20250010', 'SV010', 'Trương Thị Kim', '0990123456', 'truongthikim@gmail.com', '2025-01-28', 1, 3, 'Thuê xe máy tự lái', 400000, 'completed', '2024-12-25 10:25:00');

-- Dịch vụ hỗ trợ
INSERT INTO service_bookings (booking_code, service_id, customer_name, customer_phone, customer_email, service_date, number_of_people, number_of_days, special_requests, total_price, status, created_at) VALUES
('SB20250011', 'SV012', 'Lý Văn Long', '0901112233', 'lyvanlong@gmail.com', '2025-01-30', 8, 1, 'Cần hướng dẫn viên tiếng Anh', 800000, 'confirmed', '2024-12-26 14:30:00'),
('SB20250012', 'SV013', 'Mai Thị Minh', '0912223344', 'maithiminh@gmail.com', '2025-02-08', 2, 1, 'Chụp ảnh cưới tại Ao Bà Om', 2000000, 'pending', '2024-12-28 11:15:00');

-- Thêm nhiều booking hơn
INSERT INTO service_bookings (booking_code, service_id, customer_name, customer_phone, customer_email, service_date, number_of_people, number_of_days, special_requests, total_price, status, created_at) VALUES
('SB20250013', 'SV001', 'Phan Văn Nam', '0923334455', 'phanvannam@gmail.com', '2025-02-12', 3, 1, 'Tour khám phá văn hóa Khmer', 600000, 'pending', '2024-12-27 16:20:00'),
('SB20250014', 'SV004', 'Đinh Thị Oanh', '0934445566', 'dinhthioanh@gmail.com', '2025-02-18', 2, 1, 'Phòng đơn giản, sạch sẽ', 600000, 'confirmed', '2024-12-29 09:45:00'),
('SB20250015', 'SV007', 'Dương Văn Phúc', '0945556677', 'duongvanphuc@gmail.com', '2025-02-20', 4, 2, 'Thuê xe đi biển', 2400000, 'pending', '2024-12-30 13:00:00'),
('SB20250016', 'SV002', 'Nguyễn Thị Lan', '0956667788', 'nguyenthilan@gmail.com', '2025-01-12', 5, 2, 'Đoàn bạn bè', 3000000, 'confirmed', '2024-12-15 10:30:00'),
('SB20250017', 'SV005', 'Trần Văn Minh', '0967778899', 'tranvanminh@gmail.com', '2025-01-16', 2, 2, 'Kỷ niệm ngày cưới', 4000000, 'pending', '2024-12-18 14:20:00'),
('SB20250018', 'SV008', 'Lê Thị Hoa', '0978889900', 'lethihoa@gmail.com', '2025-02-22', 25, 1, 'Đoàn sinh viên', 3000000, 'confirmed', '2024-12-20 11:40:00'),
('SB20250019', 'SV003', 'Phạm Văn Tài', '0989990011', 'phamvantai@gmail.com', '2025-03-01', 4, 7, 'Tour trọn gói gia đình', 10000000, 'pending', '2024-12-22 09:15:00'),
('SB20250020', 'SV006', 'Hoàng Thị Mai', '0990001122', 'hoangthimai@gmail.com', '2025-02-14', 2, 3, 'Homestay lãng mạn', 3000000, 'confirmed', '2024-12-24 16:00:00');

-- =============================================
-- 4. THỐNG KÊ
-- =============================================

-- Thống kê tổng quan
SELECT 
    COUNT(*) as 'Tổng Booking',
    COUNT(CASE WHEN status = 'pending' THEN 1 END) as 'Chờ Xác Nhận',
    COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as 'Đã Xác Nhận',
    COUNT(CASE WHEN status = 'completed' THEN 1 END) as 'Hoàn Thành',
    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as 'Đã Hủy',
    FORMAT(SUM(total_price), 0) as 'Tổng Doanh Thu (VNĐ)'
FROM service_bookings;

-- Thống kê theo loại dịch vụ
SELECT 
    s.service_type as 'Loại Dịch Vụ',
    COUNT(sb.id) as 'Số Booking',
    FORMAT(SUM(sb.total_price), 0) as 'Doanh Thu (VNĐ)'
FROM service_bookings sb
LEFT JOIN services s ON sb.service_id = s.service_id
GROUP BY s.service_type
ORDER BY COUNT(sb.id) DESC;

-- =============================================
-- HOÀN THÀNH
-- =============================================
-- ✅ Đã tạo bảng service_bookings
-- ✅ Đã insert 20 booking mẫu
-- ✅ Bao gồm tất cả loại dịch vụ: Tour, Khách sạn, Xe, Hỗ trợ
-- ✅ Đa dạng trạng thái: pending, confirmed, completed
-- =============================================
