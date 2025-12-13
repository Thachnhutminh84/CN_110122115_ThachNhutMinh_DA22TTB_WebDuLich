-- Thêm cột account_number vào bảng bookings
-- File: database/add-account-number-column.sql

-- Kiểm tra và thêm cột account_number nếu chưa có
ALTER TABLE bookings 
ADD COLUMN IF NOT EXISTS account_number VARCHAR(20) NULL COMMENT 'Số tài khoản ngân hàng để hoàn tiền';

-- Thêm index cho tìm kiếm nhanh
CREATE INDEX IF NOT EXISTS idx_account_number ON bookings(account_number);

-- Hiển thị cấu trúc bảng sau khi thêm
DESCRIBE bookings;

SELECT 'Đã thêm cột account_number vào bảng bookings thành công!' AS message;
