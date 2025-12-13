-- Tạo bảng quanans và thêm dữ liệu đầy đủ cho tất cả món ăn
USE travinh_tourism;

-- Xóa bảng cũ nếu có
DROP TABLE IF EXISTS quanans;

-- Tạo bảng mới
CREATE TABLE quanans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id VARCHAR(100) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    food_type VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20),
    rating DECIMAL(2,1) DEFAULT 4.5,
    price_range VARCHAR(100),
    open_time VARCHAR(100),
    specialties JSON,
    image_url VARCHAR(255),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    description TEXT,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- THÊM DỮ LIỆU QUÁN ĂN CHO TẤT CẢ CÁC MÓN
-- =============================================

-- 1. BÚN NƯỚC LÈO
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('quan-bun-nuoc-leo-ba-sau', 'Quán Bún Nước Lèo Bà Sáu', 'bun-nuoc-leo', 'Số 45 Đường Phạm Thái Bường, TP. Trà Vinh', '0294.3855.123', 4.8, '25.000 - 35.000 VNĐ', '6:00 - 20:00', '["Bún nước lèo", "Bún suông"]', 'Quán bún nước lèo nổi tiếng với nước dùng đậm đà.', 'active'),
('bun-nuoc-leo-cho-tra-vinh', 'Bún Nước Lèo Chợ Trà Vinh', 'bun-nuoc-leo', 'Khu vực chợ Trà Vinh', '0294.3855.124', 4.6, '20.000 - 30.000 VNĐ', '5:30 - 11:00', '["Bún nước lèo"]', 'Quán bún gần chợ, phục vụ từ sáng sớm.', 'active');

-- 2. BÁNH CANH BẾN CÓ
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('banh-canh-ben-co-ba-ut', 'Bánh Canh Bến Có Bà Út', 'banh-canh-ben-co', 'Bến Có, Trà Vinh', '0294.3855.126', 4.9, '20.000 - 30.000 VNĐ', '6:00 - 18:00', '["Bánh canh", "Hải sản"]', 'Quán bánh canh nổi tiếng với hải sản tươi sống.', 'active'),
('banh-canh-hai-san-ba-muoi', 'Bánh Canh Hải Sản Bà Mười', 'banh-canh-ben-co', 'Gần chợ Bến Có', '0294.3855.127', 4.7, '25.000 - 35.000 VNĐ', '6:00 - 19:00', '["Bánh canh", "Tôm cua mực"]', 'Bánh canh với nhiều loại hải sản tươi ngon.', 'active');

-- 3. CHÙ Ụ RANG ME
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('chu-u-rang-me-ba-nam', 'Chù Ụ Rang Me Bà Năm', 'chu-u-rang-me', 'Chợ đêm Trà Vinh', '0294.3855.128', 4.5, '15.000 - 25.000 VNĐ', '17:00 - 22:00', '["Chù ụ rang me", "Chù ụ nướng"]', 'Món ăn vặt độc đáo, chù ụ rang với me chua ngọt.', 'active'),
('quan-an-vat-ba-tu', 'Quán Ăn Vặt Bà Tư', 'chu-u-rang-me', 'Đường Nguyễn Đáng, TP. Trà Vinh', '0294.3855.129', 4.4, '15.000 - 20.000 VNĐ', '16:00 - 21:00', '["Chù ụ rang me"]', 'Quán ăn vặt đa dạng.', 'active');

-- 4. BÚN SUÔNG
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('bun-suong-ba-chin', 'Bún Suông Bà Chín', 'bun-suong', 'Đường Điện Biên Phủ, TP. Trà Vinh', '0294.3855.130', 4.7, '20.000 - 30.000 VNĐ', '6:00 - 19:00', '["Bún suông", "Bún nước lèo"]', 'Bún suông với nước dùng trong vắt.', 'active'),
('quan-bun-khmer-ba-hai', 'Quán Bún Khmer Bà Hai', 'bun-suong', 'Khu phố 3, TP. Trà Vinh', '0294.3855.131', 4.6, '20.000 - 28.000 VNĐ', '6:00 - 18:00', '["Bún suông"]', 'Quán bún Khmer truyền thống.', 'active');

