-- =====================================================
-- DỮ LIỆU MẪU CHO TOURS
-- =====================================================

USE travinh_tourism;

-- Thêm dữ liệu tours
INSERT INTO tours (tour_name, description, duration_days, base_price, max_participants, itinerary, status) VALUES
('Tour Khám Phá Văn Hóa Khmer 1 Ngày', 
'Khám phá nét đẹp văn hóa Khmer qua các ngôi chùa cổ kính và thắng cảnh nổi tiếng của Trà Vinh. Tour bao gồm tham quan Ao Bà Om, Chùa Âng, Chùa Vàm Rây và thưởng thức ẩm thực địa phương.',
1, 450000, 30,
'07:00 - Khởi hành từ Trường ĐH Trà Vinh
08:00 - Tham quan Ao Bà Om và Chùa Âng
10:00 - Tham quan Chùa Vàm Rây
12:00 - Dùng bữa trưa với đặc sản Trà Vinh
14:00 - Tham quan Bảo tàng Văn hóa Khmer
16:00 - Mua sắm đặc sản
17:00 - Trở về điểm xuất phát',
'active'),

('Tour Biển Và Rừng Đước 1 Ngày',
'Trải nghiệm thiên nhiên hoang sơ với tour biển Ba Động và rừng đước. Tham gia các hoạt động thú vị như tắm biển, chèo kayak khám phá rừng ngập mặn, quan sát chim hoang dã.',
1, 550000, 25,
'06:00 - Khởi hành đi Biển Ba Động
08:00 - Tắm biển, vui chơi trên bãi cát
10:00 - Thưởng thức hải sản tươi sống
12:00 - Di chuyển đến Rừng Đước
13:30 - Chèo kayak khám phá rừng ngập mặn
15:30 - Quan sát chim tại Cồn Chim
17:00 - Trở về',
'active'),

('Tour Tâm Linh 2 Ngày 1 Đêm',
'Hành trình tâm linh đến các ngôi chùa Khmer nổi tiếng và Thiền viện Trúc Lâm Duyên Hải. Trải nghiệm tu tập, thiền định và tìm hiểu văn hóa tâm linh của vùng đất Trà Vinh.',
2, 1200000, 20,
'NGÀY 1:
07:00 - Khởi hành
08:00 - Tham quan Chùa Âng
10:00 - Chùa Vàm Rây
12:00 - Ăn trưa chay
14:00 - Chùa Hang
16:00 - Nhận phòng khách sạn
18:00 - Ăn tối
19:00 - Tự do khám phá

NGÀY 2:
06:00 - Thiền viện Trúc Lâm Duyên Hải
08:00 - Tham gia khóa tu sáng
10:00 - Tham quan khuôn viên
12:00 - Ăn trưa chay
14:00 - Chùa Kompong Chrây
16:00 - Trở về',
'active'),

('Tour Trọn Gói Trà Vinh 3 Ngày 2 Đêm',
'Tour trọn gói khám phá toàn bộ Trà Vinh với đầy đủ các điểm tham quan nổi tiếng: văn hóa, biển, rừng, ẩm thực. Phù hợp cho gia đình và nhóm bạn.',
3, 2500000, 30,
'NGÀY 1: VĂN HÓA KHMER
- Ao Bà Om, Chùa Âng
- Bảo tàng Văn hóa Khmer
- Chùa Vàm Rây
- Nhận phòng khách sạn

NGÀY 2: BIỂN VÀ SINH THÁI
- Biển Ba Động
- Rừng Đước
- Cồn Chim
- Ẩm thực hải sản

NGÀY 3: TÂM LINH VÀ MUA SẮM
- Thiền viện Trúc Lâm
- Chùa Hang
- Mua sắm đặc sản
- Trở về',
'active'),

('Tour Ẩm Thực Trà Vinh 1 Ngày',
'Hành trình khám phá ẩm thực đặc sản Trà Vinh với các món ăn truyền thống của người Khmer, Kinh và Hoa. Tham quan các nhà hàng nổi tiếng và chợ địa phương.',
1, 400000, 20,
'07:00 - Khởi hành
08:00 - Chợ Trà Vinh - Tìm hiểu nguyên liệu
09:30 - Bánh tét Trà Cú
11:00 - Cơm cháy Cầu Kè
13:00 - Lẩu mắm U Minh
15:00 - Bánh xèo Khmer
16:30 - Chè Khmer và trái cây
18:00 - Trở về',
'active');

-- Thêm lịch trình tour (schedules)
INSERT INTO tour_schedules (tour_id, departure_date, departure_time, return_date, return_time, available_slots, guide_name, guide_phone, meeting_point, status) VALUES
-- Tour 1: Văn hóa Khmer 1 ngày
(1, '2024-12-15', '07:00:00', '2024-12-15', '17:00:00', 30, 'Nguyễn Văn An', '0901234567', 'Trường Đại học Trà Vinh', 'scheduled'),
(1, '2024-12-22', '07:00:00', '2024-12-22', '17:00:00', 30, 'Trần Thị Bình', '0902345678', 'Trường Đại học Trà Vinh', 'scheduled'),
(1, '2024-12-29', '07:00:00', '2024-12-29', '17:00:00', 30, 'Nguyễn Văn An', '0901234567', 'Trường Đại học Trà Vinh', 'scheduled'),

