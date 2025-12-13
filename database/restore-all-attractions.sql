-- Khôi phục tất cả các địa điểm du lịch Trà Vinh
-- File này sẽ insert lại tất cả dữ liệu

-- Xóa dữ liệu cũ (nếu có)
TRUNCATE TABLE attractions;

-- Insert lại tất cả địa điểm
INSERT INTO attractions (attraction_id, name, description, category, address, latitude, longitude, image_url, rating, opening_hours, ticket_price, status) VALUES

-- Chùa Khmer
('aobaom', 'Ao Bà Om', 'Ao Bà Om là một thắng cảnh nổi tiếng của tỉnh Trà Vinh, gắn liền với đời sống văn hóa tâm linh của đồng bào Khmer. Nơi đây có cảnh quan thiên nhiên tươi đẹp với hồ nước trong xanh, cây cối um tùm và nhiều công trình kiến trúc độc đáo.', 'Chùa Khmer', 'Phường 8, TP. Trà Vinh', 9.9347, 106.3422, 'hinhanh/DulichtpTV/aobaom-02-1024x686.jpg', 4.8, '06:00 - 18:00', 'Miễn phí', 'active'),

('chuaang', 'Chùa Âng', 'Chùa Âng (Angkor Rajaborey) là ngôi chùa Khmer cổ nhất tỉnh Trà Vinh với lịch sử hơn 1000 năm. Kiến trúc chùa mang đậm nét văn hóa Khmer Nam Bộ với những hoa văn tinh xảo, tượng Phật linh thiêng.', 'Chùa Khmer', 'Xã Ngũ Lạc, huyện Châu Thành', 9.9876, 106.2543, 'hinhanh/DulichtpTV/maxresdefault.jpg', 4.7, '05:00 - 19:00', 'Miễn phí', 'active'),

('chuacompong', 'Chùa Kompong Chrây', 'Chùa Kompong Chrây là một trong những ngôi chùa Khmer đẹp nhất Trà Vinh. Chùa có kiến trúc độc đáo với mái cong đặc trưng, trang trí hoa văn tinh tế và nhiều tượng Phật quý giá.', 'Chùa Khmer', 'Xã Lưu Nghiệp Anh, huyện Tiểu Cần', 9.8234, 106.4567, 'hinhanh/DulichtpTV/chua-kompong-chray.jpg', 4.6, '05:30 - 18:30', 'Miễn phí', 'active'),

-- Chùa Phật giáo
('chuahang', 'Chùa Hang', 'Chùa Hang là ngôi chùa độc đáo được xây dựng trong hang đá tự nhiên. Kiến trúc chùa hài hòa với thiên nhiên, tạo nên không gian thanh tịnh, linh thiêng.', 'Chùa Phật giáo', 'Xã Tân Hiệp, huyện Châu Thành', 9.9123, 106.3789, 'hinhanh/DulichtpTV/chua-hang.jpg', 4.5, '06:00 - 17:00', 'Miễn phí', 'active'),

('truclamduyenhai', 'Thiền Viện Trúc Lâm Duyên Hải', 'Thiền viện Trúc Lâm Duyên Hải là quần thể kiến trúc Phật giáo hiện đại, nằm giữa không gian yên tĩnh với cây xanh, hồ nước. Đây là nơi tu tập và tham quan tâm linh lý tưởng.', 'Chùa Phật giáo', 'Xã Dân Thành, huyện Trà Cú', 9.7456, 106.5234, 'hinhanh/DulichtpTV/thien-vien-truc-lam.jpg', 4.7, '05:00 - 20:00', 'Miễn phí', 'active'),

