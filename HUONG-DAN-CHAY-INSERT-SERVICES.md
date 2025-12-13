# Hướng Dẫn Chạy Insert Dữ Liệu Services

## Bước 1: Mở phpMyAdmin

1. Truy cập: `http://localhost/phpmyadmin`
2. Đăng nhập với tài khoản root (mặc định không có mật khẩu)

## Bước 2: Chọn Database

1. Chọn database `travinh_tourism` ở bên trái
2. Chọn tab **SQL**

## Bước 3: Chạy SQL

Sao chép toàn bộ code dưới đây và dán vào khung SQL:

```sql
-- Insert dữ liệu vào bảng services
USE travinh_tourism;

-- Xóa dữ liệu cũ (nếu có)
TRUNCATE TABLE services;

-- Insert dịch vụ
INSERT INTO services (service_id, service_name, service_type, description, icon, price_from, price_to, unit, features, is_active) VALUES
('SV001', 'Lập Kế Hoạch Tour 1 Ngày', 'tour', 'Tư vấn thiết kế hành trình 1 ngày', 'fa-route', 500000, 2000000, 'tour', 'Tư vấn miễn phí|Thiết kế lịch trình|Gợi ý địa điểm', TRUE),
('SV002', 'Lập Kế Hoạch Tour 2-3 Ngày', 'tour', 'Thiết kế tour 2-3 ngày khám phá Trà Vinh', 'fa-route', 1500000, 5000000, 'tour', 'Lịch trình chi tiết|Đặt khách sạn|Gợi ý nhà hàng', TRUE),
('SV003', 'Tour Trọn Gói All-Inclusive', 'tour', 'Tour trọn gói bao gồm tất cả', 'fa-route', 5000000, 15000000, 'tour', 'Vé máy bay|Khách sạn 5 sao|Ăn uống|Hướng dẫn viên', TRUE),
('SV004', 'Đặt Phòng Khách Sạn 2-3 Sao', 'hotel', 'Khách sạn 2-3 sao giá tốt', 'fa-hotel', 300000, 800000, 'đêm', 'Giá tốt|Vị trí trung tâm|Wifi|Bữa sáng', TRUE),
('SV005', 'Đặt Phòng Khách Sạn 4-5 Sao', 'hotel', 'Khách sạn cao cấp 4-5 sao', 'fa-hotel', 1000000, 3000000, 'đêm', 'Dịch vụ 5 sao|Spa|Hồ bơi|Nhà hàng', TRUE),
('SV006', 'Đặt Phòng Homestay & Resort', 'hotel', 'Homestay gần biển', 'fa-hotel', 500000, 1500000, 'đêm', 'Gần biển|Không gian riêng|Giá hợp lý', TRUE),
('SV007', 'Thuê Xe 4-7 Chỗ', 'car', 'Xe 4-7 chỗ với tài xế', 'fa-car', 800000, 1500000, 'ngày', 'Xe đời mới|Tài xế kinh nghiệm|Bảo hiểm', TRUE),
('SV008', 'Thuê Xe 16-29 Chỗ', 'car', 'Xe 16-29 chỗ cho đoàn', 'fa-bus', 2000000, 3500000, 'ngày', 'Xe đời mới|Điều hòa|Wifi', TRUE),
('SV009', 'Thuê Xe 45 Chỗ', 'car', 'Xe khách 45 chỗ', 'fa-bus', 4000000, 6000000, 'ngày', 'Xe cao cấp|Ghế ngả|Tivi', TRUE),
('SV010', 'Thuê Xe Máy', 'car', 'Xe máy tự lái', 'fa-motorcycle', 100000, 150000, 'ngày', 'Xe đời mới|Bảo hiểm|Mũ bảo hiểm', TRUE),
('SV011', 'Hỗ Trợ Khách Hàng 24/7', 'support', 'Dịch vụ hỗ trợ khách hàng 24/7', 'fa-headset', 0, 0, 'dịch vụ', 'Hotline 24/7|Chat trực tuyến|Hỗ trợ khẩn cấp', TRUE);
```

## Bước 4: Thực Thi

1. Bấm nút **Thực thi** (Execute)
2. Nếu thành công sẽ hiển thị: "11 hàng đã được chèn"

## Bước 5: Kiểm Tra

1. Chọn bảng `services` ở bên trái
2. Bấm tab **Duyệt** (Browse)
3. Kiểm tra xem có 11 dịch vụ không

## Lưu Ý

- Nếu lỗi "Bảng không tồn tại", hãy chạy file `database/create-service-bookings.sql` trước
- Nếu lỗi "Cột không tồn tại", hãy kiểm tra cấu trúc bảng services

## Sau Khi Insert Xong

Bây giờ bạn có thể:
1. Bấm "Đặt Dịch Vụ" trên website
2. Chọn dịch vụ
3. Điền thông tin
4. Chọn phương thức thanh toán (VNPay, Chuyển Khoản, MoMo)
5. Xem chi tiết đơn giá và thanh toán
