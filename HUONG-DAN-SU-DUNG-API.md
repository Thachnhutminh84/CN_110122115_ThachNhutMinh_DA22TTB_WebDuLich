# 📚 HƯỚNG DẪN SỬ DỤNG API - DU LỊCH TRÀ VINH

## 🚀 Bắt Đầu Nhanh

### Bước 1: Chuẩn Bị Database

Đảm bảo bạn đã tạo đầy đủ các bảng trong database:

1. **Tạo bảng service_bookings** (nếu chưa có):
   ```
   Truy cập: http://localhost/gioithieudulichtravinh/setup-service-bookings.php
   ```

2. **Kiểm tra các bảng cần thiết**:
   - users
   - attractions
   - foods
   - restaurants
   - bookings
   - service_bookings
   - services
   - contacts
   - reviews

### Bước 2: Test Tất Cả API

Truy cập trang test tổng hợp:
```
http://localhost/gioithieudulichtravinh/test-all-apis.php
```

Trang này cho phép bạn test tất cả các API với giao diện đẹp mắt và dễ sử dụng.

### Bước 3: Test Từng API Riêng Lẻ

#### Test Service Bookings API:
```
http://localhost/gioithieudulichtravinh/test-service-booking-api.php
```

---

## 📖 Chi Tiết Các API

### 1. 🔐 Authentication API

**File:** `api/auth.php`

#### Đăng Nhập
```javascript
fetch('api/auth.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'login',
        username: 'admin',
        password: '123456'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

#### Đăng Ký
```javascript
fetch('api/auth.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'register',
        username: 'newuser',
        email: 'user@gmail.com',
        password: '123456',
        full_name: 'Nguyễn Văn A',
        phone: '0901234567'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

---

### 2. 🏛️ Attractions API

**File:** `api/attractions.php`

#### Lấy Tất Cả Địa Điểm
```javascript
fetch('api/attractions.php')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Lấy Địa Điểm Theo ID
```javascript
fetch('api/attractions.php?attraction_id=ATTR001')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Tìm Kiếm Địa Điểm
```javascript
fetch('api/attractions.php?search=chùa')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Lọc Theo Danh Mục
```javascript
fetch('api/attractions.php?category=Chùa Khmer')
    .then(res => res.json())
    .then(data => console.log(data));
```

---

### 3. 🍜 Foods API

**File:** `api/foods.php`

#### Lấy Tất Cả Món Ăn
```javascript
fetch('api/foods.php')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Lấy Món Ăn Theo ID
```javascript
fetch('api/foods.php?food_id=FOOD001')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Tìm Kiếm Món Ăn
```javascript
fetch('api/search-foods.php?keyword=bánh')
    .then(res => res.json())
    .then(data => console.log(data));
```

---

### 4. 🏨 Restaurants API

**File:** `api/restaurants.php`

#### Lấy Tất Cả Nhà Hàng
```javascript
fetch('api/restaurants.php')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Tìm Nhà Hàng Gần Đây
```javascript
fetch('api/restaurants.php?lat=9.9345&lng=106.3422&radius=5')
    .then(res => res.json())
    .then(data => console.log(data));
```

---

### 5. 📅 Bookings API (Đặt Tour)

**File:** `api/bookings.php`

#### Tạo Booking Mới
```javascript
fetch('api/bookings.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        attraction_id: 'ATTR001',
        customer_name: 'Nguyễn Văn A',
        customer_email: 'email@gmail.com',
        customer_phone: '0901234567',
        booking_date: '2025-12-01',
        number_of_people: 4,
        special_requests: 'Muốn có hướng dẫn viên'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

#### Lấy Tất Cả Bookings
```javascript
fetch('api/bookings.php')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Lấy Booking Theo Trạng Thái
```javascript
fetch('api/bookings.php?status=pending')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Lấy Thống Kê
```javascript
fetch('api/bookings.php?statistics=true')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Cập Nhật Trạng Thái
```javascript
fetch('api/bookings.php', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        booking_id: 'BK20251124123456789',
        status: 'confirmed'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

---

### 6. 🔔 Service Bookings API (Đặt Dịch Vụ)

**File:** `api/service-bookings.php`

#### Tạo Service Booking
```javascript
fetch('api/service-bookings.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        service_id: 1,
        customer_name: 'Nguyễn Văn A',
        customer_phone: '0901234567',
        customer_email: 'email@gmail.com',
        service_date: null,
        number_of_people: 2,
        number_of_days: 1,
        special_requests: 'Ghi chú đặc biệt',
        total_price: 0
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

#### Lấy Tất Cả Service Bookings
```javascript
fetch('api/service-bookings.php')
    .then(res => res.json())
    .then(data => console.log(data));
```

#### Cập Nhật Trạng Thái
```javascript
fetch('api/service-bookings.php', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        booking_code: 'SB20251201123456789',
        status: 'confirmed'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

---

### 7. 📧 Contact API

**File:** `api/contact.php`

#### Gửi Liên Hệ
```javascript
fetch('api/contact.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'create',
        name: 'Nguyễn Văn A',
        email: 'email@gmail.com',
        phone: '0901234567',
        subject: 'Hỏi về tour',
        message: 'Tôi muốn biết thêm thông tin...'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

#### Lấy Tất Cả Liên Hệ (Admin)
```javascript
fetch('api/contact.php')
    .then(res => res.json())
    .then(data => console.log(data));
```

---

### 8. ⭐ Reviews API

**File:** `api/reviews.php`

#### Thêm Đánh Giá
```javascript
fetch('api/reviews.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'create',
        attraction_id: 'ATTR001',
        rating: 5,
        comment: 'Địa điểm rất đẹp!'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

#### Lấy Đánh Giá Theo Địa Điểm
```javascript
fetch('api/reviews.php?attraction_id=ATTR001')
    .then(res => res.json())
    .then(data => console.log(data));
```

---

### 9. 👥 Users API

**File:** `api/users.php`

#### Lấy Thông Tin User
```javascript
fetch('api/users.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'get_user',
        user_id: 1
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

#### Cập Nhật Trạng Thái User (Admin)
```javascript
fetch('api/users.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'update_status',
        user_id: 5,
        status: 'banned'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

---

## 🎯 Sử Dụng Trong JavaScript

### Ví Dụ Hoàn Chỉnh

```javascript
// Hàm helper để gọi API
async function callAPI(endpoint, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        }
    };
    
    if (data && method !== 'GET') {
        options.body = JSON.stringify(data);
    }
    
    try {
        const response = await fetch(endpoint, options);
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('API Error:', error);
        return { success: false, message: error.message };
    }
}

// Sử dụng
async function bookTour() {
    const result = await callAPI('api/bookings.php', 'POST', {
        attraction_id: 'ATTR001',
        customer_name: 'Nguyễn Văn A',
        customer_phone: '0901234567',
        booking_date: '2025-12-01',
        number_of_people: 4
    });
    
    if (result.success) {
        alert('Đặt tour thành công!');
        console.log('Booking ID:', result.data.booking_id);
    } else {
        alert('Lỗi: ' + result.message);
    }
}
```

---

## 🔧 Xử Lý Lỗi

Tất cả API đều trả về format:

```json
{
    "success": true/false,
    "message": "Thông báo",
    "data": {}
}
```

### Kiểm Tra Response

```javascript
fetch('api/attractions.php')
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Xử lý thành công
            console.log('Data:', data.data);
        } else {
            // Xử lý lỗi
            console.error('Error:', data.message);
        }
    })
    .catch(error => {
        // Xử lý lỗi network
        console.error('Network Error:', error);
    });
