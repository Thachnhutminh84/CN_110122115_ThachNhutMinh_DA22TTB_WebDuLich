-- =====================================================
-- SETUP HOÀN CHỈNH DATABASE DU LỊCH TRÀ VINH
-- ĐÃ CHỈNH SỬA ĐỊA CHỈ CHÍNH XÁC VÀ LINK HÌNH ẢNH ĐÚNG
-- Chạy file này trong phpMyAdmin để tạo database và dữ liệu
-- =====================================================

-- Tạo database
CREATE DATABASE IF NOT EXISTS travinh_tourism CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE travinh_tourism;

-- Xóa bảng cũ nếu có
DROP TABLE IF EXISTS attractions;

-- Tạo bảng attractions với đầy đủ các trường
CREATE TABLE attractions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attraction_id VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    category VARCHAR(100),
    ticket_price VARCHAR(100),
    image_url VARCHAR(500),
    opening_hours VARCHAR(200),
    highlights TEXT,
    facilities TEXT,
    best_time VARCHAR(200),
    contact VARCHAR(50),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERT DỮ LIỆU ĐỊA ĐIỂM DU LỊCH
-- =====================================================

-- 1. AO BÀ OM
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('aobaom', 'Ao Bà Om', 
'Ao Bà Om là thắng cảnh quốc gia nổi tiếng với truyền thuyết về cuộc thi đắp đập của phụ nữ Khmer. Khu vực có hơn 500 cây dầu cổ thụ kỳ dị, tạo nên không gian xanh mát, yên bình. Đây là nơi tổ chức nhiều lễ hội truyền thống của đồng bào Khmer.',
'Phường 8, Thành phố Trà Vinh, Tỉnh Trà Vinh (cách trung tâm 2km)', 
'Di tích lịch sử', 'Miễn phí',
'hinhanh/DulichtpTV/aobaom-02-1024x686.jpg',
'6:00 - 18:00 hàng ngày',
'Thắng cảnh quốc gia|Hơn 500 cây dầu cổ thụ|Truyền thuyết Khmer|Lễ hội truyền thống|Không gian xanh mát',
'Bãi đỗ xe|Nhà vệ sinh|Khu vui chơi|Quán ăn|Cho thuê thuyền',
'Sáng sớm (6:00-8:00) hoặc chiều mát (16:00-18:00)',
'0292.3851.111', 'active');

-- 2. CHÙA ÂNG
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('chuaang', 'Chùa Âng', 
'Chùa Âng là ngôi chùa Khmer cổ kính nhất Trà Vinh với niên đại hơn 1000 năm. Kiến trúc Angkor độc đáo với nghệ thuật điêu khắc tinh xảo. Chùa là di tích lịch sử văn hóa quan trọng của cộng đồng người Khmer.',
'Khu di tích Ao Bà Om, Phường 8, Thành phố Trà Vinh', 
'Chùa Khmer', 'Miễn phí',
'hinhanh/DulichtpTV/maxresdefault.jpg',
'5:00 - 19:00 hàng ngày',
'Chùa cổ nhất (hơn 1000 năm)|Kiến trúc Angkor|Nghệ thuật điêu khắc|Di tích lịch sử|Văn hóa Khmer',
'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày',
'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)',
'0292.3851.222', 'active');

-- 3. BIỂN BA ĐỘNG
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('bienbadong', 'Biển Ba Động', 
'Biển Ba Động là bãi biển hoang sơ với cát trắng mịn và nước biển trong xanh. Đây là điểm đến lý tưởng cho du lịch nghỉ dưỡng, tắm biển và thưởng thức hải sản tươi ngon.',
'Xã Đôn Châu, Huyện Cầu Ngang, Tỉnh Trà Vinh (cách TP 35km)', 
'Sinh thái', 'Miễn phí',
'hinhanh/DulichtpTV/Kham-pha-Khu-du-lich-Bien-Ba-Dong-Tra-Vinh-2022.jpg.webp',
'6:00 - 18:00 hàng ngày',
'Bãi biển hoang sơ|Cát trắng mịn|Nước trong xanh|Hải sản tươi ngon|Nghỉ dưỡng',
'Bãi đỗ xe|Nhà vệ sinh|Nhà hàng hải sản|Cho thuê phao|Khu cắm trại',
'Sáng sớm (6:00-9:00) hoặc chiều mát (15:00-18:00)',
'0292.3852.333', 'active');

