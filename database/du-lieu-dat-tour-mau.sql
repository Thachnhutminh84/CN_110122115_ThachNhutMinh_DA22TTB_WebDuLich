-- =====================================================
-- DỮ LIỆU MẪU CHO HỆ THỐNG ĐẶT TOUR DU LỊCH TRÀ VINH
-- Chạy file này sau khi đã chạy create_tour_management_system.sql
-- =====================================================

USE travinh_tourism;

-- Xóa dữ liệu cũ
DELETE FROM booking_payments;
DELETE FROM tour_reviews;
DELETE FROM bookings;
DELETE FROM tour_schedules;
DELETE FROM tour_attractions;
DELETE FROM tour_pricing;
DELETE FROM tours;

-- Reset AUTO_INCREMENT
ALTER TABLE tours AUTO_INCREMENT = 1;
ALTER TABLE tour_schedules AUTO_INCREMENT = 1;
ALTER TABLE bookings AUTO_INCREMENT = 1;

-- =====================================================
-- THÊM CÁC GÓI TOUR
-- =====================================================

INSERT INTO tours (tour_code, tour_name, description, duration, price, max_participants, min_participants, tour_type, difficulty_level, image_url, itinerary, included_services, excluded_services, notes, status) VALUES
('TV-KHMER-001', 'Tour Khám Phá Văn Hóa Khmer 1 Ngày', 
'Trải nghiệm nét đẹp văn hóa Khmer qua các ngôi chùa cổ kính và thắng cảnh nổi tiếng.',
'1 ngày (7:00 - 17:00)', 450000, 30, 5, 'day_tour', 'easy',
'hinhanh/tours/tour-khmer.jpg',
'07:00 - Tập trung tại Trường ĐH Trà Vinh|08:00 - Tham quan Chùa Âng|10:00 - Tham quan Ao Bà Om|12:00 - Ăn trưa|14:00 - Tham quan Chùa Vàm Rây|16:00 - Mua sắm|17:00 - Về',
'Xe du lịch máy lạnh|Hướng dẫn viên|Vé tham quan|Bữa trưa|Nước suối|Bảo hiểm',
'Chi phí cá nhân|Đồ uống ngoài bữa ăn|Tip hướng dẫn viên',
'Mang giày thể thao|Mặc trang phục lịch sự khi vào chùa',
'active'),

('TV-BIEN-002', 'Tour Biển Ba Động - Rừng Đước',
'Khám phá biển đẹp và hệ sinh thái rừng ngập mặn độc đáo.',
'1 ngày (6:00 - 18:00)', 550000, 25, 5, 'day_tour', 'moderate',
'hinhanh/tours/tour-bien.jpg',
'06:00 - Khởi hành|08:00 - Biển Ba Động|10:00 - Ăn hải sản|14:00 - Rừng Đước|16:30 - Mua sắm|18:00 - Về',
'Xe máy lạnh|Hướng dẫn viên|Vé tham quan|Bữa trưa hải sản|Thuyền kayak|Áo phao|Bảo hiểm',
'Chi phí cá nhân|Tắm nước ngọt|Thuê phao bơi',
'Mang đồ bơi|Kem chống nắng|Mũ, kính',
'active'),

('TV-2D1N-003', 'Tour Trà Vinh 2 Ngày 1 Đêm',
'Khám phá toàn diện Trà Vinh trong 2 ngày.',
'2 ngày 1 đêm', 1200000, 20, 5, 'overnight', 'easy',
'hinhanh/tours/tour-2d1n.jpg',
'NGÀY 1: Chùa Âng - Ao Bà Om - Khách sạn||NGÀY 2: Biển Ba Động - Rừng Đước - Về',
'Xe máy lạnh|Hướng dẫn viên|Khách sạn 3 sao|3 bữa ăn + 1 sáng|Vé tham quan|Thuyền kayak|Bảo hiểm',
'Chi phí cá nhân|Phụ thu phòng đơn 200k',
'Mang CMND|Đồ dùng cá nhân',
'active');

-- =====================================================
-- LIÊN KẾT TOUR VỚI ĐỊA ĐIỂM
-- =====================================================

