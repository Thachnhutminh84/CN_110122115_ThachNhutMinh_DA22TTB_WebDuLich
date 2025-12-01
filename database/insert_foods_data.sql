-- =============================================
-- KHỐI LỆNH HOÀN CHỈNH CHO BẢNG FOODS (RESET VÀ CHÈN DỮ LIỆU)
-- ĐÃ SỬA LỖI CÚ PHÁP INSERT
-- =============================================

USE travinh_tourism;

-- ******************************************************
-- BƯỚC 1: XÓA BẢNG 'foods' (Nếu nó đã tồn tại)
-- ******************************************************
DROP TABLE IF EXISTS foods;

-- ******************************************************
-- BƯỚC 2: TẠO BẢNG 'foods' VỚI CẤU TRÚC CHUẨN
-- ******************************************************
CREATE TABLE foods (
    food_id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,              -- Tên chung
    name_vi VARCHAR(255) NOT NULL,           -- Tên tiếng Việt
    name_khmer VARCHAR(255) NOT NULL,        -- Tên tiếng Khmer
    category VARCHAR(50),
    description TEXT,
    ingredients JSON,                        -- Mảng nguyên liệu
    price_range VARCHAR(50),
    image_url VARCHAR(255),
    origin VARCHAR(100),                     -- Vị trí/Nguồn gốc (Sử dụng origin)
    best_time VARCHAR(100),
    status VARCHAR(50)
);

-- ******************************************************
-- BƯỚC 3: CHÈN TẤT CẢ 21 MÓN ĂN VÀO BẢNG MỚI (Đã sửa lỗi cú pháp)
-- ******************************************************

-- CHÈN 12 BẢN GHI ĐẶC SẢN ĐẦU TIÊN
INSERT INTO foods (food_id, name, name_vi, name_khmer, category, description, ingredients, price_range, image_url, origin, best_time, status) VALUES
('bun-nuoc-leo', 'Bún Nước Lèo', 'Bún Nước Lèo', 'នំបញ្ចុក', 'mon-chinh', 
'Món ăn đặc trưng của người Khmer với nước dùng đậm đà từ cá lóc, tôm khô và các loại rau thơm. Bún nước lèo có vị ngọt tự nhiên từ cá, hòa quyện cùng vị cay nhẹ của ớt và thơm nồng của sả.', 
'["Bún tươi", "Cá lóc", "Tôm khô", "Rau muống", "Giá đỗ", "Sả", "Ớt", "Nước mắm"]', 
'25.000 - 35.000 VNĐ', 
'hinhanh/DulichtpTV/dac-sac-bun-nuoc-leo-tra-vinh-a09-5812896.jpg', 
'Trà Vinh', 'Sáng, Trưa', 'active'),

('banh-canh-ben-co', 'Bánh Canh Bến Có', 'Bánh Canh Bến Có', 'នំបញ្ចុក', 'mon-chinh', 
'Bánh canh đặc biệt với sợi bánh dai ngon, nước dùng trong vắt từ xương heo và hải sản tươi. Món ăn mang đậm hương vị biển cả với tôm, cua, mực tươi ngon.', 
'["Bánh canh", "Tôm", "Cua", "Mực", "Xương heo", "Hành lá", "Rau thơm"]', 
'20.000 - 30.000 VNĐ', 
'hinhanh/DulichtpTV/bánh canh.jpg', 
'Bến Có, Trà Vinh', 'Sáng, Trưa', 'active'),

('chu-u-rang-me', 'Chù Ụ Rang Me', 'Chù Ụ Rang Me', 'កណ្ដុរឆាអំពិល', 'mon-an-vat', 
'Món ăn vặt độc đáo từ loài chù ụ (chuột đồng) rang với me, có vị chua ngọt đặc trưng. Thịt chù ụ giòn, thơm, không hôi, kết hợp với vị chua ngọt của me tạo nên hương vị khó quên.', 
'["Chù ụ", "Me", "Tỏi", "Ớt", "Đường", "Muối", "Sả"]', 
'15.000 - 25.000 VNĐ', 
'hinhanh/DulichtpTV/chà ụ.jpg', 
'Trà Vinh', 'Chiều, Tối', 'active'),