-- Tour 2: Biển và Rừng
(2, '2024-12-16', '06:00:00', '2024-12-16', '17:00:00', 25, 'Lê Văn Cường', '0903456789', 'Trường Đại học Trà Vinh', 'scheduled'),
(2, '2024-12-23', '06:00:00', '2024-12-23', '17:00:00', 25, 'Lê Văn Cường', '0903456789', 'Trường Đại học Trà Vinh', 'scheduled'),

-- Tour 3: Tâm linh 2 ngày
(3, '2024-12-20', '07:00:00', '2024-12-21', '16:00:00', 20, 'Phạm Thị Dung', '0904567890', 'Trường Đại học Trà Vinh', 'scheduled'),
(3, '2024-12-27', '07:00:00', '2024-12-28', '16:00:00', 20, 'Phạm Thị Dung', '0904567890', 'Trường Đại học Trà Vinh', 'scheduled'),

-- Tour 4: Trọn gói 3 ngày
(4, '2024-12-18', '07:00:00', '2024-12-20', '17:00:00', 30, 'Nguyễn Văn An', '0901234567', 'Trường Đại học Trà Vinh', 'scheduled'),
(4, '2024-12-25', '07:00:00', '2024-12-27', '17:00:00', 30, 'Trần Thị Bình', '0902345678', 'Trường Đại học Trà Vinh', 'scheduled'),

-- Tour 5: Ẩm thực
(5, '2024-12-14', '07:00:00', '2024-12-14', '18:00:00', 20, 'Lê Văn Cường', '0903456789', 'Trường Đại học Trà Vinh', 'scheduled'),
(5, '2024-12-21', '07:00:00', '2024-12-21', '18:00:00', 20, 'Lê Văn Cường', '0903456789', 'Trường Đại học Trà Vinh', 'scheduled'),
(5, '2024-12-28', '07:00:00', '2024-12-28', '18:00:00', 20, 'Phạm Thị Dung', '0904567890', 'Trường Đại học Trà Vinh', 'scheduled');

-- Thêm địa điểm cho tours
INSERT INTO tour_attractions (tour_id, attraction_id, visit_order, visit_duration) VALUES
-- Tour 1: Văn hóa Khmer
(1, 'aobaom', 1, '2 giờ'),
(1, 'chuaang', 2, '1 giờ'),
(1, 'chuavamray', 3, '1.5 giờ'),
(1, 'baotangkhmer', 4, '1.5 giờ'),

-- Tour 2: Biển và Rừng
(2, 'bienbadong', 1, '3 giờ'),
(2, 'rungduoc', 2, '2 giờ'),
(2, 'conchim', 3, '1.5 giờ'),

-- Tour 3: Tâm linh
(3, 'chuaang', 1, '1.5 giờ'),
(3, 'chuavamray', 2, '1.5 giờ'),
(3, 'chuahang', 3, '1 giờ'),
(3, 'thienvientriclam', 4, '3 giờ'),
(3, 'chuasaleng', 5, '1 giờ'),

-- Tour 4: Trọn gói
(4, 'aobaom', 1, '2 giờ'),
(4, 'chuaang', 2, '1 giờ'),
(4, 'baotangkhmer', 3, '1.5 giờ'),
(4, 'bienbadong', 4, '3 giờ'),
(4, 'rungduoc', 5, '2 giờ'),
(4, 'thienvientriclam', 6, '2 giờ'),
(4, 'chuahang', 7, '1 giờ');

-- Thêm giá theo mùa
INSERT INTO tour_pricing (tour_id, season_name, start_date, end_date, adult_price, child_price, infant_price, is_active) VALUES
-- Tour 1: Giá thường
(1, 'Giá thường', '2024-01-01', '2024-04-30', 450000, 315000, 0, 1),
(1, 'Giá cao điểm', '2024-05-01', '2024-08-31', 550000, 385000, 0, 1),
(1, 'Giá thường', '2024-09-01', '2024-12-31', 450000, 315000, 0, 1),

-- Tour 2
(2, 'Giá thường', '2024-01-01', '2024-04-30', 550000, 385000, 0, 1),
(2, 'Giá cao điểm', '2024-05-01', '2024-08-31', 650000, 455000, 0, 1),
(2, 'Giá thường', '2024-09-01', '2024-12-31', 550000, 385000, 0, 1),

-- Tour 3
(3, 'Giá thường', '2024-01-01', '2024-04-30', 1200000, 840000, 0, 1),
(3, 'Giá cao điểm', '2024-05-01', '2024-08-31', 1400000, 980000, 0, 1),
(3, 'Giá thường', '2024-09-01', '2024-12-31', 1200000, 840000, 0, 1),

-- Tour 4
(4, 'Giá thường', '2024-01-01', '2024-04-30', 2500000, 1750000, 0, 1),
(4, 'Giá cao điểm', '2024-05-01', '2024-08-31', 2900000, 2030000, 0, 1),
(4, 'Giá thường', '2024-09-01', '2024-12-31', 2500000, 1750000, 0, 1),

-- Tour 5
(5, 'Giá thường', '2024-01-01', '2024-12-31', 400000, 280000, 0, 1);

SELECT '✅ ĐÃ THÊM DỮ LIỆU TOURS THÀNH CÔNG!' as status;
SELECT COUNT(*) as total_tours FROM tours;
SELECT COUNT(*) as total_schedules FROM tour_schedules;
SELECT COUNT(*) as total_tour_attractions FROM tour_attractions;
SELECT COUNT(*) as total_pricing FROM tour_pricing;
