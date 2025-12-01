-- =============================================
-- THÊM DỮ LIỆU NHÀ HÀNG CHO TẤT CẢ CÁC MÓN ĂN
-- =============================================

USE travinh_tourism;

-- =============================================
-- TẠO BẢNG RESTAURANTS (Nếu chưa có)
-- =============================================
CREATE TABLE IF NOT EXISTS restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id VARCHAR(100) UNIQUE NOT NULL COMMENT 'ID định danh quán ăn',
    name VARCHAR(255) NOT NULL COMMENT 'Tên quán ăn',
    food_type VARCHAR(100) NOT NULL COMMENT 'Loại món ăn (liên kết với food_id)',
    address TEXT NOT NULL COMMENT 'Địa chỉ',
    phone VARCHAR(20) COMMENT 'Số điện thoại',
    rating DECIMAL(2,1) DEFAULT 4.5 COMMENT 'Đánh giá (1-5 sao)',
    price_range VARCHAR(100) COMMENT 'Khoảng giá',
    open_time VARCHAR(100) COMMENT 'Giờ mở cửa',
    specialties JSON COMMENT 'Các món đặc biệt (dạng JSON array)',
    image_url VARCHAR(255) COMMENT 'Đường dẫn hình ảnh',
    latitude DECIMAL(10, 8) COMMENT 'Vĩ độ',
    longitude DECIMAL(11, 8) COMMENT 'Kinh độ',
    description TEXT COMMENT 'Mô tả quán ăn',
    status VARCHAR(20) DEFAULT 'active' COMMENT 'Trạng thái: active/inactive',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_food_type (food_type),
    INDEX idx_status (status),
    INDEX idx_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng quản lý thông tin nhà hàng/quán ăn';

-- Xóa dữ liệu cũ (nếu có)
DELETE FROM restaurants;

-- Reset AUTO_INCREMENT
ALTER TABLE restaurants AUTO_INCREMENT = 1;

-- =============================================
-- PHẦN 1: NHÀ HÀNG CHO BÚN NƯỚC LÈO
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('quan-bun-nuoc-leo-ba-sau', 'Quán Bún Nước Lèo Bà Sáu', 'bun-nuoc-leo', 'Số 45 Đường Phạm Thái Bường, TP. Trà Vinh', '0294.3855.123', 4.8, '25.000 - 35.000 VNĐ', '6:00 - 20:00', '["Bún nước lèo", "Bún suông", "Bánh canh"]', 'hinhanh/QuanAn/bun-nuoc-leo-1.jpg', 9.9347, 106.3428, 'Quán bún nước lèo nổi tiếng với nước dùng đậm đà, cá lóc tươi ngon. Được người dân địa phương yêu thích.', 'active'),
('bun-nuoc-leo-cho-tra-vinh', 'Bún Nước Lèo Chợ Trà Vinh', 'bun-nuoc-leo', 'Khu vực chợ Trà Vinh, TP. Trà Vinh', '0294.3855.124', 4.6, '20.000 - 30.000 VNĐ', '5:30 - 11:00', '["Bún nước lèo", "Bún suông"]', 'hinhanh/QuanAn/bun-nuoc-leo-2.jpg', 9.9340, 106.3400, 'Quán bún nước lèo gần chợ, phục vụ từ sáng sớm, giá cả phải chăng.', 'active'),
('quan-bun-ba-bay', 'Quán Bún Bà Bảy', 'bun-nuoc-leo', 'Đường Lê Lợi, TP. Trà Vinh', '0294.3855.125', 4.7, '25.000 - 35.000 VNĐ', '6:00 - 19:00', '["Bún nước lèo", "Bún suông", "Bánh xèo"]', 'hinhanh/QuanAn/bun-nuoc-leo-3.jpg', 9.9360, 106.3450, 'Quán bún truyền thống với công thức gia truyền, nước dùng thơm ngon.', 'active');