-- 5. BÁNH XÈO KHMER
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('banh-xeo-khmer-ba-bon', 'Bánh Xèo Khmer Bà Bốn', 'banh-xeo-khmer', 'Đường Trần Phú, TP. Trà Vinh', '0294.3855.132', 4.8, '15.000 - 25.000 VNĐ', '15:00 - 21:00', '["Bánh xèo Khmer", "Bánh khọt"]', 'Bánh xèo Khmer giòn rụm, nhân đầy đặn.', 'active'),
('quan-banh-xeo-ba-tam', 'Quán Bánh Xèo Bà Tám', 'banh-xeo-khmer', 'Chợ Trà Vinh', '0294.3855.133', 4.6, '12.000 - 20.000 VNĐ', '14:00 - 20:00', '["Bánh xèo"]', 'Quán bánh xèo giá rẻ.', 'active');

-- 6. NOM BANH CHOK
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('nom-banh-chok-ba-ba', 'Nom Banh Chok Bà Ba', 'nom-banh-chok', 'Khu dân cư Khmer, TP. Trà Vinh', '0294.3855.134', 4.7, '12.000 - 20.000 VNĐ', '6:00 - 10:00', '["Nom banh chok"]', 'Món ăn sáng truyền thống Khmer.', 'active'),
('bun-khmer-sang-ba-sau', 'Bún Khmer Sáng Bà Sáu', 'nom-banh-chok', 'Đường Lê Thánh Tông', '0294.3855.135', 4.5, '10.000 - 18.000 VNĐ', '5:30 - 9:00', '["Nom banh chok"]', 'Quán bún Khmer sáng sớm.', 'active');

-- 7. CHÈ KHMER
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('che-khmer-ba-muoi', 'Chè Khmer Bà Mười', 'che-khmer', 'Chợ đêm Trà Vinh', '0294.3855.136', 4.6, '8.000 - 18.000 VNĐ', '14:00 - 22:00', '["Chè Khmer", "Chè dừa"]', 'Chè Khmer đa dạng, mát lạnh.', 'active'),
('quan-che-ba-bay', 'Quán Chè Bà Bảy', 'che-khmer', 'Đường Nguyễn Thị Minh Khai', '0294.3855.137', 4.5, '10.000 - 20.000 VNĐ', '13:00 - 21:00', '["Chè Khmer", "Sinh tố"]', 'Quán chè và nước giải khát.', 'active');

-- 8. CÁ LÓC NƯỚNG TRUI
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('ca-loc-nuong-ba-nam', 'Cá Lóc Nướng Bà Năm', 'ca-loc-nuong-trui', 'Ven sông Cổ Chiên', '0294.3855.138', 4.9, '150.000 - 250.000 VNĐ/kg', '10:00 - 21:00', '["Cá lóc nướng trui", "Lẩu cá"]', 'Nhà hàng chuyên cá lóc tươi sống.', 'active'),
('nha-hang-ca-loc-song-nuoc', 'Nhà Hàng Cá Lóc Sông Nước', 'ca-loc-nuong-trui', 'Bờ sông Trà Vinh', '0294.3855.139', 4.8, '180.000 - 280.000 VNĐ/kg', '11:00 - 22:00', '["Cá lóc nướng", "Cá lóc hấp"]', 'Nhà hàng view sông đẹp.', 'active');

-- 9. LẨU MẮM
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('lau-mam-ba-tu', 'Lẩu Mắm Bà Tư', 'lau-mam', 'Đường Nguyễn Đáng', '0294.3855.140', 4.7, '80.000 - 150.000 VNĐ/người', '16:00 - 22:00', '["Lẩu mắm", "Lẩu cá"]', 'Lẩu mắm đậm đà hương vị miền Tây.', 'active'),
('quan-lau-mam-mien-tay', 'Quán Lẩu Mắm Miền Tây', 'lau-mam', 'Đường Lê Lợi', '0294.3855.141', 4.6, '70.000 - 130.000 VNĐ/người', '17:00 - 23:00', '["Lẩu mắm"]', 'Lẩu mắm với rau rừng phong phú.', 'active');

-- 10. BÁNH TÉT TRÀ CUÔN
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('banh-tet-tra-cuon-co-ut', 'Bánh Tét Trà Cuôn Cô Út', 'banh-tet-tra-cuon', 'Xã Trà Cuôn, Trà Vinh', '0294.3855.142', 4.8, '30.000 - 50.000 VNĐ/cái', '6:00 - 18:00', '["Bánh tét", "Bánh ít"]', 'Bánh tét truyền thống Trà Cuôn.', 'active');