-- 4. CHÙA VÀM RÂY
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('chuavamray', 'Chùa Vàm Rây', 
'Chùa Vàm Rây là ngôi chùa Khmer lớn nhất Trà Vinh với kiến trúc tráng lệ. Nổi tiếng với tượng Phật khổng lồ cao 18m và khuôn viên rộng rãi, nhiều cây xanh.',
'xã Hàm Tân, huyện Trà Cú, tỉnh Trà Vinh  (cách TP 25km)', 
'Chùa Khmer', 'Miễn phí',
'hinhanh/DulichtpTV/chuavamraytravinh-1.jpg',
'5:00 - 19:00 hàng ngày',
'Chùa Khmer lớn nhất|Tượng Phật cao 18m|Kiến trúc tráng lệ|Khuôn viên rộng|Lễ hội Khmer',
'Bãi đỗ xe rộng|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Khu nghỉ ngơi',
'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)',
'0292.3853.444', 'active');

-- 5. RỪNG ĐƯỚC TRÀ VINH
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('rungduoc', 'Rừng Đước Trà Vinh', 
'Rừng Đước Trà Vinh là khu bảo tồn rừng ngập mặn với hệ sinh thái đa dạng. Du khách có thể trải nghiệm tour thuyền kayak khám phá thiên nhiên hoang dã, quan sát các loài chim và động vật quý hiếm.',
'Xã Long Khánh, Huyện Duyên Hải, Tỉnh Trà Vinh (cách TP 40km)', 
'Sinh thái', '50.000đ/người (bao gồm thuyền kayak)',
"hinhanh\DulichtpTV\OIP.jpg"
'7:00 - 17:00 hàng ngày',
'Hệ sinh thái đa dạng|Tour thuyền kayak|Quan sát chim hoang dã|Rừng ngập mặn|Thiên nhiên hoang sơ',
'Bãi đỗ xe|Nhà vệ sinh|Cho thuê thuyền kayak|Hướng dẫn viên|Áo phao an toàn',
'Sáng sớm (7:00-9:00) để ngắm chim, tránh nắng gắt',
'0292.3854.555', 'active');

-- 6. CỒN CHIM
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('conchim', 'Cồn Chim', 
'Cồn Chim là hòn đảo nhỏ trên sông Hậu với hàng ngàn loài chim hoang dá sinh sống. Đây là điểm đến lý tưởng cho những người yêu thiên nhiên và nhiếp ảnh.',
'Sông Hậu, Thành phố Trà Vinh (đi thuyền từ bến Trà Vinh)', 
'Sinh thái', '30.000đ/người (bao gồm thuyền)',
'hinhanh/DulichtpTV/tourconchimtravinh.jpg',
'6:00 - 17:00 hàng ngày',
'Hàng ngàn loài chim|Hòn đảo hoang sơ|Quan sát thiên nhiên|Chụp ảnh đẹp|Tour thuyền',
'Thuyền đưa đón|Hướng dẫn viên|Áo phao|Ống nhòm quan sát',
'Sáng sớm (6:00-8:00) để ngắm chim bay về tổ',
'0292.3855.666', 'active');

-- 7. CHÙA HANG (Đã sửa địa chỉ về Trà Vinh)
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('chuahang', 'Chùa Hang', 
'Chùa Hang là ngôi chùa độc đáo ẩn sâu trong lòng đất với kiến trúc hang động tự nhiên. Nổi tiếng với quần thể chim yến khổng lồ sinh sống trong hang.',
'Khóm 3, Thị trấn Châu Thành, Huyện Châu Thành, Tỉnh Trà Vinh', -- ĐÃ SỬA VỊ TRÍ
'Chùa Phật giáo', 'Miễn phí',
'hinhanh/DulichtpTV/Cổng_chùa_Hang_(Trà_Vinh).jpg',
'6:00 - 18:00 hàng ngày',
'Chùa hang động độc đáo|Quần thể chim yến|Kiến trúc đặc biệt|Không gian linh thiêng|Thiên nhiên kỳ thú',
'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Đèn chiếu sáng trong hang',
'Sáng sớm (6:00-8:00) hoặc chiều mát (16:00-18:00)',
'0292.3856.777', 'active');