-- =============================================
-- PHẦN 2: NHÀ HÀNG CHO BÁNH CANH BẾN CÓ
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('banh-canh-ben-co-ba-ut', 'Bánh Canh Bến Có Bà Út', 'banh-canh-ben-co', 'Bến Có, Trà Vinh', '0294.3855.126', 4.9, '20.000 - 30.000 VNĐ', '6:00 - 18:00', '["Bánh canh", "Hải sản tươi"]', 'hinhanh/QuanAn/banh-canh-1.jpg', 9.9500, 106.3500, 'Quán bánh canh nổi tiếng tại Bến Có với hải sản tươi sống, nước dùng ngọt thanh.', 'active'),
('banh-canh-hai-san-ba-muoi', 'Bánh Canh Hải Sản Bà Mười', 'banh-canh-ben-co', 'Gần chợ Bến Có, Trà Vinh', '0294.3855.127', 4.7, '25.000 - 35.000 VNĐ', '6:00 - 19:00', '["Bánh canh", "Tôm cua mực"]', 'hinhanh/QuanAn/banh-canh-2.jpg', 9.9510, 106.3510, 'Bánh canh với nhiều loại hải sản tươi ngon, giá cả hợp lý.', 'active');

-- =============================================
-- PHẦN 3: NHÀ HÀNG CHO CHÙ Ụ RANG ME
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('chu-u-rang-me-ba-nam', 'Chù Ụ Rang Me Bà Năm', 'chu-u-rang-me', 'Chợ đêm Trà Vinh', '0294.3855.128', 4.5, '15.000 - 25.000 VNĐ', '17:00 - 22:00', '["Chù ụ rang me", "Chù ụ nướng"]', 'hinhanh/QuanAn/chu-u-1.jpg', 9.9345, 106.3425, 'Món ăn vặt độc đáo, chù ụ tươi rang với me chua ngọt hấp dẫn.', 'active'),
('quan-an-vat-ba-tu', 'Quán Ăn Vặt Bà Tư', 'chu-u-rang-me', 'Đường Nguyễn Đáng, TP. Trà Vinh', '0294.3855.129', 4.4, '15.000 - 20.000 VNĐ', '16:00 - 21:00', '["Chù ụ rang me", "Các món ăn vặt"]', 'hinhanh/QuanAn/chu-u-2.jpg', 9.9355, 106.3435, 'Quán ăn vặt đa dạng, chù ụ rang me là món đặc biệt.', 'active');

-- =============================================
-- PHẦN 4: NHÀ HÀNG CHO BÚN SUÔNG
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('bun-suong-ba-chin', 'Bún Suông Bà Chín', 'bun-suong', 'Đường Điện Biên Phủ, TP. Trà Vinh', '0294.3855.130', 4.7, '20.000 - 30.000 VNĐ', '6:00 - 19:00', '["Bún suông", "Bún nước lèo"]', 'hinhanh/QuanAn/bun-suong-1.jpg', 9.9365, 106.3445, 'Bún suông với nước dùng trong vắt, tôm tươi ngon.', 'active'),
('quan-bun-khmer-ba-hai', 'Quán Bún Khmer Bà Hai', 'bun-suong', 'Khu phố 3, TP. Trà Vinh', '0294.3855.131', 4.6, '20.000 - 28.000 VNĐ', '6:00 - 18:00', '["Bún suông", "Nom banh chok"]', 'hinhanh/QuanAn/bun-suong-2.jpg', 9.9370, 106.3455, 'Quán bún Khmer truyền thống, hương vị đậm đà.', 'active');

-- =============================================
-- PHẦN 5: NHÀ HÀNG CHO BÁNH XÈO KHMER
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('banh-xeo-khmer-ba-bon', 'Bánh Xèo Khmer Bà Bốn', 'banh-xeo-khmer', 'Đường Trần Phú, TP. Trà Vinh', '0294.3855.132', 4.8, '15.000 - 25.000 VNĐ', '15:00 - 21:00', '["Bánh xèo Khmer", "Bánh khọt"]', 'hinhanh/QuanAn/banh-xeo-1.jpg', 9.9375, 106.3465, 'Bánh xèo Khmer giòn rụm, nhân đầy đặn, nước chấm đặc biệt.', 'active'),
('quan-banh-xeo-ba-tam', 'Quán Bánh Xèo Bà Tám', 'banh-xeo-khmer', 'Chợ Trà Vinh, TP. Trà Vinh', '0294.3855.133', 4.6, '12.000 - 20.000 VNĐ', '14:00 - 20:00', '["Bánh xèo", "Bánh tráng nướng"]', 'hinhanh/QuanAn/banh-xeo-2.jpg', 9.9342, 106.3402, 'Quán bánh xèo giá rẻ, phục vụ nhanh, đông khách.', 'active');

