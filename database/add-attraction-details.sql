-- Thêm các cột chi tiết cho bảng attractions
-- Chạy file này để cập nhật cấu trúc bảng

ALTER TABLE attractions 
ADD COLUMN IF NOT EXISTS year_built VARCHAR(50) COMMENT 'Năm xây dựng',
ADD COLUMN IF NOT EXISTS cultural_significance TEXT COMMENT 'Đặc trưng văn hóa',
ADD COLUMN IF NOT EXISTS historical_value TEXT COMMENT 'Giá trị lịch sử',
ADD COLUMN IF NOT EXISTS architecture_style VARCHAR(255) COMMENT 'Phong cách kiến trúc',
ADD COLUMN IF NOT EXISTS notable_features TEXT COMMENT 'Điểm nổi bật',
ADD COLUMN IF NOT EXISTS religious_significance TEXT COMMENT 'Ý nghĩa tôn giáo',
ADD COLUMN IF NOT EXISTS opening_hours VARCHAR(255) COMMENT 'Giờ mở cửa',
ADD COLUMN IF NOT EXISTS best_time VARCHAR(255) COMMENT 'Thời gian tốt nhất để tham quan',
ADD COLUMN IF NOT EXISTS contact VARCHAR(100) COMMENT 'Thông tin liên hệ',
ADD COLUMN IF NOT EXISTS highlights TEXT COMMENT 'Các điểm nổi bật (phân cách bởi |)',
ADD COLUMN IF NOT EXISTS facilities TEXT COMMENT 'Tiện ích và dịch vụ (phân cách bởi |)',
ADD COLUMN IF NOT EXISTS latitude DECIMAL(10, 8) COMMENT 'Vĩ độ',
ADD COLUMN IF NOT EXISTS longitude DECIMAL(11, 8) COMMENT 'Kinh độ';

-- Cập nhật dữ liệu mẫu cho Chùa Somrongek
UPDATE attractions 
SET 
    year_built = 'Thế kỷ 16',
    cultural_significance = 'Kiến trúc Khmer đặc trưng với hoa văn tinh xảo, thể hiện sự giao thoa văn hóa Khmer - Việt',
    historical_value = 'Là một trong những ngôi chùa Khmer cổ nhất tại Trà Vinh, lưu giữ nhiều giá trị văn hóa và lịch sử của cộng đồng người Khmer',
    architecture_style = 'Kiến trúc Khmer truyền thống',
    notable_features = 'Tháp chuông cao 30m, tượng Phật bằng đồng cao 5m, hoa văn chạm khắc tinh xảo',
    religious_significance = 'Trung tâm sinh hoạt tôn giáo Phật giáo Nam Tông của cộng đồng người Khmer',
    opening_hours = '6:00 - 18:00 hàng ngày',
    best_time = 'Sáng sớm (6:00-8:00) hoặc chiều mát (16:00-18:00)',
    contact = '0294.3855.246',
    highlights = 'Kiến trúc Khmer độc đáo|Tượng Phật bằng đồng|Hoa văn chạm khắc tinh xảo|Không gian yên tĩnh|Lễ hội Ok Om Bok',
    facilities = 'Bãi đỗ xe miễn phí|Nhà vệ sinh|Khu vực nghỉ ngơi|Hướng dẫn viên|Quầy bán đồ lưu niệm',
    latitude = 9.9347,
    longitude = 106.3428
WHERE attraction_id = 'somrongek';

-- 2. Cập nhật dữ liệu cho Chùa Âng
UPDATE attractions 
SET 
    year_built = 'Hơn 1000 năm (thế kỷ 10)',
    cultural_significance = 'Ngôi chùa Khmer cổ kính nhất Trà Vinh, là biểu tượng văn hóa và tâm linh của cộng đồng người Khmer',
    historical_value = 'Chùa có niên đại hơn 1000 năm, là di tích lịch sử văn hóa quan trọng, lưu giữ nhiều hiện vật quý giá',
    architecture_style = 'Kiến trúc Angkor cổ điển',
    notable_features = 'Nghệ thuật điêu khắc tinh xảo, cổng tam quan uy nghi, tượng Phật cổ quý giá',
    religious_significance = 'Trung tâm Phật giáo Nam Tông quan trọng, nơi tổ chức các lễ hội Khmer truyền thống',
    opening_hours = '5:00 - 19:00 hàng ngày',
    best_time = 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)',
    contact = '0292.3851.222',
    highlights = 'Chùa cổ nhất (hơn 1000 năm)|Kiến trúc Angkor|Nghệ thuật điêu khắc|Di tích lịch sử|Văn hóa Khmer',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày',
    latitude = 9.9500,
    longitude = 106.3500
