# HƯỚNG DẪN HỆ THỐNG ĐÁNH GIÁ & BÌNH LUẬN

## 📋 TỔNG QUAN

Hệ thống đánh giá cho phép người dùng:
- ⭐ Đánh giá địa điểm (1-5 sao)
- 💬 Viết review chi tiết
- 📸 Upload ảnh thực tế
- 👍 Vote review hữu ích
- 📊 Xem thống kê rating

---

## 🚀 CÀI ĐẶT

### Bước 1: Chạy SQL tạo database

Mở phpMyAdmin và chạy file:
```
database/create-reviews-system.sql
```

File này sẽ tạo:
- Bảng `reviews` - Lưu đánh giá
- Bảng `review_images` - Lưu ảnh review
- Bảng `review_helpful` - Lưu vote hữu ích
- Bảng `attraction_ratings` - Thống kê rating
- Triggers tự động cập nhật thống kê

### Bước 2: Tạo thư mục upload ảnh

```bash
mkdir hinhanh/reviews
chmod 777 hinhanh/reviews
```

### Bước 3: Thêm vào trang chi tiết địa điểm

Mở file `chi-tiet-dia-diem.php` và thêm trước `</body>`:

```php
<?php
// Thêm review section
include 'components/review-section.php';
?>
```

---

## 📁 CẤU TRÚC FILE

```
/database/
  └── create-reviews-system.sql    ✅ SQL tạo bảng

/models/
  └── Review.php                    ✅ Model xử lý review

/api/
  └── reviews.php                   ✅ API endpoint

/components/
  └── review-section.php            ✅ Component hiển thị

/js/
  └── reviews.js                    ✅ JavaScript xử lý

/hinhanh/reviews/                   ✅ Thư mục lưu ảnh
```

---

## 🎯 TÍNH NĂNG

### 1. Đánh giá địa điểm (1-5 sao)
- Click vào sao để chọn rating
- Bắt buộc phải chọn trước khi submit
- Hiển thị rating trung bình

### 2. Viết review
- Tiêu đề (optional)
- Nội dung chi tiết (required)
- Ngày tham quan (optional)
- Tự động lấy thông tin nếu đã đăng nhập

### 3. Upload ảnh
- Tối đa 5 ảnh
- Preview trước khi upload
- Tự động resize và optimize
- Hiển thị gallery trong review

### 4. Thống kê rating
- Rating trung bình
- Tổng số đánh giá
- Phân bố theo số sao (1-5)
- Biểu đồ thanh trực quan

### 5. Vote hữu ích
- Người dùng vote review hữu ích
- Chống vote trùng (theo user_id hoặc IP)
- Hiển thị số lượng vote

### 6. Quản lý review (Admin)
- Duyệt/Từ chối review
- Xóa review spam
- Xem tất cả review

---

## 💻 SỬ DỤNG

### Thêm vào trang chi tiết

```php
<?php
// Định nghĩa attraction_id
$attraction_id = 'ATTR001';

// Include component
include 'components/review-section.php';
?>
```

### Gọi API từ JavaScript

```javascript
// Lấy reviews
fetch('api/reviews.php?attraction_id=ATTR001')
    .then(res => res.json())
    .then(data => console.log(data));

// Tạo review mới
fetch('api/reviews.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'create',
        attraction_id: 'ATTR001',
        rating: 5,
        user_name: 'Nguyễn Văn A',
        content: 'Rất tuyệt vời!'
    })
});

// Vote hữu ích
fetch('api/reviews.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'helpful',
        review_id: 'REV001'
    })
});
```

---

## 🔧 TÙY CHỈNH

### Thay đổi số lượng ảnh tối đa

Sửa trong `components/review-section.php`:
```html
<input type="file" ... accept="image/*" max="5">
```

Và trong `js/reviews.js`:
```javascript
const files = Array.from(input.files).slice(0, 5); // Đổi 5 thành số khác
```

### Thay đổi trạng thái mặc định