-- =============================================
-- PHẦN 6: NHÀ HÀNG CHO NOM BANH CHOK
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('nom-banh-chok-ba-ba', 'Nom Banh Chok Bà Ba', 'nom-banh-chok', 'Khu dân cư Khmer, TP. Trà Vinh', '0294.3855.134', 4.7, '12.000 - 20.000 VNĐ', '6:00 - 10:00', '["Nom banh chok", "Bún tươi Khmer"]', 'hinhanh/QuanAn/nom-banh-chok-1.jpg', 9.9380, 106.3470, 'Món ăn sáng truyền thống Khmer, thanh mát và bổ dưỡng.', 'active'),
('bun-khmer-sang-ba-sau', 'Bún Khmer Sáng Bà Sáu', 'nom-banh-chok', 'Đường Lê Thánh Tông, TP. Trà Vinh', '0294.3855.135', 4.5, '10.000 - 18.000 VNĐ', '5:30 - 9:00', '["Nom banh chok", "Bún suông"]', 'hinhanh/QuanAn/nom-banh-chok-2.jpg', 9.9385, 106.3475, 'Quán bún Khmer sáng sớm, giá rẻ, phục vụ nhanh.', 'active');

-- =============================================
-- PHẦN 7: NHÀ HÀNG CHO CHÈ KHMER
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('che-khmer-ba-muoi', 'Chè Khmer Bà Mười', 'che-khmer', 'Chợ đêm Trà Vinh', '0294.3855.136', 4.6, '8.000 - 18.000 VNĐ', '14:00 - 22:00', '["Chè Khmer", "Chè thập cẩm", "Chè dừa"]', 'hinhanh/QuanAn/che-khmer-1.jpg', 9.9346, 106.3426, 'Chè Khmer đa dạng, mát lạnh, giải nhiệt tuyệt vời.', 'active'),
('quan-che-ba-bay', 'Quán Chè Bà Bảy', 'che-khmer', 'Đường Nguyễn Thị Minh Khai, TP. Trà Vinh', '0294.3855.137', 4.5, '10.000 - 20.000 VNĐ', '13:00 - 21:00', '["Chè Khmer", "Sinh tố", "Nước mía"]', 'hinhanh/QuanAn/che-khmer-2.jpg', 9.9390, 106.3480, 'Quán chè và nước giải khát đa dạng, giá cả phải chăng.', 'active');

-- =============================================
-- PHẦN 8: NHÀ HÀNG CHO CÁ LÓC NƯỚNG TRUI
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('ca-loc-nuong-ba-nam', 'Cá Lóc Nướng Bà Năm', 'ca-loc-nuong-trui', 'Ven sông Cổ Chiên, Trà Vinh', '0294.3855.138', 4.9, '150.000 - 250.000 VNĐ/kg', '10:00 - 21:00', '["Cá lóc nướng trui", "Lẩu cá lóc", "Gỏi cá"]', 'hinhanh/QuanAn/ca-loc-1.jpg', 9.9400, 106.3600, 'Nhà hàng chuyên cá lóc tươi sống, nướng trên than hồng thơm ngon.', 'active'),
('nha-hang-ca-loc-song-nuoc', 'Nhà Hàng Cá Lóc Sông Nước', 'ca-loc-nuong-trui', 'Bờ sông Trà Vinh', '0294.3855.139', 4.8, '180.000 - 280.000 VNĐ/kg', '11:00 - 22:00', '["Cá lóc nướng", "Cá lóc hấp", "Cá lóc kho"]', 'hinhanh/QuanAn/ca-loc-2.jpg', 9.9410, 106.3610, 'Nhà hàng view sông, cá lóc tươi ngon, không gian thoáng mát.', 'active');