-- Di tích lịch sử
('baotangtrav
inh', 'Bảo Tàng Tỉnh Trà Vinh', 'Bảo tàng tỉnh Trà Vinh lưu giữ và trưng bày nhiều hiện vật quý giá về lịch sử, văn hóa của vùng đất và con người Trà Vinh qua các thời kỳ.', 'Di tích lịch sử', 'Phường 1, TP. Trà Vinh', 9.9456, 106.3456, 'hinhanh/DulichtpTV/bao-tang-tra-vinh.jpg', 4.3, '07:30 - 11:00, 13:30 - 17:00', '10.000 VNĐ', 'active'),

('dinbachac', 'Đình Bà Chúa Xứ', 'Đình Bà Chúa Xứ là di tích lịch sử văn hóa quan trọng, nơi thờ Bà Chúa Xứ - vị thần linh được người dân địa phương tôn kính. Kiến trúc đình mang đậm nét văn hóa Nam Bộ.', 'Di tích lịch sử', 'Xã Ba Động, huyện Trà Cú', 9.7234, 106.5678, 'hinhanh/DulichtpTV/dinh-ba-chua-xu.jpg', 4.4, '06:00 - 18:00', 'Miễn phí', 'active'),

-- Biển và thiên nhiên
('bienbadong', 'Biển Ba Động', 'Biển Ba Động là bãi biển hoang sơ, đẹp tự nhiên với cát trắng mịn, nước biển trong xanh. Đây là điểm đến lý tưởng cho những ai yêu thích sự yên tĩnh và khám phá thiên nhiên.', 'Biển', 'Xã Ba Động, huyện Trà Cú', 9.6789, 106.6234, 'hinhanh/DulichtpTV/Kham-pha-Khu-du-lich-Bien-Ba-Dong-Tra-Vinh-2022.jpg.webp', 4.6, 'Cả ngày', 'Miễn phí', 'active'),

('cayduasautrau', 'Cây Dừa Sáu Trái', 'Cây dừa sáu trái là cây dừa kỳ lạ mọc 6 trái trên một buồng, được xem là biểu tượng may mắn. Đây là điểm tham quan độc đáo thu hút nhiều du khách.', 'Thiên nhiên', 'Xã Tập Sơn, huyện Trà Cú', 9.7123, 106.5456, 'hinhanh/DulichtpTV/cay-dua-sau-trai.jpg', 4.2, '07:00 - 17:00', 'Miễn phí', 'active'),

('rungduabaymo', 'Rừng Dừa Bảy Mẫu', 'Rừng dừa Bảy Mẫu là khu rừng dừa nước tự nhiên rộng lớn, nơi có hệ sinh thái đa dạng. Du khách có thể đi thuyền khám phá rừng dừa, thưởng thức đặc sản địa phương.', 'Thiên nhiên', 'Xã Tân Sơn, huyện Trà Cú', 9.6456, 106.5789, 'hinhanh/DulichtpTV/rung-dua-bay-mau.jpg', 4.5, '06:00 - 18:00', '20.000 VNĐ', 'active'),

-- Sinh thái và văn hóa
('langvanhoakhmer', 'Làng Văn Hóa Du Lịch Khmer', 'Làng văn hóa du lịch Khmer tái hiện không gian sinh hoạt truyền thống của đồng bào Khmer với nhà sàn, sân khấu biểu diễn nghệ thuật dân gian và các hoạt động văn hóa đặc sắc.', 'Văn hóa', 'Phường 9, TP. Trà Vinh', 9.9234, 106.3567, 'hinhanh/DulichtpTV/lang-van-hoa-khmer.jpg', 4.4, '08:00 - 17:00', '30.000 VNĐ', 'active'),

('khudulichbadong', 'Khu Du Lịch Sinh Thái Ba Động', 'Khu du lịch sinh thái Ba Động kết hợp giữa biển, rừng dừa và các hoạt động giải trí. Nơi đây có nhà hàng hải sản, khu cắm trại và nhiều trò chơi thú vị.', 'Sinh thái', 'Xã Ba Động, huyện Trà Cú', 9.6890, 106.6123, 'hinhanh/DulichtpTV/khu-du-lich-ba-dong.jpg', 4.5, '07:00 - 19:00', '50.000 VNĐ', 'active'),

('chobinhthuy', 'Chợ Nổi Bình Thủy', 'Chợ nổi Bình Thủy là nét văn hóa đặc trưng của vùng sông nước miền Tây. Du khách có thể trải nghiệm mua bán trên thuyền, thưởng thức đặc sản địa phương.', 'Văn hóa', 'Xã Bình Thủy, huyện Càng Long', 9.8567, 106.2890, 'hinhanh/DulichtpTV/cho-noi-binh-thuy.jpg', 4.3, '05:00 - 09:00', 'Miễn phí', 'active');

-- Kiểm tra kết quả
SELECT COUNT(*) as total_attractions FROM attractions;
SELECT category, COUNT(*) as count FROM attractions GROUP BY category;