WHERE attraction_id = 'chuaang';

-- 3. Cập nhật dữ liệu cho Biển Ba Động
UPDATE attractions 
SET 
    year_built = 'Tự nhiên',
    cultural_significance = 'Bãi biển hoang sơ giữ nguyên vẻ đẹp tự nhiên, là điểm đến yêu thích của người dân địa phương',
    historical_value = 'Gắn liền với đời sống sinh hoạt và văn hóa biển của cư dân ven biển Trà Vinh',
    architecture_style = 'Cảnh quan thiên nhiên',
    notable_features = 'Cát trắng mịn, nước biển trong xanh, rừng dương ven biển, hải sản tươi ngon',
    religious_significance = 'Không có',
    opening_hours = '6:00 - 18:00 hàng ngày',
    best_time = 'Sáng sớm (6:00-9:00) hoặc chiều mát (15:00-18:00), tránh nắng gắt',
    contact = '0292.3852.333',
    highlights = 'Bãi biển hoang sơ|Cát trắng mịn|Nước trong xanh|Hải sản tươi ngon|Nghỉ dưỡng',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Nhà hàng hải sản|Cho thuê phao|Khu cắm trại',
    latitude = 9.7800,
    longitude = 106.4200
WHERE attraction_id = 'bienbadong';

-- 4. Cập nhật dữ liệu cho Chùa Vàm Rây
UPDATE attractions 
SET 
    year_built = 'Năm 1850 (cải tạo 2005)',
    cultural_significance = 'Chùa Khmer lớn nhất Trà Vinh, trung tâm văn hóa và tâm linh quan trọng của cộng đồng người Khmer',
    historical_value = 'Chùa có lịch sử hơn 170 năm, là nơi tổ chức nhiều lễ hội Khmer truyền thống lớn',
    architecture_style = 'Kiến trúc Khmer hiện đại kết hợp truyền thống',
    notable_features = 'Tượng Phật khổng lồ cao 18m, khuôn viên rộng 5 hecta, kiến trúc tráng lệ',
    religious_significance = 'Trung tâm Phật giáo Nam Tông lớn nhất tỉnh, nơi tu hành và giáo dục Phật pháp',
    opening_hours = '5:00 - 19:00 hàng ngày',
    best_time = 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00), đặc biệt dịp lễ hội Khmer',
    contact = '0292.3853.444',
    highlights = 'Chùa Khmer lớn nhất|Tượng Phật cao 18m|Kiến trúc tráng lệ|Khuôn viên rộng|Lễ hội Khmer',
    facilities = 'Bãi đỗ xe rộng|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Khu nghỉ ngơi',
    latitude = 9.8500,
    longitude = 106.2800
WHERE attraction_id = 'chuavamray';

-- 5. Cập nhật dữ liệu cho Rừng Đước Trà Vinh
UPDATE attractions 
SET 
    year_built = 'Tự nhiên (bảo tồn từ 1995)',
    cultural_significance = 'Khu bảo tồn rừng ngập mặn quan trọng, thể hiện nỗ lực bảo vệ môi trường của địa phương',
    historical_value = 'Là một trong những khu rừng ngập mặn lớn nhất miền Tây, có giá trị sinh thái cao',
    architecture_style = 'Hệ sinh thái tự nhiên',
    notable_features = 'Rừng đước nguyên sinh, hệ sinh thái đa dạng, tour thuyền kayak, quan sát chim hoang dã',
    religious_significance = 'Không có',
    opening_hours = '7:00 - 17:00 hàng ngày',
    best_time = 'Sáng sớm (7:00-9:00) để ngắm chim, tránh nắng gắt và thủy triều cao',
    contact = '0292.3854.555',
    highlights = 'Hệ sinh thái đa dạng|Tour thuyền kayak|Quan sát chim hoang dã|Rừng ngập mặn|Thiên nhiên hoang sơ',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Cho thuê thuyền kayak|Hướng dẫn viên|Áo phao an toàn',
    latitude = 9.6500,
    longitude = 106.5200