-- 8. CHÙA SOMRONG EK
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('somrongek', 'Chùa Somrong Ek', 
'Chùa Somrong Ek là ngôi chùa Khmer cổ kính với kiến trúc truyền thống đặc trưng và nghệ thuật trang trí tinh xảo. Khuôn viên chùa rộng rãi với nhiều cây xanh tạo không gian yên bình.',
'phường 8, thị xã Trà Vinh, tỉnh Trà Vinh', -- ĐÃ THÊM DẤU PHẨY (,)
'Chùa Khmer', 
'Miễn phí',
'hinhanh\DulichtpTV\1.Chua-Samrong-Ek-Tra-Vinh-Nguon_vietlandmarks.com_.jpg',
'5:00 - 19:00 hàng ngày',
'Kiến trúc Khmer cổ kính|Nghệ thuật trang trí|Khuôn viên rộng rãi|Không gian yên bình|Văn hóa truyền thống',
'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Khu nghỉ ngơi',
'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)',
'0292.3857.888', 'active');

-- 9. ĐỀN THỜ BÁC HỒ
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('denbacho', 'Đền Thờ Bác Hồ', 
'Đền thờ Bác Hồ là công trình tưởng niệm Chủ tịch Hồ Chí Minh, thể hiện lòng kính yêu và tinh thần cách mạng của nhân dân Trà Vinh. Đây là nơi tổ chức các hoạt động giáo dục truyền thống.',
'Đường 30/4, Xã Long Đức, Thành phố Trà Vinh, Tỉnh Trà Vinh', 
'Di tích lịch sử', 'Miễn phí',
'hinhanh/DulichtpTV/Den-Tho-Amt.jpg',
'7:00 - 17:00 hàng ngày',
'Công trình tưởng niệm|Giáo dục truyền thống|Tìm hiểu lịch sử|Không gian trang nghiêm|Điểm tham quan',
'Bãi đỗ xe rộng|Nhà vệ sinh|Khu trưng bày|Khu nghỉ ngơi|Nước uống miễn phí',
'Sáng (8:00-10:00) hoặc chiều (14:00-16:00)',
'0292.3858.999', 'active');

-- 10. NHÀ THỜ ĐỨC MỸ
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('ducmy', 'Nhà Thờ Đức Mỹ', 
'Nhà thờ Đức Mỹ là công trình kiến trúc tôn giáo Công giáo với lối kiến trúc Gothic cổ điển. Nhà thờ là trung tâm sinh hoạt Công giáo quan trọng tại huyện Càng Long.',
'Xã Đức Mỹ, Huyện Càng Long, Tỉnh Trà Vinh (cách TP 30km)', 
'Di tích kiến trúc', 'Miễn phí',
'hinhanh/DulichtpTV/2021-02-18.jpg',
'6:00 - 18:00 hàng ngày (tránh giờ lễ)',
'Kiến trúc Gothic cổ điển|Tháp chuông cao vút|Cửa sổ kính màu|Không gian trang nghiêm|Lễ Giáng sinh',
'Bãi đỗ xe|Nhà vệ sinh|Khu ngồi nghỉ|Nước uống miễn phí',
'Sáng sớm hoặc chiều mát, tránh giờ lễ (6:00, 17:00)',
'0292.3859.111', 'active');

-- 11. CHÙA CÀNH
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('chuacanh', 'Chùa Cành', 
'Chùa Cành là ngôi chùa Khmer nổi tiếng với lễ hội Chaul Chnam Thmey (Tết Khmer) và các hoạt động văn hóa truyền thống sôi động. Chùa có kiến trúc đẹp và không gian yên tĩnh.',
'Hoà Ân, Cầu Kè, Trà Vinh', 
'Chùa Khmer', 'Miễn phí',
'hinhanh/DulichtpTV/NGB_7219.jpg',
'5:00 - 19:00 hàng ngày',
'Lễ hội Tết Khmer|Văn hóa truyền thống|Kiến trúc đẹp|Không gian yên tĩnh|Hoạt động sôi động',
'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Sân khấu lễ hội|Khu nghỉ ngơi',
'Sáng sớm (5:00-7:00) hoặc dịp lễ hội Tết Khmer (tháng 4)',
'0292.3860.222', 'active');