Sửa trong `models/Review.php`:
```php
$status = isset($data['user_id']) ? 'approved' : 'pending';
// Đổi 'approved' thành 'pending' nếu muốn duyệt thủ công
```

### Thêm validation

Sửa trong `api/reviews.php`:
```php
// Kiểm tra độ dài nội dung
if (strlen($data['content']) < 10) {
    throw new Exception("Nội dung quá ngắn");
}

// Kiểm tra rating
if ($data['rating'] < 1 || $data['rating'] > 5) {
    throw new Exception("Rating không hợp lệ");
}
```

---

## 📊 DATABASE SCHEMA

### Bảng reviews
```sql
- id (INT, PK, AUTO_INCREMENT)
- review_id (VARCHAR(50), UNIQUE)
- attraction_id (VARCHAR(50))
- user_id (INT, nullable)
- user_name (VARCHAR(100))
- user_email (VARCHAR(100), nullable)
- rating (INT, 1-5)
- title (VARCHAR(255), nullable)
- content (TEXT)
- visit_date (DATE, nullable)
- is_verified (BOOLEAN)
- helpful_count (INT)
- status (ENUM: pending, approved, rejected)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### Bảng review_images
```sql
- id (INT, PK, AUTO_INCREMENT)
- review_id (VARCHAR(50), FK)
- image_path (VARCHAR(255))
- caption (VARCHAR(255), nullable)
- display_order (INT)
- created_at (TIMESTAMP)
```

### Bảng attraction_ratings
```sql
- attraction_id (VARCHAR(50), PK)
- total_reviews (INT)
- average_rating (DECIMAL(3,2))
- rating_5_star (INT)
- rating_4_star (INT)
- rating_3_star (INT)
- rating_2_star (INT)
- rating_1_star (INT)
- updated_at (TIMESTAMP)
```

---

## ✅ KIỂM TRA

### Test tạo review
1. Mở trang chi tiết địa điểm
2. Click "Viết Đánh Giá"
3. Chọn số sao
4. Điền thông tin
5. Upload ảnh (optional)
6. Click "Gửi Đánh Giá"

### Test hiển thị
1. Kiểm tra rating trung bình
2. Kiểm tra biểu đồ phân bố sao
3. Kiểm tra danh sách reviews
4. Kiểm tra hiển thị ảnh

### Test vote hữu ích
1. Click nút "Hữu ích"
2. Kiểm tra số lượng tăng
3. Thử vote lại (phải báo lỗi)

---

## 🐛 XỬ LÝ LỖI

### Lỗi: "Cannot create directory"
```bash
# Tạo thư mục và phân quyền
mkdir -p hinhanh/reviews
chmod 777 hinhanh/reviews
```

### Lỗi: "Trigger already exists"
```sql
-- Xóa trigger cũ trước
DROP TRIGGER IF EXISTS after_review_insert;
DROP TRIGGER IF EXISTS after_review_update;
DROP TRIGGER IF EXISTS after_review_delete;
-- Sau đó chạy lại SQL
```

### Lỗi: "Foreign key constraint fails"
```sql
-- Tắt foreign key check tạm thời
SET FOREIGN_KEY_CHECKS = 0;
-- Chạy SQL
SET FOREIGN_KEY_CHECKS = 1;
```

---

## 🎨 RESPONSIVE

Hệ thống đã responsive sẵn cho:
- 📱 Mobile (< 768px)
- 📱 Tablet (768px - 992px)
- 💻 Desktop (> 992px)

---

## 🔒 BẢO MẬT

- ✅ Validate input
- ✅ Escape HTML
- ✅ Prepared statements
- ✅ File upload validation
- ✅ Rate limiting (có thể thêm)

---

## 📈 NÂNG CAO

### Thêm tính năng:
1. Reply to review
2. Report spam
3. Sort by rating/date
4. Filter by rating
5. Pagination
6. Email notification
7. Social share

---

## ✨ HOÀN THÀNH!

Hệ thống đánh giá đã sẵn sàng sử dụng!

**Liên hệ:** Nếu cần hỗ trợ, hãy tham khảo code hoặc documentation.