WHERE attraction_id = 'rungduoc';

-- 6. Cập nhật dữ liệu cho Cồn Chim
UPDATE attractions 
SET 
    year_built = 'Tự nhiên',
    cultural_significance = 'Hòn đảo sinh thái độc đáo, là nơi cư trú của hàng ngàn loài chim hoang dã',
    historical_value = 'Gắn liền với đời sống sinh hoạt của người dân ven sông, là điểm du lịch sinh thái nổi tiếng',
    architecture_style = 'Cảnh quan thiên nhiên',
    notable_features = 'Hàng ngàn loài chim, hòn đảo hoang sơ, cảnh quan sông nước miền Tây, tour thuyền',
    religious_significance = 'Không có',
    opening_hours = '6:00 - 17:00 hàng ngày',
    best_time = 'Sáng sớm (6:00-8:00) để ngắm chim bay về tổ, hoặc chiều (16:00-17:00)',
    contact = '0292.3855.666',
    highlights = 'Hàng ngàn loài chim|Hòn đảo hoang sơ|Quan sát thiên nhiên|Chụp ảnh đẹp|Tour thuyền',
    facilities = 'Thuyền đưa đón|Hướng dẫn viên|Áo phao|Ống nhòm quan sát',
    latitude = 9.9380,
    longitude = 106.3450
WHERE attraction_id = 'conchim';

-- 7. Cập nhật dữ liệu cho Chùa Hang
UPDATE attractions 
SET 
    year_built = 'Năm 1637 (thế kỷ 17)',
    cultural_significance = 'Ngôi chùa độc đáo ẩn trong hang động tự nhiên, thể hiện sự hòa quyện giữa tự nhiên và tâm linh',
    historical_value = 'Chùa có lịch sử gần 400 năm, là di tích lịch sử văn hóa cấp quốc gia',
    architecture_style = 'Kiến trúc hang động tự nhiên kết hợp Phật giáo',
    notable_features = 'Hang động tự nhiên, quần thể chim yến khổng lồ, không gian linh thiêng độc đáo',
    religious_significance = 'Trung tâm Phật giáo quan trọng, nơi tu hành và hành hương của Phật tử',
    opening_hours = '6:00 - 18:00 hàng ngày',
    best_time = 'Sáng sớm (6:00-8:00) hoặc chiều mát (16:00-18:00)',
    contact = '0292.3856.777',
    highlights = 'Chùa hang động độc đáo|Quần thể chim yến|Kiến trúc đặc biệt|Không gian linh thiêng|Thiên nhiên kỳ thú',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Đèn chiếu sáng trong hang',
    latitude = 9.9100,
    longitude = 106.2900
WHERE attraction_id = 'chuahang';

-- Cập nhật dữ liệu cho Bảo tàng Trà Vinh
UPDATE attractions 
SET 
    year_built = 'Năm 1976',
    cultural_significance = 'Trưng bày hiện vật về lịch sử, văn hóa các dân tộc Kinh - Khmer - Hoa tại Trà Vinh',
    historical_value = 'Lưu giữ hơn 3.000 hiện vật quý giá về lịch sử và văn hóa địa phương',
    architecture_style = 'Kiến trúc hiện đại kết hợp truyền thống',
    notable_features = 'Bộ sưu tập hiện vật phong phú, không gian trưng bày chuyên nghiệp',
    religious_significance = 'Không có',
    opening_hours = '7:30 - 11:00 và 13:30 - 17:00 (Thứ 2 - Thứ 7)',
    best_time = 'Buổi sáng hoặc chiều',
    contact = '0294.3855.246',
    highlights = 'Hiện vật lịch sử quý|Không gian trưng bày hiện đại|Tư liệu phong phú|Hướng dẫn viên chuyên nghiệp',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Điều hòa|Wifi miễn phí|Quầy bán sách',
    latitude = 9.9350,
    longitude = 106.3420
