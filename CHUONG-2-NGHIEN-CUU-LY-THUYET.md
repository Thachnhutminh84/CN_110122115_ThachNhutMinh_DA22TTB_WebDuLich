# CHƯƠNG 2: NGHIÊN CỨU LÝ THUYẾT

## 2.1 Các Khái Niệm Cơ Bản

### 2.1.1 Hệ Thống Đặt Tour Du Lịch

#### Định Nghĩa
Hệ thống đặt tour du lịch là một ứng dụng web hiện đại cho phép khách hàng tương tác trực tuyến với các dịch vụ du lịch. Hệ thống này tích hợp các tính năng quản lý tour, xử lý booking, và thanh toán trực tuyến.

#### Các Chức Năng Chính
1. **Tìm Kiếm và Xem Thông Tin Tour**
   - Hiển thị danh sách tour với thông tin chi tiết
   - Tìm kiếm theo điểm đến, ngày khởi hành, giá tiền
   - Xem đánh giá và bình luận từ khách hàng khác
   - Xem hình ảnh, video về tour

2. **Đặt Tour**
   - Chọn số lượng người lớn, trẻ em
   - Chọn ngày khởi hành
   - Thêm yêu cầu đặc biệt
   - Xem tổng giá tiền

3. **Thanh Toán Trực Tuyến**
   - Chọn phương thức thanh toán
   - Nhập thông tin thanh toán
   - Xác nhận giao dịch
   - Nhận xác nhận qua email

4. **Quản Lý Booking**
   - Xem lịch sử booking
   - Hủy hoặc sửa booking
   - Tải vé điện tử
   - Theo dõi trạng thái thanh toán

### 2.1.2 Hệ Thống Thanh Toán Trực Tuyến

#### Khái Niệm
Thanh toán trực tuyến là quá trình chuyển tiền từ tài khoản khách hàng đến tài khoản công ty thông qua các cổng thanh toán điện tử.

#### Các Phương Thức Thanh Toán

**1. Thanh Toán VNPay**
- Khách hàng sử dụng thẻ ngân hàng (Visa, Mastercard, JCB)
- Hoặc sử dụng ví điện tử (Momo, ZaloPay)
- Hệ thống VNPay xử lý giao dịch an toàn
- Kết quả thanh toán được gửi về hệ thống qua callback

**2. Chuyển Khoản Ngân Hàng**
- Khách hàng chuyển tiền vào tài khoản công ty
- Nhập thông tin chuyển khoản (số tài khoản, tên chủ tài khoản)
- Hệ thống lưu thông tin xác nhận
- Admin kiểm tra và xác nhận thanh toán

**3. Thanh Toán Tiền Mặt**
- Khách hàng thanh toán khi lên xe
- Hệ thống ghi nhận booking nhưng chưa thanh toán
- Hướng dẫn viên thu tiền trực tiếp

#### Ưu Điểm Của Mỗi Phương Thức
| Phương Thức | Ưu Điểm | Nhược Điểm |
|---|---|---|
| VNPay | Nhanh, an toàn, tự động xác nhận | Phí giao dịch cao |
| Chuyển Khoản | Phí thấp, linh hoạt | Cần xác nhận thủ công |
| Tiền Mặt | Không phí, đơn giản | Rủi ro mất tiền |

### 2.1.3 Quản Lý Dịch Vụ Du Lịch

#### Các Loại Dịch Vụ
1. **Dịch Vụ Vận Chuyển**
   - Xe khách, xe riêng
   - Tàu, máy bay
   - Tàu du lịch

2. **Dịch Vụ Lưu Trú**
   - Khách sạn 3-5 sao
   - Resort, villa
   - Nhà nghỉ

3. **Dịch Vụ Ăn Uống**
   - Bữa sáng, trưa, tối
   - Đồ ăn địa phương
   - Nhà hàng cao cấp

4. **Dịch Vụ Hướng Dẫn**
   - Hướng dẫn viên chuyên nghiệp
   - Hướng dẫn viên ngoại ngữ
   - Tài liệu hướng dẫn

5. **Dịch Vụ Bảo Hiểm**
   - Bảo hiểm du lịch
   - Bảo hiểm y tế
   - Bảo hiểm hành lý

#### Quản Lý Dịch Vụ
- Tạo và cập nhật thông tin dịch vụ
- Quản lý giá dịch vụ
- Theo dõi tình trạng dịch vụ
- Xử lý khiếu nại về dịch vụ

## 2.2 Các Công Nghệ Sử Dụng

### 2.2.1 Frontend (Phía Client)

#### HTML5
- **Mục đích**: Cấu trúc và ngữ nghĩa của trang web
- **Ứng dụng**: 
  - Tạo form đặt tour
  - Hiển thị danh sách tour
  - Cấu trúc trang thanh toán
- **Ưu điểm**: Hỗ trợ các thẻ semantic, tương thích tốt với trình duyệt

#### CSS3
- **Mục đích**: Thiết kế giao diện, bố cục, màu sắc
- **Ứng dụng**:
  - Responsive design (mobile, tablet, desktop)
  - Gradient backgrounds
  - Animation và transition
  - Flexbox và Grid layout