-- =============================================
-- PHẦN 9: NHÀ HÀNG CHO LẨU MẮM
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('lau-mam-ba-tu', 'Lẩu Mắm Bà Tư', 'lau-mam', 'Đường Nguyễn Đáng, TP. Trà Vinh', '0294.3855.140', 4.7, '80.000 - 150.000 VNĐ/người', '16:00 - 22:00', '["Lẩu mắm", "Lẩu cá", "Các món nhậu"]', 'hinhanh/QuanAn/lau-mam-1.jpg', 9.9356, 106.3436, 'Lẩu mắm đậm đà hương vị miền Tây, rau rừng phong phú.', 'active'),
('nha-hang-lau-mien-tay', 'Nhà Hàng Lẩu Miền Tây', 'lau-mam', 'Khu ẩm thực Trà Vinh', '0294.3855.141', 4.8, '100.000 - 180.000 VNĐ/người', '17:00 - 23:00', '["Lẩu mắm", "Lẩu cá", "Lẩu hải sản"]', 'hinhanh/QuanAn/lau-mam-2.jpg', 9.9420, 106.3620, 'Nhà hàng lẩu đa dạng, không gian rộng rãi, phục vụ tốt.', 'active');

-- =============================================
-- PHẦN 10: NHÀ HÀNG CHO BÁNH TÉT TRÀ CUÔN
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('banh-tet-tra-cuon-ba-bay', 'Bánh Tét Trà Cuôn Bà Bảy', 'banh-tet-tra-cuon', 'Trà Cuôn, Trà Vinh', '0294.3855.142', 4.9, '30.000 - 50.000 VNĐ/cái', '7:00 - 19:00', '["Bánh tét", "Bánh ú", "Bánh ít"]', 'hinhanh/QuanAn/banh-tet-1.jpg', 9.9600, 106.3700, 'Cơ sở làm bánh tét truyền thống, nổi tiếng khắp vùng.', 'active'),
('banh-tet-gia-truyen', 'Bánh Tét Gia Truyền', 'banh-tet-tra-cuon', 'Chợ Trà Cuôn, Trà Vinh', '0294.3855.143', 4.7, '35.000 - 55.000 VNĐ/cái', '6:00 - 18:00', '["Bánh tét", "Bánh chưng"]', 'hinhanh/QuanAn/banh-tet-2.jpg', 9.9610, 106.3710, 'Bánh tét làm thủ công, công thức gia truyền nhiều đời.', 'active');

-- =============================================
-- PHẦN 11: NHÀ HÀNG CHO LỢI CHOI XÃ ỚT
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('quan-loi-choi-ba-sau', 'Quán Lợi Choi Bà Sáu', 'loi-choi-xa-ot', 'Xã Ớt, Trà Vinh', '0294.3855.144', 4.6, '20.000 - 35.000 VNĐ', '10:00 - 20:00', '["Lợi choi xào tỏi", "Canh lợi choi", "Các món rau rừng"]', 'hinhanh/QuanAn/loi-choi-1.jpg', 9.9700, 106.3800, 'Quán chuyên các món từ lợi choi và rau rừng đặc sản.', 'active'),
('nha-hang-rau-rung', 'Nhà Hàng Rau Rừng', 'loi-choi-xa-ot', 'Gần chợ Xã Ớt, Trà Vinh', '0294.3855.145', 4.5, '25.000 - 40.000 VNĐ', '11:00 - 21:00', '["Lợi choi", "Các món rau rừng", "Cá kho"]', 'hinhanh/QuanAn/loi-choi-2.jpg', 9.9710, 106.3810, 'Nhà hàng đặc sản rau rừng, món ăn dân dã, bổ dưỡng.', 'active');

