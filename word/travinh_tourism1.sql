-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 24, 2025 lúc 01:10 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `travinh_tourism`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `facebook_id` varchar(100) DEFAULT NULL,
  `avatar_url` varchar(500) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','manager','user') DEFAULT 'user',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `app_users`
--

INSERT INTO `app_users` (`id`, `username`, `password`, `email`, `google_id`, `facebook_id`, `avatar_url`, `full_name`, `phone`, `role`, `status`, `created_at`) VALUES
(1, 'manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager@travinh.edu.vn', NULL, NULL, NULL, 'Nguyễn Văn Quản Lý', '0292.3855.247', 'manager', 'active', '2024-01-15 02:00:00'),
(2, 'user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user1@gmail.com', NULL, NULL, NULL, 'Trần Thị Hương', '0901234567', 'user', 'active', '2024-06-10 03:30:00'),
(3, 'user2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user2@gmail.com', NULL, NULL, NULL, 'Lê Văn Minh', '0912345678', 'user', 'active', '2024-07-20 07:15:00'),
(6, 'admin', '$2y$10$DWXvd4SfMTfoOyyW3ZZYKezUpIiKGo6ClwtQVPJCzKKQlt5Z20Cca', 'admin@travinh.vn', NULL, NULL, NULL, 'Quản Trị Viên', '0123456789', 'admin', 'active', '2025-11-14 04:16:22'),
(8, 'nhutminh', '$2y$10$slZT7AxdMrIrZJQoaMAhPuumgeomL0PU3rXMNrsYNkGt.Ll49igJS', 'nhutminh@gmail.com', NULL, NULL, NULL, 'Nhựt Minh', NULL, 'user', 'active', '2025-11-15 13:30:11'),
(9, 'socna', '$2y$10$slZT7AxdMrIrZJQoaMAhPuumgeomL0PU3rXMNrsYNkGt.Ll49igJS', 'socna@gmail.com', NULL, NULL, NULL, 'Sóc Na', NULL, 'user', 'active', '2025-11-15 13:30:11'),
(10, 'Nhựt Minh', '$2y$10$lve9B6OAKBoXei/n5/PmPemCU1wgVZg9vv4eGmvl8034ROT2K88fi', 'thachnhatminh8@gmail.com', NULL, NULL, NULL, 'Thạch Nhựt Minh', '0366058110', 'user', '', '2025-11-19 07:51:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attractions`
--

CREATE TABLE `attractions` (
  `id` int(11) NOT NULL,
  `attraction_id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `ticket_price` varchar(100) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `opening_hours` varchar(200) DEFAULT NULL,
  `highlights` text DEFAULT NULL,
  `facilities` text DEFAULT NULL,
  `best_time` varchar(200) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `year_built` varchar(50) DEFAULT NULL COMMENT 'Năm xây dựng',
  `cultural_significance` text DEFAULT NULL COMMENT 'Đặc trưng văn hóa',
  `historical_value` text DEFAULT NULL COMMENT 'Giá trị lịch sử',
  `architecture_style` varchar(255) DEFAULT NULL COMMENT 'Phong cách kiến trúc',
  `notable_features` text DEFAULT NULL COMMENT 'Điểm nổi bật',
  `religious_significance` text DEFAULT NULL COMMENT 'Ý nghĩa tôn giáo',
  `latitude` decimal(10,8) DEFAULT NULL COMMENT 'Vĩ độ',
  `longitude` decimal(11,8) DEFAULT NULL COMMENT 'Kinh độ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `attractions`
--

INSERT INTO `attractions` (`id`, `attraction_id`, `name`, `description`, `location`, `category`, `ticket_price`, `image_url`, `opening_hours`, `highlights`, `facilities`, `best_time`, `contact`, `status`, `created_at`, `updated_at`, `year_built`, `cultural_significance`, `historical_value`, `architecture_style`, `notable_features`, `religious_significance`, `latitude`, `longitude`) VALUES
(1, 'aobaom', 'Ao Bà Om', 'Ao Bà Om là thắng cảnh quốc gia nổi tiếng với truyền thuyết về cuộc thi đắp đập của phụ nữ Khmer. Khu vực có hơn 500 cây dầu cổ thụ kỳ dị, tạo nên không gian xanh mát, yên bình. Đây là nơi tổ chức nhiều lễ hội truyền thống của đồng bào Khmer.', 'Phường 8, Thành phố Trà Vinh, Tỉnh Trà Vinh (cách trung tâm 2km)', 'Di tích lịch sử', 'Miễn phí', 'hinhanh/DulichtpTV/aobaom-02-1024x686.jpg', '6:00 - 18:00 hàng ngày', 'Thắng cảnh quốc gia|Hơn 500 cây dầu cổ thụ|Truyền thuyết Khmer|Lễ hội Ok Om Bok|Không gian xanh mát', 'Bãi đỗ xe rộng|Nhà vệ sinh|Khu ăn uống|Khu vui chơi trẻ em|Cho thuê thuyền|Khu cắm trại', 'Sáng sớm (6:00-8:00) hoặc chiều mát (16:00-18:00), đặc biệt mùa lễ hội (tháng 10 âm lịch)', '0292.3851.111', 'active', '2025-11-12 09:07:11', '2025-11-15 07:14:15', 'Tự nhiên (hồ tự nhiên cổ)', 'Thắng cảnh quốc gia, địa điểm tổ chức lễ hội Ok Om Bok truyền thống của người Khmer', 'Gắn liền với truyền thuyết và đời sống tâm linh văn hóa của cộng đồng người Khmer qua nhiều thế hệ', 'Cảnh quan thiên nhiên', 'Hồ nước trong xanh, hơn 500 cây dầu cổ thụ kỳ dị, không gian xanh mát yên bình', 'Nơi tổ chức lễ hội Ok Om Bok - lễ hội truyền thống quan trọng nhất của người Khmer', 9.94000000, 106.36000000),
(2, 'chuaang', 'Chùa Âng', 'Chùa Âng là ngôi chùa Khmer cổ kính nhất Trà Vinh với niên đại hơn 1000 năm. Kiến trúc Angkor độc đáo với nghệ thuật điêu khắc tinh xảo. Chùa là di tích lịch sử văn hóa quan trọng của cộng đồng người Khmer.', 'Khu di tích Ao Bà Om, Phường 8, Thành phố Trà Vinh', 'Chùa Khmer', 'Miễn phí', 'hinhanh/DulichtpTV/maxresdefault.jpg', '5:00 - 19:00 hàng ngày', 'Chùa cổ nhất (hơn 1000 năm)|Kiến trúc Angkor|Nghệ thuật điêu khắc|Di tích lịch sử|Văn hóa Khmer', 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày', 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)', '0292.3851.222', 'active', '2025-11-12 09:07:11', '2025-11-15 07:14:14', 'Hơn 1000 năm (thế kỷ 10)', 'Ngôi chùa Khmer cổ kính nhất Trà Vinh, là biểu tượng văn hóa và tâm linh của cộng đồng người Khmer', 'Chùa có niên đại hơn 1000 năm, là di tích lịch sử văn hóa quan trọng, lưu giữ nhiều hiện vật quý giá', 'Kiến trúc Angkor cổ điển', 'Nghệ thuật điêu khắc tinh xảo, cổng tam quan uy nghi, tượng Phật cổ quý giá', 'Trung tâm Phật giáo Nam Tông quan trọng, nơi tổ chức các lễ hội Khmer truyền thống', 9.95000000, 106.35000000),
(3, 'bienbadong', 'Biển Ba Động', 'Biển Ba Động là bãi biển hoang sơ với cát trắng mịn và nước biển trong xanh. Đây là điểm đến lý tưởng cho du lịch nghỉ dưỡng, tắm biển và thưởng thức hải sản tươi ngon.', 'Xã Đôn Châu, Huyện Cầu Ngang, Tỉnh Trà Vinh (cách TP 35km)', 'Sinh thái', 'Miễn phí', 'hinhanh/DulichtpTV/Kham-pha-Khu-du-lich-Bien-Ba-Dong-Tra-Vinh-2022.jpg.webp', '6:00 - 18:00 hàng ngày', 'Bãi biển hoang sơ|Cát trắng mịn|Nước trong xanh|Hải sản tươi ngon|Nghỉ dưỡng', 'Bãi đỗ xe|Nhà vệ sinh|Nhà hàng hải sản|Cho thuê phao|Khu cắm trại', 'Sáng sớm (6:00-9:00) hoặc chiều mát (15:00-18:00), tránh nắng gắt', '0292.3852.333', 'active', '2025-11-12 09:07:11', '2025-11-15 07:14:14', 'Tự nhiên', 'Bãi biển hoang sơ giữ nguyên vẻ đẹp tự nhiên, là điểm đến yêu thích của người dân địa phương', 'Gắn liền với đời sống sinh hoạt và văn hóa biển của cư dân ven biển Trà Vinh', 'Cảnh quan thiên nhiên', 'Cát trắng mịn, nước biển trong xanh, rừng dương ven biển, hải sản tươi ngon', 'Không có', 9.78000000, 106.42000000),
(4, 'chuavamray', 'Chùa Vàm Rây', 'Chùa Vàm Rây là ngôi chùa Khmer lớn nhất Trà Vinh với kiến trúc tráng lệ. Nổi tiếng với tượng Phật khổng lồ cao 18m và khuôn viên rộng rãi, nhiều cây xanh.', 'xã Hàm Tân, huyện Trà Cú, tỉnh Trà Vinh  (cách TP 25km)', 'Chùa Khmer', 'Miễn phí', 'hinhanh/DulichtpTV/chuavamraytravinh-1.jpg', '5:00 - 19:00 hàng ngày', 'Chùa Khmer lớn nhất|Tượng Phật cao 18m|Kiến trúc tráng lệ|Khuôn viên rộng|Lễ hội Khmer', 'Bãi đỗ xe rộng|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Khu nghỉ ngơi', 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00), đặc biệt dịp lễ hội Khmer', '0292.3853.444', 'active', '2025-11-12 09:07:11', '2025-11-15 07:14:15', 'Năm 1850 (cải tạo 2005)', 'Chùa Khmer lớn nhất Trà Vinh, trung tâm văn hóa và tâm linh quan trọng của cộng đồng người Khmer', 'Chùa có lịch sử hơn 170 năm, là nơi tổ chức nhiều lễ hội Khmer truyền thống lớn', 'Kiến trúc Khmer hiện đại kết hợp truyền thống', 'Tượng Phật khổng lồ cao 18m, khuôn viên rộng 5 hecta, kiến trúc tráng lệ', 'Trung tâm Phật giáo Nam Tông lớn nhất tỉnh, nơi tu hành và giáo dục Phật pháp', 9.85000000, 106.28000000),
(6, 'conchim', 'Cồn Chim', 'Cồn Chim là hòn đảo nhỏ trên sông Hậu với hàng ngàn loài chim hoang dá sinh sống. Đây là điểm đến lý tưởng cho những người yêu thiên nhiên và nhiếp ảnh.', 'Sông Hậu, Thành phố Trà Vinh (đi thuyền từ bến Trà Vinh)', 'Sinh thái', '30.000đ/người (bao gồm thuyền)', 'hinhanh/DulichtpTV/tourconchimtravinh.jpg', '6:00 - 17:00 hàng ngày', 'Hàng ngàn loài chim|Hòn đảo hoang sơ|Quan sát thiên nhiên|Chụp ảnh đẹp|Tour thuyền', 'Thuyền đưa đón|Hướng dẫn viên|Áo phao|Ống nhòm quan sát', 'Sáng sớm (6:00-8:00) để ngắm chim bay về tổ, hoặc chiều (16:00-17:00)', '0292.3855.666', 'active', '2025-11-12 09:07:11', '2025-11-15 07:14:15', 'Tự nhiên', 'Hòn đảo sinh thái độc đáo, là nơi cư trú của hàng ngàn loài chim hoang dã', 'Gắn liền với đời sống sinh hoạt của người dân ven sông, là điểm du lịch sinh thái nổi tiếng', 'Cảnh quan thiên nhiên', 'Hàng ngàn loài chim, hòn đảo hoang sơ, cảnh quan sông nước miền Tây, tour thuyền', 'Không có', 9.93800000, 106.34500000),
(7, 'chuahang', 'Chùa Hang', 'Chùa Hang là ngôi chùa độc đáo ẩn sâu trong lòng đất với kiến trúc hang động tự nhiên. Nổi tiếng với quần thể chim yến khổng lồ sinh sống trong hang.', 'Khóm 3, Thị trấn Châu Thành, Huyện Châu Thành, Tỉnh Trà Vinh', 'Chùa Phật giáo', 'Miễn phí', 'hinhanh/DulichtpTV/Cổng_chùa_Hang_(Trà_Vinh).jpg', '6:00 - 18:00 hàng ngày', 'Chùa hang động độc đáo|Quần thể chim yến|Kiến trúc đặc biệt|Không gian linh thiêng|Thiên nhiên kỳ thú', 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Đèn chiếu sáng trong hang', 'Sáng sớm (6:00-8:00) hoặc chiều mát (16:00-18:00)', '0292.3856.777', 'active', '2025-11-12 09:07:11', '2025-11-15 07:14:15', 'Năm 1637 (thế kỷ 17)', 'Ngôi chùa độc đáo ẩn trong hang động tự nhiên, thể hiện sự hòa quyện giữa tự nhiên và tâm linh', 'Chùa có lịch sử gần 400 năm, là di tích lịch sử văn hóa cấp quốc gia', 'Kiến trúc hang động tự nhiên kết hợp Phật giáo', 'Hang động tự nhiên, quần thể chim yến khổng lồ, không gian linh thiêng độc đáo', 'Trung tâm Phật giáo quan trọng, nơi tu hành và hành hương của Phật tử', 9.91000000, 106.29000000),
(9, 'denbacho', 'Đền Thờ Bác Hồ', 'Đền thờ Bác Hồ là công trình tưởng niệm Chủ tịch Hồ Chí Minh, thể hiện lòng kính yêu và tinh thần cách mạng của nhân dân Trà Vinh. Đây là nơi tổ chức các hoạt động giáo dục truyền thống.', 'Đường 30/4, Xã Long Đức, Thành phố Trà Vinh, Tỉnh Trà Vinh', 'Di tích lịch sử', 'Miễn phí', 'hinhanh/DulichtpTV/Den-Tho-Amt.jpg', '7:00 - 17:00 hàng ngày', 'Công trình tưởng niệm|Giáo dục truyền thống|Tìm hiểu lịch sử|Không gian trang nghiêm|Điểm tham quan', 'Bãi đỗ xe rộng|Nhà vệ sinh|Khu trưng bày|Khu nghỉ ngơi|Nước uống miễn phí', 'Sáng (8:00-10:00) hoặc chiều (14:00-16:00)', '0292.3858.999', 'active', '2025-11-12 09:07:11', '2025-11-15 07:14:15', 'Năm 1970', 'Công trình tưởng niệm Chủ tịch Hồ Chí Minh, thể hiện lòng kính yêu của nhân dân Trà Vinh', 'Nơi lưu giữ kỷ vật và tư liệu về Chủ tịch Hồ Chí Minh, là điểm giáo dục truyền thống cách mạng', 'Kiến trúc hiện đại trang nghiêm', 'Tượng Bác Hồ, phòng trưng bày tư liệu, không gian trang nghiêm', 'Không có', 9.93200000, 106.33800000),
(10, 'ducmy', 'Nhà Thờ Đức Mỹ', 'Nhà thờ Đức Mỹ là công trình kiến trúc tôn giáo Công giáo với lối kiến trúc Gothic cổ điển. Nhà thờ là trung tâm sinh hoạt Công giáo quan trọng tại huyện Càng Long.', 'Xã Đức Mỹ, Huyện Càng Long, Tỉnh Trà Vinh (cách TP 30km)', 'Di tích kiến trúc', 'Miễn phí', 'hinhanh/DulichtpTV/2021-02-18.jpg', '6:00 - 18:00 hàng ngày (tránh giờ lễ)', 'Kiến trúc Gothic cổ điển|Tháp chuông cao vút|Cửa sổ kính màu|Không gian trang nghiêm|Lễ Giáng sinh', 'Bãi đỗ xe|Nhà vệ sinh|Khu ngồi nghỉ|Nước uống miễn phí', 'Sáng sớm hoặc chiều mát, tránh giờ lễ (6:00, 17:00), đặc biệt đẹp vào lễ Giáng sinh', '0292.3859.111', 'active', '2025-11-12 09:07:12', '2025-11-15 07:14:15', 'Năm 1902 (đầu thế kỷ 20)', 'Công trình kiến trúc tôn giáo Công giáo tiêu biểu, trung tâm sinh hoạt của cộng đồng Công giáo', 'Nhà thờ có lịch sử hơn 120 năm, là di tích kiến trúc nghệ thuật quý giá', 'Kiến trúc Gothic cổ điển châu Âu', 'Tháp chuông cao vút, cửa sổ kính màu đẹp, không gian trang nghiêm linh thiêng', 'Trung tâm Công giáo quan trọng tại huyện Càng Long, nơi tổ chức các thánh lễ và lễ hội', 9.98000000, 106.25000000),
(11, 'chuacanh', 'Chùa Cành', 'Chùa Cành là ngôi chùa Khmer nổi tiếng với lễ hội Chaul Chnam Thmey (Tết Khmer) và các hoạt động văn hóa truyền thống sôi động. Chùa có kiến trúc đẹp và không gian yên tĩnh.', 'Hoà Ân, Cầu Kè, Trà Vinh', 'Chùa Khmer', 'Miễn phí', 'hinhanh/DulichtpTV/NGB_7219.jpg', '5:00 - 19:00 hàng ngày', 'Lễ hội Tết Khmer|Văn hóa truyền thống|Kiến trúc đẹp|Không gian yên tĩnh|Hoạt động sôi động', 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Sân khấu lễ hội|Khu nghỉ ngơi', 'Sáng sớm (5:00-7:00) hoặc dịp lễ hội Tết Khmer (tháng 4 dương lịch)', '0292.3860.222', 'active', '2025-11-12 09:07:12', '2025-11-15 07:14:15', 'Năm 1820 (thế kỷ 19)', 'Ngôi chùa Khmer nổi tiếng với lễ hội Chaul Chnam Thmey (Tết Khmer) sôi động', 'Chùa có lịch sử hơn 200 năm, là trung tâm văn hóa và tâm linh của cộng đồng người Khmer', 'Kiến trúc Khmer truyền thống', 'Kiến trúc đẹp, sân khấu lễ hội rộng, không gian yên tĩnh, nghệ thuật trang trí tinh xảo', 'Trung tâm Phật giáo Nam Tông, nơi tổ chức lễ hội Tết Khmer và các nghi lễ truyền thống', 9.96000000, 106.31000000),
(16, 'chuakompong', 'Chùa Kom Pong (Ông Mẹt)', 'Chùa Kom Pong (còn gọi là Chùa Ông Mẹt) là ngôi chùa Khmer cổ kính với kiến trúc truyền thống đặc trưng. Khuôn viên chùa rộng rãi với nhiều cây xanh, tạo không gian yên tĩnh.', 'Số 50/1, Đường Lê Lợi, Khóm 2, Phường 1, Thành phố Trà Vinh, Tỉnh Trà Vinh', 'Chùa Khmer', 'Miễn phí (có thể cúng dường tự nguyện)', 'hinhanh/DulichtpTV/chua-kompong-tra-vinh.jpg', '5:00 - 19:00 hàng ngày', 'Kiến trúc Khmer cổ kính|Nghệ thuật trang trí|Khuôn viên rộng rãi|Tượng Phật quý giá|Lễ hội truyền thống', 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Khu nghỉ ngơi', 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)', '0292.3865.777', 'active', '2025-11-12 09:07:12', '2025-11-15 07:14:15', 'Năm 1789 (thế kỷ 18)', 'Ngôi chùa Khmer cổ kính với kiến trúc truyền thống, trung tâm văn hóa tâm linh', 'Chùa có lịch sử hơn 230 năm, lưu giữ nhiều hiện vật và truyền thống văn hóa Khmer', 'Kiến trúc Khmer truyền thống cổ điển', 'Nghệ thuật trang trí tinh xảo, tượng Phật quý giá, khuôn viên rộng rãi', 'Trung tâm Phật giáo Nam Tông, nơi tổ chức các lễ hội truyền thống Khmer', 9.93700000, 106.34100000),
(18, 'khudulichhuynhkha', 'Khu Du Lịch Huỳnh Kha', 'Khu du lịch Huỳnh Kha là điểm đến sinh thái độc đáo với không gian xanh mát, yên bình. Du khách có thể tham gia các hoạt động như câu cá, chèo thuyền, tham quan vườn trái cây.', 'Ấp Long Bình A, Phường 4, Thành phố Trà Vinh, Tỉnh Trà Vinh', 'Sinh thái', '50.000đ/người', 'hinhanh/DulichtpTV/3-scaled.jpg', '7:00 - 18:00 hàng ngày', 'Không gian xanh mát|Câu cá giải trí|Chèo thuyền|Vườn trái cây|Ẩm thực miền Tây', 'Bãi đỗ xe rộng|Nhà vệ sinh|Nhà hàng|Khu vui chơi trẻ em|Cho thuê thuyền', 'Cuối tuần, mùa trái cây (tháng 5-8)', '0292.3867.999', 'active', '2025-11-12 09:07:12', '2025-11-15 07:14:15', 'Năm 2005', 'Khu du lịch sinh thái kết hợp văn hóa miền Tây, điểm đến giải trí gia đình', 'Phát triển từ vườn trái cây gia đình, thể hiện nét văn hóa vườn miệt vườn miền Tây', 'Kiến trúc sinh thái miền Tây', 'Không gian xanh mát, vườn trái cây, khu câu cá, ẩm thực miền Tây đặc sắc', 'Không có', 9.93900000, 106.34700000),
(34, 'rungduoc', 'Rừng Đước Trà Vinh', 'Rừng Đước Trà Vinh là khu bảo tồn rừng ngập mặn với hệ sinh thái đa dạng. Du khách có thể trải nghiệm tour thuyền kayak khám phá thiên nhiên hoang dã, quan sát các loài chim và động vật quý hiếm.', 'Xã Long Khánh, Huyện Duyên Hải, Tỉnh Trà Vinh (cách TP 40km)', 'Sinh thái', '50.000đ/người (bao gồm thuyền kayak)', 'hinhanh/DulichtpTV/OIP.jpg', '7:00 - 17:00 hàng ngày', 'Hệ sinh thái đa dạng|Tour thuyền kayak|Quan sát chim hoang dã|Rừng ngập mặn|Thiên nhiên hoang sơ', 'Bãi đỗ xe|Nhà vệ sinh|Cho thuê thuyền kayak|Hướng dẫn viên|Áo phao an toàn', 'Sáng sớm (7:00-9:00) để ngắm chim, tránh nắng gắt', '0292.3854.555', 'active', '2025-11-19 14:20:58', '2025-11-19 14:20:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'somrongek', 'Chùa Somrong Ek', 'Chùa Somrong Ek là ngôi chùa Khmer cổ kính với kiến trúc truyền thống đặc trưng và nghệ thuật trang trí tinh xảo. Khuôn viên chùa rộng rãi với nhiều cây xanh tạo không gian yên bình.', 'Phường 8, thị xã Trà Vinh, tỉnh Trà Vinh', 'Chùa Khmer', 'Miễn phí', 'hinhanh/DulichtpTV/1.Chua-Samrong-Ek-Tra-Vinh-Nguon_vietlandmarks.com_.jpg', '5:00 - 19:00 hàng ngày', 'Kiến trúc Khmer cổ kính|Nghệ thuật trang trí|Khuôn viên rộng rãi|Không gian yên bình|Văn hóa truyền thống', 'Bãi đỗ xe|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Khu nghỉ ngơi', 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)', '0292.3857.888', 'active', '2025-11-19 14:20:58', '2025-11-19 14:20:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'nhathomacbac', 'Nhà Thờ Công Giáo Mạc Bắc', 'Nhà thờ Công giáo Mạc Bắc là công trình kiến trúc tôn giáo với lối kiến trúc Gothic châu Âu đặc trưng. Nhà thờ được xây dựng từ đầu thế kỷ 20.', 'Xã Long Thới, Huyện Tiểu Cần, Tỉnh Trà Vinh', 'Di tích kiến trúc', 'Miễn phí', 'hinhanh/DulichtpTV/nha-tho-cong-giao-mac-bac.jpg', '6:00 - 18:00 hàng ngày (tránh giờ lễ)', 'Kiến trúc Gothic châu Âu|Tháp chuông cao vút|Cửa sổ kính màu|Di tích lịch sử|Lễ Giáng sinh', 'Bãi đỗ xe|Nhà vệ sinh|Khu ngồi nghỉ|Nước uống miễn phí', 'Sáng sớm hoặc chiều mát, tránh giờ lễ (6:00, 17:00)', '0292.3864.666', 'active', '2025-11-19 14:20:58', '2025-11-19 14:20:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'baotangkhmer', 'Bảo tàng Văn hóa Dân tộc Khmer', 'Bảo tàng Văn hóa Dân tộc Khmer là bảo tàng chuyên đề đầu tiên về văn hóa Khmer tại Việt Nam. Nơi đây lưu giữ hơn 3.000 hiện vật quý giá từ thế kỷ 7 đến nay.', 'Đường Phạm Thái Bường, Phường 4, Thành phố Trà Vinh, Tỉnh Trà Vinh', 'Văn hóa', '20.000đ/người', 'hinhanh/DulichtpTV/bảo tàng văn hóa .jpg', '7:30 - 11:00 và 13:30 - 17:00 (Thứ 2 - Thứ 7)', 'Bảo tàng chuyên đề đầu tiên|Hơn 3.000 hiện vật|Văn hóa Khmer|Từ thế kỷ 7|Giáo dục lịch sử', 'Bãi đỗ xe|Nhà vệ sinh|Phòng trưng bày|Hướng dẫn viên|Điều hòa', 'Sáng (8:00-10:00) hoặc chiều (14:00-16:00)', '0292.3861.333', 'active', '2025-11-19 14:33:41', '2025-11-19 14:33:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'thienvientriclam', 'Thiền Viện Trúc Lâm Duyên Hải', 'Thiền viện Trúc Lâm Duyên Hải là thiền viện lớn nhất miền Tây với diện tích 50 hecta. Không gian tu hành yên tĩnh với vườn sen đẹp và rừng tre xanh mướt.', 'Ấp Khoán Tiều, Xã Trường Long Hòa, Thị xã Duyên Hải, Tỉnh Trà Vinh (cách TP 45km)', 'Chùa Phật giáo', 'Miễn phí', 'hinhanh/DulichtpTV/thiện viện trúc lâm .jpg', '6:00 - 18:00 hàng ngày', 'Thiền viện lớn nhất miền Tây|Diện tích 50 hecta|Vườn sen đẹp|Rừng tre xanh|Tu hành yên tĩnh', 'Bãi đỗ xe rộng|Nhà vệ sinh|Nhà khách|Phòng ăn chay|Wifi miễn phí', 'Sáng sớm (6:00-8:00) để tham gia khóa tu', '0292.3862.444', 'active', '2025-11-19 14:33:41', '2025-11-19 14:33:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'chuaphuongthanhpisay', 'Chùa Khmer Phương Thạnh Pisay', 'Chùa Khmer Phương Thạnh Pisay là ngôi chùa hiện đại với kiến trúc độc đáo kết hợp giữa truyền thống Khmer và phong cách hiện đại. Nổi tiếng với tháp Phật 7 tầng cao 35m.', 'Xã Phương Thạnh, Huyện Càng Long, Tỉnh Trà Vinh (cách TP 35km)', 'Chùa Khmer', 'Miễn phí (có thể cúng dường tự nguyện)', 'hinhanh/DulichtpTV/phuong thạnh .jpg', '5:00 - 19:00 hàng ngày', 'Tháp Phật 7 tầng cao 35m|Kiến trúc hiện đại độc đáo|Nghệ thuật trang trí đẹp|Vườn hoa đẹp|Lễ hội Khmer', 'Bãi đỗ xe rộng|Nhà vệ sinh|Khu thắp hương|Phòng trưng bày|Vườn hoa nghỉ ngơi', 'Sáng sớm (5:00-7:00) hoặc chiều mát (16:00-18:00)', '0292.3863.555', 'active', '2025-11-19 14:33:41', '2025-11-19 14:33:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attraction_ratings`
--

CREATE TABLE `attraction_ratings` (
  `attraction_id` varchar(50) NOT NULL,
  `total_reviews` int(11) DEFAULT 0,
  `average_rating` decimal(3,2) DEFAULT 0.00,
  `rating_5_star` int(11) DEFAULT 0,
  `rating_4_star` int(11) DEFAULT 0,
  `rating_3_star` int(11) DEFAULT 0,
  `rating_2_star` int(11) DEFAULT 0,
  `rating_1_star` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `attraction_ratings`
--

INSERT INTO `attraction_ratings` (`attraction_id`, `total_reviews`, `average_rating`, `rating_5_star`, `rating_4_star`, `rating_3_star`, `rating_2_star`, `rating_1_star`, `updated_at`) VALUES
('aobaom', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('baotangkhmer', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('bienbadong', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('chuaang', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('chuacanh', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('chuahang', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('chuakompong', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('chuaphuongthanhpisay', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('chuavamray', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('conchim', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('denbacho', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('ducmy', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('khudulichhuynhkha', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('nhathomacbac', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('rungduoc', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('somrongek', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23'),
('thienvientriclam', 0, 0.00, 0, 0, 0, 0, 0, '2025-11-19 15:55:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `booking_code` varchar(50) NOT NULL,
  `attraction_id` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `booking_date` date NOT NULL,
  `number_of_people` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(15,2) DEFAULT 0.00,
  `special_requests` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `account_number` varchar(20) DEFAULT NULL COMMENT 'Số tài khoản ngân hàng để hoàn tiền'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `booking_id`, `booking_code`, `attraction_id`, `customer_name`, `customer_email`, `customer_phone`, `booking_date`, `number_of_people`, `total_price`, `special_requests`, `status`, `created_at`, `updated_at`, `account_number`) VALUES
(1, 'BK20251114044651001', 'BOOKBK20251114044651001BK2025', 'aobaom', 'Nguyễn Văn Test', 'test@gmail.com', '0901234567', '2025-11-17', 4, 0.00, 'Đây là booking test', 'completed', '2025-11-14 03:46:51', '2025-12-09 16:12:21', NULL),
(4, 'BK20251114051753612', 'BOOKBK20251114051753612BK2025', 'aobaom', 'minh', 'thachnhatminh0@gmail.com', '0366058110', '2025-11-19', 1, 0.00, 'evf', 'completed', '2025-11-14 04:17:53', '2025-12-09 16:12:21', NULL),
(9, 'BK20251123125132742', 'BOOKBK20251123125132742BK2025', 'aobaom', 'TRương Quãng', 'thachnhatminh8@gmail.com', '0366058110', '2025-11-26', 1, 0.00, 'đi cchoiw', 'pending', '2025-11-23 11:51:32', '2025-12-09 16:12:21', NULL),
(11, 'BK20251126013742581', 'BOOKBK20251126013742581BK2025', 'chuaphuongthanhpisay', 'TRương Quãng', 'thachnhatminh8@gmail.com', '0366058110', '2025-11-29', 1, 0.00, 'sè', 'pending', '2025-11-26 00:37:42', '2025-12-09 16:12:21', NULL),
(12, 'BK20251205134925181', 'BOOKBK20251205134925181BK2025', 'aobaom', 'TRương Quãng', 'thachnhatminh8@gmail.com', '0366058110', '2025-12-24', 1, 0.00, 'đi chơi\n', 'pending', '2025-12-05 12:49:25', '2025-12-09 16:12:21', NULL),
(13, 'BK20251205145036709', 'BOOKBK20251205145036709BK2025', 'conchim', 'Thạch Nhựt  Minh', 'thachnhutmih8@gmail.com', '0366058110', '2025-12-15', 1, 30000.00, 'đi hơi', 'pending', '2025-12-05 13:50:36', '2025-12-09 16:12:21', NULL),
(14, 'BK20251205150225835', 'BOOKBK20251205150225835BK2025', 'aobaom', 'Thạch Huy', 'thahNhatminh8@gmail.com', '5465410', '2025-12-21', 1, 0.00, 'ssd', 'confirmed', '2025-12-05 14:02:25', '2025-12-23 08:51:55', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied','archived') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `replied_at` timestamp NULL DEFAULT NULL,
  `reply_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `full_name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `replied_at`, `reply_message`) VALUES
(1, 'Nguyễn Thị Hoa', 'hoanguyen@gmail.com', '0912345678', 'Hỏi về tour Văn hóa Khmer', 'Xin chào, tôi muốn hỏi về tour Văn hóa Khmer có phù hợp cho người già không?', 'new', '2024-12-15 02:30:00', NULL, NULL),
(2, 'Trần Văn Nam', 'namtran@yahoo.com', '0923456789', 'Đặt tour cho nhóm 20 người', 'Công ty muốn đặt tour 2 ngày 1 đêm cho 20 nhân viên. Có giảm giá không?', 'read', '2024-12-14 07:20:00', NULL, NULL),
(3, 'Lê Thị Mai', 'maile@gmail.com', '0934567890', 'Hỏi về giá tour Biển', 'Tour Biển Ba Động có bao gồm đồ bơi không?', 'replied', '2024-12-13 09:45:00', NULL, NULL),
(7, 'Thạch Nhựt Minh', 'thachnhatminh8@gmail.com', '0366058110', 'Đặt tour', 'đi chơi', 'new', '2025-11-14 03:19:26', NULL, NULL),
(9, 'Thạch Nhựt Minh', 'thachnhatminh8@gmail.com', '0366058110', 'Thông tin địa điểm', 'hvbn', 'new', '2025-11-14 15:05:41', NULL, NULL),
(10, 'Thạch Nhựt Minh', 'thachnhatminh8@gmail.com', '0366058110', 'Thông tin địa điểm', 'dịch vụ tốt', 'new', '2025-11-15 13:11:10', NULL, NULL),
(12, 'Thạch Nhựt Vi', 'thachnhutminh0@gmail.com', '0366058110', 'Đặt tour', 'đi chơi', 'new', '2025-12-05 13:55:36', NULL, NULL),
(13, 'Thạch Hương Trầm', 'thachnhatminh8@gmail.com', '0326310394', 'Đặt tour', 'drhaeh', 'new', '2025-12-23 08:37:08', NULL, NULL),
(14, 'Thạch Hương Trầm', 'thachnhatminh8@gmail.com', '0326310394', 'Thông tin địa điểm', 'ưgqewg', 'new', '2025-12-23 11:59:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `foods`
--

CREATE TABLE `foods` (
  `food_id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_vi` varchar(255) NOT NULL,
  `name_khmer` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ingredients`)),
  `price_range` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `best_time` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `foods`
--

INSERT INTO `foods` (`food_id`, `name`, `name_vi`, `name_khmer`, `category`, `description`, `ingredients`, `price_range`, `image_url`, `origin`, `best_time`, `status`) VALUES
('banh-canh-ben-co', 'Bánh Canh Bến Có', 'Bánh Canh Bến Có', 'នំបញ្ចុក', 'mon-chinh', 'Bánh canh đặc biệt với sợi bánh dai ngon, nước dùng trong vắt từ xương heo và hải sản tươi. Món ăn mang đậm hương vị biển cả với tôm, cua, mực tươi ngon.', '[\"Bánh canh\", \"Tôm\", \"Cua\", \"Mực\", \"Xương heo\", \"Hành lá\", \"Rau thơm\"]', '20.000 - 30.000 VNĐ', 'hinhanh/DulichtpTV/bánh canh.jpg', 'Bến Có, Trà Vinh', 'Sáng, Trưa', 'active'),
('banh-it-la-gai', 'Bánh Ít Lá Gai', 'Bánh Ít Lá Gai', 'នំអន្សម', 'banh-ngot', 'Bánh ít lá gai với vỏ bánh dẻo từ lá gai, nhân đậu xanh hoặc dừa. Bánh có màu đen tự nhiên từ lá gai, vị dẻo thơm và ngọt thanh.', '[\"Bột nếp\", \"Lá gai\", \"Đậu xanh\", \"Dừa\", \"Đường\"]', '5.000 - 10.000 VNĐ/cái', 'hinhanh/DulichtpTV/dac-san-tra-vinh-co-gi bánh tests.jpg', 'Trà Vinh', 'Cả ngày', 'active'),
('banh-mi-thit-2', 'Bánh Mì Thịt', 'Bánh Mì Thịt', 'នំបុ័ង', 'mon-an-vat', 'Bánh mì Việt Nam với nhân thịt nguội, pate, rau thơm và nước sốt đặc biệt. Bánh mì giòn rụm, nhân đầy đặn và hương vị hài hòa.', '[\"Bánh mì\", \"Thịt nguội\", \"Pate\", \"Dưa leo\", \"Rau thơm\", \"Ớt\", \"Nước tương\"]', '15.000 - 25.000 VNĐ', 'hinhanh/DulichtpTV/Bánh mì mới.jpg', 'Trà Vinh', 'Sáng, Chiều', 'active'),
('banh-tet-tra-cuon', 'Bánh Tét Trà Cuôn', 'Bánh Tét Trà Cuôn', 'នំអន្សម', 'banh-ngot', 'Bánh tét đặc sản Trà Cuôn với nhân đậu xanh và thịt heo, gói trong lá chuối. Bánh tét Trà Cuôn nổi tiếng với vị ngọt thanh của gạo nếp, đậu xanh béo ngậy và thịt heo thơm.', '[\"Gạo nếp\", \"Đậu xanh\", \"Thịt heo\", \"Lá chuối\", \"Muối\"]', '30.000 - 50.000 VNĐ/cái', 'hinhanh/DulichtpTV/dac-san-tra-vinh-co-gi bánh tests.jpg', 'Trà Cuôn, Trà Vinh', 'Tết, Lễ hội', 'active'),
('banh-xeo-khmer', 'Bánh Xèo Khmer', 'Bánh Xèo Khmer', 'នំបញ្ចុក', 'mon-an-vat', 'Bánh xèo kiểu Khmer với vỏ bánh mỏng giòn, nhân tôm thịt và giá đỗ, ăn kèm rau sống và nước chấm đặc biệt. Bánh xèo Khmer có màu vàng đẹp mắt, giòn rụm và thơm ngon.', '[\"Bột gạo\", \"Bột nghệ\", \"Tôm\", \"Thịt heo\", \"Giá đỗ\", \"Rau sống\", \"Nước mắm\"]', '15.000 - 25.000 VNĐ', 'hinhanh/DulichtpTV/bánh xèo.jpg', 'Trà Vinh', 'Chiều, Tối', 'active'),
('bun-nuoc-leo', 'Bún Nước Lèo', 'Bún Nước Lèo', 'នំបញ្ចុក', 'mon-chinh', 'Món ăn đặc trưng của người Khmer với nước dùng đậm đà từ cá lóc, tôm khô và các loại rau thơm. Bún nước lèo có vị ngọt tự nhiên từ cá, hòa quyện cùng vị cay nhẹ của ớt và thơm nồng của sả.', '[\"Bún tươi\", \"Cá lóc\", \"Tôm khô\", \"Rau muống\", \"Giá đỗ\", \"Sả\", \"Ớt\", \"Nước mắm\"]', '25.000 - 35.000 VNĐ', 'hinhanh/DulichtpTV/dac-sac-bun-nuoc-leo-tra-vinh-a09-5812896.jpg', 'Trà Vinh', 'Sáng, Trưa', 'active'),
('bun-suong', 'Bún Suông', 'Bún Suông', 'នំបញ្ចុក', 'mon-chinh', 'Món bún đặc trưng của người Khmer với nước dùng trong vắt từ xương heo, tôm tươi và các loại rau sống tươi mát. Bún suông có vị ngọt thanh, ăn kèm với rau sống và nước mắm pha.', '[\"Bún tươi\", \"Tôm\", \"Thịt heo\", \"Giá đỗ\", \"Rau muống\", \"Rau thơm\", \"Nước mắm\"]', '20.000 - 30.000 VNĐ', 'hinhanh/DulichtpTV/bunbs suồn.jpg', 'Trà Vinh', 'Sáng, Trưa', 'active'),
('ca-loc-nuong-trui', 'Cá Lóc Nướng Trui', 'Cá Lóc Nướng Trui', 'ត្រីឆ្អិនអាំង', 'mon-chinh', 'Cá lóc nướng trui đặc sản vùng sông nước, thịt cá ngọt tự nhiên, ăn kèm bánh tráng và rau sống. Cá được nướng trên than hồng, da giòn thơm, thịt ngọt và mềm.', '[\"Cá lóc\", \"Muối\", \"Ớt\", \"Sả\", \"Bánh tráng\", \"Rau sống\", \"Nước mắm\"]', '150.000 - 250.000 VNĐ/kg', 'hinhanh/DulichtpTV/cá lóc.jpg', 'Trà Vinh', 'Trưa, Tối', 'active'),
('ca-phe-sua-da-2', 'Cà Phê Sữa Đá', 'Cà Phê Sữa Đá', 'កាហ្វេទឹកដោះគោ', 'do-uong', 'Cà phê phin truyền thống pha với sữa đặc và đá, đậm đà và thơm ngon. Cà phê Việt Nam nổi tiếng với hương vị đặc trưng và cách pha độc đáo.', '[\"Cà phê\", \"Sữa đặc\", \"Đá\"]', '15.000 - 25.000 VNĐ', 'hinhanh/DulichtpTV/Cafe mới.jpg', 'Trà Vinh', 'Cả ngày', 'active'),
('che-khmer', 'Chè Khmer', 'Chè Khmer', 'បបរ', 'banh-ngot', 'Chè Khmer truyền thống với nhiều loại đậu và nước cốt dừa thơm ngon, mát lạnh giải nhiệt. Chè Khmer có nhiều màu sắc bắt mắt từ các loại đậu và thạch khác nhau.', '[\"Đậu đỏ\", \"Đậu xanh\", \"Đậu trắng\", \"Nước cốt dừa\", \"Đường\", \"Thạch\", \"Đá bào\"]', '8.000 - 18.000 VNĐ', 'hinhanh/DulichtpTV/chè khmer.jpg', 'Trà Vinh', 'Cả ngày', 'active'),
('chu-u-rang-me', 'Chù Ụ Rang Me', 'Chù Ụ Rang Me', 'កណ្ដុរឆាអំពិល', 'mon-an-vat', 'Món ăn vặt độc đáo từ loài chù ụ (chuột đồng) rang với me, có vị chua ngọt đặc trưng. Thịt chù ụ giòn, thơm, không hôi, kết hợp với vị chua ngọt của me tạo nên hương vị khó quên.', '[\"Chù ụ\", \"Me\", \"Tỏi\", \"Ớt\", \"Đường\", \"Muối\", \"Sả\"]', '15.000 - 25.000 VNĐ', 'hinhanh/DulichtpTV/chà ụ.jpg', 'Trà Vinh', 'Chiều, Tối', 'active'),
('com-tam-suon-nuong-2', 'Cơm Tấm Sườn Nướng', 'Cơm Tấm Sườn Nướng', 'បាយសាច់ជ្រូក', 'mon-chinh', 'Cơm tấm với sườn nướng thơm phức, ăn kèm dưa leo, cà chua và nước mắm pha. Sườn được ướp gia vị đậm đà, nướng trên than hồng cho thơm và giòn.', '[\"Cơm tấm\", \"Sườn heo\", \"Nước mắm\", \"Đường\", \"Tỏi\", \"Sả\", \"Dưa leo\", \"Cà chua\"]', '25.000 - 40.000 VNĐ', 'hinhanh/DulichtpTV/Cơm mới.jpg', 'Trà Vinh', 'Trưa, Tối', 'active'),
('hu-tieu-my-tho-2', 'Hủ Tiếu Mỹ Tho', 'Hủ Tiếu Mỹ Tho', 'គុយទាវ', 'mon-chinh', 'Hủ tiếu Mỹ Tho với nước dùng ngọt thanh từ xương heo và hải sản. Món ăn có sợi hủ tiếu dai, nước dùng trong vắt và nhiều topping hấp dẫn.', '[\"Hủ tiếu\", \"Tôm\", \"Thịt heo\", \"Gan\", \"Giá đỗ\", \"Hành lá\", \"Nước dùng\"]', '20.000 - 35.000 VNĐ', 'hinhanh/DulichtpTV/hủ tiếu mới.jpg', 'Trà Vinh', 'Sáng, Trưa', 'active'),
('kem-dua-2', 'Kem Dừa', 'Kem Dừa', 'ក្រែមដូង', 'banh-ngot', 'Kem dừa mát lạnh với vị ngọt thanh của dừa tươi. Kem được làm từ nước cốt dừa tươi, béo ngậy và thơm ngon.', '[\"Nước cốt dừa\", \"Sữa\", \"Đường\", \"Cơm dừa\"]', '10.000 - 20.000 VNĐ', 'hinhanh/DulichtpTV/kem mới .jpg', 'Trà Vinh', 'Cả ngày', 'active'),
('lau-mam', 'Lẩu Mắm', 'Lẩu Mắm', 'ស្ងោរ', 'mon-chinh', 'Lẩu mắm đậm đà hương vị miền Tây với nhiều loại rau rừng, cá tươi và nước dùng thơm ngon. Lẩu mắm có vị đậm đà, hơi chua và rất kích thích vị giác.', '[\"Mắm\", \"Cá lóc\", \"Tôm\", \"Thịt heo\", \"Rau muống\", \"Bông điên điển\", \"Bông so đũa\", \"Bún\"]', '80.000 - 150.000 VNĐ/người', 'hinhanh/DulichtpTV/lẩu .jpg', 'Trà Vinh', 'Trưa, Tối', 'active'),
('nom-banh-chok', 'Nom Banh Chok', 'Nom Banh Chok', 'នំបញ្ចុក', 'mon-chinh', 'Bún tươi Khmer ăn kèm nước mắm chua ngọt, rau thơm và các loại rau sống, là món ăn sáng phổ biến. Nom banh chok có vị thanh mát, dễ ăn và rất bổ dưỡng.', '[\"Bún tươi\", \"Cá\", \"Rau thơm\", \"Dưa chuột\", \"Giá đỗ\", \"Nước mắm\", \"Đường\"]', '12.000 - 20.000 VNĐ', 'hinhanh/DulichtpTV/num banh chok.jpg', 'Trà Vinh', 'Sáng', 'active'),
('nuoc-mia-2', 'Nước Mía', 'Nước Mía', 'ទឹកអំពៅ', 'do-uong', 'Nước mía tươi mát, ngọt thanh, giải nhiệt tuyệt vời. Nước mía được ép tươi, có thể thêm chanh hoặc kumquat để tăng hương vị.', '[\"Mía\", \"Đá\", \"Chanh (tùy chọn)\"]', '8.000 - 15.000 VNĐ', 'hinhanh/DulichtpTV/mía mới.jpg', 'Trà Vinh', 'Cả ngày', 'active'),
('sinh-to-bo-2', 'Sinh Tố Bơ', 'Sinh Tố Bơ', 'ស្មូធី', 'do-uong', 'Sinh tố bơ béo ngậy, thơm ngon và bổ dưỡng. Bơ được xay nhuyễn với sữa tươi và đá, tạo nên ly sinh tố mát lạnh và giàu dinh dưỡng.', '[\"Bơ\", \"Sữa tươi\", \"Đường\", \"Đá\"]', '25.000 - 35.000 VNĐ', 'hinhanh/DulichtpTV/bơ mới.jpg', 'Trà Vinh', 'Cả ngày', 'active'),
('tra-sua-2', 'Trà Sữa', 'Trà Sữa', 'តែទឹកដោះគោ', 'do-uong', 'Trà sữa với nhiều hương vị khác nhau, topping trân châu, thạch, pudding. Đồ uống được giới trẻ yêu thích với vị ngọt dịu và thơm mát.', '[\"Trà\", \"Sữa\", \"Đường\", \"Trân châu\", \"Thạch\", \"Đá\"]', '20.000 - 35.000 VNĐ', 'hinhanh/DulichtpTV/sửa mới.jpg', 'Trà Vinh', 'Cả ngày', 'active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_confirmations`
--

CREATE TABLE `payment_confirmations` (
  `id` int(11) NOT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `booking_id` varchar(50) NOT NULL,
  `booking_type` enum('tour','service') NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `transfer_amount` decimal(10,2) NOT NULL,
  `transfer_date` date NOT NULL,
  `transfer_content` text DEFAULT NULL,
  `proof_image` varchar(500) DEFAULT NULL,
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_confirmations`
--

INSERT INTO `payment_confirmations` (`id`, `booking_code`, `booking_id`, `booking_type`, `customer_name`, `bank_name`, `account_number`, `transfer_amount`, `transfer_date`, `transfer_content`, `proof_image`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, NULL, 'TB001', 'tour', 'Nguyễn Văn An', 'Vietcombank', '1234567890', 5000000.00, '2024-12-20', 'Thanh toan tour TB001', NULL, 'verified', NULL, '2025-12-23 08:44:28', '2025-12-23 08:44:28'),
(2, NULL, 'TB002', 'tour', 'Trần Thị Bình', 'VietinBank', '9876543210', 3500000.00, '2024-12-21', 'Thanh toan tour TB002', NULL, 'pending', NULL, '2025-12-23 08:44:28', '2025-12-23 08:44:28'),
(3, NULL, 'SB20250001', 'service', 'Lê Văn Cường', 'BIDV', '5555666677', 800000.00, '2024-12-22', 'Thanh toan dich vu SB20250001', NULL, 'verified', NULL, '2025-12-23 08:44:28', '2025-12-23 08:44:28'),
(4, NULL, 'SB20250002', 'service', 'Phạm Thị Dung', 'Sacombank', '1111222233', 1200000.00, '2024-12-23', 'Thanh toan dich vu SB20250002', NULL, 'pending', NULL, '2025-12-23 08:44:28', '2025-12-23 08:44:28'),
(5, 'TOUR20251223124315903', 'TOUR20251223124315903', 'tour', 'Thạch Nhựt Minh', 'Sacombank', '070132292432', 1100000.00, '2025-12-23', NULL, NULL, 'pending', NULL, '2025-12-23 11:47:32', '2025-12-23 11:47:32'),
(6, 'TOUR20251223125912628', 'TOUR20251223125912628', 'tour', 'Thạch Nhựt Minh', 'Sacombank', '070132292432', 1300000.00, '2025-12-23', NULL, NULL, 'pending', NULL, '2025-12-23 11:59:31', '2025-12-23 11:59:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quanans`
--

CREATE TABLE `quanans` (
  `id` int(11) NOT NULL,
  `restaurant_id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `food_type` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 4.5,
  `price_range` varchar(100) DEFAULT NULL,
  `open_time` varchar(100) DEFAULT NULL,
  `specialties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`specialties`)),
  `image_url` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quanans`
--

INSERT INTO `quanans` (`id`, `restaurant_id`, `name`, `food_type`, `address`, `phone`, `rating`, `price_range`, `open_time`, `specialties`, `image_url`, `latitude`, `longitude`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'quan-bun-nuoc-leo-ba-sau', 'Quán Bún Nước Lèo Bà Sáu', 'bun-nuoc-leo', 'Số 45 Đường Phạm Thái Bường, TP. Trà Vinh', '0294.3855.123', 4.8, '25.000 - 35.000 VNĐ', '6:00 - 20:00', '[\"Bún nước lèo\", \"Bún suông\"]', NULL, NULL, NULL, 'Quán bún nước lèo nổi tiếng với nước dùng đậm đà.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(2, 'bun-nuoc-leo-cho-tra-vinh', 'Bún Nước Lèo Chợ Trà Vinh', 'bun-nuoc-leo', 'Khu vực chợ Trà Vinh', '0294.3855.124', 4.6, '20.000 - 30.000 VNĐ', '5:30 - 11:00', '[\"Bún nước lèo\"]', NULL, NULL, NULL, 'Quán bún gần chợ, phục vụ từ sáng sớm.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(3, 'banh-canh-ben-co-ba-ut', 'Bánh Canh Bến Có Bà Út', 'banh-canh-ben-co', 'Bến Có, Trà Vinh', '0294.3855.126', 4.9, '20.000 - 30.000 VNĐ', '6:00 - 18:00', '[\"Bánh canh\", \"Hải sản\"]', NULL, NULL, NULL, 'Quán bánh canh nổi tiếng với hải sản tươi sống.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(4, 'banh-canh-hai-san-ba-muoi', 'Bánh Canh Hải Sản Bà Mười', 'banh-canh-ben-co', 'Gần chợ Bến Có', '0294.3855.127', 4.7, '25.000 - 35.000 VNĐ', '6:00 - 19:00', '[\"Bánh canh\", \"Tôm cua mực\"]', NULL, NULL, NULL, 'Bánh canh với nhiều loại hải sản tươi ngon.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(5, 'chu-u-rang-me-ba-nam', 'Chù Ụ Rang Me Bà Năm', 'chu-u-rang-me', 'Chợ đêm Trà Vinh', '0294.3855.128', 4.5, '15.000 - 25.000 VNĐ', '17:00 - 22:00', '[\"Chù ụ rang me\", \"Chù ụ nướng\"]', NULL, NULL, NULL, 'Món ăn vặt độc đáo, chù ụ rang với me chua ngọt.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(6, 'quan-an-vat-ba-tu', 'Quán Ăn Vặt Bà Tư', 'chu-u-rang-me', 'Đường Nguyễn Đáng, TP. Trà Vinh', '0294.3855.129', 4.4, '15.000 - 20.000 VNĐ', '16:00 - 21:00', '[\"Chù ụ rang me\"]', NULL, NULL, NULL, 'Quán ăn vặt đa dạng.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(7, 'bun-suong-ba-chin', 'Bún Suông Bà Chín', 'bun-suong', 'Đường Điện Biên Phủ, TP. Trà Vinh', '0294.3855.130', 4.7, '20.000 - 30.000 VNĐ', '6:00 - 19:00', '[\"Bún suông\", \"Bún nước lèo\"]', NULL, NULL, NULL, 'Bún suông với nước dùng trong vắt.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(8, 'quan-bun-khmer-ba-hai', 'Quán Bún Khmer Bà Hai', 'bun-suong', 'Khu phố 3, TP. Trà Vinh', '0294.3855.131', 4.6, '20.000 - 28.000 VNĐ', '6:00 - 18:00', '[\"Bún suông\"]', NULL, NULL, NULL, 'Quán bún Khmer truyền thống.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(9, 'banh-xeo-khmer-ba-bon', 'Bánh Xèo Khmer Bà Bốn', 'banh-xeo-khmer', 'Đường Trần Phú, TP. Trà Vinh', '0294.3855.132', 4.8, '15.000 - 25.000 VNĐ', '15:00 - 21:00', '[\"Bánh xèo Khmer\", \"Bánh khọt\"]', NULL, NULL, NULL, 'Bánh xèo Khmer giòn rụm, nhân đầy đặn.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(10, 'quan-banh-xeo-ba-tam', 'Quán Bánh Xèo Bà Tám', 'banh-xeo-khmer', 'Chợ Trà Vinh', '0294.3855.133', 4.6, '12.000 - 20.000 VNĐ', '14:00 - 20:00', '[\"Bánh xèo\"]', NULL, NULL, NULL, 'Quán bánh xèo giá rẻ.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(11, 'nom-banh-chok-ba-ba', 'Nom Banh Chok Bà Ba', 'nom-banh-chok', 'Khu dân cư Khmer, TP. Trà Vinh', '0294.3855.134', 4.7, '12.000 - 20.000 VNĐ', '6:00 - 10:00', '[\"Nom banh chok\"]', NULL, NULL, NULL, 'Món ăn sáng truyền thống Khmer.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(12, 'bun-khmer-sang-ba-sau', 'Bún Khmer Sáng Bà Sáu', 'nom-banh-chok', 'Đường Lê Thánh Tông', '0294.3855.135', 4.5, '10.000 - 18.000 VNĐ', '5:30 - 9:00', '[\"Nom banh chok\"]', NULL, NULL, NULL, 'Quán bún Khmer sáng sớm.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(13, 'che-khmer-ba-muoi', 'Chè Khmer Bà Mười', 'che-khmer', 'Chợ đêm Trà Vinh', '0294.3855.136', 4.6, '8.000 - 18.000 VNĐ', '14:00 - 22:00', '[\"Chè Khmer\", \"Chè dừa\"]', NULL, NULL, NULL, 'Chè Khmer đa dạng, mát lạnh.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(14, 'quan-che-ba-bay', 'Quán Chè Bà Bảy', 'che-khmer', 'Đường Nguyễn Thị Minh Khai', '0294.3855.137', 4.5, '10.000 - 20.000 VNĐ', '13:00 - 21:00', '[\"Chè Khmer\", \"Sinh tố\"]', NULL, NULL, NULL, 'Quán chè và nước giải khát.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(15, 'ca-loc-nuong-ba-nam', 'Cá Lóc Nướng Bà Năm', 'ca-loc-nuong-trui', 'Ven sông Cổ Chiên', '0294.3855.138', 4.9, '150.000 - 250.000 VNĐ/kg', '10:00 - 21:00', '[\"Cá lóc nướng trui\", \"Lẩu cá\"]', NULL, NULL, NULL, 'Nhà hàng chuyên cá lóc tươi sống.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(16, 'nha-hang-ca-loc-song-nuoc', 'Nhà Hàng Cá Lóc Sông Nước', 'ca-loc-nuong-trui', 'Bờ sông Trà Vinh', '0294.3855.139', 4.8, '180.000 - 280.000 VNĐ/kg', '11:00 - 22:00', '[\"Cá lóc nướng\", \"Cá lóc hấp\"]', NULL, NULL, NULL, 'Nhà hàng view sông đẹp.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(17, 'lau-mam-ba-tu', 'Lẩu Mắm Bà Tư', 'lau-mam', 'Đường Nguyễn Đáng', '0294.3855.140', 4.7, '80.000 - 150.000 VNĐ/người', '16:00 - 22:00', '[\"Lẩu mắm\", \"Lẩu cá\"]', NULL, NULL, NULL, 'Lẩu mắm đậm đà hương vị miền Tây.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(18, 'quan-lau-mam-mien-tay', 'Quán Lẩu Mắm Miền Tây', 'lau-mam', 'Đường Lê Lợi', '0294.3855.141', 4.6, '70.000 - 130.000 VNĐ/người', '17:00 - 23:00', '[\"Lẩu mắm\"]', NULL, NULL, NULL, 'Lẩu mắm với rau rừng phong phú.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(19, 'banh-tet-tra-cuon-co-ut', 'Bánh Tét Trà Cuôn Cô Út', 'banh-tet-tra-cuon', 'Xã Trà Cuôn, Trà Vinh', '0294.3855.142', 4.8, '30.000 - 50.000 VNĐ/cái', '6:00 - 18:00', '[\"Bánh tét\", \"Bánh ít\"]', NULL, NULL, NULL, 'Bánh tét truyền thống Trà Cuôn.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(20, 'banh-it-la-gai-ba-hai', 'Bánh Ít Lá Gai Bà Hai', 'banh-it-la-gai', 'Chợ Trà Vinh', '0294.3855.143', 4.6, '5.000 - 10.000 VNĐ/cái', '6:00 - 17:00', '[\"Bánh ít lá gai\"]', NULL, NULL, NULL, 'Bánh ít lá gai truyền thống.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(21, 'com-tam-suon-nuong-ba-nam', 'Cơm Tấm Sườn Nướng Bà Năm', 'com-tam-suon-nuong-2', 'Đường Trần Hưng Đạo', '0294.3855.144', 4.7, '25.000 - 40.000 VNĐ', '6:00 - 21:00', '[\"Cơm tấm sườn nướng\"]', NULL, NULL, NULL, 'Cơm tấm sườn nướng thơm ngon.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(22, 'quan-com-tam-anh-tu', 'Quán Cơm Tấm Anh Tư', 'com-tam-suon-nuong-2', 'Đường Nguyễn Trãi', '0294.3855.145', 4.5, '20.000 - 35.000 VNĐ', '5:30 - 20:00', '[\"Cơm tấm\"]', NULL, NULL, NULL, 'Cơm tấm giá rẻ.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(23, 'hu-tieu-my-tho-ba-bay', 'Hủ Tiếu Mỹ Tho Bà Bảy', 'hu-tieu-my-tho-2', 'Đường Điện Biên Phủ', '0294.3855.146', 4.6, '20.000 - 35.000 VNĐ', '6:00 - 14:00', '[\"Hủ tiếu Mỹ Tho\"]', NULL, NULL, NULL, 'Hủ tiếu nước dùng ngọt thanh.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(24, 'banh-mi-thit-co-ba', 'Bánh Mì Thịt Cô Ba', 'banh-mi-thit-2', 'Đường Lê Lợi', '0294.3855.147', 4.7, '15.000 - 25.000 VNĐ', '5:00 - 22:00', '[\"Bánh mì thịt\"]', NULL, NULL, NULL, 'Bánh mì giòn rụm, nhân đầy đặn.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(25, 'cafe-sua-da-ong-nam', 'Cà Phê Ông Năm', 'ca-phe-sua-da-2', 'Đường Nguyễn Đáng', '0294.3855.148', 4.8, '15.000 - 25.000 VNĐ', '6:00 - 22:00', '[\"Cà phê sữa đá\", \"Cà phê đen\"]', NULL, NULL, NULL, 'Cà phê phin truyền thống.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(26, 'nuoc-mia-co-hai', 'Nước Mía Cô Hai', 'nuoc-mia-2', 'Chợ Trà Vinh', '0294.3855.149', 4.5, '8.000 - 15.000 VNĐ', '7:00 - 20:00', '[\"Nước mía\"]', NULL, NULL, NULL, 'Nước mía tươi mát.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(27, 'tra-sua-toco', 'Trà Sữa TocoToco', 'tra-sua-2', 'Đường Trần Phú', '0294.3855.150', 4.6, '20.000 - 35.000 VNĐ', '9:00 - 22:00', '[\"Trà sữa\", \"Trà trái cây\"]', NULL, NULL, NULL, 'Trà sữa nhiều hương vị.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(28, 'sinh-to-bo-co-tam', 'Sinh Tố Bơ Cô Tám', 'sinh-to-bo-2', 'Đường Nguyễn Thị Minh Khai', '0294.3855.151', 4.7, '25.000 - 35.000 VNĐ', '8:00 - 21:00', '[\"Sinh tố bơ\", \"Sinh tố các loại\"]', NULL, NULL, NULL, 'Sinh tố bơ béo ngậy.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29'),
(29, 'kem-dua-ba-sau', 'Kem Dừa Bà Sáu', 'kem-dua-2', 'Chợ đêm Trà Vinh', '0294.3855.152', 4.6, '10.000 - 20.000 VNĐ', '14:00 - 22:00', '[\"Kem dừa\", \"Kem các loại\"]', NULL, NULL, NULL, 'Kem dừa mát lạnh.', 'active', '2025-12-05 12:33:29', '2025-12-05 12:33:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `review_id` varchar(50) NOT NULL,
  `attraction_id` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `title` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `visit_date` date DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `helpful_count` int(11) DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bẫy `reviews`
--
DELIMITER $$
CREATE TRIGGER `after_review_delete` AFTER DELETE ON `reviews` FOR EACH ROW BEGIN
    IF OLD.status = 'approved' THEN
        CALL RecalculateRatings(OLD.attraction_id);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_review_insert` AFTER INSERT ON `reviews` FOR EACH ROW BEGIN
    IF NEW.status = 'approved' THEN
        -- Đảm bảo dòng thống kê tồn tại trước khi update
        INSERT IGNORE INTO attraction_ratings (attraction_id) VALUES (NEW.attraction_id);
        CALL RecalculateRatings(NEW.attraction_id);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_review_update` AFTER UPDATE ON `reviews` FOR EACH ROW BEGIN
    IF OLD.status != NEW.status OR OLD.rating != NEW.rating THEN
        INSERT IGNORE INTO attraction_ratings (attraction_id) VALUES (NEW.attraction_id);
        CALL RecalculateRatings(NEW.attraction_id);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review_helpful`
--

CREATE TABLE `review_helpful` (
  `id` int(11) NOT NULL,
  `review_id` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review_images`
--

CREATE TABLE `review_images` (
  `id` int(11) NOT NULL,
  `review_id` varchar(50) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `service_id` varchar(20) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `service_type` enum('tour','hotel','car','support') NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `price_from` decimal(15,2) DEFAULT 0.00,
  `price_to` decimal(15,2) DEFAULT 0.00,
  `unit` varchar(50) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_type`, `description`, `icon`, `price_from`, `price_to`, `unit`, `features`, `is_active`, `created_at`) VALUES
('SV001', 'Lập Kế Hoạch Tour 1 Ngày', 'tour', 'Tư vấn thiết kế hành trình 1 ngày', 'fa-route', 500000.00, 2000000.00, 'tour', 'Tư vấn miễn phí|Thiết kế lịch trình|Gợi ý địa điểm', 1, '2025-11-27 03:06:41'),
('SV002', 'Lập Kế Hoạch Tour 2-3 Ngày', 'tour', 'Thiết kế tour 2-3 ngày khám phá Trà Vinh', 'fa-route', 1500000.00, 5000000.00, 'tour', 'Lịch trình chi tiết|Đặt khách sạn|Gợi ý nhà hàng', 1, '2025-11-27 03:06:41'),
('SV003', 'Tour Trọn Gói All-Inclusive', 'tour', 'Tour trọn gói bao gồm tất cả', 'fa-route', 5000000.00, 15000000.00, 'tour', 'Vé máy bay|Khách sạn 5 sao|Ăn uống|Hướng dẫn viên', 1, '2025-11-27 03:06:41'),
('SV004', 'Đặt Phòng Khách Sạn 2-3 Sao', 'hotel', 'Khách sạn 2-3 sao giá tốt', 'fa-hotel', 300000.00, 800000.00, 'đêm', 'Giá tốt|Vị trí trung tâm|Wifi|Bữa sáng', 1, '2025-11-27 03:06:41'),
('SV005', 'Đặt Phòng Khách Sạn 4-5 Sao', 'hotel', 'Khách sạn cao cấp 4-5 sao', 'fa-hotel', 1000000.00, 3000000.00, 'đêm', 'Dịch vụ 5 sao|Spa|Hồ bơi|Nhà hàng', 1, '2025-11-27 03:06:41'),
('SV006', 'Đặt Phòng Homestay & Resort', 'hotel', 'Homestay gần biển', 'fa-hotel', 500000.00, 1500000.00, 'đêm', 'Gần biển|Không gian riêng|Giá hợp lý', 1, '2025-11-27 03:06:41'),
('SV007', 'Thuê Xe 4-7 Chỗ', 'car', 'Xe 4-7 chỗ với tài xế', 'fa-car', 800000.00, 1500000.00, 'ngày', 'Xe đời mới|Tài xế kinh nghiệm|Bảo hiểm', 1, '2025-11-27 03:06:41'),
('SV008', 'Thuê Xe 16-29 Chỗ', 'car', 'Xe 16-29 chỗ cho đoàn', 'fa-bus', 2000000.00, 3500000.00, 'ngày', 'Xe đời mới|Điều hòa|Wifi', 1, '2025-11-27 03:06:41'),
('SV009', 'Thuê Xe 45 Chỗ', 'car', 'Xe khách 45 chỗ', 'fa-bus', 4000000.00, 6000000.00, 'ngày', 'Xe cao cấp|Ghế ngả|Tivi', 1, '2025-11-27 03:06:41'),
('SV010', 'Thuê Xe Máy', 'car', 'Xe máy tự lái', 'fa-motorcycle', 100000.00, 150000.00, 'ngày', 'Xe đời mới|Bảo hiểm|Mũ bảo hiểm', 1, '2025-11-27 03:06:41'),
('SV011', 'Hỗ Trợ 24/7', 'support', 'Hỗ trợ khách hàng 24/7', 'fa-headset', 0.00, 0.00, 'miễn phí', 'Hỗ trợ 24/7|Tư vấn miễn phí|Hotline', 1, '2025-11-27 03:06:41'),
('SV012', 'Hướng Dẫn Viên', 'support', 'Hướng dẫn viên chuyên nghiệp', 'fa-user-tie', 500000.00, 1000000.00, 'ngày', 'Chuyên nghiệp|Kiến thức sâu|Ngoại ngữ', 1, '2025-11-27 03:06:41'),
('SV013', 'Chụp Ảnh Du Lịch', 'support', 'Photographer chuyên nghiệp', 'fa-camera', 1000000.00, 3000000.00, 'buổi', 'Chuyên nghiệp|Chỉnh sửa ảnh|Giao nhanh', 1, '2025-11-27 03:06:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_bookings`
--

CREATE TABLE `service_bookings` (
  `id` int(11) NOT NULL,
  `booking_code` varchar(50) NOT NULL,
  `service_id` varchar(20) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `service_date` date DEFAULT NULL,
  `number_of_people` int(11) DEFAULT 1,
  `number_of_days` int(11) DEFAULT 1,
  `special_requests` text DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT 0.00,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `service_bookings`
--

INSERT INTO `service_bookings` (`id`, `booking_code`, `service_id`, `customer_name`, `customer_phone`, `customer_email`, `service_date`, `number_of_people`, `number_of_days`, `special_requests`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SB20250001', 'SV001', 'Nguyễn Văn An', '0901234567', 'nguyenvanan@gmail.com', '2025-01-15', 4, 1, 'Muốn tham quan chùa Âng và Ao Bà Om', 800000.00, 'confirmed', '2024-12-01 02:30:00', '2025-11-27 03:10:28'),
(2, 'SB20250002', 'SV002', 'Trần Thị Bình', '0912345678', 'tranthibinh@gmail.com', '2025-01-20', 2, 3, 'Honeymoon, muốn tour lãng mạn', 3500000.00, 'pending', '2024-12-05 07:20:00', '2025-11-27 03:10:28'),
(3, 'SB20250003', 'SV003', 'Lê Văn Cường', '0923456789', 'levancuong@gmail.com', '2025-02-01', 6, 5, 'Đoàn gia đình, có trẻ nhỏ', 12000000.00, 'confirmed', '2024-12-10 03:15:00', '2025-11-27 03:10:28'),
(4, 'SB20250004', 'SV004', 'Phạm Thị Dung', '0934567890', 'phamthidung@gmail.com', '2025-01-18', 2, 2, 'Cần phòng đôi, gần trung tâm', 1200000.00, 'confirmed', '2024-12-08 09:45:00', '2025-11-27 03:10:28'),
(5, 'SB20250005', 'SV005', 'Hoàng Văn Em', '0945678901', 'hoangvanem@gmail.com', '2025-01-25', 2, 3, 'Phòng view biển, có bồn tắm', 6000000.00, 'pending', '2024-12-12 04:30:00', '2025-11-27 03:10:28'),
(6, 'SB20250006', 'SV006', 'Võ Thị Phương', '0956789012', 'vothiphuong@gmail.com', '2025-02-05', 4, 2, 'Homestay gần biển, có bếp', 2000000.00, 'confirmed', '2024-12-15 01:00:00', '2025-11-27 03:10:28'),
(7, 'SB20250007', 'SV007', 'Đặng Văn Giang', '0967890123', 'dangvangiang@gmail.com', '2025-01-22', 5, 1, 'Cần xe 7 chỗ, đón tại sân bay', 1200000.00, 'confirmed', '2024-12-18 06:20:00', '2025-11-27 03:10:28'),
(8, 'SB20250008', 'SV008', 'Bùi Thị Hoa', '0978901234', 'buithihoa@gmail.com', '2025-02-10', 20, 2, 'Đoàn công ty, cần xe 29 chỗ', 6000000.00, 'pending', '2024-12-20 08:40:00', '2025-11-27 03:10:28'),
(9, 'SB20250009', 'SV009', 'Ngô Văn Inh', '0989012345', 'ngovaninh@gmail.com', '2025-02-15', 40, 3, 'Đoàn du lịch, cần xe 45 chỗ', 15000000.00, 'confirmed', '2024-12-22 02:10:00', '2025-11-27 03:10:28'),
(10, 'SB20250010', 'SV010', 'Trương Thị Kim', '0990123456', 'truongthikim@gmail.com', '2025-01-28', 1, 3, 'Thuê xe máy tự lái', 400000.00, 'completed', '2024-12-25 03:25:00', '2025-11-27 03:10:28'),
(11, 'SB20250011', 'SV012', 'Lý Văn Long', '0901112233', 'lyvanlong@gmail.com', '2025-01-30', 8, 1, 'Cần hướng dẫn viên tiếng Anh', 800000.00, 'confirmed', '2024-12-26 07:30:00', '2025-11-27 03:10:28'),
(12, 'SB20250012', 'SV013', 'Mai Thị Minh', '0912223344', 'maithiminh@gmail.com', '2025-02-08', 2, 1, 'Chụp ảnh cưới tại Ao Bà Om', 2000000.00, 'cancelled', '2024-12-28 04:15:00', '2025-11-30 01:59:42'),
(13, 'SB20250013', 'SV001', 'Phan Văn Nam', '0923334455', 'phanvannam@gmail.com', '2025-02-12', 3, 1, 'Tour khám phá văn hóa Khmer', 600000.00, 'cancelled', '2024-12-27 09:20:00', '2025-11-27 03:15:24'),
(14, 'SB20250014', 'SV004', 'Đinh Thị Oanh', '0934445566', 'dinhthioanh@gmail.com', '2025-02-18', 2, 1, 'Phòng đơn giản, sạch sẽ', 600000.00, 'confirmed', '2024-12-29 02:45:00', '2025-11-27 03:10:28'),
(15, 'SB20250015', 'SV007', 'Dương Văn Phúc', '0945556677', 'duongvanphuc@gmail.com', '2025-02-20', 4, 2, 'Thuê xe đi biển', 2400000.00, 'completed', '2024-12-30 06:00:00', '2025-11-27 03:12:50'),
(16, 'SB20250016', 'SV002', 'Nguyễn Thị Lan', '0956667788', 'nguyenthilan@gmail.com', '2025-01-12', 5, 2, 'Đoàn bạn bè', 3000000.00, 'confirmed', '2024-12-15 03:30:00', '2025-11-27 03:10:28'),
(17, 'SB20250017', 'SV005', 'Trần Văn Minh', '0967778899', 'tranvanminh@gmail.com', '2025-01-16', 2, 2, 'Kỷ niệm ngày cưới', 4000000.00, 'pending', '2024-12-18 07:20:00', '2025-11-27 03:10:28'),
(18, 'SB20250018', 'SV008', 'Lê Thị Hoa', '0978889900', 'lethihoa@gmail.com', '2025-02-22', 25, 1, 'Đoàn sinh viên', 3000000.00, 'confirmed', '2024-12-20 04:40:00', '2025-11-27 03:10:28'),
(19, 'SB20250019', 'SV003', 'Phạm Văn Tài', '0989990011', 'phamvantai@gmail.com', '2025-03-01', 4, 7, 'Tour trọn gói gia đình', 10000000.00, 'confirmed', '2024-12-22 02:15:00', '2025-11-27 03:15:33'),
(20, 'SB20250020', 'SV006', 'Hoàng Thị Mai', '0990001122', 'hoangthimai@gmail.com', '2025-02-14', 2, 3, 'Homestay lãng mạn', 3000000.00, 'confirmed', '2024-12-24 09:00:00', '2025-11-27 03:10:28'),
(21, 'SB20251130031158382', '1', 'TRương Quãng', '0366058110', 'thachnhatminh8@gmail.com', NULL, 1, 1, 'đi chơi\n', 0.00, 'pending', '2025-11-30 02:11:58', '2025-11-30 02:11:58'),
(22, 'SB20251130031241928', '2', 'Thạch Nhưt Minh', '0366058110', 'thachnhatminh8@gmail.com', NULL, 1, 1, 'đi chơi', 0.00, 'pending', '2025-11-30 02:12:41', '2025-11-30 02:12:41'),
(23, 'SB20251130053455224', '3', 'Thạch Hương Trầm', '0366058110', 'thachnhatminh8@gmail.com', NULL, 1, 1, 'đi chơi', 0.00, 'pending', '2025-11-30 04:34:55', '2025-11-30 04:34:55'),
(24, 'SB20251205151640748', '1', 'Thạch Huy', '5465410', 'thachnhutmih8@gmail.com', '2025-12-07', 1, 1, 'du lịch', 0.00, 'pending', '2025-12-05 14:16:40', '2025-12-05 14:16:40'),
(25, 'SB20251205152833108', '3', 'Thạch Nhựt  Minh', '0366058110', 'thahNhatminh8@gmail.com', '2025-12-06', 4, 1, '7 chỗ', 0.00, 'pending', '2025-12-05 14:28:33', '2025-12-05 14:28:33'),
(26, 'SB20251223093913101', 'SV001', 'Thạch Nhựt Minh', '0366058110', 'thachnhutminh8@gmail.com', '2025-12-04', 1, 1, 'gewth', 500000.00, 'pending', '2025-12-23 08:39:13', '2025-12-23 08:39:13'),
(27, 'SB20251223125425899', 'SV001', 'Thạch Nhựt Minh', '0366058110', 'thachnhutminh8@gmail.com', '2025-12-27', 1, 1, 'srnw', 500000.00, 'pending', '2025-12-23 11:54:25', '2025-12-23 11:54:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_payments`
--

CREATE TABLE `service_payments` (
  `id` int(11) NOT NULL,
  `booking_code` varchar(50) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'bank_transfer',
  `transaction_code` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','confirmed','failed','refunded') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `service_payments`
--

INSERT INTO `service_payments` (`id`, `booking_code`, `service_id`, `customer_name`, `customer_phone`, `customer_email`, `amount`, `payment_method`, `transaction_code`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'SB20251223125425899', 0, 'Thạch Nhựt Minh', '0366058110', 'thachnhatminh8@gmail.com', 500000.00, 'bank_transfer', 'SV202512231258259735', 'pending', 'Ngân hàng: Sacombank\nSố TK: 0366058110\nChủ TK: THẠCH NHỰT MINH', '2025-12-23 11:58:25', '2025-12-23 11:58:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `tour_id` int(11) NOT NULL,
  `tour_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration_days` int(11) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `itinerary` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`tour_id`, `tour_name`, `description`, `duration_days`, `base_price`, `max_participants`, `itinerary`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tour Khám Phá Văn Hóa Khmer 1 Ngày', 'Khám phá nét đẹp văn hóa Khmer qua các ngôi chùa cổ kính và thắng cảnh nổi tiếng của Trà Vinh. Tour bao gồm tham quan Ao Bà Om, Chùa Âng, Chùa Vàm Rây và thưởng thức ẩm thực địa phương.', 1, 450000.00, 30, '07:00 - Khởi hành từ Trường ĐH Trà Vinh\r\n08:00 - Tham quan Ao Bà Om và Chùa Âng\r\n10:00 - Tham quan Chùa Vàm Rây\r\n12:00 - Dùng bữa trưa với đặc sản Trà Vinh\r\n14:00 - Tham quan Bảo tàng Văn hóa Khmer\r\n16:00 - Mua sắm đặc sản\r\n17:00 - Trở về điểm xuất phát', 'active', '2025-12-09 14:03:36', '2025-12-09 14:03:36'),
(2, 'Tour Biển Và Rừng Đước 1 Ngày', 'Trải nghiệm thiên nhiên hoang sơ với tour biển Ba Động và rừng đước. Tham gia các hoạt động thú vị như tắm biển, chèo kayak khám phá rừng ngập mặn, quan sát chim hoang dã.', 1, 550000.00, 25, '06:00 - Khởi hành đi Biển Ba Động\r\n08:00 - Tắm biển, vui chơi trên bãi cát\r\n10:00 - Thưởng thức hải sản tươi sống\r\n12:00 - Di chuyển đến Rừng Đước\r\n13:30 - Chèo kayak khám phá rừng ngập mặn\r\n15:30 - Quan sát chim tại Cồn Chim\r\n17:00 - Trở về', 'active', '2025-12-09 14:03:36', '2025-12-09 14:03:36'),
(3, 'Tour Tâm Linh 2 Ngày 1 Đêm', 'Hành trình tâm linh đến các ngôi chùa Khmer nổi tiếng và Thiền viện Trúc Lâm Duyên Hải. Trải nghiệm tu tập, thiền định và tìm hiểu văn hóa tâm linh của vùng đất Trà Vinh.', 2, 1200000.00, 20, 'NGÀY 1:\r\n07:00 - Khởi hành\r\n08:00 - Tham quan Chùa Âng\r\n10:00 - Chùa Vàm Rây\r\n12:00 - Ăn trưa chay\r\n14:00 - Chùa Hang\r\n16:00 - Nhận phòng khách sạn\r\n18:00 - Ăn tối\r\n19:00 - Tự do khám phá\r\n\r\nNGÀY 2:\r\n06:00 - Thiền viện Trúc Lâm Duyên Hải\r\n08:00 - Tham gia khóa tu sáng\r\n10:00 - Tham quan khuôn viên\r\n12:00 - Ăn trưa chay\r\n14:00 - Chùa Kompong Chrây\r\n16:00 - Trở về', 'active', '2025-12-09 14:03:36', '2025-12-09 14:03:36'),
(4, 'Tour Trọn Gói Trà Vinh 3 Ngày 2 Đêm', 'Tour trọn gói khám phá toàn bộ Trà Vinh với đầy đủ các điểm tham quan nổi tiếng: văn hóa, biển, rừng, ẩm thực. Phù hợp cho gia đình và nhóm bạn.', 3, 2500000.00, 30, 'NGÀY 1: VĂN HÓA KHMER\r\n- Ao Bà Om, Chùa Âng\r\n- Bảo tàng Văn hóa Khmer\r\n- Chùa Vàm Rây\r\n- Nhận phòng khách sạn\r\n\r\nNGÀY 2: BIỂN VÀ SINH THÁI\r\n- Biển Ba Động\r\n- Rừng Đước\r\n- Cồn Chim\r\n- Ẩm thực hải sản\r\n\r\nNGÀY 3: TÂM LINH VÀ MUA SẮM\r\n- Thiền viện Trúc Lâm\r\n- Chùa Hang\r\n- Mua sắm đặc sản\r\n- Trở về', 'active', '2025-12-09 14:03:36', '2025-12-09 14:03:36'),
(5, 'Tour Ẩm Thực Trà Vinh 1 Ngày', 'Hành trình khám phá ẩm thực đặc sản Trà Vinh với các món ăn truyền thống của người Khmer, Kinh và Hoa. Tham quan các nhà hàng nổi tiếng và chợ địa phương.', 1, 400000.00, 20, '07:00 - Khởi hành\r\n08:00 - Chợ Trà Vinh - Tìm hiểu nguyên liệu\r\n09:30 - Bánh tét Trà Cú\r\n11:00 - Cơm cháy Cầu Kè\r\n13:00 - Lẩu mắm U Minh\r\n15:00 - Bánh xèo Khmer\r\n16:30 - Chè Khmer và trái cây\r\n18:00 - Trở về', 'active', '2025-12-09 14:03:36', '2025-12-09 14:03:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_attractions`
--

CREATE TABLE `tour_attractions` (
  `tour_id` int(11) NOT NULL,
  `attraction_id` varchar(50) NOT NULL,
  `visit_order` int(11) NOT NULL,
  `visit_duration` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_attractions`
--

INSERT INTO `tour_attractions` (`tour_id`, `attraction_id`, `visit_order`, `visit_duration`) VALUES
(1, 'aobaom', 1, '2 giờ'),
(1, 'baotangkhmer', 4, '1.5 giờ'),
(1, 'chuaang', 2, '1 giờ'),
(1, 'chuavamray', 3, '1.5 giờ'),
(2, 'bienbadong', 1, '3 giờ'),
(2, 'conchim', 3, '1.5 giờ'),
(2, 'rungduoc', 2, '2 giờ'),
(3, 'chuaang', 1, '1.5 giờ'),
(3, 'chuahang', 3, '1 giờ'),
(3, 'chuasaleng', 5, '1 giờ'),
(3, 'chuavamray', 2, '1.5 giờ'),
(3, 'thienvientriclam', 4, '3 giờ'),
(4, 'aobaom', 1, '2 giờ'),
(4, 'baotangkhmer', 3, '1.5 giờ'),
(4, 'bienbadong', 4, '3 giờ'),
(4, 'chuaang', 2, '1 giờ'),
(4, 'chuahang', 7, '1 giờ'),
(4, 'rungduoc', 5, '2 giờ'),
(4, 'thienvientriclam', 6, '2 giờ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_bookings`
--

CREATE TABLE `tour_bookings` (
  `id` int(11) NOT NULL,
  `booking_code` varchar(50) NOT NULL,
  `departure_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `num_adults` int(11) NOT NULL DEFAULT 1,
  `num_children` int(11) DEFAULT 0,
  `total_price` decimal(15,2) NOT NULL,
  `booking_status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `special_requests` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_bookings`
--

INSERT INTO `tour_bookings` (`id`, `booking_code`, `departure_date`, `return_date`, `customer_name`, `customer_phone`, `customer_email`, `num_adults`, `num_children`, `total_price`, `booking_status`, `payment_status`, `special_requests`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 'TOUR20251223124310937', '2026-01-03', '2026-01-18', 'Thạch Nhựt Minh', '0366058110', 'thachnhutminh8@gmail.com', 1, 2, 1100000.00, 'pending', 'pending', '', 'online', '2025-12-23 11:43:10', '2025-12-23 11:43:10'),
(2, 'TOUR20251223124315903', '2026-01-03', '2026-01-18', 'Thạch Nhựt Minh', '0366058110', 'thachnhutminh8@gmail.com', 1, 2, 1100000.00, 'pending', 'pending', '', 'online', '2025-12-23 11:43:15', '2025-12-23 11:43:15'),
(3, 'TOUR20251223125912628', '2025-12-25', '2025-12-28', 'Thạch Nhựt Minh', '0366058110', 'thachnhutminh8@gmail.com', 2, 1, 1300000.00, 'pending', 'pending', 'agh', 'online', '2025-12-23 11:59:12', '2025-12-23 11:59:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_pricing`
--

CREATE TABLE `tour_pricing` (
  `pricing_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `season_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `adult_price` decimal(10,2) NOT NULL,
  `child_price` decimal(10,2) DEFAULT 0.00,
  `infant_price` decimal(10,2) DEFAULT 0.00,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_pricing`
--

INSERT INTO `tour_pricing` (`pricing_id`, `tour_id`, `season_name`, `start_date`, `end_date`, `adult_price`, `child_price`, `infant_price`, `is_active`) VALUES
(1, 1, 'Giá thường', '2024-01-01', '2024-04-30', 450000.00, 315000.00, 0.00, 1),
(2, 1, 'Giá cao điểm', '2024-05-01', '2024-08-31', 550000.00, 385000.00, 0.00, 1),
(3, 1, 'Giá thường', '2024-09-01', '2024-12-31', 450000.00, 315000.00, 0.00, 1),
(4, 2, 'Giá thường', '2024-01-01', '2024-04-30', 550000.00, 385000.00, 0.00, 1),
(5, 2, 'Giá cao điểm', '2024-05-01', '2024-08-31', 650000.00, 455000.00, 0.00, 1),
(6, 2, 'Giá thường', '2024-09-01', '2024-12-31', 550000.00, 385000.00, 0.00, 1),
(7, 3, 'Giá thường', '2024-01-01', '2024-04-30', 1200000.00, 840000.00, 0.00, 1),
(8, 3, 'Giá cao điểm', '2024-05-01', '2024-08-31', 1400000.00, 980000.00, 0.00, 1),
(9, 3, 'Giá thường', '2024-09-01', '2024-12-31', 1200000.00, 840000.00, 0.00, 1),
(10, 4, 'Giá thường', '2024-01-01', '2024-04-30', 2500000.00, 1750000.00, 0.00, 1),
(11, 4, 'Giá cao điểm', '2024-05-01', '2024-08-31', 2900000.00, 2030000.00, 0.00, 1),
(12, 4, 'Giá thường', '2024-09-01', '2024-12-31', 2500000.00, 1750000.00, 0.00, 1),
(13, 5, 'Giá thường', '2024-01-01', '2024-12-31', 400000.00, 280000.00, 0.00, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_reviews`
--

CREATE TABLE `tour_reviews` (
  `review_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `tour_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review_title` varchar(255) DEFAULT NULL,
  `review_content` text DEFAULT NULL,
  `pros` text DEFAULT NULL,
  `cons` text DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_schedules`
--

CREATE TABLE `tour_schedules` (
  `schedule_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time DEFAULT '07:00:00',
  `return_date` date DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `available_slots` int(11) NOT NULL,
  `guide_name` varchar(100) DEFAULT NULL,
  `guide_phone` varchar(20) DEFAULT NULL,
  `meeting_point` varchar(255) DEFAULT 'Trường Đại học Trà Vinh',
  `status` enum('scheduled','confirmed','completed','cancelled') DEFAULT 'scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_schedules`
--

INSERT INTO `tour_schedules` (`schedule_id`, `tour_id`, `departure_date`, `departure_time`, `return_date`, `return_time`, `available_slots`, `guide_name`, `guide_phone`, `meeting_point`, `status`, `created_at`) VALUES
(1, 1, '2024-12-15', '07:00:00', '2024-12-15', '17:00:00', 30, 'Nguyễn Văn An', '0901234567', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(2, 1, '2024-12-22', '07:00:00', '2024-12-22', '17:00:00', 30, 'Trần Thị Bình', '0902345678', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(3, 1, '2024-12-29', '07:00:00', '2024-12-29', '17:00:00', 30, 'Nguyễn Văn An', '0901234567', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(4, 2, '2024-12-16', '06:00:00', '2024-12-16', '17:00:00', 25, 'Lê Văn Cường', '0903456789', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(5, 2, '2024-12-23', '06:00:00', '2024-12-23', '17:00:00', 25, 'Lê Văn Cường', '0903456789', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(6, 3, '2024-12-20', '07:00:00', '2024-12-21', '16:00:00', 20, 'Phạm Thị Dung', '0904567890', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(7, 3, '2024-12-27', '07:00:00', '2024-12-28', '16:00:00', 20, 'Phạm Thị Dung', '0904567890', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(8, 4, '2024-12-18', '07:00:00', '2024-12-20', '17:00:00', 30, 'Nguyễn Văn An', '0901234567', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(9, 4, '2024-12-25', '07:00:00', '2024-12-27', '17:00:00', 30, 'Trần Thị Bình', '0902345678', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(10, 5, '2024-12-14', '07:00:00', '2024-12-14', '18:00:00', 20, 'Lê Văn Cường', '0903456789', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(11, 5, '2024-12-21', '07:00:00', '2024-12-21', '18:00:00', 20, 'Lê Văn Cường', '0903456789', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36'),
(12, 5, '2024-12-28', '07:00:00', '2024-12-28', '18:00:00', 20, 'Phạm Thị Dung', '0904567890', 'Trường Đại học Trà Vinh', 'scheduled', '2025-12-09 14:03:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `facebook_id` varchar(100) DEFAULT NULL,
  `avatar_url` varchar(500) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','manager','user') DEFAULT 'user',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `google_id`, `facebook_id`, `avatar_url`, `full_name`, `phone`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@travinh.edu.vn', NULL, NULL, NULL, 'Quản Trị Viên', '0292.3851.237', 'admin', 'active', '2025-12-23 08:46:28', '2025-12-23 08:46:28'),
(2, 'NhutMinh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nhutminh@gmail.com', NULL, NULL, NULL, 'Thạch Nhựt Minh', '0901234567', 'user', 'active', '2025-12-23 08:46:28', '2025-12-23 08:46:28'),
(3, 'minh', '$2y$10$4bjzTU6YHbouFs62LTl91OsGepJvz6dijn5EK.Ol0NCPQL/YfVQ7i', 'thachnhatminh8@gmail.com', NULL, NULL, NULL, 'Mi@131204', '0326310394', 'user', 'active', '2025-12-23 12:03:37', '2025-12-23 12:03:37');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attraction_id` (`attraction_id`);

--
-- Chỉ mục cho bảng `attraction_ratings`
--
ALTER TABLE `attraction_ratings`
  ADD PRIMARY KEY (`attraction_id`);

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `idx_attraction` (`attraction_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_booking_date` (`booking_date`),
  ADD KEY `idx_account_number` (`account_number`),
  ADD KEY `idx_booking_code` (`booking_code`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Chỉ mục cho bảng `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`food_id`);

--
-- Chỉ mục cho bảng `payment_confirmations`
--
ALTER TABLE `payment_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_booking_id` (`booking_id`),
  ADD KEY `idx_booking_type` (`booking_type`),
  ADD KEY `idx_status` (`status`);

--
-- Chỉ mục cho bảng `quanans`
--
ALTER TABLE `quanans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `restaurant_id` (`restaurant_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `review_id` (`review_id`),
  ADD KEY `idx_attraction` (`attraction_id`),
  ADD KEY `idx_rating` (`rating`),
  ADD KEY `idx_status` (`status`);

--
-- Chỉ mục cho bảng `review_helpful`
--
ALTER TABLE `review_helpful`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`review_id`,`user_id`,`ip_address`);

--
-- Chỉ mục cho bảng `review_images`
--
ALTER TABLE `review_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_review` (`review_id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Chỉ mục cho bảng `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`);

--
-- Chỉ mục cho bảng `service_payments`
--
ALTER TABLE `service_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_code` (`transaction_code`),
  ADD KEY `idx_booking_code` (`booking_code`),
  ADD KEY `idx_transaction_code` (`transaction_code`),
  ADD KEY `idx_payment_status` (`payment_status`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `idx_tour_status` (`status`);

--
-- Chỉ mục cho bảng `tour_attractions`
--
ALTER TABLE `tour_attractions`
  ADD PRIMARY KEY (`tour_id`,`attraction_id`);

--
-- Chỉ mục cho bảng `tour_bookings`
--
ALTER TABLE `tour_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`);

--
-- Chỉ mục cho bảng `tour_pricing`
--
ALTER TABLE `tour_pricing`
  ADD PRIMARY KEY (`pricing_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `idx_pricing_dates` (`start_date`,`end_date`);

--
-- Chỉ mục cho bảng `tour_reviews`
--
ALTER TABLE `tour_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `idx_schedule_date` (`departure_date`),
  ADD KEY `idx_schedule_status` (`status`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `attractions`
--
ALTER TABLE `attractions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `payment_confirmations`
--
ALTER TABLE `payment_confirmations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `quanans`
--
ALTER TABLE `quanans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `review_helpful`
--
ALTER TABLE `review_helpful`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `review_images`
--
ALTER TABLE `review_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `service_bookings`
--
ALTER TABLE `service_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `service_payments`
--
ALTER TABLE `service_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tour_bookings`
--
ALTER TABLE `tour_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tour_pricing`
--
ALTER TABLE `tour_pricing`
  MODIFY `pricing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tour_reviews`
--
ALTER TABLE `tour_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `attraction_ratings`
--
ALTER TABLE `attraction_ratings`
  ADD CONSTRAINT `attraction_ratings_ibfk_1` FOREIGN KEY (`attraction_id`) REFERENCES `attractions` (`attraction_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`attraction_id`) REFERENCES `attractions` (`attraction_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `review_helpful`
--
ALTER TABLE `review_helpful`
  ADD CONSTRAINT `review_helpful_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`review_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `review_images`
--
ALTER TABLE `review_images`
  ADD CONSTRAINT `review_images_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`review_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_attractions`
--
ALTER TABLE `tour_attractions`
  ADD CONSTRAINT `tour_attractions_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_pricing`
--
ALTER TABLE `tour_pricing`
  ADD CONSTRAINT `tour_pricing_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_reviews`
--
ALTER TABLE `tour_reviews`
  ADD CONSTRAINT `tour_reviews_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  ADD CONSTRAINT `tour_schedules_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