('bun-suong', 'Bún Suông', 'Bún Suông', 'នំបញ្ចុក', 'mon-chinh', 
'Món bún đặc trưng của người Khmer với nước dùng trong vắt từ xương heo, tôm tươi và các loại rau sống tươi mát. Bún suông có vị ngọt thanh, ăn kèm với rau sống và nước mắm pha.', 
'["Bún tươi", "Tôm", "Thịt heo", "Giá đỗ", "Rau muống", "Rau thơm", "Nước mắm"]', 
'20.000 - 30.000 VNĐ', 
'hinhanh/DulichtpTV/bunbs suồn.jpg', 
'Trà Vinh', 'Sáng, Trưa', 'active'),

('banh-xeo-khmer', 'Bánh Xèo Khmer', 'Bánh Xèo Khmer', 'នំបញ្ចុក', 'mon-an-vat', 
'Bánh xèo kiểu Khmer với vỏ bánh mỏng giòn, nhân tôm thịt và giá đỗ, ăn kèm rau sống và nước chấm đặc biệt. Bánh xèo Khmer có màu vàng đẹp mắt, giòn rụm và thơm ngon.', 
'["Bột gạo", "Bột nghệ", "Tôm", "Thịt heo", "Giá đỗ", "Rau sống", "Nước mắm"]', 
'15.000 - 25.000 VNĐ', 
'hinhanh/DulichtpTV/bánh xèo.jpg', 
'Trà Vinh', 'Chiều, Tối', 'active'),

('nom-banh-chok', 'Nom Banh Chok', 'Nom Banh Chok', 'នំបញ្ចុក', 'mon-chinh', 
'Bún tươi Khmer ăn kèm nước mắm chua ngọt, rau thơm và các loại rau sống, là món ăn sáng phổ biến. Nom banh chok có vị thanh mát, dễ ăn và rất bổ dưỡng.', 
'["Bún tươi", "Cá", "Rau thơm", "Dưa chuột", "Giá đỗ", "Nước mắm", "Đường"]', 
'12.000 - 20.000 VNĐ', 
'hinhanh/DulichtpTV/num banh chok.jpg', 
'Trà Vinh', 'Sáng', 'active'),

('che-khmer', 'Chè Khmer', 'Chè Khmer', 'បបរ', 'banh-ngot', 
'Chè Khmer truyền thống với nhiều loại đậu và nước cốt dừa thơm ngon, mát lạnh giải nhiệt. Chè Khmer có nhiều màu sắc bắt mắt từ các loại đậu và thạch khác nhau.', 
'["Đậu đỏ", "Đậu xanh", "Đậu trắng", "Nước cốt dừa", "Đường", "Thạch", "Đá bào"]', 
'8.000 - 18.000 VNĐ', 
'hinhanh/DulichtpTV/chè khmer.jpg', 
'Trà Vinh', 'Cả ngày', 'active'),

('ca-loc-nuong-trui', 'Cá Lóc Nướng Trui', 'Cá Lóc Nướng Trui', 'ត្រីឆ្អិនអាំង', 'mon-chinh', 
'Cá lóc nướng trui đặc sản vùng sông nước, thịt cá ngọt tự nhiên, ăn kèm bánh tráng và rau sống. Cá được nướng trên than hồng, da giòn thơm, thịt ngọt và mềm.', 
'["Cá lóc", "Muối", "Ớt", "Sả", "Bánh tráng", "Rau sống", "Nước mắm"]', 
'150.000 - 250.000 VNĐ/kg', 
'hinhanh/DulichtpTV/cá lóc.jpg', 
'Trà Vinh', 'Trưa, Tối', 'active'),

