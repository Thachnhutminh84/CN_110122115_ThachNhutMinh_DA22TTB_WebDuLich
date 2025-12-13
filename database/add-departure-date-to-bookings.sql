-- Thêm cột departure_date vào bảng bookings
ALTER TABLE bookings ADD COLUMN departure_date DATE AFTER booking_code;