INSERT INTO tour_attractions (tour_id, attraction_id, visit_order, visit_duration) VALUES
(1, 'chuaang', 1, '1.5 giờ'),
(1, 'aobaom', 2, '1.5 giờ'),
(1, 'chuavamray', 3, '1 giờ'),
(2, 'bienbadong', 1, '3 giờ'),
(2, 'rungduoc', 2, '2 giờ'),
(3, 'chuaang', 1, '1 giờ'),
(3, 'aobaom', 2, '1 giờ'),
(3, 'bienbadong', 3, '2 giờ'),
(3, 'rungduoc', 4, '1.5 giờ');

-- =====================================================
-- LỊCH KHỞI HÀNH
-- =====================================================

INSERT INTO tour_schedules (tour_id, departure_date, departure_time, return_date, return_time, available_slots, guide_name, guide_phone, meeting_point, status) VALUES
(1, '2024-12-20', '07:00:00', '2024-12-20', '17:00:00', 30, 'Nguyễn Văn An', '0901234567', 'Trường ĐH Trà Vinh', 'scheduled'),
(1, '2024-12-27', '07:00:00', '2024-12-27', '17:00:00', 30, 'Trần Thị Bình', '0902345678', 'Trường ĐH Trà Vinh', 'scheduled'),
(2, '2024-12-21', '06:00:00', '2024-12-21', '18:00:00', 25, 'Lê Văn Cường', '0903456789', 'Trường ĐH Trà Vinh', 'scheduled'),
(3, '2024-12-22', '07:00:00', '2024-12-23', '18:00:00', 20, 'Phạm Thị Dung', '0904567890', 'Trường ĐH Trà Vinh', 'scheduled');

-- =====================================================
-- BẢNG GIÁ
-- =====================================================

INSERT INTO tour_pricing (tour_id, season_name, start_date, end_date, adult_price, child_price, infant_price, is_active) VALUES
(1, 'Giá thường', '2024-01-01', '2024-12-31', 450000, 300000, 0, TRUE),
(2, 'Giá thường', '2024-01-01', '2024-12-31', 550000, 400000, 0, TRUE),
(3, 'Giá thường', '2024-01-01', '2024-12-31', 1200000, 900000, 300000, TRUE);

-- =====================================================
-- ĐƠN ĐẶT TOUR MẪU
-- =====================================================

INSERT INTO bookings (booking_code, schedule_id, user_id, customer_name, customer_email, customer_phone, customer_address, num_adults, num_children, num_infants, total_price, special_requests, payment_method, payment_status, booking_status, booking_date, confirmed_at, notes) VALUES
('BK2024120001', 1, NULL, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0912345678', '123 Đường ABC, TP Trà Vinh', 2, 1, 0, 1200000, 'Cần ghế gần cửa sổ', 'bank_transfer', 'paid', 'confirmed', '2024-12-10 10:30:00', '2024-12-10 14:00:00', 'Khách VIP'),

('BK2024120002', 2, NULL, 'Trần Thị B', 'tranthib@gmail.com', '0923456789', '456 Đường XYZ, TP Trà Vinh', 4, 2, 1, 2700000, 'Có người ăn chay', 'cash', 'pending', 'pending', '2024-12-12 15:20:00', NULL, 'Gọi xác nhận'),

('BK2024110001', 1, NULL, 'Lê Văn C', 'levanc@gmail.com', '0934567890', '789 Đường DEF, TP Trà Vinh', 2, 0, 0, 900000, NULL, 'bank_transfer', 'paid', 'completed', '2024-11-15 09:00:00', '2024-11-15 10:00:00', 'Đã hoàn thành');

-- =====================================================
-- ĐÁNH GIÁ
-- =====================================================

INSERT INTO tour_reviews (booking_id, tour_id, user_id, rating, review_title, review_content, pros, cons, is_verified, status, created_at) VALUES
(3, 1, NULL, 5, 'Tour rất tuyệt!', 'Gia đình tôi rất hài lòng. Hướng dẫn viên nhiệt tình, các điểm đẹp.', 'HDV tốt|Lịch trình hợp lý|Xe đẹp|Món ăn ngon', 'Thời gian hơi gấp', TRUE, 'approved', '2024-11-20 20:00:00');

-- =====================================================
-- HOÀN TẤT
-- =====================================================

SELECT '✓ Đã thêm dữ liệu thành công!' AS message;
SELECT 'Tours:' AS info, COUNT(*) AS count FROM tours
UNION ALL
SELECT 'Schedules:', COUNT(*) FROM tour_schedules
UNION ALL
SELECT 'Bookings:', COUNT(*) FROM bookings;