- **Ưu điểm**: Tách biệt nội dung và thiết kế, dễ bảo trì

#### JavaScript (ES6+)
- **Mục đích**: Tương tác người dùng, xử lý sự kiện
- **Ứng dụng**:
  - Validate form trước khi submit
  - Xử lý sự kiện click, change
  - AJAX request để gửi dữ liệu
  - Hiệu ứng UI (show/hide, animation)
- **Ưu điểm**: Chạy trên trình duyệt, không cần reload trang

#### Bootstrap 5
- **Mục đích**: Framework CSS giúp phát triển nhanh
- **Ứng dụng**:
  - Grid system (12 cột)
  - Pre-built components (button, card, modal)
  - Responsive utilities
  - Theme customization
- **Ưu điểm**: Tiết kiệm thời gian, consistent design

#### Font Awesome
- **Mục đích**: Thư viện icon
- **Ứng dụng**:
  - Icon cho nút bấm
  - Icon cho form fields
  - Icon cho status
- **Ưu điểm**: Nhiều icon, dễ sử dụng, scalable

### 2.2.2 Backend (Phía Server)

#### PHP 7.4+
- **Mục đích**: Xử lý logic server, tương tác database
- **Ứng dụng**:
  - Xử lý form submission
  - Validate dữ liệu
  - Tạo booking record
  - Gửi email xác nhận
- **Ưu điểm**: 
  - Dễ học, cú pháp đơn giản
  - Hỗ trợ tốt cho web development
  - Hiệu suất cao

#### MySQL 5.7+
- **Mục đích**: Lưu trữ dữ liệu
- **Ứng dụng**:
  - Lưu thông tin tour
  - Lưu booking
  - Lưu thông tin thanh toán
  - Lưu user account
- **Ưu điểm**:
  - Miễn phí, open source
  - Ổn định, đáng tin cậy
  - Hỗ trợ transaction

#### PDO (PHP Data Objects)
- **Mục đích**: Kết nối database an toàn
- **Ứng dụng**:
  - Prepared statements (tránh SQL injection)
  - Hỗ trợ nhiều database
  - Error handling
- **Ưu điểm**:
  - Bảo mật cao
  - Dễ sử dụng
  - Consistent API

### 2.2.3 API và Thư Viện

#### VNPay API
- **Mục đích**: Xử lý thanh toán trực tuyến
- **Quy trình**:
  1. Tạo URL thanh toán
  2. Chuyển hướng khách hàng đến VNPay
  3. Khách hàng nhập thông tin thẻ
  4. VNPay xử lý giao dịch
  5. Gửi callback về hệ thống
  6. Cập nhật trạng thái booking
- **Ưu điểm**: An toàn, hỗ trợ nhiều phương thức

#### AJAX (Asynchronous JavaScript and XML)
- **Mục đích**: Gửi dữ liệu không reload trang
- **Ứng dụng**:
  - Submit form thanh toán
  - Validate form real-time
  - Load dữ liệu động
- **Ưu điểm**: Trải nghiệm người dùng tốt hơn

#### cURL
- **Mục đض**: Gửi HTTP request từ server
- **Ứng dụng**:
  - Gọi VNPay API
  - Gửi email qua SMTP
  - Tích hợp API bên thứ ba
- **Ưu điểm**: Linh hoạt, hỗ trợ nhiều protocol

## 2.3 Kiến Trúc Hệ Thống

### 2.3.1 Mô Hình MVC (Model-View-Controller)

#### Khái Niệm
MVC là một mô hình kiến trúc phần mềm chia ứng dụng thành 3 thành phần chính:

#### Model (Mô Hình Dữ Liệu)
- **Chức năng**: Quản lý dữ liệu và logic nghiệp vụ
- **Ứng dụng**:
  - Lớp Database: Kết nối, query database
  - Lớp Model: Đại diện cho các entity (Tour, Booking, User)
  - Lớp Service: Xử lý logic nghiệp vụ
- **Ví dụ**:
  ```php
  class Tour {
      public function getTourById($id) { ... }
      public function getAllTours() { ... }
      public function createTour($data) { ... }
  }
  ```

#### View (Giao Diện)
- **Chức năng**: Hiển thị dữ liệu cho người dùng
- **Ứng dụng**:
  - HTML template
  - CSS styling
  - JavaScript interaction
- **Ví dụ**:
  - dat-tour.php: Form đặt tour
  - payment-tour-method.php: Chọn phương thức thanh toán
  - danh-sach-tour.php: Danh sách tour

#### Controller (Bộ Điều Khiển)
- **Chức năng**: Xử lý request, gọi Model, trả về View
- **Ứng dụng**:
  - Nhận request từ người dùng
  - Validate dữ liệu
  - Gọi Model để xử lý
  - Trả về View với dữ liệu
- **Ví dụ**:
  ```php
  // process-booking.php
  $booking_code = 'TOUR' . date('YmdHis');
  $stmt = $db->prepare("INSERT INTO tour_bookings ...");
  header('Location: payment-tour-method.php?booking_id=' . $booking_code);
  ```

#### Lợi Ích Của MVC
- Tách biệt logic, dễ bảo trì
- Dễ test từng thành phần
- Tái sử dụng code
- Phát triển song song