-- =============================================
-- PHẦN 12: NHÀ HÀNG CHO BÁNH ÍT LÁ GAI
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('banh-it-la-gai-ba-chin', 'Bánh Ít Lá Gai Bà Chín', 'banh-it-la-gai', 'Chợ Trà Vinh', '0294.3855.146', 4.7, '5.000 - 10.000 VNĐ/cái', '6:00 - 18:00', '["Bánh ít lá gai", "Bánh ít nhân dừa", "Bánh ít nhân đậu"]', 'hinhanh/QuanAn/banh-it-1.jpg', 9.9343, 106.3403, 'Bánh ít lá gai truyền thống, làm thủ công hàng ngày.', 'active'),
('banh-deo-ba-muoi', 'Bánh Dẻo Bà Mười', 'banh-it-la-gai', 'Đường Lê Lợi, TP. Trà Vinh', '0294.3855.147', 4.6, '6.000 - 12.000 VNĐ/cái', '7:00 - 19:00', '["Bánh ít lá gai", "Bánh dẻo", "Bánh bò"]', 'hinhanh/QuanAn/banh-it-2.jpg', 9.9361, 106.3451, 'Cửa hàng bánh dẻo đa dạng, tươi ngon mỗi ngày.', 'active');

-- =============================================
-- PHẦN 13: NHÀ HÀNG CHO CƠM TẤM SƯỜN NƯỚNG
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('com-tam-ba-ba', 'Cơm Tấm Bà Ba', 'com-tam-suon-nuong-2', 'Đường Phạm Hùng, TP. Trà Vinh', '0294.3855.148', 4.7, '25.000 - 40.000 VNĐ', '10:00 - 21:00', '["Cơm tấm sườn nướng", "Cơm tấm bì chả", "Cơm tấm đặc biệt"]', 'hinhanh/QuanAn/com-tam-1.jpg', 9.9348, 106.3429, 'Quán cơm tấm nổi tiếng, sườn nướng thơm ngon, giá cả hợp lý.', 'active'),
('com-tam-suon-nuong-ba-nam', 'Cơm Tấm Sườn Nướng Bà Năm', 'com-tam-suon-nuong-2', 'Chợ đêm Trà Vinh', '0294.3855.149', 4.6, '20.000 - 35.000 VNĐ', '16:00 - 22:00', '["Cơm tấm sườn", "Cơm tấm chả", "Cơm tấm trứng"]', 'hinhanh/QuanAn/com-tam-2.jpg', 9.9349, 106.3430, 'Cơm tấm chợ đêm, đông khách, phục vụ nhanh.', 'active');

-- =============================================
-- PHẦN 14: NHÀ HÀNG CHO HỦ TIẾU MỸ THO
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('hu-tieu-my-tho-ba-tu', 'Hủ Tiếu Mỹ Tho Bà Tư', 'hu-tieu-my-tho-2', 'Đường Trần Hưng Đạo, TP. Trà Vinh', '0294.3855.150', 4.8, '20.000 - 35.000 VNĐ', '6:00 - 20:00', '["Hủ tiếu Mỹ Tho", "Hủ tiếu khô", "Hủ tiếu nước"]', 'hinhanh/QuanAn/hu-tieu-1.jpg', 9.9357, 106.3437, 'Hủ tiếu Mỹ Tho đậm đà, nước dùng ngọt thanh, topping phong phú.', 'active'),
('quan-hu-tieu-ba-sau', 'Quán Hủ Tiếu Bà Sáu', 'hu-tieu-my-tho-2', 'Khu phố 5, TP. Trà Vinh', '0294.3855.151', 4.7, '18.000 - 30.000 VNĐ', '5:30 - 19:00', '["Hủ tiếu", "Mì", "Hủ tiếu xào"]', 'hinhanh/QuanAn/hu-tieu-2.jpg', 9.9371, 106.3456, 'Quán hủ tiếu sáng sớm, giá rẻ, đông khách địa phương.', 'active');