```

---

## 📱 Sử Dụng Trong Form HTML

```html
<form id="bookingForm">
    <input type="text" name="customer_name" required>
    <input type="tel" name="customer_phone" required>
    <input type="date" name="booking_date" required>
    <input type="number" name="number_of_people" required>
    <button type="submit">Đặt Tour</button>
</form>

<script>
document.getElementById('bookingForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = {
        attraction_id: 'ATTR001',
        customer_name: formData.get('customer_name'),
        customer_phone: formData.get('customer_phone'),
        booking_date: formData.get('booking_date'),
        number_of_people: parseInt(formData.get('number_of_people'))
    };
    
    const response = await fetch('api/bookings.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    
    const result = await response.json();
    
    if (result.success) {
        alert('✅ ' + result.message);
        e.target.reset();
    } else {
        alert('❌ ' + result.message);
    }
});
</script>
```

---

## 🎨 Tích Hợp Vào Website

### 1. Hiển Thị Danh Sách Địa Điểm

```javascript
async function loadAttractions() {
    const response = await fetch('api/attractions.php');
    const result = await response.json();
    
    if (result.success) {
        const container = document.getElementById('attractions-list');
        container.innerHTML = result.data.map(attraction => `
            <div class="attraction-card">
                <img src="${attraction.image_url}" alt="${attraction.name}">
                <h3>${attraction.name}</h3>
                <p>${attraction.description}</p>
                <button onclick="bookTour('${attraction.attraction_id}')">
                    Đặt Tour
                </button>
            </div>
        `).join('');
    }
}

// Gọi khi trang load
loadAttractions();
```

### 2. Form Đặt Tour Động

```javascript
async function bookTour(attractionId) {
    const name = prompt('Nhập tên của bạn:');
    const phone = prompt('Nhập số điện thoại:');
    const date = prompt('Nhập ngày đặt (YYYY-MM-DD):');
    const people = prompt('Số người:');
    
    if (!name || !phone || !date || !people) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }
    
    const response = await fetch('api/bookings.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            attraction_id: attractionId,
            customer_name: name,
            customer_phone: phone,
            booking_date: date,
            number_of_people: parseInt(people)
        })
    });
    
    const result = await response.json();
    alert(result.success ? '✅ ' + result.message : '❌ ' + result.message);
}
```

---

## 🔒 Bảo Mật

### Các API Yêu Cầu Đăng Nhập

- Tất cả API có prefix `/quan-ly-*`
- API xóa, cập nhật dữ liệu
- API quản lý users

### Kiểm Tra Session

```javascript
async function checkAuth() {
    const response = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'check_session' })
    });
    
    const result = await response.json();
    
    if (!result.logged_in) {
        window.location.href = 'dang-nhap.php';
    }
}
```

---

## 📞 Hỗ Trợ

- **Email:** support@travinh-tourism.vn
- **Phone:** 0123456789
- **Tài liệu API:** TAI-LIEU-API.md

---

**Version:** 1.0.0  
**Last Updated:** 01/12/2025  
**Author:** Trường Đại học Trà Vinh