### 2.3.2 Cấu Trúc Thư Mục Chi Tiết

```
project/
├── api/                          # API endpoints
│   ├── bookings.php             # API quản lý booking
│   ├── tours.php                # API quản lý tour
│   ├── payments.php             # API quản lý thanh toán
│   └── process-payment.php      # Xử lý thanh toán
│
├── models/                       # Model classes
│   ├── Database.php             # Kết nối database
│   ├── Tour.php                 # Model Tour
│   ├── Booking.php              # Model Booking
│   └── User.php                 # Model User
│
├── config/                       # Cấu hình
│   ├── database.php             # Cấu hình database
│   ├── vnpay.php                # Cấu hình VNPay
│   └── oauth.php                # Cấu hình OAuth
│
├── database/                     # SQL files
│   ├── create-tour-bookings.sql # Tạo bảng tour_bookings
│   ├── create-payment-confirmations.sql
│   └── insert-tours-data.sql    # Dữ liệu mẫu
│
├── css/                          # Stylesheet
│   ├── styles.css               # CSS chính
│   ├── responsive.css           # CSS responsive
│   └── booking-system-new.css   # CSS booking
│
├── js/                           # JavaScript
│   ├── main.js                  # JS chính
│   ├── service-modal.js         # Modal service
│   └── google-maps.js           # Google Maps
│
├── components/                   # Reusable components
│   ├── header.php               # Header
│   ├── footer.php               # Footer
│   ├── navigation.php           # Navigation
│   └── service-modals.php       # Service modals
│
├── includes/                     # Include files
│   ├── check-auth.php           # Kiểm tra auth
│   └── mobile-menu.php          # Mobile menu
│
├── dat-tour.php                 # Trang đặt tour
├── payment-tour-method.php      # Chọn phương thức thanh toán
├── payment-tour-form.php        # Form thanh toán
├── process-booking.php          # Xử lý booking
└── index.php                    # Trang chủ
```