-- =============================================
-- PHẦN 15: NHÀ HÀNG CHO BÁNH MÌ THỊT
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('banh-mi-ba-hai', 'Bánh Mì Bà Hai', 'banh-mi-thit-2', 'Đường Nguyễn Thị Minh Khai, TP. Trà Vinh', '0294.3855.152', 4.8, '15.000 - 25.000 VNĐ', '6:00 - 22:00', '["Bánh mì thịt", "Bánh mì pate", "Bánh mì xíu mại"]', 'hinhanh/QuanAn/banh-mi-1.jpg', 9.9391, 106.3481, 'Bánh mì nổi tiếng, bánh giòn, nhân đầy đặn, nước sốt đặc biệt.', 'active'),
('banh-mi-thit-ba-bay', 'Bánh Mì Thịt Bà Bảy', 'banh-mi-thit-2', 'Chợ Trà Vinh', '0294.3855.153', 4.6, '12.000 - 20.000 VNĐ', '5:30 - 21:00', '["Bánh mì thịt", "Bánh mì trứng", "Bánh mì chả"]', 'hinhanh/QuanAn/banh-mi-2.jpg', 9.9344, 106.3404, 'Bánh mì giá rẻ, phục vụ nhanh, đông khách.', 'active');

-- =============================================
-- PHẦN 16: QUÁN CHO CÀ PHÊ SỮA ĐÁ
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('cafe-tra-vinh', 'Cafe Trà Vinh', 'ca-phe-sua-da-2', 'Đường Phạm Thái Bường, TP. Trà Vinh', '0294.3855.154', 4.7, '15.000 - 25.000 VNĐ', '6:00 - 22:00', '["Cà phê sữa đá", "Cà phê đen", "Bạc xỉu"]', 'hinhanh/QuanAn/cafe-1.jpg', 9.9350, 106.3431, 'Quán cà phê truyền thống, không gian yên tĩnh, cà phê thơm ngon.', 'active'),
('cafe-phin-ba-muoi', 'Cafe Phin Bà Mười', 'ca-phe-sua-da-2', 'Đường Lê Lợi, TP. Trà Vinh', '0294.3855.155', 4.6, '12.000 - 20.000 VNĐ', '5:30 - 21:00', '["Cà phê phin", "Cà phê sữa", "Cà phê đá"]', 'hinhanh/QuanAn/cafe-2.jpg', 9.9362, 106.3452, 'Quán cà phê bình dân, giá rẻ, cà phê đậm đà.', 'active');

-- =============================================
-- PHẦN 17: QUÁN CHO NƯỚC MÍA
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('nuoc-mia-ba-chin', 'Nước Mía Bà Chín', 'nuoc-mia-2', 'Chợ Trà Vinh', '0294.3855.156', 4.5, '8.000 - 15.000 VNĐ', '6:00 - 20:00', '["Nước mía", "Nước mía chanh", "Nước mía kumquat"]', 'hinhanh/QuanAn/nuoc-mia-1.jpg', 9.9345, 106.3405, 'Nước mía tươi mát, ép tươi mỗi ngày, giá rẻ.', 'active'),
('quan-nuoc-mia-ba-nam', 'Quán Nước Mía Bà Năm', 'nuoc-mia-2', 'Đường Điện Biên Phủ, TP. Trà Vinh', '0294.3855.157', 4.4, '10.000 - 18.000 VNĐ', '7:00 - 21:00', '["Nước mía", "Nước chanh", "Nước dừa"]', 'hinhanh/QuanAn/nuoc-mia-2.jpg', 9.9366, 106.3446, 'Quán nước giải khát đa dạng, mát lạnh, giải nhiệt.', 'active');

-- =============================================
-- PHẦN 18: QUÁN CHO TRÀ SỮA
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('tra-sua-bobapop', 'Trà Sữa BobaPop', 'tra-sua-2', 'Đường Nguyễn Đáng, TP. Trà Vinh', '0294.3855.158', 4.8, '20.000 - 35.000 VNĐ', '8:00 - 22:00', '["Trà sữa trân châu", "Trà sữa thạch", "Trà sữa pudding"]', 'hinhanh/QuanAn/tra-sua-1.jpg', 9.9358, 106.3438, 'Quán trà sữa hiện đại, nhiều hương vị, topping đa dạng.', 'active'),
('tra-sua-gong-cha', 'Trà Sữa Gong Cha', 'tra-sua-2', 'Trung tâm TP. Trà Vinh', '0294.3855.159', 4.7, '25.000 - 40.000 VNĐ', '9:00 - 23:00', '["Trà sữa", "Trà trái cây", "Sữa tươi trân châu"]', 'hinhanh/QuanAn/tra-sua-2.jpg', 9.9372, 106.3457, 'Chuỗi trà sữa nổi tiếng, chất lượng ổn định, không gian đẹp.', 'active');