('lau-mam', 'Lẩu Mắm', 'Lẩu Mắm', 'ស្ងោរ', 'mon-chinh', 
'Lẩu mắm đậm đà hương vị miền Tây với nhiều loại rau rừng, cá tươi và nước dùng thơm ngon. Lẩu mắm có vị đậm đà, hơi chua và rất kích thích vị giác.', 
'["Mắm", "Cá lóc", "Tôm", "Thịt heo", "Rau muống", "Bông điên điển", "Bông so đũa", "Bún"]', 
'80.000 - 150.000 VNĐ/người', 
'hinhanh/DulichtpTV/lẩu .jpg', 
'Trà Vinh', 'Trưa, Tối', 'active'),

('banh-tet-tra-cuon', 'Bánh Tét Trà Cuôn', 'Bánh Tét Trà Cuôn', 'នំអន្សម', 'banh-ngot', 
'Bánh tét đặc sản Trà Cuôn với nhân đậu xanh và thịt heo, gói trong lá chuối. Bánh tét Trà Cuôn nổi tiếng với vị ngọt thanh của gạo nếp, đậu xanh béo ngậy và thịt heo thơm.', 
'["Gạo nếp", "Đậu xanh", "Thịt heo", "Lá chuối", "Muối"]', 
'30.000 - 50.000 VNĐ/cái', 
'hinhanh/DulichtpTV/dac-san-tra-vinh-co-gi bánh tests.jpg', 
'Trà Cuôn, Trà Vinh', 'Tết, Lễ hội', 'active'),


('banh-it-la-gai', 'Bánh Ít Lá Gai', 'Bánh Ít Lá Gai', 'នំអន្សម', 'banh-ngot', 
'Bánh ít lá gai với vỏ bánh dẻo từ lá gai, nhân đậu xanh hoặc dừa. Bánh có màu đen tự nhiên từ lá gai, vị dẻo thơm và ngọt thanh.', 
'["Bột nếp", "Lá gai", "Đậu xanh", "Dừa", "Đường"]', 
'5.000 - 10.000 VNĐ/cái', 
'hinhanh/DulichtpTV/dac-san-tra-vinh-co-gi bánh tests.jpg', 
'Trà Vinh', 'Cả ngày', 'active');


-- CHÈN 9 BẢN GHI ĐỒ ĂN/ĐỒ UỐNG BỔ SUNG (Đã đổi food_id để tránh trùng lặp)
INSERT INTO foods (food_id, name, name_vi, name_khmer, category, description, ingredients, price_range, image_url, origin, best_time, status) VALUES 
('com-tam-suon-nuong-2', 'Cơm Tấm Sườn Nướng', 'Cơm Tấm Sườn Nướng', 'បាយសាច់ជ្រូក', 'mon-chinh', 
'Cơm tấm với sườn nướng thơm phức, ăn kèm dưa leo, cà chua và nước mắm pha. Sườn được ướp gia vị đậm đà, nướng trên than hồng cho thơm và giòn.', 
'["Cơm tấm", "Sườn heo", "Nước mắm", "Đường", "Tỏi", "Sả", "Dưa leo", "Cà chua"]', 
'25.000 - 40.000 VNĐ', 
'hinhanh/DulichtpTV/Cơm mới.jpg', 
'Trà Vinh', 'Trưa, Tối', 'active'),

('hu-tieu-my-tho-2', 'Hủ Tiếu Mỹ Tho', 'Hủ Tiếu Mỹ Tho', 'គុយទាវ', 'mon-chinh', 
'Hủ tiếu Mỹ Tho với nước dùng ngọt thanh từ xương heo và hải sản. Món ăn có sợi hủ tiếu dai, nước dùng trong vắt và nhiều topping hấp dẫn.', 
'["Hủ tiếu", "Tôm", "Thịt heo", "Gan", "Giá đỗ", "Hành lá", "Nước dùng"]', 
'20.000 - 35.000 VNĐ', 
'hinhanh/DulichtpTV/hủ tiếu mới.jpg', 
'Trà Vinh', 'Sáng, Trưa', 'active'),