WHERE attraction_id = 'bao-tang';

-- 8. Cập nhật dữ liệu cho Ao Bà Om
UPDATE attractions 
SET 
    year_built = 'Tự nhiên (hồ tự nhiên cổ)',
    cultural_significance = 'Thắng cảnh quốc gia, địa điểm tổ chức lễ hội Ok Om Bok truyền thống của người Khmer',
    historical_value = 'Gắn liền với truyền thuyết và đời sống tâm linh văn hóa của cộng đồng người Khmer qua nhiều thế hệ',
    architecture_style = 'Cảnh quan thiên nhiên',
    notable_features = 'Hồ nước trong xanh, hơn 500 cây dầu cổ thụ kỳ dị, không gian xanh mát yên bình',
    religious_significance = 'Nơi tổ chức lễ hội Ok Om Bok - lễ hội truyền thống quan trọng nhất của người Khmer',
    opening_hours = '6:00 - 18:00 hàng ngày',
    best_time = 'Sáng sớm (6:00-8:00) hoặc chiều mát (16:00-18:00), đặc biệt mùa lễ hội (tháng 10 âm lịch)',
    contact = '0292.3851.111',
    highlights = 'Thắng cảnh quốc gia|Hơn 500 cây dầu cổ thụ|Truyền thuyết Khmer|Lễ hội Ok Om Bok|Không gian xanh mát',
    facilities = 'Bãi đỗ xe rộng|Nhà vệ sinh|Khu ăn uống|Khu vui chơi trẻ em|Cho thuê thuyền|Khu cắm trại',
    latitude = 9.9400,
    longitude = 106.3600
WHERE attraction_id = 'aobaom';

-- 9. Cập nhật dữ liệu cho Đền Thờ Bác Hồ
UPDATE attractions 
SET 
    year_built = 'Năm 1970',
    cultural_significance = 'Công trình tưởng niệm Chủ tịch Hồ Chí Minh, thể hiện lòng kính yêu của nhân dân Trà Vinh',
    historical_value = 'Nơi lưu giữ kỷ vật và tư liệu về Chủ tịch Hồ Chí Minh, là điểm giáo dục truyền thống cách mạng',
    architecture_style = 'Kiến trúc hiện đại trang nghiêm',
    notable_features = 'Tượng Bác Hồ, phòng trưng bày tư liệu, không gian trang nghiêm',
    religious_significance = 'Không có',
    opening_hours = '7:00 - 17:00 hàng ngày',
    best_time = 'Sáng (8:00-10:00) hoặc chiều (14:00-16:00)',
    contact = '0292.3858.999',
    highlights = 'Công trình tưởng niệm|Giáo dục truyền thống|Tìm hiểu lịch sử|Không gian trang nghiêm|Điểm tham quan',
    facilities = 'Bãi đỗ xe rộng|Nhà vệ sinh|Khu trưng bày|Khu nghỉ ngơi|Nước uống miễn phí',
    latitude = 9.9320,
    longitude = 106.3380
WHERE attraction_id = 'denbacho';

-- 10. Cập nhật dữ liệu cho Nhà Thờ Đức Mỹ
UPDATE attractions 
SET 
    year_built = 'Năm 1902 (đầu thế kỷ 20)',
    cultural_significance = 'Công trình kiến trúc tôn giáo Công giáo tiêu biểu, trung tâm sinh hoạt của cộng đồng Công giáo',
    historical_value = 'Nhà thờ có lịch sử hơn 120 năm, là di tích kiến trúc nghệ thuật quý giá',
    architecture_style = 'Kiến trúc Gothic cổ điển châu Âu',
    notable_features = 'Tháp chuông cao vút, cửa sổ kính màu đẹp, không gian trang nghiêm linh thiêng',
    religious_significance = 'Trung tâm Công giáo quan trọng tại huyện Càng Long, nơi tổ chức các thánh lễ và lễ hội',
    opening_hours = '6:00 - 18:00 hàng ngày (tránh giờ lễ)',
    best_time = 'Sáng sớm hoặc chiều mát, tránh giờ lễ (6:00, 17:00), đặc biệt đẹp vào lễ Giáng sinh',
    contact = '0292.3859.111',
    highlights = 'Kiến trúc Gothic cổ điển|Tháp chuông cao vút|Cửa sổ kính màu|Không gian trang nghiêm|Lễ Giáng sinh',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Khu ngồi nghỉ|Nước uống miễn phí',
    latitude = 9.9800,
    longitude = 106.2500
