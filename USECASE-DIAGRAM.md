# 📊 USE CASE DIAGRAM - WEBSITE DU LỊCH TRÀ VINH

## 🎯 TỔNG QUAN HỆ THỐNG

Website Du Lịch Trà Vinh là hệ thống quản lý và giới thiệu du lịch với 3 vai trò chính:
- **Khách (Guest)**: Người dùng chưa đăng nhập
- **User**: Người dùng đã đăng ký tài khoản
- **Admin/Manager**: Quản trị viên hệ thống

---

## 📐 SƠ ĐỒ USE CASE

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    WEBSITE DU LỊCH TRÀ VINH                              │
└─────────────────────────────────────────────────────────────────────────┘

┌──────────────┐                                              ┌──────────────┐
│              │                                              │              │
│   KHÁCH      │◄─────────────────────────────────────────────┤   ADMIN      │
│   (Guest)    │                                              │  (Manager)   │
│              │                                              │              │
└──────┬───────┘                                              └──────┬───────┘
       │                                                             │
       │  ┌──────────────────────────────────────────┐             │
       │  │                                          │             │
       ├──┤ 1. Xem Trang Chủ                        │             │
       │  │                                          │             │
       ├──┤ 2. Xem Địa Điểm Du Lịch                 │             │
       │  │    - Danh sách địa điểm                 │             │
       │  │    - Chi tiết địa điểm                  │             │
       │  │    - Xem bản đồ Google Maps             │             │
       │  │    - Xem đánh giá địa điểm              │             │
       │  │                                          │             │
       ├──┤ 3. Xem Ẩm Thực                          │             │
       │  │    - Danh sách món ăn                   │             │
       │  │    - Chi tiết món ăn                    │             │
       │  │    - Tìm quán ăn theo món               │             │
       │  │                                          │             │
       ├──┤ 4. Xem Dịch Vụ Du Lịch                  │             │
       │  │    - Lập kế hoạch tour                  │             │
       │  │    - Đặt phòng khách sạn                │             │
       │  │    - Thuê xe du lịch                    │             │
       │  │    - Hỗ trợ khách hàng 24/7             │             │
       │  │                                          │             │
       ├──┤ 5. Liên Hệ                              │             │
       │  │    - Gửi form liên hệ                   │             │
       │  │                                          │             │
       ├──┤ 6. Đăng Ký Tài Khoản                    │             │
       │  │                                          │             │
       ├──┤ 7. Đăng Nhập                            │             │
       │  │                                          │             │
       │  └──────────────────────────────────────────┘             │
       │                                                            │
       │                                                            │