('banh-mi-thit-2', 'Bánh Mì Thịt', 'Bánh Mì Thịt', 'នំបុ័ង', 'mon-an-vat', 
'Bánh mì Việt Nam với nhân thịt nguội, pate, rau thơm và nước sốt đặc biệt. Bánh mì giòn rụm, nhân đầy đặn và hương vị hài hòa.', 
'["Bánh mì", "Thịt nguội", "Pate", "Dưa leo", "Rau thơm", "Ớt", "Nước tương"]', 
'15.000 - 25.000 VNĐ', 
'hinhanh/DulichtpTV/Bánh mì mới.jpg', 
'Trà Vinh', 'Sáng, Chiều', 'active'),

('ca-phe-sua-da-2', 'Cà Phê Sữa Đá', 'Cà Phê Sữa Đá', 'កាហ្វេទឹកដោះគោ', 'do-uong', 
'Cà phê phin truyền thống pha với sữa đặc và đá, đậm đà và thơm ngon. Cà phê Việt Nam nổi tiếng với hương vị đặc trưng và cách pha độc đáo.', 
'["Cà phê", "Sữa đặc", "Đá"]', 
'15.000 - 25.000 VNĐ', 
'hinhanh/DulichtpTV/Cafe mới.jpg', 
'Trà Vinh', 'Cả ngày', 'active'),

('nuoc-mia-2', 'Nước Mía', 'Nước Mía', 'ទឹកអំពៅ', 'do-uong', 
'Nước mía tươi mát, ngọt thanh, giải nhiệt tuyệt vời. Nước mía được ép tươi, có thể thêm chanh hoặc kumquat để tăng hương vị.', 
'["Mía", "Đá", "Chanh (tùy chọn)"]', 
'8.000 - 15.000 VNĐ', 
'hinhanh/DulichtpTV/mía mới.jpg', 
'Trà Vinh', 'Cả ngày', 'active'),

('tra-sua-2', 'Trà Sữa', 'Trà Sữa', 'តែទឹកដោះគោ', 'do-uong', 
'Trà sữa với nhiều hương vị khác nhau, topping trân châu, thạch, pudding. Đồ uống được giới trẻ yêu thích với vị ngọt dịu và thơm mát.', 
'["Trà", "Sữa", "Đường", "Trân châu", "Thạch", "Đá"]', 
'20.000 - 35.000 VNĐ', 
'hinhanh/DulichtpTV/sửa mới.jpg', 
'Trà Vinh', 'Cả ngày', 'active'),

('sinh-to-bo-2', 'Sinh Tố Bơ', 'Sinh Tố Bơ', 'ស្មូធី', 'do-uong', 
'Sinh tố bơ béo ngậy, thơm ngon và bổ dưỡng. Bơ được xay nhuyễn với sữa tươi và đá, tạo nên ly sinh tố mát lạnh và giàu dinh dưỡng.', 
'["Bơ", "Sữa tươi", "Đường", "Đá"]', 
'25.000 - 35.000 VNĐ', 
'hinhanh/DulichtpTV/bơ mới.jpg', 
'Trà Vinh', 'Cả ngày', 'active'),

('kem-dua-2', 'Kem Dừa', 'Kem Dừa', 'ក្រែមដូង', 'banh-ngot', 
'Kem dừa mát lạnh với vị ngọt thanh của dừa tươi. Kem được làm từ nước cốt dừa tươi, béo ngậy và thơm ngon.', 
'["Nước cốt dừa", "Sữa", "Đường", "Cơm dừa"]', 
'10.000 - 20.000 VNĐ', 
'hinhanh/DulichtpTV/kem mới .jpg', 
'Trà Vinh', 'Cả ngày', 'active'),




-- *********************************************
-- Kiểm tra kết quả
-- *********************************************

SELECT COUNT(*) as 'Tổng số món ăn' FROM foods;
SELECT category, COUNT(*) as 'Số lượng' FROM foods GROUP BY category;

SELECT '✅ Đã hoàn thành quá trình xóa, tạo lại và chèn 21 món ăn thành công!' as 'Kết quả';