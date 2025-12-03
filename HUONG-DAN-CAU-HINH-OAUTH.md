# Hướng Dẫn Cấu Hình Đăng Nhập Google & Facebook

## 📋 Tổng Quan

Hệ thống hỗ trợ đăng nhập bằng:
- **Google OAuth 2.0**
- **Facebook Login**

## 🔧 Bước 1: Cập Nhật Database

Chạy file SQL để thêm các cột cần thiết:

```sql
-- Chạy trong phpMyAdmin hoặc MySQL CLI
SOURCE database/add-oauth-columns.sql;
```

Hoặc chạy trực tiếp:
```sql
ALTER TABLE users ADD COLUMN google_id VARCHAR(100) NULL;
ALTER TABLE users ADD COLUMN facebook_id VARCHAR(100) NULL;
ALTER TABLE users ADD COLUMN avatar_url VARCHAR(500) NULL;
ALTER TABLE users MODIFY COLUMN password VARCHAR(255) NULL;
```

---

## 🔴 Bước 2: Cấu Hình Google OAuth

### 2.1. Tạo Project trên Google Cloud Console

1. Truy cập: https://console.cloud.google.com/
2. Tạo project mới hoặc chọn project có sẵn
3. Vào **APIs & Services** > **Credentials**

### 2.2. Tạo OAuth Client ID

1. Click **Create Credentials** > **OAuth client ID**
2. Chọn **Application type**: Web application
3. Đặt tên: "Du Lịch Trà Vinh"
4. Thêm **Authorized redirect URIs**:
   - Development: `http://localhost/gioithieudulichtravinh/auth/google-callback.php`
   - Production: `https://yourdomain.com/auth/google-callback.php`
5. Click **Create**
6. Copy **Client ID** và **Client Secret**

### 2.3. Cập nhật file config/oauth.php

```php
define('GOOGLE_CLIENT_ID', 'your-client-id.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'your-client-secret');
define('GOOGLE_REDIRECT_URI', 'http://localhost/gioithieudulichtravinh/auth/google-callback.php');
```

---

## 🔵 Bước 3: Cấu Hình Facebook Login

### 3.1. Tạo Facebook App

1. Truy cập: https://developers.facebook.com/
2. Click **My Apps** > **Create App**
3. Chọn **Consumer** > **Next**
4. Đặt tên app: "Du Lịch Trà Vinh"

### 3.2. Cấu hình Facebook Login

1. Trong Dashboard, tìm **Facebook Login** > **Set Up**
2. Chọn **Web**
3. Nhập Site URL: `http://localhost/gioithieudulichtravinh/`
4. Vào **Facebook Login** > **Settings**
5. Thêm **Valid OAuth Redirect URIs**:
   - `http://localhost/gioithieudulichtravinh/auth/facebook-callback.php`

### 3.3. Lấy App ID và App Secret

1. Vào **Settings** > **Basic**
2. Copy **App ID** và **App Secret**

### 3.4. Cập nhật file config/oauth.php

```php
define('FACEBOOK_APP_ID', 'your-app-id');
define('FACEBOOK_APP_SECRET', 'your-app-secret');
define('FACEBOOK_REDIRECT_URI', 'http://localhost/gioithieudulichtravinh/auth/facebook-callback.php');
```

---

## ✅ Bước 4: Kiểm Tra

1. Truy cập trang đăng nhập: `http://localhost/gioithieudulichtravinh/dang-nhap.php`
2. Click nút **Google** hoặc **Facebook**
3. Đăng nhập với tài khoản của bạn
4. Hệ thống sẽ tự động:
   - Tạo tài khoản mới nếu chưa có
   - Đăng nhập nếu đã có tài khoản

---

## 📁 Cấu Trúc Files

```
auth/
├── google-login.php      # Redirect đến Google OAuth
├── google-callback.php   # Xử lý callback từ Google
├── facebook-login.php    # Redirect đến Facebook OAuth
└── facebook-callback.php # Xử lý callback từ Facebook

config/
└── oauth.php             # Cấu hình OAuth credentials

database/
└── add-oauth-columns.sql # SQL thêm cột cho OAuth
```

---

## 🔒 Lưu Ý Bảo Mật

1. **KHÔNG** commit file `config/oauth.php` với credentials thật lên Git
2. Sử dụng **environment variables** cho production
3. Đảm bảo **HTTPS** cho production
4. Kiểm tra **redirect URI** khớp chính xác

---

## 🐛 Xử Lý Lỗi Thường Gặp

### Lỗi "redirect_uri_mismatch"
- Kiểm tra URI trong Google/Facebook Console khớp với `config/oauth.php`

### Lỗi "invalid_client"
- Kiểm tra Client ID/App ID đúng

### Lỗi "access_denied"
- User đã hủy đăng nhập
- App chưa được phê duyệt (Facebook)

---

## 👤 Tác Giả

- **Thạch Nhựt Minh**
- MSSV: 110122115
- Lớp: Da22TTB
- Trường ĐH Trà Vinh