-- 12. BẢO TÀNG VĂN HÓA DÂN TỘC KHMER
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('baotangkhmer', 'Bảo tàng Văn hóa Dân tộc Khmer', 
'Bảo tàng Văn hóa Dân tộc Khmer là bảo tàng chuyên đề đầu tiên về văn hóa Khmer tại Việt Nam. Nơi đây lưu giữ hơn 3.000 hiện vật quý giá từ thế kỷ 7 đến nay.',
'Đường Phạm Thái Bường, Phường 4, Thành phố Trà Vinh, Tỉnh Trà Vinh', 
'Văn hóa', '20.000đ/người',
'hinhanh\DulichtpTV\bảo tàng văn hóa .jpg',
'7:30 - 11:00 và 13:30 - 17:00 (Thứ 2 - Thứ 7)',
'Bảo tàng chuyên đề đầu tiên|Hơn 3.000 hiện vật|Văn hóa Khmer|Từ thế kỷ 7|Giáo dục lịch sử',
'Bãi đỗ xe|Nhà vệ sinh|Phòng trưng bày|Hướng dẫn viên|Điều hòa',
'Sáng (8:00-10:00) hoặc chiều (14:00-16:00)',
'0292.3861.333', 'active');

-- 13. THIỀN VIỆN TRÚC LÂM DUYÊN HẢI
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('thienvientriclam', 'Thiền Viện Trúc Lâm Duyên Hải', 
'Thiền viện Trúc Lâm Duyên Hải là thiền viện lớn nhất miền Tây với diện tích 50 hecta. Không gian tu hành yên tĩnh với vườn sen đẹp và rừng tre xanh mướt.',
'Ấp Khoán Tiều, Xã Trường Long Hòa, Thị xã Duyên Hải, Tỉnh Trà Vinh (cách TP 45km)', 
'Chùa Phật giáo', 'Miễn phí',
'hinhanh\DulichtpTV\thiện viện trúc lâm .jpg',
'6:00 - 18:00 hàng ngày',
'Thiền viện lớn nhất miền Tây|Diện tích 50 hecta|Vườn sen đẹp|Rừng tre xanh|Tu hành yên tĩnh',
'Bãi đỗ xe rộng|Nhà vệ sinh|Nhà khách|Phòng ăn chay|Wifi miễn phí',
'Sáng sớm (6:00-8:00) để tham gia khóa tu',
'0292.3862.444', 'active');

-- 14. CHÙA KHMER PHƯƠNG THẠNH PISAY
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('chuaphuongthanhpisay', 'Chùa Khmer Phương Thạnh Pisay', 
'Chùa Khmer Phương Thạnh Pisay là ngôi chùa hiện đại với kiến trúc độc đáo kết hợp giữa truyền thống Khmer và phong cách hiện đại. Nổi tiếng với tháp Phật 7 tầng cao 35m.',
'Xã Phương Thạnh, Huyện Càng Long, Tỉnh Trà Vinh (cách TP 35km)', 
'Chùa Khmer', 'Miễn phí (có thể cúng dường tự nguyện)',
'hinhanh\DulichtpTV\phuong thạnh .jpg',
'5:00 - 19:00 hàng ngày',
'Tháp Phật 7 tầng cao 35m|Kiến trúc hiện đại độc đáo|Nghệ thuật trang trí đẹp|Vườn hoa đẹp|Lễ hội Khmer',
'Bãi đỗ xe rộng|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Vườn hoa nghỉ ngơi',
'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)',
'0292.3863.555', 'active');

-- 15. NHÀ THỜ CÔNG GIÁO MẠC BẮC
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('nhathomacbac', 'Nhà Thờ Công Giáo Mạc Bắc', 
'Nhà thờ Công giáo Mạc Bắc là công trình kiến trúc tôn giáo với lối kiến trúc Gothic châu Âu đặc trưng. Nhà thờ được xây dựng từ đầu thế kỷ 20.',
'Xã Long Thới, Huyện Tiểu Cần, Tỉnh Trà Vinh', 
'Di tích kiến trúc', 'Miễn phí',
'hinhanh\DulichtpTV\nha-tho-cong-giao-mac-bac.jpg',
'6:00 - 18:00 hàng ngày (tránh giờ lễ)',
'Kiến trúc Gothic châu Âu|Tháp chuông cao vút|Cửa sổ kính màu|Di tích lịch sử|Lễ Giáng sinh',
'Bãi đỗ xe|Nhà vệ sinh|Khu ngồi nghỉ|Nước uống miễn phí',
'Sáng sớm hoặc chiều mát, tránh giờ lễ (6:00, 17:00)',
'0292.3864.666', 'active');