#### Giải Thích Các Thư Mục
- **api/**: Chứa các endpoint API để xử lý request từ frontend
- **models/**: Chứa các lớp Model để tương tác với database
- **config/**: Chứa các file cấu hình (database, API keys, etc.)
- **database/**: Chứa các file SQL để tạo bảng, insert dữ liệu
- **css/**: Chứa các file CSS cho styling
- **js/**: Chứa các file JavaScript cho tương tác
- **components/**: Chứa các component tái sử dụng (header, footer, etc.)
- **includes/**: Chứa các file include (auth check, menu, etc.)

## 2.4 Cơ Sở Dữ Liệu

### 2.4.1 Bảng Chính
- tour_bookings: Lưu thông tin đặt tour
- payment_confirmations: Lưu xác nhận thanh toán
- service_bookings: Lưu thông tin đặt dịch vụ
- tours: Thông tin tour
- users: Thông tin người dùng

### 2.4.2 Quan Hệ Giữa Các Bảng
- tour_bookings → payment_confirmations (1:N)
- users → tour_bookings (1:N)
- tours → tour_bookings (1:N)

## 2.5 Quy Trình Đặt Tour

### 2.5.1 Các Bước Chính
1. Người dùng điền form đặt tour
2. Hệ thống tạo booking record
3. Chuyển hướng đến trang chọn phương thức thanh toán
4. Người dùng chọn phương thức (VNPay/Chuyển khoản)
5. Nhập thông tin thanh toán
6. Xác nhận và lưu vào database
7. Hiển thị thông báo thành công

### 2.5.2 Luồng Dữ Liệu
```
Form Input → Validation → Database Insert → Payment Selection → 
Payment Form → Confirmation → Success Page
```

## 2.6 Bảo Mật

### 2.6.1 Các Biện Pháp Bảo Mật
- Sử dụng PDO prepared statements để tránh SQL injection
- Validate input từ người dùng
- Mã hóa dữ liệu nhạy cảm
- Sử dụng HTTPS cho thanh toán

### 2.6.2 Xác Thực và Phân Quyền
- Kiểm tra session người dùng
- Phân quyền admin/user
- Kiểm tra quyền trước khi thực hiện hành động

## 2.7 Giao Diện Người Dùng

### 2.7.1 Nguyên Tắc Thiết Kế
- Responsive design (mobile-friendly)
- Giao diện trực quan, dễ sử dụng
- Tối ưu hóa tốc độ tải
- Consistent styling

### 2.7.2 Các Trang Chính
- Trang chủ: Hiển thị danh sách tour
- Trang đặt tour: Form đặt tour
- Trang thanh toán: Chọn phương thức thanh toán
- Trang xác nhận: Hiển thị kết quả

## 2.8 Các Tính Năng Nâng Cao

### 2.8.1 Tính Năng Hiện Tại
- Đặt tour với nhiều người
- Chọn phương thức thanh toán
- Xác nhận thanh toán chuyển khoản
- Quản lý booking

### 2.8.2 Tính Năng Có Thể Mở Rộng
- Hệ thống đánh giá và bình luận
- Gợi ý tour dựa trên lịch sử
- Chương trình khuyến mãi
- Tích hợp email notification
- Hệ thống affiliate

## 2.9 Kết Luận Chương
Chương này đã trình bày các khái niệm cơ bản, công nghệ sử dụng, kiến trúc hệ thống và quy trình hoạt động của hệ thống đặt tour du lịch. Những kiến thức này sẽ là nền tảng cho việc phát triển và cải tiến hệ thống trong các chương tiếp theo.


## 2.4 Cơ Sở Dữ Liệu Chi Tiết

### 2.4.1 Bảng Chính

#### Bảng tour_bookings (Đặt Tour)
```sql
CREATE TABLE tour_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(50) UNIQUE NOT NULL,
    departure_date DATE NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    num_adults INT NOT NULL DEFAULT 1,
    num_children INT DEFAULT 0,
    total_price DECIMAL(15, 2) NOT NULL,
    booking_status ENUM('pending', 'confirmed', 'completed', 'cancelled'),
    payment_status ENUM('pending', 'paid', 'failed', 'refunded'),
    special_requests TEXT,
    payment_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Giải thích các cột:**
- `booking_code`: Mã booking duy nhất (VD: TOUR20240115123456789)
- `departure_date`: Ngày khởi hành
- `customer_name`: Tên khách hàng
- `num_adults`: Số người lớn
- `num_children`: Số trẻ em
- `total_price`: Tổng giá tiền
- `booking_status`: Trạng thái booking (pending/confirmed/completed/cancelled)
- `payment_status`: Trạng thái thanh toán (pending/paid/failed/refunded)

#### Bảng payment_confirmations (Xác Nhận Thanh Toán)
```sql
CREATE TABLE payment_confirmations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(50) NOT NULL,
    bank_name VARCHAR(100),
    account_number VARCHAR(50),
    account_name VARCHAR(100),
    amount DECIMAL(15, 2),
    status ENUM('pending', 'confirmed', 'rejected'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Giải thích các cột:**
- `booking_code`: Liên kết đến booking
- `bank_name`: Tên ngân hàng (Vietcombank, VietinBank, etc.)
- `account_number`: Số tài khoản chuyển khoản
- `account_name`: Tên chủ tài khoản
- `amount`: Số tiền chuyển khoản
- `status`: Trạng thái xác nhận (pending/confirmed/rejected)

#### Bảng tours (Thông Tin Tour)
```sql
CREATE TABLE tours (
    tour_id INT AUTO_INCREMENT PRIMARY KEY,
    tour_name VARCHAR(255) NOT NULL,
    description TEXT,
    destination VARCHAR(255),
    duration INT,
    price_per_adult DECIMAL(15, 2),
    price_per_child DECIMAL(15, 2),
    max_participants INT,
    guide_name VARCHAR(100),
    status ENUM('active', 'inactive', 'cancelled'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Bảng users (Thông Tin Người Dùng)
```sql
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    role ENUM('user', 'admin', 'guide'),
    status ENUM('active', 'inactive'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 2.4.2 Quan Hệ Giữa Các Bảng

#### Sơ Đồ ER (Entity-Relationship)
```
users (1) ──── (N) tour_bookings
                    │
                    └──── (1) payment_confirmations

tours (1) ──── (N) tour_bookings
```

#### Giải Thích Quan Hệ
- **users → tour_bookings**: Một người dùng có thể có nhiều booking
- **tour_bookings → payment_confirmations**: Một booking có thể có nhiều xác nhận thanh toán
- **tours → tour_bookings**: Một tour có thể có nhiều booking

### 2.4.3 Ràng Buộc Dữ Liệu

#### Primary Key (Khóa Chính)
- Mỗi bảng có một primary key duy nhất
- Đảm bảo không có bản ghi trùng lặp

#### Unique Constraint (Ràng Buộc Duy Nhất)
- `booking_code` phải duy nhất
- `username` phải duy nhất
- `email` phải duy nhất

#### NOT NULL Constraint
- Các trường bắt buộc phải có giá trị
- VD: `customer_name`, `customer_email`, `total_price`

#### ENUM Constraint
- Giới hạn giá trị cho các trường status
- VD: `booking_status` chỉ có thể là 'pending', 'confirmed', 'completed', 'cancelled'

#### TIMESTAMP
- Tự động ghi lại thời gian tạo/cập nhật
- Hữu ích cho audit trail

## 2.5 Quy Trình Đặt Tour Chi Tiết

### 2.5.1 Các Bước Chính

#### Bước 1: Người Dùng Điền Form Đặt Tour
- Truy cập trang `dat-tour.php`
- Điền thông tin:
  - Họ tên
  - Số điện thoại
  - Email
  - Số người lớn, trẻ em
  - Ngày khởi hành
  - Yêu cầu đặc biệt
- Click nút "Đặt Tour Ngay"

#### Bước 2: Hệ Thống Xử Lý Booking
- File `process-booking.php` nhận request
- Validate dữ liệu:
  - Kiểm tra các trường bắt buộc
  - Kiểm tra định dạng email
  - Kiểm tra ngày khởi hành >= ngày hôm nay
- Tính toán tổng giá tiền:
  - `total_price = (num_adults * 500000) + (num_children * 300000)`
- Tạo mã booking:
  - `booking_code = 'TOUR' + timestamp + random(100-999)`
- Insert vào bảng `tour_bookings`
- Chuyển hướng đến `payment-tour-method.php?booking_id=TOUR...`

#### Bước 3: Chọn Phương Thức Thanh Toán
- Hiển thị trang `payment-tour-method.php`
- Hiển thị thông tin booking:
  - Mã booking
  - Ngày khởi hành
  - Số người
  - Tổng tiền
- Người dùng chọn:
  - VNPay (thanh toán qua thẻ)
  - Chuyển khoản (thanh toán qua ngân hàng)
- Submit form đến `payment-tour-form.php`

#### Bước 4: Nhập Thông Tin Thanh Toán
- Hiển thị form `payment-tour-form.php`
- Nếu chọn VNPay:
  - Chuyển hướng đến cổng VNPay
  - Khách hàng nhập thông tin thẻ
  - VNPay xử lý giao dịch
  - Callback về hệ thống
- Nếu chọn Chuyển Khoản:
  - Nhập thông tin tài khoản:
    - Chọn ngân hàng
    - Số tài khoản
    - Tên chủ tài khoản
    - Số tiền
  - Nhập thông tin người thanh toán:
    - Họ tên
    - Email
    - Số điện thoại
  - Submit form

#### Bước 5: Xác Nhận Thanh Toán
- Hệ thống lưu thông tin vào `payment_confirmations`
- Hiển thị thông báo thành công
- Gửi email xác nhận đến khách hàng
- Admin kiểm tra và xác nhận thanh toán

#### Bước 6: Cập Nhật Trạng Thái
- Cập nhật `payment_status` = 'paid'
- Cập nhật `booking_status` = 'confirmed'
- Gửi email xác nhận cuối cùng
- Khách hàng có thể xem vé điện tử

### 2.5.2 Luồng Dữ Liệu Chi Tiết

```
┌─────────────────────────────────────────────────────────────┐
│ 1. Người dùng truy cập dat-tour.php                         │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│ 2. Điền form: tên, email, số người, ngày khởi hành         │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│ 3. Submit form → process-booking.php                        │
│    - Validate dữ liệu                                       │
│    - Tính tổng giá tiền                                     │
│    - Tạo booking_code                                       │
│    - Insert vào tour_bookings                               │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│ 4. Redirect → payment-tour-method.php?booking_id=TOUR...    │
│    - Hiển thị thông tin booking                             │
│    - Chọn phương thức thanh toán                            │
└────────────────────┬────────────────────────────────────────┘
                     │
        ┌────────────┴────────────┐
        │                         │
        ▼                         ▼
   ┌─────────────┐          ┌──────────────┐
   │ VNPay       │          │ Chuyển Khoản │
   └──────┬──────┘          └──────┬───────┘
          │                        │
          ▼                        ▼
   ┌─────────────────┐    ┌──────────────────┐
   │ Redirect VNPay  │    │ Form chuyển khoản│
   │ Nhập thẻ        │    │ Nhập tài khoản   │
   │ Xử lý giao dịch │    │ Nhập thông tin   │
   └──────┬──────────┘    └──────┬───────────┘
          │                      │
          ▼                      ▼
   ┌─────────────────┐    ┌──────────────────┐
   │ Callback VNPay  │    │ Insert vào       │
   │ Cập nhật status │    │ payment_confirm  │
   └──────┬──────────┘    └──────┬───────────┘
          │                      │
          └──────────┬───────────┘
                     │
                     ▼
        ┌────────────────────────────┐
        │ Hiển thị thông báo thành   │
        │ công                       │
        │ Gửi email xác nhận         │
        └────────────────────────────┘
```

## 2.6 Bảo Mật Chi Tiết

### 2.6.1 Các Biện Pháp Bảo Mật

#### SQL Injection Prevention
- **Vấn đề**: Attacker có thể chèn code SQL vào input
- **Giải pháp**: Sử dụng Prepared Statements
```php
// ❌ Không an toàn
$query = "SELECT * FROM users WHERE email = '" . $_POST['email'] . "'";

// ✅ An toàn
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_POST['email']]);
```

#### Input Validation
- Kiểm tra loại dữ liệu (string, int, email)
- Kiểm tra độ dài dữ liệu
- Kiểm tra định dạng (email, phone, date)
```php
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    throw new Exception('Email không hợp lệ');
}
```

#### Output Encoding
- Mã hóa dữ liệu khi hiển thị
- Tránh XSS (Cross-Site Scripting)
```php
// ❌ Không an toàn
echo "Xin chào " . $_GET['name'];

// ✅ An toàn
echo "Xin chào " . htmlspecialchars($_GET['name']);
```

#### HTTPS
- Mã hóa dữ liệu truyền trên mạng
- Bắt buộc cho trang thanh toán
- Cấp chứng chỉ SSL/TLS

#### Password Hashing
- Không lưu password dạng plain text
- Sử dụng bcrypt hoặc Argon2
```php
$hashed = password_hash($password, PASSWORD_BCRYPT);
if (password_verify($input_password, $hashed)) {
    // Password đúng
}
```

#### CSRF Protection
- Sử dụng token CSRF
- Kiểm tra token trước khi xử lý form
```php
// Tạo token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Kiểm tra token
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    throw new Exception('CSRF token không hợp lệ');
}
```

### 2.6.2 Xác Thực và Phân Quyền

#### Session Management
- Tạo session khi người dùng đăng nhập
- Lưu user_id trong session
- Kiểm tra session trước khi truy cập trang
```php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: dang-nhap.php');
    exit;
}
```

#### Role-Based Access Control (RBAC)
- Phân quyền dựa trên role (user, admin, guide)
- Kiểm tra quyền trước khi thực hiện hành động
```php
if ($_SESSION['role'] !== 'admin') {
    die('Bạn không có quyền truy cập');
}
```

#### Audit Trail
- Ghi lại các hành động quan trọng
- Lưu user_id, timestamp, action
- Hữu ích cho debugging và security

## 2.7 Giao Diện Người Dùng Chi Tiết

### 2.7.1 Nguyên Tắc Thiết Kế

#### Responsive Design
- Mobile-first approach
- Breakpoints: 320px, 768px, 1024px, 1440px
- Flexible layout (Flexbox, Grid)
- Scalable images

#### User Experience (UX)
- Giao diện trực quan, dễ hiểu
- Feedback rõ ràng (loading, success, error)
- Minimize clicks (3-click rule)
- Consistent navigation

#### Performance
- Tối ưu hóa hình ảnh
- Minify CSS/JS
- Lazy loading
- Caching

#### Accessibility
- WCAG 2.1 compliance
- Semantic HTML
- Alt text cho hình ảnh
- Keyboard navigation

### 2.7.2 Các Trang Chính

#### Trang Chủ (index.php)
- Hiển thị danh sách tour nổi bật
- Search bar
- Filter options
- Tour cards với hình ảnh, giá, rating

#### Trang Đặt Tour (dat-tour.php)
- Form với các trường:
  - Họ tên (required)
  - Email (required)
  - Số điện thoại (required)
  - Số người lớn (required)
  - Số trẻ em (optional)
  - Ngày khởi hành (required)
  - Yêu cầu đặc biệt (optional)
- Validation real-time
- Submit button

#### Trang Chọn Phương Thức Thanh Toán (payment-tour-method.php)
- Hiển thị thông tin booking
- 2 option: VNPay, Chuyển khoản
- Mô tả từng phương thức
- Continue button

#### Trang Form Thanh Toán (payment-tour-form.php)
- Hiển thị tổng tiền
- Form nhập thông tin:
  - Chọn ngân hàng
  - Số tài khoản
  - Tên chủ tài khoản
  - Số tiền
  - Họ tên người thanh toán
  - Email
  - Số điện thoại
- Submit button
- Success message

## 2.8 Các Tính Năng Nâng Cao

### 2.8.1 Tính Năng Hiện Tại
- ✅ Đặt tour với nhiều người
- ✅ Chọn phương thức thanh toán
- ✅ Xác nhận thanh toán chuyển khoản
- ✅ Quản lý booking
- ✅ Gửi email xác nhận

### 2.8.2 Tính Năng Có Thể Mở Rộng

#### Hệ Thống Đánh Giá
- Cho phép khách hàng đánh giá tour
- Hiển thị rating trung bình
- Hiển thị bình luận

#### Gợi Ý Tour
- Dựa trên lịch sử booking
- Dựa trên tour tương tự
- Machine learning recommendation

#### Chương Trình Khuyến Mãi
- Mã giảm giá
- Khuyến mãi theo mùa
- Loyalty program

#### Email Notification
- Xác nhận booking
- Nhắc nhở trước ngày khởi hành
- Cảm ơn sau tour
- Khảo sát hài lòng

#### Hệ Thống Affiliate
- Cho phép đối tác quảng bá
- Tính hoa hồng
- Dashboard affiliate

#### Mobile App
- Native iOS/Android app
- Push notification
- Offline booking

## 2.9 Ánh Xạ Chức Năng - File

### 2.9.1 Chức Năng Đặt Tour

#### Trang Chủ - Danh Sách Tour
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Hiển thị danh sách tour | `danh-sach-tour.php` | `api/tours.php` | Lấy dữ liệu tour từ database |
| Tìm kiếm tour | `danh-sach-tour.php` | `js/search-attractions.js` | JavaScript xử lý tìm kiếm |
| Lọc tour | `danh-sach-tour.php` | `css/styles.css` | CSS styling cho filter |
| Xem chi tiết tour | `chi-tiet-tour.php` | `models/Tour.php` | Model lấy thông tin tour |

#### Form Đặt Tour
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Hiển thị form đặt tour | `dat-tour.php` | `css/booking-system-new.css` | CSS cho form |
| Validate form | `dat-tour.php` | `js/service-modal.js` | JavaScript validate |
| Submit form | `dat-tour.php` | `process-booking.php` | Xử lý form submission |
| Tạo booking | `process-booking.php` | `models/Booking.php` | Model tạo booking |
| Lưu vào database | `process-booking.php` | `database/create-tour-bookings.sql` | Bảng tour_bookings |

### 2.9.2 Chức Năng Thanh Toán

#### Chọn Phương Thức Thanh Toán
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Hiển thị trang chọn | `payment-tour-method.php` | `css/styles.css` | CSS styling |
| Lấy thông tin booking | `payment-tour-method.php` | `models/Booking.php` | Query booking từ DB |
| Chọn VNPay | `payment-tour-method.php` | `config/vnpay.php` | Cấu hình VNPay |
| Chọn Chuyển Khoản | `payment-tour-method.php` | `payment-tour-form.php` | Chuyển đến form |

#### Form Thanh Toán Chuyển Khoản
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Hiển thị form | `payment-tour-form.php` | `css/styles.css` | CSS styling |
| Validate form | `payment-tour-form.php` | `js/service-modal.js` | JavaScript validate |
| Submit AJAX | `payment-tour-form.php` | `js/service-modal.js` | AJAX request |
| Lưu xác nhận | `payment-tour-form.php` | `database/create-payment-confirmations.sql` | Bảng payment_confirmations |
| Hiển thị success | `payment-tour-form.php` | `css/styles.css` | CSS success message |

#### Thanh Toán VNPay
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Tạo URL VNPay | `payment-vnpay.php` | `config/vnpay.php` | Cấu hình VNPay |
| Redirect VNPay | `payment-vnpay.php` | - | Chuyển hướng đến VNPay |
| Callback VNPay | `payment-return.php` | `api/update-payment-status.php` | Cập nhật trạng thái |
| Xác nhận thanh toán | `payment-return.php` | `models/Booking.php` | Update booking status |

### 2.9.3 Chức Năng Quản Lý (Admin)

#### Quản Lý Booking
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Danh sách booking | `quan-ly-booking.php` | `api/bookings.php` | API lấy booking |
| Xem chi tiết booking | `quan-ly-booking.php` | `models/Booking.php` | Model Booking |
| Sửa booking | `quan-ly-booking.php` | `api/bookings.php` | API update booking |
| Xóa booking | `quan-ly-booking.php` | `api/delete-payment.php` | API delete |
| Export booking | `quan-ly-booking.php` | `api/bookings.php` | Export to CSV/PDF |

#### Quản Lý Thanh Toán
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Danh sách thanh toán | `quan-ly-thanh-toan.php` | `api/payments.php` | API lấy payment |
| Xác nhận thanh toán | `quan-ly-thanh-toan.php` | `api/update-payment-status.php` | API update status |
| Xem chi tiết thanh toán | `quan-ly-thanh-toan.php` | `models/Booking.php` | Model Booking |
| Xác nhận chuyển khoản | `quan-ly-thanh-toan-dich-vu.php` | `chi-tiet-chuyen-khoan.php` | Chi tiết chuyển khoản |

#### Quản Lý Tour
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Danh sách tour | `quan-ly-tour.php` | `api/tours.php` | API lấy tour |
| Tạo tour | `quan-ly-tour.php` | `api/tours.php` | API create tour |
| Sửa tour | `quan-ly-tour.php` | `api/tours.php` | API update tour |
| Xóa tour | `quan-ly-tour.php` | `api/tours.php` | API delete tour |

#### Quản Lý Dịch Vụ
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Danh sách dịch vụ | `quan-ly-dich-vu.php` | `api/service-bookings.php` | API lấy service |
| Tạo dịch vụ | `dat-dich-vu.php` | `api/create-service-booking.php` | API create service |
| Sửa dịch vụ | `quan-ly-dich-vu.php` | `api/service-bookings.php` | API update service |
| Xóa dịch vụ | `quan-ly-dich-vu.php` | `api/service-bookings.php` | API delete service |

### 2.9.4 Chức Năng Người Dùng

#### Đăng Nhập / Đăng Ký
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Trang đăng nhập | `dang-nhap.php` | `css/styles.css` | CSS form |
| Xác thực đăng nhập | `dang-nhap.php` | `api/auth.php` | API auth |
| Trang đăng ký | `register.php` | `css/styles.css` | CSS form |
| Tạo tài khoản | `register.php` | `api/auth.php` | API create user |
| OAuth Google | `auth/google-callback.php` | `config/oauth.php` | Cấu hình OAuth |

#### Hồ Sơ Người Dùng
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Xem hồ sơ | `profile.php` | `models/User.php` | Model User |
| Sửa hồ sơ | `profile.php` | `api/users.php` | API update user |
| Xem lịch sử booking | `profile.php` | `api/bookings.php` | API lấy booking |
| Xem dashboard | `dashboard.php` | `api/bookings.php` | API dashboard data |

#### Đánh Giá & Bình Luận
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Hiển thị đánh giá | `chi-tiet-tour.php` | `components/review-section.php` | Component review |
| Thêm đánh giá | `chi-tiet-tour.php` | `api/reviews.php` | API create review |
| Xem bình luận | `chi-tiet-tour.php` | `js/reviews.js` | JavaScript review |

### 2.9.5 Chức Năng Khác

#### Liên Hệ
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Form liên hệ | `lien-he.php` | `css/styles.css` | CSS form |
| Submit liên hệ | `lien-he.php` | `api/contact.php` | API contact |
| Quản lý liên hệ | `quan-ly-lien-he.php` | `api/contact.php` | API manage contact |

#### Tìm Kiếm
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Tìm kiếm tour | `danh-sach-tour.php` | `js/search-attractions.js` | JavaScript search |
| Tìm kiếm nhà hàng | `tim-quan-an.php` | `js/restaurant-finder.js` | JavaScript search |
| Tìm kiếm địa điểm | `dia-diem-du-lich-dynamic.php` | `js/google-maps.js` | Google Maps |

#### Giao Diện
| Chức Năng | File Chính | File Hỗ Trợ | Mô Tả |
|---|---|---|---|
| Header | `includes/navigation.php` | `css/styles.css` | Navigation bar |
| Footer | `components/footer.php` | `css/styles.css` | Footer |
| Mobile menu | `includes/mobile-menu.php` | `js/mobile-menu.js` | Mobile navigation |
| Responsive | Tất cả | `css/responsive.css` | Responsive design |

### 2.9.6 Cơ Sở Dữ Liệu

#### Bảng Chính
| Bảng | File SQL | Mô Tả |
|---|---|---|
| tour_bookings | `database/create-tour-bookings.sql` | Lưu booking tour |
| payment_confirmations | `database/create-payment-confirmations.sql` | Lưu xác nhận thanh toán |
| service_bookings | `database/create-service-bookings.sql` | Lưu booking dịch vụ |
| tours | `database/create-tours-table.sql` | Lưu thông tin tour |
| users | `database/create_users_simple.sql` | Lưu thông tin user |
| reviews | `database/create-reviews-system.sql` | Lưu đánh giá |

#### Dữ Liệu Mẫu
| File | Mô Tả |
|---|---|
| `database/insert-tours-data.sql` | Insert dữ liệu tour |
| `database/insert_foods_data.sql` | Insert dữ liệu thực phẩm |
| `database/insert-service-bookings-complete.sql` | Insert booking dịch vụ |
| `database/du-lieu-dat-tour-mau.sql` | Dữ liệu mẫu tour |

### 2.9.7 Cấu Hình

| File | Mô Tả |
|---|---|
| `config/database.php` | Cấu hình kết nối database |
| `config/vnpay.php` | Cấu hình VNPay |
| `config/oauth.php` | Cấu hình OAuth Google |

### 2.9.8 Model Classes

| File | Chức Năng |
|---|---|
| `models/Database.php` | Kết nối database |
| `models/Tour.php` | Model Tour |
| `models/Booking.php` | Model Booking |
| `models/User.php` | Model User |
| `models/Review.php` | Model Review |
| `models/Restaurant.php` | Model Restaurant |
| `models/Attraction.php` | Model Attraction |
| `models/Food.php` | Model Food |
| `models/Contact.php` | Model Contact |

### 2.9.9 CSS Files

| File | Chức Năng |
|---|---|
| `css/styles.css` | CSS chính |
| `css/responsive.css` | CSS responsive |
| `css/booking-system-new.css` | CSS booking system |
| `css/bootstrap-custom.css` | Bootstrap custom |
| `css/attractions-redesign.css` | CSS attractions |
| `css/admin-responsive.css` | CSS admin responsive |
| `css/mobile-enhancements.css` | CSS mobile |
| `css/header-responsive-fix.css` | CSS header responsive |
| `css/food-search.css` | CSS food search |

### 2.9.10 JavaScript Files

| File | Chức Năng |
|---|---|
| `js/service-modal.js` | Modal service |
| `js/reviews.js` | Xử lý review |
| `js/restaurant-finder.js` | Tìm kiếm nhà hàng |
| `js/search-attractions.js` | Tìm kiếm địa điểm |
| `js/google-maps.js` | Google Maps |
| `js/mobile-menu.js` | Mobile menu |

### 2.9.11 API Endpoints

| Endpoint | File | Chức Năng |
|---|---|---|
| `/api/tours.php` | `api/tours.php` | Quản lý tour |
| `/api/bookings.php` | `api/bookings.php` | Quản lý booking |
| `/api/payments.php` | `api/payments.php` | Quản lý thanh toán |
| `/api/reviews.php` | `api/reviews.php` | Quản lý review |
| `/api/users.php` | `api/users.php` | Quản lý user |
| `/api/auth.php` | `api/auth.php` | Xác thực |
| `/api/contact.php` | `api/contact.php` | Quản lý liên hệ |
| `/api/service-bookings.php` | `api/service-bookings.php` | Quản lý service booking |
| `/api/process-payment.php` | `api/process-payment.php` | Xử lý thanh toán |
| `/api/update-payment-status.php` | `api/update-payment-status.php` | Cập nhật trạng thái thanh toán |

## 2.10 Kết Luận Chương

Chương 2 đã trình bày chi tiết về:
- Các khái niệm cơ bản của hệ thống đặt tour
- Công nghệ sử dụng (Frontend, Backend, API)
- Kiến trúc MVC và cấu trúc thư mục
- Cơ sở dữ liệu và quan hệ giữa các bảng
- Quy trình đặt tour từ A đến Z
- Các biện pháp bảo mật
- Nguyên tắc thiết kế giao diện
- Các tính năng nâng cao

Những kiến thức này sẽ là nền tảng vững chắc cho việc phát triển, triển khai và bảo trì hệ thống trong các chương tiếp theo.