-- =============================================
-- PHẦN 19: QUÁN CHO SINH TỐ BƠ
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('sinh-to-ba-tu', 'Sinh Tố Bà Tư', 'sinh-to-bo-2', 'Chợ đêm Trà Vinh', '0294.3855.160', 4.7, '25.000 - 35.000 VNĐ', '14:00 - 22:00', '["Sinh tố bơ", "Sinh tố mãng cầu", "Sinh tố dâu"]', 'hinhanh/QuanAn/sinh-to-1.jpg', 9.9351, 106.3432, 'Quán sinh tố trái cây tươi, bơ béo ngậy, thơm ngon.', 'active'),
('quan-sinh-to-trai-cay', 'Quán Sinh Tố Trái Cây', 'sinh-to-bo-2', 'Đường Trần Phú, TP. Trà Vinh', '0294.3855.161', 4.6, '20.000 - 30.000 VNĐ', '13:00 - 21:00', '["Sinh tố bơ", "Sinh tố sapoche", "Sinh tố mix"]', 'hinhanh/QuanAn/sinh-to-2.jpg', 9.9376, 106.3466, 'Sinh tố trái cây tươi ngon, giá cả phải chăng.', 'active');

-- =============================================
-- PHẦN 20: QUÁN CHO KEM DỪA
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('kem-dua-ba-sau', 'Kem Dừa Bà Sáu', 'kem-dua-2', 'Bãi biển Ba Động, Trà Vinh', '0294.3855.162', 4.8, '10.000 - 20.000 VNĐ', '8:00 - 20:00', '["Kem dừa", "Kem cơm dừa", "Nước dừa"]', 'hinhanh/QuanAn/kem-dua-1.jpg', 9.9800, 106.4000, 'Kem dừa tươi mát, làm từ dừa tươi, view biển đẹp.', 'active'),
('quan-kem-dua-tuoi', 'Quán Kem Dừa Tươi', 'kem-dua-2', 'Chợ Trà Vinh', '0294.3855.163', 4.6, '8.000 - 15.000 VNĐ', '9:00 - 21:00', '["Kem dừa", "Kem trái cây", "Kem sữa"]', 'hinhanh/QuanAn/kem-dua-2.jpg', 9.9346, 106.3406, 'Quán kem dừa giá rẻ, mát lạnh, giải nhiệt.', 'active');

-- =============================================
-- PHẦN 21: QUÁN CHO BÁNH FLAN
-- =============================================
INSERT INTO restaurants (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, image_url, latitude, longitude, description, status) VALUES
('banh-flan-ba-bay', 'Bánh Flan Bà Bảy', 'banh-flan-2', 'Chợ Trà Vinh', '0294.3855.164', 4.7, '8.000 - 15.000 VNĐ', '7:00 - 19:00', '["Bánh flan", "Bánh flan caramen", "Bánh flan trứng"]', 'hinhanh/QuanAn/banh-flan-1.jpg', 9.9347, 106.3407, 'Bánh flan mềm mịn, ngọt dịu, làm thủ công hàng ngày.', 'active'),
('tiem-banh-ngot-ba-muoi', 'Tiệm Bánh Ngọt Bà Mười', 'banh-flan-2', 'Đường Lê Thánh Tông, TP. Trà Vinh', '0294.3855.165', 4.6, '10.000 - 18.000 VNĐ', '8:00 - 20:00', '["Bánh flan", "Bánh bông lan", "Bánh su kem"]', 'hinhanh/QuanAn/banh-flan-2.jpg', 9.9386, 106.3476, 'Tiệm bánh ngọt đa dạng, bánh flan là món đặc biệt.', 'active');

-- =============================================
-- HOÀN THÀNH
-- =============================================
SELECT COUNT(*) as 'Tổng số nhà hàng' FROM restaurants;
SELECT food_type, COUNT(*) as 'Số lượng quán' FROM restaurants GROUP BY food_type;

SELECT '✅ Đã thêm thành công dữ liệu nhà hàng cho tất cả 21 món ăn!' as 'Kết quả';