WHERE attraction_id = 'ducmy';

-- 11. Cập nhật dữ liệu cho Chùa Cành
UPDATE attractions 
SET 
    year_built = 'Năm 1820 (thế kỷ 19)',
    cultural_significance = 'Ngôi chùa Khmer nổi tiếng với lễ hội Chaul Chnam Thmey (Tết Khmer) sôi động',
    historical_value = 'Chùa có lịch sử hơn 200 năm, là trung tâm văn hóa và tâm linh của cộng đồng người Khmer',
    architecture_style = 'Kiến trúc Khmer truyền thống',
    notable_features = 'Kiến trúc đẹp, sân khấu lễ hội rộng, không gian yên tĩnh, nghệ thuật trang trí tinh xảo',
    religious_significance = 'Trung tâm Phật giáo Nam Tông, nơi tổ chức lễ hội Tết Khmer và các nghi lễ truyền thống',
    opening_hours = '5:00 - 19:00 hàng ngày',
    best_time = 'Sáng sớm (5:00-7:00) hoặc dịp lễ hội Tết Khmer (tháng 4 dương lịch)',
    contact = '0292.3860.222',
    highlights = 'Lễ hội Tết Khmer|Văn hóa truyền thống|Kiến trúc đẹp|Không gian yên tĩnh|Hoạt động sôi động',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Sân khấu lễ hội|Khu nghỉ ngơi',
    latitude = 9.9600,
    longitude = 106.3100
WHERE attraction_id = 'chuacanh';

-- 12. Cập nhật dữ liệu cho Bảo tàng Văn hóa Dân tộc Khmer
UPDATE attractions 
SET 
    year_built = 'Năm 2012',
    cultural_significance = 'Bảo tàng chuyên đề đầu tiên về văn hóa Khmer tại Việt Nam, lưu giữ bản sắc văn hóa dân tộc',
    historical_value = 'Lưu giữ hơn 3.000 hiện vật quý giá từ thế kỷ 7 đến nay, tư liệu về lịch sử văn hóa Khmer',
    architecture_style = 'Kiến trúc hiện đại kết hợp yếu tố Khmer truyền thống',
    notable_features = 'Hơn 3.000 hiện vật quý, phòng trưng bày chuyên nghiệp, tư liệu phong phú',
    religious_significance = 'Không có',
    opening_hours = '7:30 - 11:00 và 13:30 - 17:00 (Thứ 2 - Thứ 7)',
    best_time = 'Sáng (8:00-10:00) hoặc chiều (14:00-16:00)',
    contact = '0292.3861.333',
    highlights = 'Bảo tàng chuyên đề đầu tiên|Hơn 3.000 hiện vật|Văn hóa Khmer|Từ thế kỷ 7|Giáo dục lịch sử',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Phòng trưng bày|Hướng dẫn viên|Điều hòa',
    latitude = 9.9360,
    longitude = 106.3440
WHERE attraction_id = 'baotangkhmer';

