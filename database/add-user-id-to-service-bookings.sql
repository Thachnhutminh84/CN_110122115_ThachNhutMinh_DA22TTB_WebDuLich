-- Thêm cột user_id vào bảng service_bookings
ALTER TABLE service_bookings ADD COLUMN user_id INT AFTER id;

-- Thêm cột booking_date, start_time, quantity, notes, payment_id, status
ALTER TABLE service_bookings ADD COLUMN booking_date DATE AFTER customer_email;
ALTER TABLE service_bookings ADD COLUMN start_time TIME AFTER booking_date;
ALTER TABLE service_bookings ADD COLUMN quantity INT DEFAULT 1 AFTER start_time;
ALTER TABLE service_bookings ADD COLUMN notes TEXT AFTER quantity;
ALTER TABLE service_bookings ADD COLUMN payment_id INT AFTER notes;

-- Thêm foreign key cho user_id
ALTER TABLE service_bookings ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

-- Thêm index cho user_id
CREATE INDEX idx_user_id ON service_bookings(user_id);