┌──────▼───────┐                                                   │
│              │                                                   │
│    USER      │                                                   │
│  (Đã đăng    │                                                   │
│   nhập)      │                                                   │
│              │                                                   │
└──────┬───────┘                                                   │
       │                                                            │
       │  ┌──────────────────────────────────────────┐             │
       │  │                                          │             │
       ├──┤ Tất cả chức năng của KHÁCH              │             │
       │  │                                          │             │
       ├──┤ 8. Đặt Tour Du Lịch                     │             │
       │  │    - Chọn địa điểm                      │             │
       │  │    - Điền thông tin booking             │             │
       │  │    - Xác nhận đặt tour                  │             │
       │  │                                          │             │
       ├──┤ 9. Đặt Dịch Vụ                          │             │
       │  │    - Đặt tour du lịch                   │             │
       │  │    - Đặt phòng khách sạn                │             │
       │  │    - Thuê xe du lịch                    │             │
       │  │    - Yêu cầu hỗ trợ                     │             │
       │  │                                          │             │
       ├──┤ 10. Đánh Giá & Nhận Xét                 │             │
       │  │     - Đánh giá địa điểm (1-5 sao)       │             │
       │  │     - Viết nhận xét                     │             │
       │  │     - Xem đánh giá của người khác       │             │
       │  │                                          │             │
       ├──┤ 11. Xem Lịch Sử Booking                 │             │
       │  │                                          │             │
       ├──┤ 12. Đăng Xuất                           │             │
       │  │                                          │             │
       │  └──────────────────────────────────────────┘             │
       │                                                            │
       │                                                            │
       │                                                            │
       │  ┌──────────────────────────────────────────┐             │
       │  │         CHỨC NĂNG ADMIN/MANAGER          │◄────────────┤
       │  │                                          │             │
       │  │ 13. Quản Lý Tài Khoản                   │             │
       │  │     - Xem danh sách users               │             │
       │  │     - Thêm/Sửa/Xóa users                │             │
       │  │     - Phân quyền (admin/manager/user)   │             │
       │  │     - Kích hoạt/Vô hiệu hóa tài khoản   │             │
       │  │                                          │             │
       │  │ 14. Quản Lý Booking Tour                │             │
       │  │     - Xem tất cả booking                │             │
       │  │     - Duyệt/Từ chối booking             │             │
       │  │     - Cập nhật trạng thái               │             │
       │  │     - Xóa booking                       │             │
       │  │                                          │             │
       │  │ 15. Quản Lý Đặt Dịch Vụ                 │             │
       │  │     - Xem tất cả đặt dịch vụ            │             │
       │  │     - Xác nhận/Hủy đặt dịch vụ          │             │
       │  │     - Cập nhật trạng thái               │             │
       │  │     - Hoàn thành dịch vụ                │             │
       │  │     - Thống kê doanh thu                │             │
       │  │                                          │             │
       │  │ 16. Quản Lý Đánh Giá                    │             │
       │  │     - Xem tất cả đánh giá               │             │
       │  │     - Duyệt/Ẩn đánh giá                 │             │
       │  │     - Xóa đánh giá không phù hợp        │             │
       │  │     - Thống kê đánh giá                 │             │
       │  │                                          │             │
       │  │ 17. Quản Lý Liên Hệ                     │             │
       │  │     - Xem danh sách liên hệ             │             │
       │  │     - Đọc chi tiết tin nhắn             │             │
       │  │     - Xóa tin nhắn                      │             │
       │  │                                          │             │
       │  │ 18. Quản Lý Địa Điểm                    │             │
       │  │     - Thêm/Sửa/Xóa địa điểm             │             │
       │  │     - Cập nhật thông tin chi tiết       │             │
       │  │                                          │             │
       │  │ 19. Quản Lý Ẩm Thực                     │             │
       │  │     - Thêm/Sửa/Xóa món ăn               │             │
       │  │     - Quản lý nhà hàng                  │             │
       │  │                                          │             │
       │  └──────────────────────────────────────────┘             │
       │                                                            │
       └────────────────────────────────────────────────────────────┘