-- 13. Cập nhật dữ liệu cho Thiền Viện Trúc Lâm Duyên Hải
UPDATE attractions 
SET 
    year_built = 'Năm 2010',
    cultural_significance = 'Thiền viện lớn nhất miền Tây, trung tâm tu hành và giáo dục Phật pháp',
    historical_value = 'Công trình Phật giáo hiện đại, góp phần phát triển du lịch tâm linh tại Trà Vinh',
    architecture_style = 'Kiến trúc Phật giáo Việt Nam hiện đại',
    notable_features = 'Diện tích 50 hecta, vườn sen đẹp, rừng tre xanh mướt, không gian tu hành yên tĩnh',
    religious_significance = 'Trung tâm tu hành Phật giáo Thiền phái Trúc Lâm, nơi tổ chức các khóa tu và giáo dục Phật pháp',
    opening_hours = '6:00 - 18:00 hàng ngày',
    best_time = 'Sáng sớm (6:00-8:00) để tham gia khóa tu hoặc ngồi thiền',
    contact = '0292.3862.444',
    highlights = 'Thiền viện lớn nhất miền Tây|Diện tích 50 hecta|Vườn sen đẹp|Rừng tre xanh|Tu hành yên tĩnh',
    facilities = 'Bãi đỗ xe rộng|Nhà vệ sinh|Nhà khách|Phòng ăn chay|Wifi miễn phí',
    latitude = 9.6200,
    longitude = 106.5500
WHERE attraction_id = 'thienvientriclam';

-- 14. Cập nhật dữ liệu cho Chùa Khmer Phương Thạnh Pisay
UPDATE attractions 
SET 
    year_built = 'Năm 2008 (cải tạo hiện đại)',
    cultural_significance = 'Ngôi chùa hiện đại với kiến trúc độc đáo, biểu tượng của sự phát triển văn hóa Khmer',
    historical_value = 'Chùa được xây dựng trên nền chùa cổ, kết hợp giữa truyền thống và hiện đại',
    architecture_style = 'Kiến trúc Khmer hiện đại độc đáo',
    notable_features = 'Tháp Phật 7 tầng cao 35m, nghệ thuật trang trí đẹp, vườn hoa rộng',
    religious_significance = 'Trung tâm Phật giáo Nam Tông, nơi tổ chức các lễ hội Khmer lớn',
    opening_hours = '5:00 - 19:00 hàng ngày',
    best_time = 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)',
    contact = '0292.3863.555',
    highlights = 'Tháp Phật 7 tầng cao 35m|Kiến trúc hiện đại độc đáo|Nghệ thuật trang trí đẹp|Vườn hoa đẹp|Lễ hội Khmer',
    facilities = 'Bãi đỗ xe rộng|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Vườn hoa nghỉ ngơi',
    latitude = 9.9700,
    longitude = 106.2600
WHERE attraction_id = 'chuaphuongthanhpisay';

-- 15. Cập nhật dữ liệu cho Nhà Thờ Công Giáo Mạc Bắc
UPDATE attractions 
SET 
    year_built = 'Năm 1910 (đầu thế kỷ 20)',
    cultural_significance = 'Công trình kiến trúc tôn giáo Công giáo tiêu biểu với lối kiến trúc Gothic châu Âu',
    historical_value = 'Nhà thờ có lịch sử hơn 110 năm, là di tích lịch sử văn hóa của cộng đồng Công giáo',
    architecture_style = 'Kiến trúc Gothic châu Âu cổ điển',
    notable_features = 'Tháp chuông cao vút, cửa sổ kính màu nghệ thuật, không gian linh thiêng',
    religious_significance = 'Trung tâm Công giáo quan trọng tại huyện Tiểu Cần, nơi tổ chức các thánh lễ',
    opening_hours = '6:00 - 18:00 hàng ngày (tránh giờ lễ)',
    best_time = 'Sáng sớm hoặc chiều mát, tránh giờ lễ (6:00, 17:00), đặc biệt đẹp vào lễ Giáng sinh',
    contact = '0292.3864.666',
    highlights = 'Kiến trúc Gothic châu Âu|Tháp chuông cao vút|Cửa sổ kính màu|Di tích lịch sử|Lễ Giáng sinh',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Khu ngồi nghỉ|Nước uống miễn phí',
    latitude = 9.8800,
    longitude = 106.3200
WHERE attraction_id = 'nhathomacbac';