-- 11. BÁNH ÍT LÁ GAI
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('banh-it-la-gai-ba-hai', 'Bánh Ít Lá Gai Bà Hai', 'banh-it-la-gai', 'Chợ Trà Vinh', '0294.3855.143', 4.6, '5.000 - 10.000 VNĐ/cái', '6:00 - 17:00', '["Bánh ít lá gai"]', 'Bánh ít lá gai truyền thống.', 'active');

-- 12. CƠM TẤM SƯỜN NƯỚNG
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('com-tam-suon-nuong-ba-nam', 'Cơm Tấm Sườn Nướng Bà Năm', 'com-tam-suon-nuong-2', 'Đường Trần Hưng Đạo', '0294.3855.144', 4.7, '25.000 - 40.000 VNĐ', '6:00 - 21:00', '["Cơm tấm sườn nướng"]', 'Cơm tấm sườn nướng thơm ngon.', 'active'),
('quan-com-tam-anh-tu', 'Quán Cơm Tấm Anh Tư', 'com-tam-suon-nuong-2', 'Đường Nguyễn Trãi', '0294.3855.145', 4.5, '20.000 - 35.000 VNĐ', '5:30 - 20:00', '["Cơm tấm"]', 'Cơm tấm giá rẻ.', 'active');

-- 13. HỦ TIẾU MỸ THO
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('hu-tieu-my-tho-ba-bay', 'Hủ Tiếu Mỹ Tho Bà Bảy', 'hu-tieu-my-tho-2', 'Đường Điện Biên Phủ', '0294.3855.146', 4.6, '20.000 - 35.000 VNĐ', '6:00 - 14:00', '["Hủ tiếu Mỹ Tho"]', 'Hủ tiếu nước dùng ngọt thanh.', 'active');

-- 14. BÁNH MÌ THỊT
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('banh-mi-thit-co-ba', 'Bánh Mì Thịt Cô Ba', 'banh-mi-thit-2', 'Đường Lê Lợi', '0294.3855.147', 4.7, '15.000 - 25.000 VNĐ', '5:00 - 22:00', '["Bánh mì thịt"]', 'Bánh mì giòn rụm, nhân đầy đặn.', 'active');

-- 15. CÀ PHÊ SỮA ĐÁ
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('cafe-sua-da-ong-nam', 'Cà Phê Ông Năm', 'ca-phe-sua-da-2', 'Đường Nguyễn Đáng', '0294.3855.148', 4.8, '15.000 - 25.000 VNĐ', '6:00 - 22:00', '["Cà phê sữa đá", "Cà phê đen"]', 'Cà phê phin truyền thống.', 'active');

-- 16. NƯỚC MÍA
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('nuoc-mia-co-hai', 'Nước Mía Cô Hai', 'nuoc-mia-2', 'Chợ Trà Vinh', '0294.3855.149', 4.5, '8.000 - 15.000 VNĐ', '7:00 - 20:00', '["Nước mía"]', 'Nước mía tươi mát.', 'active');

-- 17. TRÀ SỮA
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('tra-sua-toco', 'Trà Sữa TocoToco', 'tra-sua-2', 'Đường Trần Phú', '0294.3855.150', 4.6, '20.000 - 35.000 VNĐ', '9:00 - 22:00', '["Trà sữa", "Trà trái cây"]', 'Trà sữa nhiều hương vị.', 'active');

-- 18. SINH TỐ BƠ
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('sinh-to-bo-co-tam', 'Sinh Tố Bơ Cô Tám', 'sinh-to-bo-2', 'Đường Nguyễn Thị Minh Khai', '0294.3855.151', 4.7, '25.000 - 35.000 VNĐ', '8:00 - 21:00', '["Sinh tố bơ", "Sinh tố các loại"]', 'Sinh tố bơ béo ngậy.', 'active');

-- 19. KEM DỪA
INSERT INTO quanans (restaurant_id, name, food_type, address, phone, rating, price_range, open_time, specialties, description, status) VALUES
('kem-dua-ba-sau', 'Kem Dừa Bà Sáu', 'kem-dua-2', 'Chợ đêm Trà Vinh', '0294.3855.152', 4.6, '10.000 - 20.000 VNĐ', '14:00 - 22:00', '["Kem dừa", "Kem các loại"]', 'Kem dừa mát lạnh.', 'active');

-- Kiểm tra kết quả
SELECT COUNT(*) as 'Tổng số quán ăn' FROM quanans;
SELECT food_type, COUNT(*) as 'Số quán' FROM quanans GROUP BY food_type ORDER BY food_type;
SELECT '✅ Đã tạo bảng quanans và thêm quán ăn cho tất cả 19 món!' as 'Kết quả';