-- 16. CHÙA KOM PONG (CHÙA ÔNG MẸT)
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('chuakompong', 'Chùa Kom Pong (Ông Mẹt)', 
'Chùa Kom Pong (còn gọi là Chùa Ông Mẹt) là ngôi chùa Khmer cổ kính với kiến trúc truyền thống đặc trưng. Khuôn viên chùa rộng rãi với nhiều cây xanh, tạo không gian yên tĩnh.',
'Số 50/1, Đường Lê Lợi, Khóm 2, Phường 1, Thành phố Trà Vinh, Tỉnh Trà Vinh', 
'Chùa Khmer', 'Miễn phí (có thể cúng dường tự nguyện)',
'hinhanh/DulichtpTV/chua-kompong-tra-vinh.jpg',
'5:00 - 19:00 hàng ngày',
'Kiến trúc Khmer cổ kính|Nghệ thuật trang trí|Khuôn viên rộng rãi|Tượng Phật quý giá|Lễ hội truyền thống',
'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Khu nghỉ ngơi',
'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)',
'0292.3865.777', 'active');

-- 17. CHÙA SALENG (KOMPONG CHRÂY)
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('chuasaleng', 'Chùa Saleng (Kompong Chrây)', 
'Chùa Saleng (Kompong Chrây) được mệnh danh là "Viên ngọc kiến trúc Khmer giữa lòng Trà Cú". Điểm đặc biệt của chùa là có tượng Phật nằm dài 20m được chạm khắc tỉ mỉ.',
'Quốc lộ 54, Ấp Chợ, Xã Phước Hưng, Huyện Trà Cú, Tỉnh Trà Vinh', 
'Chùa Khmer', 'Miễn phí (có thể cúng dường tự nguyện)',
'hinhanh\DulichtpTV\saleng.webp',
'5:00 - 19:00 hàng ngày',
'Viên ngọc kiến trúc Khmer|Tượng Phật nằm dài 20m|Kiến trúc tráng lệ|Nghệ thuật chạm khắc|Lễ hội Phật giáo',
'Bãi đỗ xe rộng|Nhà vệ sinh sạch sẽ|Khu thắp hương|Phòng trưng bày|Nước uống miễn phí',
'Sáng sớm (5:00-7:00) để tham gia lễ chùa',
'0292.3866.888', 'active');

-- 18. KHU DU LỊCH HUỲNH KHA
INSERT INTO attractions (attraction_id, name, description, location, category, ticket_price, image_url, opening_hours, highlights, facilities, best_time, contact, status) VALUES
('khudulichhuynhkha', 'Khu Du Lịch Huỳnh Kha', 
'Khu du lịch Huỳnh Kha là điểm đến sinh thái độc đáo với không gian xanh mát, yên bình. Du khách có thể tham gia các hoạt động như câu cá, chèo thuyền, tham quan vườn trái cây.',
'Ấp Long Bình A, Phường 4, Thành phố Trà Vinh, Tỉnh Trà Vinh', 
'Sinh thái', '50.000đ/người',
'hinhanh/DulichtpTV/3-scaled.jpg',
'7:00 - 18:00 hàng ngày',
'Không gian xanh mát|Câu cá giải trí|Chèo thuyền|Vườn trái cây|Ẩm thực miền Tây',
'Bãi đỗ xe rộng|Nhà vệ sinh|Nhà hàng|Khu vui chơi trẻ em|Cho thuê thuyền',
'Cuối tuần, mùa trái cây (tháng 5-8)',
'0292.3867.999', 'active');

-- =====================================================
-- KIỂM TRA KẾT QUẢ
-- =====================================================

SELECT '✅ ĐÃ THÊM THÀNH CÔNG TẤT CẢ ĐỊA ĐIỂM!' as status;

-- Đếm tổng số địa điểm
SELECT COUNT(*) as total_attractions FROM attractions;

-- Hiển thị danh sách tất cả địa điểm
SELECT 
    attraction_id,
    name,
    category,
    location,
    ticket_price
FROM attractions 
ORDER BY name;

SELECT '🎉 HOÀN TẤT CÀI ĐẶT DATABASE!' as message;