-- 16. Cập nhật dữ liệu cho Chùa Kom Pong (Ông Mẹt)
UPDATE attractions 
SET 
    year_built = 'Năm 1789 (thế kỷ 18)',
    cultural_significance = 'Ngôi chùa Khmer cổ kính với kiến trúc truyền thống, trung tâm văn hóa tâm linh',
    historical_value = 'Chùa có lịch sử hơn 230 năm, lưu giữ nhiều hiện vật và truyền thống văn hóa Khmer',
    architecture_style = 'Kiến trúc Khmer truyền thống cổ điển',
    notable_features = 'Nghệ thuật trang trí tinh xảo, tượng Phật quý giá, khuôn viên rộng rãi',
    religious_significance = 'Trung tâm Phật giáo Nam Tông, nơi tổ chức các lễ hội truyền thống Khmer',
    opening_hours = '5:00 - 19:00 hàng ngày',
    best_time = 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)',
    contact = '0292.3865.777',
    highlights = 'Kiến trúc Khmer cổ kính|Nghệ thuật trang trí|Khuôn viên rộng rãi|Tượng Phật quý giá|Lễ hội truyền thống',
    facilities = 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Khu nghỉ ngơi',
    latitude = 9.9370,
    longitude = 106.3410
WHERE attraction_id = 'chuakompong';

-- 17. Cập nhật dữ liệu cho Chùa Saleng (Kompong Chrây)
UPDATE attractions 
SET 
    year_built = 'Năm 1850 (cải tạo 2015)',
    cultural_significance = 'Được mệnh danh là "Viên ngọc kiến trúc Khmer giữa lòng Trà Cú", biểu tượng văn hóa Khmer',
    historical_value = 'Chùa có lịch sử hơn 170 năm, là di tích văn hóa quan trọng của cộng đồng người Khmer',
    architecture_style = 'Kiến trúc Khmer tráng lệ hiện đại',
    notable_features = 'Tượng Phật nằm dài 20m được chạm khắc tỉ mỉ, kiến trúc tráng lệ, nghệ thuật chạm khắc tinh xảo',
    religious_significance = 'Trung tâm Phật giáo Nam Tông lớn tại Trà Cú, nơi tổ chức các lễ hội Phật giáo',
    opening_hours = '5:00 - 19:00 hàng ngày',
    best_time = 'Sáng sớm (5:00-7:00) để tham gia lễ chùa và ngắm bình minh',
    contact = '0292.3866.888',
    highlights = 'Viên ngọc kiến trúc Khmer|Tượng Phật nằm dài 20m|Kiến trúc tráng lệ|Nghệ thuật chạm khắc|Lễ hội Phật giáo',
    facilities = 'Bãi đỗ xe rộng|Nhà vệ sinh sạch sẽ|Khu thắp hương|Phòng trưng bày|Nước uống miễn phí',
    latitude = 9.8200,
    longitude = 106.2700
WHERE attraction_id = 'chuasaleng';

-- 18. Cập nhật dữ liệu cho Khu Du Lịch Huỳnh Kha
UPDATE attractions 
SET 
    year_built = 'Năm 2005',
    cultural_significance = 'Khu du lịch sinh thái kết hợp văn hóa miền Tây, điểm đến giải trí gia đình',
    historical_value = 'Phát triển từ vườn trái cây gia đình, thể hiện nét văn hóa vườn miệt vườn miền Tây',
    architecture_style = 'Kiến trúc sinh thái miền Tây',
    notable_features = 'Không gian xanh mát, vườn trái cây, khu câu cá, ẩm thực miền Tây đặc sắc',
    religious_significance = 'Không có',
    opening_hours = '7:00 - 18:00 hàng ngày',
    best_time = 'Cuối tuần, mùa trái cây (tháng 5-8)',
    contact = '0292.3867.999',
    highlights = 'Không gian xanh mát|Câu cá giải trí|Chèo thuyền|Vườn trái cây|Ẩm thực miền Tây',
    facilities = 'Bãi đỗ xe rộng|Nhà vệ sinh|Nhà hàng|Khu vui chơi trẻ em|Cho thuê thuyền',
    latitude = 9.9390,
    longitude = 106.3470
WHERE attraction_id = 'khudulichhuynhkha';

-- Thông báo hoàn thành
SELECT 'Đã cập nhật thành công cấu trúc bảng attractions và dữ liệu mẫu!' as message;
