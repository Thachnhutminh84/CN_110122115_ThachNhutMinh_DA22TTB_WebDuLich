-- Cập nhật bảng service_bookings để thêm các cột thiếu
USE travinh_tourism;

-- Thay đổi kiểu dữ liệu của service_id từ INT sang VARCHAR(20)
ALTER TABLE service_bookings MODIFY COLUMN service_id VARCHAR(20);

-- Thêm cột unit_price nếu chưa có
ALTER TABLE service_bookings ADD COLUMN IF NOT EXISTS unit_price DECIMAL(15, 2) DEFAULT 0 AFTER total_price;

-- Thêm cột price_from nếu chưa có
ALTER TABLE service_bookings ADD COLUMN IF NOT EXISTS price_from DECIMAL(15, 2) DEFAULT 0 AFTER unit_price;

-- Thêm cột price_to nếu chưa có
ALTER TABLE service_bookings ADD COLUMN IF NOT EXISTS price_to DECIMAL(15, 2) DEFAULT 0 AFTER price_from;

-- Cập nhật lại total_price để có độ chính xác cao hơn
ALTER TABLE service_bookings MODIFY COLUMN total_price DECIMAL(15, 2) DEFAULT 0;

-- Thêm index
CREATE INDEX IF NOT EXISTS idx_unit_price ON service_bookings(unit_price);
