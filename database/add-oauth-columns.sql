-- =====================================================
-- Thêm cột OAuth cho bảng app_users
-- Du Lịch Trà Vinh
-- =====================================================

-- Thêm cột google_id
ALTER TABLE app_users ADD COLUMN IF NOT EXISTS google_id VARCHAR(100) NULL AFTER email;

-- Thêm cột facebook_id  
ALTER TABLE app_users ADD COLUMN IF NOT EXISTS facebook_id VARCHAR(100) NULL AFTER google_id;

-- Thêm cột avatar_url
ALTER TABLE app_users ADD COLUMN IF NOT EXISTS avatar_url VARCHAR(500) NULL AFTER facebook_id;

-- Tạo index cho tìm kiếm nhanh (bỏ IF NOT EXISTS vì MySQL không hỗ trợ)
-- Chạy riêng nếu chưa có index
-- CREATE INDEX idx_google_id ON app_users(google_id);
-- CREATE INDEX idx_facebook_id ON app_users(facebook_id);

-- Cho phép password NULL (cho user đăng nhập bằng OAuth)
ALTER TABLE app_users MODIFY COLUMN password VARCHAR(255) NULL;

-- Nếu bảng là 'users' thay vì 'app_users', chạy các lệnh sau:
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS google_id VARCHAR(100) NULL;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS facebook_id VARCHAR(100) NULL;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS avatar_url VARCHAR(500) NULL;
-- ALTER TABLE users MODIFY COLUMN password VARCHAR(255) NULL;