```

---

## 👥 CHI TIẾT CHỨC NĂNG THEO VAI TRÒ

### 🌐 KHÁCH (GUEST) - Chưa đăng nhập

#### 1️⃣ Xem Trang Chủ
- Xem banner giới thiệu Trà Vinh
- Xem địa điểm nổi bật
- Xem thống kê tổng quan
- Truy cập menu điều hướng

#### 2️⃣ Xem Địa Điểm Du Lịch
- **Danh sách địa điểm:**
  - Hiển thị tất cả địa điểm (chùa, bảo tàng, ao, biển...)
  - Lọc theo danh mục
  - Tìm kiếm theo tên
  - Xem hình ảnh và mô tả ngắn

- **Chi tiết địa điểm:**
  - Thông tin đầy đủ (năm xây dựng, văn hóa, lịch sử)
  - Hình ảnh chất lượng cao
  - Giờ mở cửa, giá vé
  - Điểm nổi bật, tiện ích
  - Bản đồ Google Maps tích hợp
  - Chỉ đường từ vị trí hiện tại
  - Nút "Đặt Tour" (yêu cầu đăng nhập)

#### 3️⃣ Xem Ẩm Thực
- **Danh sách món ăn:**
  - 21 món ăn đặc sản Trà Vinh
  - Phân loại: Món chính, Ăn vặt, Bánh ngọt, Đồ uống
  - Hình ảnh món ăn
  - Giá cả, mô tả

- **Chi tiết món ăn:**
  - Thông tin chi tiết món ăn
  - Nguyên liệu, cách chế biến
  - Nút "Tìm Quán" → Danh sách nhà hàng phục vụ món này

- **Tìm quán ăn:**
  - Danh sách nhà hàng theo món ăn
  - Thông tin: địa chỉ, SĐT, giờ mở cửa, đánh giá
  - Chỉ đường Google Maps
  - Gọi điện trực tiếp
  - Chia sẻ thông tin

#### 4️⃣ Xem Dịch Vụ Du Lịch
- **Lập kế hoạch tour:**
  - Xem thông tin gói tour (1 ngày, 2-3 ngày, trọn gói)
  - Xem giá cả và dịch vụ bao gồm
  - Xem tính năng nổi bật

- **Đặt phòng khách sạn:**
  - Xem các loại khách sạn (2-3 sao, 4 sao, 5 sao)
  - So sánh giá và tiện ích
  - Xem hình ảnh và mô tả

- **Thuê xe du lịch:**
  - Xem các loại xe (4-7 chỗ, 16-29 chỗ, 35-45 chỗ)
  - Xem giá thuê theo ngày
  - Thông tin tài xế và dịch vụ

- **Hỗ trợ khách hàng 24/7:**
  - Xem thông tin hỗ trợ
  - Hotline, chat trực tuyến
  - Các gói hỗ trợ (cơ bản, VIP, doanh nghiệp)

#### 5️⃣ Liên Hệ
- Điền form liên hệ (tên, email, SĐT, tin nhắn)
- Gửi câu hỏi, góp ý
- Xem thông tin liên hệ văn phòng

#### 6️⃣ Đăng Ký Tài Khoản
- Tạo tài khoản mới
- Nhập: username, email, password, họ tên, SĐT
- Xác thực thông tin

#### 7️⃣ Đăng Nhập
- Đăng nhập bằng username/email + password
- Ghi nhớ đăng nhập
- Quên mật khẩu

---

### 👤 USER - Người dùng đã đăng nhập

**Có tất cả chức năng của KHÁCH, PLUS:**

#### 8️⃣ Đặt Tour Du Lịch
- Chọn địa điểm muốn tham quan
- Điền thông tin booking:
  - Họ tên
  - Email
  - Số điện thoại
  - Ngày tham quan
  - Số người tham gia
  - Ghi chú đặc biệt
- Xác nhận đặt tour
- Nhận thông báo đặt tour thành công

#### 9️⃣ Đặt Dịch Vụ
- **Đặt tour du lịch:**
  - Chọn gói tour (1 ngày, 2-3 ngày, trọn gói)
  - Điền thông tin khách hàng
  - Số người, số ngày
  - Yêu cầu đặc biệt
  - Gửi yêu cầu đặt dịch vụ

- **Đặt phòng khách sạn:**
  - Chọn loại phòng
  - Chọn ngày nhận/trả phòng
  - Số người ở
  - Gửi yêu cầu đặt phòng

- **Thuê xe du lịch:**
  - Chọn loại xe
  - Chọn ngày thuê
  - Số ngày thuê
  - Lộ trình dự kiến
  - Gửi yêu cầu thuê xe

- **Yêu cầu hỗ trợ:**
  - Mô tả vấn đề cần hỗ trợ
  - Chọn loại hỗ trợ
  - Gửi yêu cầu

#### 🔟 Đánh Giá & Nhận Xét
- **Đánh giá địa điểm:**
  - Chọn số sao (1-5 sao)
  - Viết tiêu đề đánh giá
  - Viết nội dung nhận xét chi tiết
  - Gửi đánh giá

- **Xem đánh giá:**
  - Xem tất cả đánh giá của địa điểm
  - Xem điểm trung bình
  - Lọc theo số sao
  - Sắp xếp theo mới nhất/cũ nhất

- **Quản lý đánh giá của mình:**
  - Xem các đánh giá đã viết
  - Sửa đánh giá
  - Xóa đánh giá

#### 1️⃣1️⃣ Xem Lịch Sử Booking
- Xem các tour đã đặt
- Trạng thái booking (pending/confirmed/cancelled)
- Chi tiết từng booking
- Xem lịch sử đặt dịch vụ

#### 1️⃣2️⃣ Đăng Xuất
- Đăng xuất khỏi hệ thống
- Xóa session
- Chuyển về trang đăng nhập

---

### 👨‍💼 ADMIN/MANAGER - Quản trị viên

**Có tất cả chức năng của USER, PLUS:**

#### 1️⃣3️⃣ Quản Lý Tài Khoản
- **Xem danh sách users:**
  - Hiển thị tất cả tài khoản
  - Thông tin: ID, username, email, họ tên, role, status
  - Lọc theo role (admin/manager/user)
  - Tìm kiếm user

- **Thêm user mới:**
  - Tạo tài khoản thủ công
  - Phân quyền ngay từ đầu

- **Sửa thông tin user:**
  - Cập nhật thông tin cá nhân
  - Thay đổi role
  - Reset mật khẩu

- **Xóa user:**
  - Xóa tài khoản khỏi hệ thống
  - Xác nhận trước khi xóa

- **Kích hoạt/Vô hiệu hóa:**
  - Chuyển status: active ↔ inactive
  - User inactive không thể đăng nhập

#### 1️⃣4️⃣ Quản Lý Booking Tour
- **Xem tất cả booking:**
  - Danh sách booking từ tất cả users
  - Thông tin: ID, tên khách, địa điểm, ngày, số người, trạng thái
  - Lọc theo trạng thái
  - Tìm kiếm booking

- **Duyệt booking:**
  - Xác nhận booking (pending → confirmed)
  - Từ chối booking (pending → cancelled)

- **Cập nhật trạng thái:**
  - Thay đổi trạng thái booking
  - Thêm ghi chú admin

- **Xóa booking:**
  - Xóa booking không hợp lệ
  - Xác nhận trước khi xóa

#### 1️⃣5️⃣ Quản Lý Đặt Dịch Vụ
- **Xem tất cả đặt dịch vụ:**
  - Danh sách tất cả yêu cầu đặt dịch vụ
  - Thông tin: mã đặt, dịch vụ, khách hàng, ngày, số người, giá
  - Lọc theo trạng thái (chờ xác nhận, đã xác nhận, hoàn thành, đã hủy)
  - Lọc theo loại dịch vụ (tour, hotel, car, support)
  - Tìm kiếm theo mã đặt hoặc tên khách

- **Xác nhận đặt dịch vụ:**
  - Xem chi tiết yêu cầu
  - Xác nhận yêu cầu (pending → confirmed)
  - Thêm ghi chú xác nhận

- **Hủy đặt dịch vụ:**
  - Từ chối yêu cầu (pending → cancelled)
  - Ghi rõ lý do hủy

- **Hoàn thành dịch vụ:**
  - Đánh dấu hoàn thành (confirmed → completed)
  - Cập nhật thông tin thanh toán

- **Thống kê:**
  - Tổng số đặt dịch vụ
  - Số lượng theo trạng thái
  - Doanh thu theo loại dịch vụ
  - Biểu đồ thống kê

#### 1️⃣6️⃣ Quản Lý Đánh Giá
- **Xem tất cả đánh giá:**
  - Danh sách đánh giá từ users
  - Thông tin: người đánh giá, địa điểm, số sao, nội dung
  - Lọc theo số sao
  - Lọc theo địa điểm
  - Tìm kiếm theo nội dung

- **Duyệt đánh giá:**
  - Xem chi tiết đánh giá
  - Phê duyệt đánh giá hiển thị công khai
  - Ẩn đánh giá không phù hợp

- **Xóa đánh giá:**
  - Xóa đánh giá vi phạm
  - Xóa spam
  - Xác nhận trước khi xóa

- **Thống kê đánh giá:**
  - Điểm trung bình theo địa điểm
  - Số lượng đánh giá theo thời gian
  - Top địa điểm được đánh giá cao nhất

#### 1️⃣7️⃣ Quản Lý Liên Hệ
- **Xem danh sách liên hệ:**
  - Tất cả tin nhắn từ khách hàng
  - Thông tin: tên, email, SĐT, nội dung, thời gian
  - Đánh dấu đã đọc/chưa đọc

- **Đọc chi tiết:**
  - Xem nội dung đầy đủ
  - Thông tin liên hệ khách hàng

- **Xóa tin nhắn:**
  - Xóa tin nhắn đã xử lý
  - Xác nhận trước khi xóa

#### 1️⃣8️⃣ Quản Lý Địa Điểm
- **Thêm địa điểm mới:**
  - Nhập thông tin đầy đủ
  - Upload hình ảnh
  - Thêm tọa độ GPS

- **Sửa địa điểm:**
  - Cập nhật thông tin
  - Thay đổi hình ảnh
  - Cập nhật giá vé, giờ mở cửa

- **Xóa địa điểm:**
  - Xóa địa điểm không còn hoạt động

#### 1️⃣9️⃣ Quản Lý Ẩm Thực
- **Quản lý món ăn:**
  - Thêm/Sửa/Xóa món ăn
  - Cập nhật giá cả, mô tả
  - Upload hình ảnh món ăn

- **Quản lý nhà hàng:**
  - Thêm/Sửa/Xóa nhà hàng
  - Liên kết nhà hàng với món ăn
  - Cập nhật thông tin liên hệ

---

## 🔐 PHÂN QUYỀN HỆ THỐNG

### Cấp độ truy cập:

| Chức năng | Guest | User | Manager | Admin |
|-----------|-------|------|---------|-------|
| Xem trang chủ | ✅ | ✅ | ✅ | ✅ |
| Xem địa điểm | ✅ | ✅ | ✅ | ✅ |
| Xem ẩm thực | ✅ | ✅ | ✅ | ✅ |
| Xem dịch vụ | ✅ | ✅ | ✅ | ✅ |
| Tìm quán ăn | ✅ | ✅ | ✅ | ✅ |
| Gửi liên hệ | ✅ | ✅ | ✅ | ✅ |
| Đăng ký | ✅ | ❌ | ❌ | ❌ |
| Đăng nhập | ✅ | ❌ | ❌ | ❌ |
| Đặt tour | ❌ | ✅ | ✅ | ✅ |
| Đặt dịch vụ | ❌ | ✅ | ✅ | ✅ |
| Đánh giá địa điểm | ❌ | ✅ | ✅ | ✅ |
| Xem lịch sử booking | ❌ | ✅ | ✅ | ✅ |
| Quản lý users | ❌ | ❌ | ✅ | ✅ |
| Quản lý booking tour | ❌ | ❌ | ✅ | ✅ |
| Quản lý đặt dịch vụ | ❌ | ❌ | ✅ | ✅ |
| Quản lý đánh giá | ❌ | ❌ | ✅ | ✅ |
| Quản lý liên hệ | ❌ | ❌ | ✅ | ✅ |
| Quản lý địa điểm | ❌ | ❌ | ❌ | ✅ |
| Quản lý ẩm thực | ❌ | ❌ | ❌ | ✅ |

---

## 📱 TÍNH NĂNG BỔ SUNG

### 🗺️ Tích hợp Google Maps
- Hiển thị vị trí địa điểm trên bản đồ
- Chỉ đường từ vị trí hiện tại
- Xem trên Google Maps
- Sao chép tọa độ

### 🔍 Tìm kiếm & Lọc
- Tìm kiếm địa điểm theo tên
- Tìm kiếm món ăn
- Tìm kiếm nhà hàng
- Lọc theo danh mục

### 📊 Thống kê
- Số lượng địa điểm
- Số lượng booking
- Số lượng users
- Địa điểm phổ biến

### 📱 Responsive Design
- Tương thích mobile
- Tương thích tablet
- Tương thích desktop
- Menu mobile

### 🔔 Thông báo
- Thông báo đăng nhập thành công
- Thông báo đăng xuất
- Thông báo đặt tour thành công
- Thông báo lỗi

---

## 🎨 GIAO DIỆN NGƯỜI DÙNG

### Trang chủ
- Banner hero với hình ảnh Trà Vinh
- Giới thiệu ngắn gọn
- Địa điểm nổi bật (3 địa điểm)
- Thống kê tổng quan
- Footer với thông tin liên hệ

### Trang danh sách
- Grid layout hiện đại
- Card design đẹp mắt
- Hình ảnh chất lượng cao
- Thông tin rõ ràng
- Nút hành động nổi bật

### Trang chi tiết
- Layout 2 cột (nội dung + sidebar)
- Hình ảnh lớn
- Thông tin chi tiết đầy đủ
- Bản đồ tích hợp
- Nút đặt tour nổi bật

### Trang quản lý (Admin)
- Sidebar menu
- Bảng dữ liệu (table)
- Nút hành động (Sửa/Xóa)
- Form nhập liệu
- Thông báo xác nhận

---

## 🔒 BẢO MẬT

- Mật khẩu được hash bằng bcrypt
- Session management
- CSRF protection
- SQL injection prevention (PDO prepared statements)
- XSS protection (htmlspecialchars)
- Role-based access control

---

## 📈 KẾT LUẬN

Website Du Lịch Trà Vinh là hệ thống hoàn chỉnh với:
- ✅ 3 vai trò người dùng rõ ràng
- ✅ Phân quyền chặt chẽ
- ✅ Giao diện thân thiện
- ✅ Tính năng đầy đủ
- ✅ Bảo mật tốt
- ✅ Responsive design
- ✅ Tích hợp Google Maps
- ✅ Quản lý dễ dàng

Hệ thống phù hợp cho việc quảng bá du lịch Trà Vinh và quản lý tour du lịch hiệu quả.
