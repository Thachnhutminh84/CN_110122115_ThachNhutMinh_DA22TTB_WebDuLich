# CHƯƠNG 3: HIỆN THỰC HÓA NGHIÊN CỨU

## 3.1 Phân Tích Yêu Cầu Chi Tiết

### 3.1.1 Yêu Cầu Chức Năng (Functional Requirements)

#### Yêu Cầu Đặt Tour

**1. Tìm Kiếm Tour**

Người dùng cần có khả năng tìm kiếm tour du lịch theo nhiều tiêu chí khác nhau để dễ dàng tìm được tour phù hợp với nhu cầu của mình. Các tiêu chí tìm kiếm bao gồm:

- **Theo Điểm Đến**: Người dùng có thể nhập tên địa điểm hoặc chọn từ danh sách các điểm đến phổ biến. Hệ thống sẽ tìm kiếm tất cả tour có điểm đến trùng khớp.

- **Theo Ngày Khởi Hành**: Người dùng chọn khoảng ngày khởi hành mong muốn. Hệ thống sẽ hiển thị các tour khởi hành trong khoảng thời gian đó.

- **Theo Giá Tiền**: Người dùng có thể chọn khoảng giá từ - đến. Hệ thống sẽ lọc các tour có giá nằm trong khoảng đó.

- **Theo Thời Gian Tour**: Người dùng có thể chọn thời gian tour (1 ngày, 2 ngày, 3 ngày, v.v.). Hệ thống sẽ hiển thị các tour có thời gian phù hợp.

Kết quả tìm kiếm sẽ hiển thị dưới dạng danh sách các tour card, mỗi card chứa:
- Hình ảnh tour
- Tên tour
- Giá tiền
- Thời gian tour
- Rating trung bình
- Nút "Xem Chi Tiết"

Người dùng có thể sắp xếp kết quả theo:
- Giá tiền (tăng/giảm)
- Rating (cao nhất trước)
- Ngày khởi hành (sớm nhất trước)
- Mới nhất

**2. Xem Chi Tiết Tour**

Khi người dùng click vào một tour, hệ thống sẽ hiển thị trang chi tiết tour với thông tin đầy đủ:

- **Thông Tin Cơ Bản**: Tên tour, mô tả chi tiết, điểm đến, thời gian tour, số ngày, số đêm.

- **Hình Ảnh và Video**: Hiển thị album hình ảnh tour, có thể xem video giới thiệu tour.

- **Giá Tiền**: Hiển thị giá cho người lớn, trẻ em, trẻ nhỏ. Có thể hiển thị giá theo nhóm (2-5 người, 6-10 người, v.v.).

- **Lịch Trình Chi Tiết**: Hiển thị lịch trình từng ngày, bao gồm:
  - Thời gian khởi hành
  - Các địa điểm tham quan
  - Thời gian tham quan
  - Bữa ăn (sáng, trưa, tối)
  - Nơi lưu trú

- **Dịch Vụ Bao Gồm**: Liệt kê các dịch vụ được bao gồm trong tour:
  - Vận chuyển (xe, tàu, máy bay)
  - Lưu trú (khách sạn, resort)
  - Ăn uống (bữa sáng, trưa, tối)
  - Hướng dẫn viên
  - Bảo hiểm du lịch
  - Vé vào cổng

- **Dịch Vụ Không Bao Gồm**: Liệt kê các dịch vụ không được bao gồm.

- **Điều Kiện Hủy**: Hiển thị chính sách hủy tour.

- **Đánh Giá và Bình Luận**: Hiển thị:
  - Rating trung bình (1-5 sao)
  - Số lượng đánh giá
  - Danh sách bình luận từ khách hàng đã đi tour
  - Nút "Viết Đánh Giá" (nếu đã đi tour)

- **Nút "Đặt Tour Ngay"**: Nút CTA (Call To Action) để người dùng bắt đầu quá trình đặt tour.

**3. Đặt Tour**

Khi người dùng click "Đặt Tour Ngay", hệ thống sẽ hiển thị form đặt tour với các trường thông tin:

- **Thông Tin Khách Hàng**:
  - Họ và tên (bắt buộc): Phải có ít nhất 3 ký tự
  - Email (bắt buộc): Phải là email hợp lệ
  - Số điện thoại (bắt buộc): Phải có 10 chữ số
  - Địa chỉ (tùy chọn)

- **Thông Tin Booking**:
  - Số người lớn (bắt buộc): Tối thiểu 1 người, tối đa 50 người
  - Số trẻ em (tùy chọn): Từ 0 đến 20 trẻ
  - Số trẻ nhỏ (tùy chọn): Từ 0 đến 10 trẻ
  - Ngày khởi hành (bắt buộc): Phải >= ngày hôm nay + 7 ngày
  - Yêu cầu đặc biệt (tùy chọn): Ví dụ: ghế cạnh cửa sổ, yêu cầu ăn chay, v.v.

- **Hiển Thị Tổng Giá Tiền**: Hệ thống sẽ tự động tính toán:
  - Giá người lớn × số người lớn
  - Giá trẻ em × số trẻ em
  - Giá trẻ nhỏ × số trẻ nhỏ
  - Cộng các khoản phí (nếu có)
  - Hiển thị tổng tiền

- **Validate Dữ Liệu**: Trước khi submit, hệ thống sẽ:
  - Kiểm tra các trường bắt buộc
  - Kiểm tra định dạng email, số điện thoại
  - Kiểm tra ngày khởi hành
  - Hiển thị thông báo lỗi nếu có

- **Submit Form**: Người dùng click nút "Đặt Tour Ngay" để submit form.

#### Yêu Cầu Thanh Toán

**1. Chọn Phương Thức Thanh Toán**

Sau khi submit form đặt tour, hệ thống sẽ chuyển hướng đến trang chọn phương thức thanh toán. Trang này sẽ hiển thị:

- **Thông Tin Booking**: Hiển thị lại thông tin booking vừa tạo:
  - Mã booking (VD: TOUR20240115123456789)
  - Ngày khởi hành
  - Số người
  - Tổng tiền

- **Các Phương Thức Thanh Toán**: Hiển thị 2 tùy chọn:
  - **VNPay**: Thanh toán qua thẻ ngân hàng (Visa, Mastercard, JCB), ví điện tử (Momo, ZaloPay). Ưu điểm: nhanh, an toàn, tự động xác nhận. Nhược điểm: phí giao dịch cao.
  - **Chuyển Khoản**: Thanh toán qua chuyển khoản ngân hàng. Ưu điểm: phí thấp, linh hoạt. Nhược điểm: cần xác nhận thủ công.

- **Chọn Phương Thức**: Người dùng chọn một trong hai phương thức và click "Tiếp Tục".

**2. Thanh Toán VNPay**

Nếu người dùng chọn VNPay:

- **Tạo URL Thanh Toán**: Hệ thống sẽ tạo URL thanh toán VNPay với các thông tin:
  - Mã merchant (TMN Code)
  - Số tiền
  - Mô tả giao dịch
  - URL callback
  - Timestamp

- **Chuyển Hướng**: Hệ thống chuyển hướng người dùng đến cổng thanh toán VNPay.

- **Nhập Thông Tin Thẻ**: Người dùng nhập thông tin thẻ (số thẻ, tên chủ thẻ, ngày hết hạn, CVV).

- **Xác Thực OTP**: VNPay gửi OTP đến điện thoại người dùng, người dùng nhập OTP để xác thực.

- **Xử Lý Giao Dịch**: VNPay xử lý giao dịch và trả kết quả.

- **Callback**: VNPay gửi callback về hệ thống với kết quả giao dịch (thành công hoặc thất bại).

- **Cập Nhật Trạng Thái**: Hệ thống cập nhật trạng thái booking:
  - Nếu thành công: payment_status = 'paid', booking_status = 'confirmed'
  - Nếu thất bại: payment_status = 'failed'

- **Hiển Thị Kết Quả**: Hệ thống hiển thị trang kết quả (thành công hoặc thất bại).

**3. Thanh Toán Chuyển Khoản**

Nếu người dùng chọn Chuyển Khoản:

- **Hiển Thị Form**: Hệ thống hiển thị form nhập thông tin chuyển khoản:
  - Chọn ngân hàng (Vietcombank, VietinBank, BIDV, Agribank, Techcombank, v.v.)
  - Số tài khoản (phải là số, không có ký tự đặc biệt)
  - Tên chủ tài khoản (phải là chữ hoa)
  - Số tiền (phải bằng tổng tiền booking)
  - Họ tên người thanh toán
  - Email người thanh toán
  - Số điện thoại người thanh toán

- **Validate Dữ Liệu**: Trước khi submit:
  - Kiểm tra các trường bắt buộc
  - Kiểm tra định dạng số tài khoản
  - Kiểm tra số tiền có bằng tổng tiền booking
  - Hiển thị thông báo lỗi nếu có

- **Lưu Vào Database**: Hệ thống lưu thông tin xác nhận thanh toán vào bảng payment_confirmations:
  - booking_code
  - bank_name
  - account_number
  - account_name
  - amount
  - status = 'pending'
  - created_at

- **Hiển Thị Thông Báo Thành Công**: Hệ thống hiển thị thông báo "Xác nhận thành công. Chúng tôi sẽ kiểm tra và xác nhận trong vòng 30 phút."

- **Gửi Email**: Hệ thống gửi email xác nhận đến khách hàng với:
  - Mã booking
  - Thông tin chuyển khoản
  - Số tiền
  - Hướng dẫn tiếp theo

#### Yêu Cầu Quản Lý

**1. Quản Lý Booking**

Admin có thể:
- Xem danh sách tất cả booking với các thông tin: mã booking, tên khách hàng, ngày khởi hành, số người, tổng tiền, trạng thái booking, trạng thái thanh toán.
- Tìm kiếm booking theo mã booking, tên khách hàng, email, số điện thoại.
- Sắp xếp booking theo ngày tạo, ngày khởi hành, tổng tiền.
- Xem chi tiết booking: tất cả thông tin khách hàng, thông tin tour, yêu cầu đặc biệt.
- Sửa booking: thay đổi số người, ngày khởi hành, yêu cầu đặc biệt (nếu chưa thanh toán).
- Xóa booking: chỉ có thể xóa booking chưa thanh toán.
- Export booking: xuất danh sách booking ra file Excel hoặc PDF.

**2. Quản Lý Thanh Toán**

Admin có thể:
- Xem danh sách tất cả thanh toán với các thông tin: mã booking, phương thức thanh toán, số tiền, trạng thái thanh toán, ngày tạo.
- Tìm kiếm thanh toán theo mã booking, phương thức, trạng thái.
- Xem chi tiết thanh toán: tất cả thông tin chuyển khoản (ngân hàng, số tài khoản, tên chủ tài khoản, số tiền).
- Xác nhận thanh toán chuyển khoản: kiểm tra thông tin chuyển khoản, xác nhận hoặc từ chối.
- Cập nhật trạng thái thanh toán: từ 'pending' sang 'confirmed' hoặc 'rejected'.
- Gửi email xác nhận: gửi email cho khách hàng khi xác nhận thanh toán.

**3. Quản Lý Tour**

Admin có thể:
- Xem danh sách tất cả tour với các thông tin: tên tour, điểm đến, giá tiền, thời gian tour, trạng thái.
- Tạo tour mới: nhập tên tour, mô tả, điểm đến, giá tiền (người lớn, trẻ em), thời gian tour, lịch trình, dịch vụ bao gồm, hình ảnh.
- Sửa thông tin tour: thay đổi bất kỳ thông tin nào của tour.
- Xóa tour: chỉ có thể xóa tour chưa có booking.
- Quản lý lịch trình: thêm, sửa, xóa lịch trình của tour.
- Quản lý hình ảnh: thêm, xóa hình ảnh của tour.

### 3.1.2 Yêu Cầu Phi Chức Năng (Non-Functional Requirements)

#### Hiệu Suất (Performance)

**Tốc Độ Tải Trang**
- Trang chủ phải tải trong < 3 giây
- Trang danh sách tour phải tải trong < 2 giây
- Trang chi tiết tour phải tải trong < 2 giây
- Trang đặt tour phải tải trong < 1 giây

**Tốc Độ API**
- API response time phải < 500ms
- Database query phải < 100ms
- Hỗ trợ 1000 concurrent users

**Tối Ưu Hóa**
- Nén hình ảnh để giảm kích thước
- Minify CSS, JavaScript
- Sử dụng caching (browser cache, server cache)
- Lazy loading cho hình ảnh

#### Bảo Mật (Security)

**Mã Hóa Dữ Liệu**
- Mã hóa dữ liệu nhạy cảm (số tài khoản, số thẻ)
- Sử dụng HTTPS cho tất cả trang
- Sử dụng SSL/TLS certificate

**Validate Input**
- Validate tất cả input từ người dùng
- Kiểm tra loại dữ liệu, độ dài, định dạng
- Reject input không hợp lệ

**Prevent SQL Injection**
- Sử dụng Prepared Statements
- Không nối chuỗi SQL trực tiếp
- Escape dữ liệu đầu vào

**Prevent XSS (Cross-Site Scripting)**
- Encode output khi hiển thị
- Sử dụng htmlspecialchars() trong PHP
- Validate input trên server

**CSRF Protection**
- Sử dụng CSRF token
- Kiểm tra token trước khi xử lý form
- Sử dụng SameSite cookie

**Authentication & Authorization**
- Kiểm tra session người dùng
- Phân quyền admin/user
- Kiểm tra quyền trước khi thực hiện hành động

#### Khả Dụng (Availability)

**Uptime**
- Hệ thống phải có uptime 99.9% (tối đa 8.76 giờ downtime/năm)
- Sử dụng load balancing để phân tán tải

**Backup**
- Backup database hàng ngày
- Lưu backup ở nhiều nơi
- Có thể restore từ backup

**Disaster Recovery**
- Có kế hoạch phục hồi khi xảy ra sự cố
- Có server backup sẵn sàng
- Có thể chuyển sang server backup trong < 1 giờ

**Monitoring**
- Giám sát uptime của hệ thống
- Giám sát hiệu suất (CPU, memory, disk)
- Alert khi có vấn đề

#### Khả Mở Rộng (Scalability)

**Hỗ Trợ Tăng Dữ Liệu**
- Hỗ trợ tăng số lượng tour (từ 100 lên 10,000)
- Hỗ trợ tăng số lượng user (từ 1,000 lên 100,000)
- Hỗ trợ tăng số lượng booking (từ 10,000 lên 1,000,000)

**Database Optimization**
- Sử dụng index cho các cột tìm kiếm
- Sử dụng partitioning cho bảng lớn
- Sử dụng caching (Redis, Memcached)

**Horizontal Scaling**
- Có thể thêm server web mới
- Sử dụng load balancer để phân tán tải
- Sử dụng database replication

**Vertical Scaling**
- Có thể nâng cấp server (CPU, memory, disk)
- Có thể nâng cấp database server

## 3.2 Thiết Kế Chi Tiết

### 3.2.1 Thiết Kế Database

#### Bảng tour_bookings

Bảng này lưu trữ thông tin các booking tour của khách hàng. Cấu trúc bảng bao gồm:

**Cột Khóa Chính**
- `id`: Khóa chính, tự động tăng, dùng để định danh duy nhất mỗi booking trong hệ thống.

**Cột Thông Tin Booking**
- `booking_code`: Mã booking duy nhất, định dạng TOUR + timestamp + số ngẫu nhiên (VD: TOUR20240115123456789). Được indexed để tìm kiếm nhanh.
- `departure_date`: Ngày khởi hành của tour, định dạng DATE (YYYY-MM-DD).
- `return_date`: Ngày trở về từ tour, định dạng DATE (YYYY-MM-DD), tùy chọn.
- `destination`: Điểm đến du lịch, VARCHAR(255), bắt buộc. VD: "Hà Nội", "Sapa", "Hạ Long", "Đà Nẵng", v.v.
- `created_at`: Thời gian tạo booking, tự động ghi lại thời gian hiện tại.
- `updated_at`: Thời gian cập nhật booking lần cuối.

**Cột Thông Tin Khách Hàng**
- `customer_name`: Tên khách hàng, VARCHAR(100), bắt buộc.
- `customer_phone`: Số điện thoại khách hàng, VARCHAR(20), bắt buộc.
- `customer_email`: Email khách hàng, VARCHAR(100), bắt buộc, được indexed để tìm kiếm nhanh.
- `customer_address`: Địa chỉ khách hàng, VARCHAR(255), tùy chọn.

**Cột Thông Tin Số Lượng**
- `num_adults`: Số người lớn, INT, mặc định 1, bắt buộc.
- `num_children`: Số trẻ em, INT, mặc định 0, tùy chọn.
- `num_infants`: Số trẻ nhỏ (dưới 2 tuổi), INT, mặc định 0, tùy chọn.

**Cột Thông Tin Giá Tiền**
- `total_price`: Tổng giá tiền, DECIMAL(15,2), bắt buộc. Được tính từ: (num_adults × giá người lớn) + (num_children × giá trẻ em) + (num_infants × giá trẻ nhỏ).

**Cột Thông Tin Trạng Thái**
- `booking_status`: Trạng thái booking, ENUM với các giá trị:
  - 'pending': Booking vừa tạo, chưa thanh toán
  - 'confirmed': Booking đã thanh toán, xác nhận
  - 'completed': Tour đã hoàn thành
  - 'cancelled': Booking bị hủy
  - Mặc định: 'pending'

- `payment_status`: Trạng thái thanh toán, ENUM với các giá trị:
  - 'pending': Chưa thanh toán
  - 'paid': Đã thanh toán
  - 'failed': Thanh toán thất bại
  - 'refunded': Đã hoàn tiền
  - Mặc định: 'pending'

**Cột Thông Tin Khác**
- `special_requests`: Yêu cầu đặc biệt từ khách hàng, TEXT, tùy chọn. VD: "Yêu cầu ghế cạnh cửa sổ", "Ăn chay", "Phòng không hút thuốc", v.v.
- `payment_method`: Phương thức thanh toán, VARCHAR(50). VD: 'vnpay', 'bank_transfer', 'cash'.
- `notes`: Ghi chú từ admin, TEXT, tùy chọn.

**Index**
- Index trên `booking_code` để tìm kiếm nhanh theo mã booking.
- Index trên `customer_email` để tìm kiếm nhanh theo email.
- Index trên `destination` để tìm kiếm nhanh theo điểm đến.
- Index trên `created_at` để sắp xếp theo ngày tạo.
- Index trên `departure_date` để tìm kiếm nhanh theo ngày khởi hành.

#### Bảng payment_confirmations

Bảng này lưu trữ thông tin xác nhận thanh toán chuyển khoản. Cấu trúc bảng bao gồm:

**Cột Khóa Chính**
- `id`: Khóa chính, tự động tăng.

**Cột Liên Kết**
- `booking_code`: Mã booking, VARCHAR(50), bắt buộc. Được indexed để tìm kiếm nhanh. Có ràng buộc khóa ngoại tham chiếu đến bảng tour_bookings.

**Cột Thông Tin Chuyển Khoản**
- `bank_name`: Tên ngân hàng, VARCHAR(100). VD: 'Vietcombank', 'VietinBank', 'BIDV'.
- `account_number`: Số tài khoản, VARCHAR(50). Chỉ chứa số, không có ký tự đặc biệt.
- `account_name`: Tên chủ tài khoản, VARCHAR(100). Phải là chữ hoa.
- `amount`: Số tiền chuyển khoản, DECIMAL(15,2).

**Cột Trạng Thái**
- `status`: Trạng thái xác nhận, ENUM với các giá trị:
  - 'pending': Chờ xác nhận từ admin
  - 'confirmed': Admin đã xác nhận thanh toán
  - 'rejected': Admin từ chối thanh toán
  - Mặc định: 'pending'
  - Được indexed để tìm kiếm nhanh.

**Cột Thời Gian**
- `created_at`: Thời gian tạo xác nhận, tự động ghi lại.
- `updated_at`: Thời gian cập nhật lần cuối.

### 3.2.2 Thiết Kế API

#### API Endpoint: POST /api/bookings.php

**Mục Đích**: Tạo booking tour mới

**Tham Số Đầu Vào**:
- `action`: Hành động cần thực hiện ('create', 'update', 'delete', 'get')
- `customer_name`: Tên khách hàng (bắt buộc)
- `customer_email`: Email khách hàng (bắt buộc)
- `customer_phone`: Số điện thoại (bắt buộc)
- `num_adults`: Số người lớn (bắt buộc)
- `num_children`: Số trẻ em (tùy chọn)
- `departure_date`: Ngày khởi hành (bắt buộc)
- `special_requests`: Yêu cầu đặc biệt (tùy chọn)

**Kết Quả Trả Về (Thành Công)**:
- `success`: true
- `message`: "Booking created successfully"
- `booking_code`: Mã booking vừa tạo
- `total_price`: Tổng giá tiền

**Kết Quả Trả Về (Lỗi)**:
- `success`: false
- `message`: Mô tả lỗi
- `error_code`: Mã lỗi (VALIDATION_ERROR, DATABASE_ERROR, v.v.)

**Quy Trình Xử Lý**:
1. Nhận tham số từ request
2. Validate dữ liệu (kiểm tra trường bắt buộc, định dạng, v.v.)
3. Tính tổng giá tiền
4. Tạo mã booking
5. Insert vào database
6. Trả về kết quả

#### API Endpoint: POST /api/process-payment.php

**Mục Đích**: Xử lý thanh toán chuyển khoản

**Tham Số Đầu Vào**:
- `action`: 'confirm_transfer'
- `booking_code`: Mã booking
- `bank_name`: Tên ngân hàng
- `account_number`: Số tài khoản
- `account_name`: Tên chủ tài khoản
- `amount`: Số tiền
- `payer_name`: Tên người thanh toán
- `payer_email`: Email người thanh toán
- `payer_phone`: Số điện thoại người thanh toán

**Kết Quả Trả Về (Thành Công)**:
- `success`: true
- `message`: "Payment confirmation saved"
- `confirmation_id`: ID xác nhận vừa tạo

**Kết Quả Trả Về (Lỗi)**:
- `success`: false
- `message`: Mô tả lỗi

**Quy Trình Xử Lý**:
1. Nhận tham số từ request
2. Validate dữ liệu
3. Kiểm tra booking có tồn tại không
4. Kiểm tra số tiền có bằng tổng tiền booking không
5. Insert vào bảng payment_confirmations
6. Gửi email xác nhận cho khách hàng
7. Trả về kết quả

#### API Endpoint: GET /api/tours.php

**Mục Đích**: Lấy danh sách tour hoặc chi tiết tour

**Tham Số Đầu Vào**:
- `action`: 'list' hoặc 'get'
- `id`: ID tour (nếu action = 'get')
- `search`: Từ khóa tìm kiếm (nếu action = 'list')
- `sort`: Cách sắp xếp (price_asc, price_desc, rating, date)
- `limit`: Số lượng kết quả (mặc định 10)
- `offset`: Vị trí bắt đầu (mặc định 0)

**Kết Quả Trả Về**:
- Danh sách tour hoặc chi tiết tour với các thông tin: ID, tên, mô tả, giá tiền, thời gian, rating, v.v.

### 3.2.3 Thiết Kế Giao Diện

#### Trang Đặt Tour (dat-tour.php)

**Bố Cục Trang**:
- **Header**: Chứa logo, menu navigation, nút đăng nhập/đăng ký
- **Tiêu Đề**: "Đặt Tour Du Lịch" với mô tả ngắn
- **Form Đặt Tour**: Chứa các trường nhập liệu
- **Footer**: Chứa thông tin liên hệ, link, copyright

**Các Phần Của Form**:
1. **Phần Thông Tin Khách Hàng**:
   - Họ và tên (text input, bắt buộc)
   - Email (email input, bắt buộc)
   - Số điện thoại (tel input, bắt buộc)
   - Địa chỉ (text input, tùy chọn)

2. **Phần Thông Tin Booking**:
   - Số người lớn (number input, bắt buộc, min=1, max=50)
   - Số trẻ em (number input, tùy chọn, min=0, max=20)
   - Ngày khởi hành (date input, bắt buộc)
   - Yêu cầu đặc biệt (textarea, tùy chọn)

3. **Phần Hiển Thị Giá**:
   - Giá người lớn × số người lớn
   - Giá trẻ em × số trẻ em
   - Tổng tiền (in đậm, màu nổi bật)

4. **Nút Submit**:
   - Nút "Đặt Tour Ngay" (màu xanh, kích thước lớn)
   - Nút "Quay Lại" (màu xám)

**Responsive Design**:
- Trên desktop: Form hiển thị 2 cột
- Trên tablet: Form hiển thị 1 cột
- Trên mobile: Form hiển thị 1 cột, kích thước nhỏ hơn

#### Trang Chọn Phương Thức Thanh Toán (payment-tour-method.php)

**Bố Cục Trang**:
- **Header**: Chứa logo, menu navigation
- **Tiêu Đề**: "Chọn Phương Thức Thanh Toán"
- **Thông Tin Booking**: Hiển thị lại thông tin booking vừa tạo
- **Các Phương Thức Thanh Toán**: Hiển thị 2 tùy chọn (VNPay, Chuyển Khoản)
- **Nút Hành Động**: Nút "Tiếp Tục", "Quay Lại"
- **Footer**: Chứa thông tin liên hệ

**Thông Tin Booking**:
- Mã booking (VD: TOUR20240115123456789)
- Ngày khởi hành (định dạng: dd/mm/yyyy)
- Số người (VD: 3 người)
- Tổng tiền (định dạng: 1.300.000 VNĐ)

**Các Phương Thức Thanh Toán**:
Mỗi phương thức được hiển thị dưới dạng card với:
- Icon (💳 cho VNPay, 🏦 cho Chuyển Khoản)
- Tên phương thức
- Mô tả ngắn
- Radio button để chọn

**Responsive Design**:
- Trên desktop: 2 card hiển thị cạnh nhau
- Trên tablet: 2 card hiển thị cạnh nhau
- Trên mobile: 2 card hiển thị xếp chồng

#### Trang Form Thanh Toán (payment-tour-form.php)

**Bố Cục Trang**:
- **Header**: Chứa logo, menu navigation
- **Tiêu Đề**: "Thanh Toán Tour"
- **Hiển Thị Tổng Tiền**: Hiển thị tổng tiền cần thanh toán (in đậm, màu nổi bật)
- **Form Thanh Toán**: Chứa các trường nhập liệu
- **Nút Hành Động**: Nút "Xác Nhận Đã Chuyển Khoản", "Quay Lại"
- **Footer**: Chứa thông tin liên hệ

**Các Phần Của Form**:
1. **Phần Thông Tin Tài Khoản Chuyển Khoản**:
   - Chọn ngân hàng (select dropdown, bắt buộc)
   - Số tài khoản (text input, bắt buộc)
   - Tên chủ tài khoản (text input, bắt buộc)
   - Số tiền cần chuyển (number input, bắt buộc, mặc định = tổng tiền)

2. **Phần Thông Tin Người Thanh Toán**:
   - Họ tên (text input, bắt buộc)
   - Email (email input, bắt buộc)
   - Số điện thoại (tel input, bắt buộc)

3. **Phần Lưu Ý**:
   - Hiển thị lưu ý: "Vui lòng nhập đúng thông tin tài khoản bạn đã chuyển khoản"

**Responsive Design**:
- Trên desktop: Form hiển thị 1 cột
- Trên tablet: Form hiển thị 1 cột
- Trên mobile: Form hiển thị 1 cột, kích thước nhỏ hơn

## 3.3 Cài Đặt Môi Trường

### 3.3.1 Yêu Cầu Hệ Thống

**Phần Cứng**:
- CPU: Tối thiểu 2 cores, khuyên dùng 4 cores
- RAM: Tối thiểu 2GB, khuyên dùng 4GB
- Disk: Tối thiểu 10GB, khuyên dùng 50GB
- Bandwidth: Tối thiểu 10Mbps

**Phần Mềm**:
- **PHP**: Phiên bản 7.4 trở lên (khuyên dùng 8.0+)
  - Extensions cần thiết: PDO, MySQLi, cURL, JSON, OpenSSL
  - Memory limit: Tối thiểu 128MB, khuyên dùng 256MB
  - Max upload size: Tối thiểu 10MB, khuyên dùng 50MB

- **MySQL**: Phiên bản 5.7 trở lên (khuyên dùng 8.0+)
  - Character set: utf8mb4
  - Collation: utf8mb4_unicode_ci
  - Max connections: Tối thiểu 100, khuyên dùng 500

- **Web Server**: Apache 2.4+ hoặc Nginx 1.18+
  - Hỗ trợ .htaccess (nếu dùng Apache)
  - Hỗ trợ rewrite module
  - SSL/TLS support

- **Công Cụ Khác**:
  - Composer (optional, để quản lý dependencies)
  - Git (optional, để version control)
  - cURL (để gọi API VNPay)

### 3.3.2 Cài Đặt Database

**Bước 1: Tạo Database**
- Kết nối đến MySQL server
- Tạo database mới với tên 'travinh_tourism'
- Chỉ định character set là utf8mb4 và collation là utf8mb4_unicode_ci
- Điều này đảm bảo hỗ trợ tiếng Việt và các ký tự đặc biệt

**Bước 2: Tạo Bảng**
- Chạy file SQL `database/create-tour-bookings.sql` để tạo bảng tour_bookings
- Chạy file SQL `database/create-payment-confirmations.sql` để tạo bảng payment_confirmations
- Chạy file SQL `database/create-tours-table.sql` để tạo bảng tours
- Chạy file SQL `database/create_users_simple.sql` để tạo bảng users

**Bước 3: Insert Dữ Liệu Mẫu**
- Chạy file SQL `database/insert-tours-data.sql` để insert dữ liệu tour mẫu
- Chạy file SQL `database/du-lieu-dat-tour-mau.sql` để insert dữ liệu booking mẫu
- Dữ liệu mẫu giúp test hệ thống

**Bước 4: Tạo Index**
- Tạo index trên các cột tìm kiếm (booking_code, customer_email, created_at)
- Index giúp tăng tốc độ tìm kiếm

### 3.3.3 Cấu Hình Ứng Dụng

**Cấu Hình Database**:
- File: `config/database.php`
- Cần cập nhật:
  - DB_HOST: Địa chỉ server MySQL (thường là 'localhost')
  - DB_USER: Tên user MySQL (thường là 'root')
  - DB_PASS: Mật khẩu MySQL
  - DB_NAME: Tên database ('travinh_tourism')
  - DB_PORT: Port MySQL (mặc định 3306)

**Cấu Hình VNPay**:
- File: `config/vnpay.php`
- Cần cập nhật:
  - VNP_TMNCODE: Mã merchant từ VNPay
  - VNP_HASHSECRET: Secret key từ VNPay
  - VNP_URL: URL cổng thanh toán VNPay
  - VNP_RETURN_URL: URL callback khi thanh toán xong
  - VNP_NOTIFY_URL: URL webhook từ VNPay

**Cấu Hình Email**:
- File: `config/email.php` (nếu có)
- Cần cập nhật:
  - SMTP_HOST: Địa chỉ SMTP server
  - SMTP_PORT: Port SMTP (thường 587 hoặc 465)
  - SMTP_USER: Email gửi
  - SMTP_PASS: Mật khẩu email
  - FROM_EMAIL: Email gửi từ
  - FROM_NAME: Tên gửi từ

**Cấu Hình OAuth (nếu có)**:
- File: `config/oauth.php`
- Cần cập nhật:
  - GOOGLE_CLIENT_ID: Client ID từ Google
  - GOOGLE_CLIENT_SECRET: Client Secret từ Google
  - GOOGLE_REDIRECT_URI: URL redirect sau khi đăng nhập Google

**Cấu Hình Ứng Dụng Chung**:
- File: `config/app.php` (nếu có)
- Cần cập nhật:
  - APP_NAME: Tên ứng dụng
  - APP_URL: URL ứng dụng
  - APP_ENV: Môi trường (development, production)
  - APP_DEBUG: Bật/tắt debug mode
  - TIMEZONE: Múi giờ (Asia/Ho_Chi_Minh)
  - CURRENCY: Đơn vị tiền tệ (VND)

## 3.4 Triển Khai Chức Năng

### 3.4.1 Chức Năng Đặt Tour

#### File: dat-tour.php

**Mục Đích**: Hiển thị form đặt tour cho người dùng

**Chức Năng Chính**:
1. **Hiển Thị Form**: Trang này hiển thị form đặt tour với các trường nhập liệu. Form được thiết kế responsive, phù hợp với desktop, tablet, mobile.

2. **Validate Client-Side**: Sử dụng JavaScript để validate dữ liệu trước khi submit:
   - Kiểm tra các trường bắt buộc không được để trống
   - Kiểm tra định dạng email (phải chứa @)
   - Kiểm tra số điện thoại (phải có 10 chữ số)
   - Kiểm tra họ tên (phải có ít nhất 3 ký tự)
   - Kiểm tra ngày khởi hành (phải >= ngày hôm nay + 7 ngày)
   - Hiển thị thông báo lỗi nếu có

3. **Tính Toán Giá Tiền**: Khi người dùng thay đổi số người, form sẽ tự động tính toán lại tổng giá tiền:
   - Giá người lớn × số người lớn
   - Giá trẻ em × số trẻ em
   - Cộng lại để được tổng tiền
   - Hiển thị tổng tiền dưới dạng tiền tệ (VD: 1.300.000 VNĐ)

4. **Submit Form**: Khi người dùng click nút "Đặt Tour Ngay", form sẽ submit đến file `process-booking.php` bằng phương thức POST.

#### File: process-booking.php

**Mục Đích**: Xử lý form đặt tour từ phía server

**Chức Năng Chính**:
1. **Kiểm Tra Request**: Kiểm tra xem request có phải là POST không. Nếu không, hiển thị lỗi.

2. **Lấy Dữ Liệu**: Lấy dữ liệu từ form:
   - customer_name, customer_email, customer_phone
   - num_adults, num_children
   - departure_date, special_requests

3. **Validate Server-Side**: Validate dữ liệu trên server (quan trọng vì client-side có thể bị bypass):
   - Kiểm tra các trường bắt buộc
   - Kiểm tra định dạng email (sử dụng filter_var)
   - Kiểm tra số điện thoại (sử dụng regex)
   - Kiểm tra họ tên (độ dài >= 3)
   - Kiểm tra ngày khởi hành (>= ngày hôm nay + 7 ngày)
   - Nếu có lỗi, hiển thị trang lỗi

4. **Kết Nối Database**: Kết nối đến database bằng class Database.

5. **Tạo Mã Booking**: Tạo mã booking duy nhất:
   - Định dạng: TOUR + timestamp (YYYYMMDDHHmmss) + số ngẫu nhiên (100-999)
   - VD: TOUR20240115123456789

6. **Tính Tổng Giá Tiền**:
   - Giá người lớn = 500.000 VNĐ
   - Giá trẻ em = 300.000 VNĐ
   - Tổng tiền = (num_adults × 500000) + (num_children × 300000)

7. **Insert Vào Database**: Insert booking vào bảng tour_bookings:
   - booking_code, departure_date, customer_name, customer_phone, customer_email
   - num_adults, num_children, total_price
   - booking_status = 'pending', payment_status = 'pending'
   - Sử dụng Prepared Statements để tránh SQL injection

8. **Xử Lý Lỗi**: Nếu insert thất bại, hiển thị trang lỗi với thông báo chi tiết.

9. **Chuyển Hướng**: Nếu insert thành công, chuyển hướng đến trang `payment-tour-method.php?booking_id=TOUR...`

### 3.4.2 Chức Năng Thanh Toán

#### File: payment-tour-method.php

**Mục Đích**: Cho phép người dùng chọn phương thức thanh toán

**Chức Năng Chính**:
1. **Lấy Booking ID**: Lấy booking_id từ URL parameter.

2. **Kiểm Tra Booking**: Kiểm tra xem booking có tồn tại trong database không. Nếu không, hiển thị lỗi.

3. **Lấy Thông Tin Booking**: Query database để lấy thông tin booking:
   - booking_code, departure_date, num_adults, num_children, total_price

4. **Hiển Thị Thông Tin**: Hiển thị lại thông tin booking cho người dùng xác nhận:
   - Mã booking
   - Ngày khởi hành
   - Số người
   - Tổng tiền

5. **Hiển Thị Phương Thức Thanh Toán**: Hiển thị 2 tùy chọn:
   - VNPay (thanh toán qua thẻ)
   - Chuyển Khoản (thanh toán qua ngân hàng)
   - Mỗi tùy chọn được hiển thị dưới dạng card với icon, tên, mô tả

6. **Chọn Phương Thức**: Người dùng chọn một phương thức bằng radio button.

7. **Submit Form**: Khi người dùng click "Tiếp Tục", form submit đến:
   - Nếu chọn VNPay: chuyển hướng đến `payment-vnpay.php`
   - Nếu chọn Chuyển Khoản: chuyển hướng đến `payment-tour-form.php`

#### File: payment-tour-form.php

**Mục Đích**: Xử lý thanh toán chuyển khoản

**Chức Năng Chính**:
1. **Lấy Booking ID**: Lấy booking_id từ POST parameter.

2. **Lấy Thông Tin Booking**: Query database để lấy thông tin booking.

3. **Hiển Thị Form**: Hiển thị form nhập thông tin chuyển khoản:
   - Chọn ngân hàng (select dropdown)
   - Số tài khoản (text input)
   - Tên chủ tài khoản (text input)
   - Số tiền (number input, mặc định = tổng tiền)
   - Họ tên người thanh toán (text input)
   - Email (email input)
   - Số điện thoại (tel input)

4. **Validate Client-Side**: Sử dụng JavaScript để validate:
   - Kiểm tra các trường bắt buộc
   - Kiểm tra định dạng số tài khoản (chỉ số)
   - Kiểm tra số tiền (phải bằng tổng tiền booking)
   - Hiển thị thông báo lỗi

5. **Submit AJAX**: Khi người dùng click "Xác Nhận Đã Chuyển Khoản", form submit bằng AJAX (không reload trang):
   - Gửi dữ liệu đến server
   - Hiển thị loading indicator
   - Chờ response từ server

6. **Validate Server-Side**: Validate dữ liệu trên server:
   - Kiểm tra các trường bắt buộc
   - Kiểm tra booking có tồn tại không
   - Kiểm tra số tiền có bằng tổng tiền booking không

7. **Insert Vào Database**: Insert xác nhận thanh toán vào bảng payment_confirmations:
   - booking_code, bank_name, account_number, account_name, amount
   - status = 'pending' (chờ admin xác nhận)
   - created_at = thời gian hiện tại

8. **Gửi Email**: Gửi email xác nhận đến khách hàng:
   - Mã booking
   - Thông tin chuyển khoản
   - Số tiền
   - Hướng dẫn tiếp theo

9. **Trả Về Response**: Trả về JSON response:
   - Nếu thành công: `{"success": true}`
   - Nếu lỗi: `{"success": false, "error": "..."}`

10. **Hiển Thị Kết Quả**: Dựa trên response:
    - Nếu thành công: ẩn form, hiển thị thông báo thành công
    - Nếu lỗi: hiển thị thông báo lỗi, cho phép thử lại

#### File: payment-vnpay.php

**Mục Đích**: Xử lý thanh toán VNPay

**Chức Năng Chính**:
1. **Lấy Booking ID**: Lấy booking_id từ POST parameter.

2. **Lấy Thông Tin Booking**: Query database để lấy thông tin booking.

3. **Tạo URL Thanh Toán**: Tạo URL thanh toán VNPay với các tham số:
   - Mã merchant (TMN Code)
   - Số tiền
   - Mô tả giao dịch
   - URL callback
   - Timestamp
   - Hash (HMAC SHA512)

4. **Chuyển Hướng**: Chuyển hướng người dùng đến cổng thanh toán VNPay.

5. **Người Dùng Thanh Toán**: Người dùng nhập thông tin thẻ, xác thực OTP, VNPay xử lý giao dịch.

6. **Callback**: VNPay gửi callback về hệ thống với kết quả giao dịch.

#### File: payment-return.php

**Mục Đích**: Xử lý callback từ VNPay

**Chức Năng Chính**:
1. **Nhận Callback**: Nhận callback từ VNPay với các tham số:
   - Mã giao dịch VNPay
   - Mã booking
   - Số tiền
   - Kết quả giao dịch (0 = thành công, khác 0 = thất bại)
   - Hash (để xác thực)

2. **Xác Thực Hash**: Xác thực hash để đảm bảo callback từ VNPay:
   - Tính hash từ các tham số
   - So sánh với hash từ callback
   - Nếu không khớp, từ chối callback

3. **Cập Nhật Database**: Nếu thanh toán thành công:
   - Cập nhật payment_status = 'paid'
   - Cập nhật booking_status = 'confirmed'
   - Lưu mã giao dịch VNPay

4. **Gửi Email**: Gửi email xác nhận cho khách hàng.

5. **Hiển Thị Kết Quả**: Hiển thị trang kết quả (thành công hoặc thất bại).

### 3.4.3 Chức Năng Quản Lý

#### File: quan-ly-booking.php

**Mục Đích**: Cho phép admin quản lý booking

**Chức Năng Chính**:
1. **Kiểm Tra Quyền**: Kiểm tra xem người dùng có phải admin không. Nếu không, redirect đến login.

2. **Hiển Thị Danh Sách**: Hiển thị danh sách tất cả booking:
   - Mã booking, tên khách hàng, ngày khởi hành, số người, tổng tiền, trạng thái booking, trạng thái thanh toán
   - Phân trang (10 booking/trang)
   - Sắp xếp theo ngày tạo (mới nhất trước)

3. **Tìm Kiếm**: Cho phép tìm kiếm booking theo:
   - Mã booking
   - Tên khách hàng
   - Email
   - Số điện thoại

4. **Sắp Xếp**: Cho phép sắp xếp theo:
   - Ngày tạo (tăng/giảm)
   - Ngày khởi hành (tăng/giảm)
   - Tổng tiền (tăng/giảm)

5. **Xem Chi Tiết**: Click vào booking để xem chi tiết:
   - Tất cả thông tin khách hàng
   - Thông tin tour
   - Yêu cầu đặc biệt
   - Trạng thái booking, thanh toán

6. **Sửa Booking**: Cho phép sửa booking (nếu chưa thanh toán):
   - Sửa số người
   - Sửa ngày khởi hành
   - Sửa yêu cầu đặc biệt
   - Tự động tính lại tổng tiền

7. **Xóa Booking**: Cho phép xóa booking (chỉ nếu chưa thanh toán):
   - Xác nhận trước khi xóa
   - Xóa booking và các xác nhận thanh toán liên quan

8. **Export**: Cho phép export danh sách booking ra file Excel hoặc PDF.

#### File: quan-ly-thanh-toan.php

**Mục Đích**: Cho phép admin quản lý thanh toán

**Chức Năng Chính**:
1. **Kiểm Tra Quyền**: Kiểm tra xem người dùng có phải admin không.

2. **Hiển Thị Danh Sách**: Hiển thị danh sách tất cả thanh toán:
   - Mã booking, phương thức thanh toán, số tiền, trạng thái, ngày tạo
   - Phân trang
   - Sắp xếp theo ngày tạo (mới nhất trước)

3. **Tìm Kiếm**: Cho phép tìm kiếm theo:
   - Mã booking
   - Phương thức thanh toán
   - Trạng thái

4. **Xem Chi Tiết**: Click vào thanh toán để xem chi tiết:
   - Mã booking
   - Phương thức thanh toán
   - Thông tin chuyển khoản (ngân hàng, số tài khoản, tên chủ tài khoản, số tiền)
   - Trạng thái
   - Ngày tạo

5. **Xác Nhận Thanh Toán**: Cho phép xác nhận thanh toán chuyển khoản:
   - Kiểm tra thông tin chuyển khoản
   - Xác nhận hoặc từ chối
   - Gửi email cho khách hàng

6. **Cập Nhật Trạng Thái**: Cập nhật trạng thái thanh toán:
   - Từ 'pending' sang 'confirmed' hoặc 'rejected'
   - Tự động cập nhật booking_status nếu cần

## 3.5 Testing

### 3.5.1 Unit Testing
- Test validate form
- Test tính giá tiền
- Test tạo booking code

### 3.5.2 Integration Testing
- Test flow đặt tour
- Test flow thanh toán
- Test flow quản lý

### 3.5.3 User Acceptance Testing
- Test trên các trình duyệt khác nhau
- Test trên mobile
- Test performance

## 3.6 Kết Luận Chương

Chương 3 đã trình bày chi tiết về:
- Phân tích yêu cầu chức năng và phi chức năng
- Thiết kế database, API, giao diện
- Cài đặt môi trường
- Triển khai các chức năng chính
- Testing


## 3.7 Chi Tiết Triển Khai Từng Chức Năng

### 3.7.1 Chức Năng Đặt Tour - Chi Tiết

#### Bước 1: Hiển Thị Form (dat-tour.php)

**Cấu trúc HTML:**
```html
<form id="bookingForm" method="POST" action="process-booking.php">
    <div class="form-group">
        <label>Họ và tên *</label>
        <input type="text" name="customer_name" required 
               placeholder="Nguyễn Văn A">
    </div>
    
    <div class="form-group">
        <label>Email *</label>
        <input type="email" name="customer_email" required 
               placeholder="email@example.com">
    </div>
    
    <div class="form-group">
        <label>Số điện thoại *</label>
        <input type="tel" name="customer_phone" required 
               placeholder="0901234567">
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label>Số người lớn *</label>
            <input type="number" name="num_adults" required 
                   min="1" value="1">
        </div>
        
        <div class="form-group">
            <label>Số trẻ em</label>
            <input type="number" name="num_children" 
                   min="0" value="0">
        </div>
    </div>
    
    <div class="form-group">
        <label>Ngày khởi hành *</label>
        <input type="date" name="departure_date" required>
    </div>
    
    <div class="form-group">
        <label>Yêu cầu đặc biệt</label>
        <textarea name="special_requests" rows="3"></textarea>
    </div>
    
    <button type="submit" class="btn-submit">
        Đặt Tour Ngay
    </button>
</form>
```

**JavaScript Validation:**
```javascript
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    const name = document.querySelector('input[name="customer_name"]').value;
    const email = document.querySelector('input[name="customer_email"]').value;
    const phone = document.querySelector('input[name="customer_phone"]').value;
    
    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Email không hợp lệ');
        return;
    }
    
    // Validate phone
    const phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(phone)) {
        e.preventDefault();
        alert('Số điện thoại phải có 10 chữ số');
        return;
    }
    
    // Validate name
    if (name.trim().length < 3) {
        e.preventDefault();
        alert('Họ tên phải có ít nhất 3 ký tự');
        return;
    }
});
```

#### Bước 2: Xử Lý Form (process-booking.php)

**Validate Server-Side:**
```php
<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

try {
    // Lấy dữ liệu
    $customer_name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
    $customer_email = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : '';
    $customer_phone = isset($_POST['customer_phone']) ? trim($_POST['customer_phone']) : '';
    $num_adults = isset($_POST['num_adults']) ? (int)$_POST['num_adults'] : 1;
    $num_children = isset($_POST['num_children']) ? (int)$_POST['num_children'] : 0;
    $departure_date = isset($_POST['departure_date']) ? trim($_POST['departure_date']) : '';
    $special_requests = isset($_POST['special_requests']) ? trim($_POST['special_requests']) : '';
    
    // Validate
    if (empty($customer_name) || strlen($customer_name) < 3) {
        throw new Exception('Họ tên phải có ít nhất 3 ký tự');
    }
    
    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email không hợp lệ');
    }
    
    if (!preg_match('/^[0-9]{10}$/', $customer_phone)) {
        throw new Exception('Số điện thoại phải có 10 chữ số');
    }
    
    if ($num_adults < 1) {
        throw new Exception('Phải có ít nhất 1 người lớn');
    }
    
    if (strtotime($departure_date) < strtotime('today')) {
        throw new Exception('Ngày khởi hành phải >= ngày hôm nay');
    }
    
    // Kết nối database
    $database = new Database();
    $db = $database->getConnection();
    
    // Tạo booking code
    $booking_code = 'TOUR' . date('YmdHis') . rand(100, 999);
    
    // Tính giá
    $adult_price = 500000;
    $child_price = 300000;
    $total_price = ($num_adults * $adult_price) + ($num_children * $child_price);
    
    // Insert booking
    $query = "INSERT INTO tour_bookings 
              (booking_code, departure_date, customer_name, customer_phone, 
               customer_email, num_adults, num_children, total_price,
               booking_status, special_requests, payment_method, payment_status)
              VALUES (:booking_code, :departure_date, :customer_name, :customer_phone,
                      :customer_email, :num_adults, :num_children, :total_price,
                      :booking_status, :special_requests, :payment_method, :payment_status)";
    
    $stmt = $db->prepare($query);
    $success = $stmt->execute(array(
        ':booking_code' => $booking_code,
        ':departure_date' => $departure_date,
        ':customer_name' => $customer_name,
        ':customer_phone' => $customer_phone,
        ':customer_email' => $customer_email,
        ':num_adults' => $num_adults,
        ':num_children' => $num_children,
        ':total_price' => $total_price,
        ':booking_status' => 'pending',
        ':special_requests' => $special_requests,
        ':payment_method' => 'pending',
        ':payment_status' => 'pending'
    ));
    
    if (!$success) {
        $error = $stmt->errorInfo();
        throw new Exception('Lỗi SQL: ' . $error[2]);
    }
    
    // Chuyển hướng
    header('Location: payment-tour-method.php?booking_id=' . urlencode($booking_code));
    exit;
    
} catch (Exception $e) {
    // Hiển thị lỗi
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Lỗi</title>
        <style>
            body { font-family: Arial; padding: 50px; text-align: center; }
            .error { background: #f8d7da; padding: 20px; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class="error">
            <h1>❌ Có lỗi xảy ra</h1>
            <p><?php echo htmlspecialchars($e->getMessage()); ?></p>
            <a href="dat-tour.php">Quay Lại</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>
```

### 3.7.2 Chức Năng Thanh Toán - Chi Tiết

#### Bước 1: Chọn Phương Thức (payment-tour-method.php)

**Hiển thị thông tin booking:**
```php
<?php
session_start();
require_once 'config/database.php';

$booking_id = $_GET['booking_id'] ?? null;

if (!$booking_id) {
    die('Thiếu thông tin booking');
}

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT * FROM tour_bookings WHERE booking_code = :code OR id = :id";
$stmt = $conn->prepare($query);
$stmt->execute([':code' => $booking_id, ':id' => $booking_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die('Không tìm thấy booking');
}

$total_amount = $booking['total_price'];
?>
```

**HTML hiển thị:**
```html
<div class="booking-summary">
    <div class="summary-row">
        <span>Mã Booking:</span>
        <strong><?php echo htmlspecialchars($booking['booking_code']); ?></strong>
    </div>
    <div class="summary-row">
        <span>Ngày Khởi Hành:</span>
        <strong><?php echo date('d/m/Y', strtotime($booking['departure_date'])); ?></strong>
    </div>
    <div class="summary-row">
        <span>Số Người:</span>
        <strong><?php echo ($booking['num_adults'] + $booking['num_children']); ?> người</strong>
    </div>
    <div class="summary-row">
        <span>Tổng Tiền:</span>
        <strong><?php echo number_format($total_amount, 0, ',', '.'); ?> VNĐ</strong>
    </div>
</div>

<form id="paymentMethodForm" method="POST" action="payment-tour-form.php">
    <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
    
    <div class="payment-methods">
        <label class="payment-method-card">
            <input type="radio" name="method" value="vnpay" required>
            <div class="payment-method-icon">💳</div>
            <div class="payment-method-name">VNPay</div>
            <div class="payment-method-desc">Thanh toán qua thẻ ngân hàng</div>
        </label>
        
        <label class="payment-method-card">
            <input type="radio" name="method" value="bank_transfer">
            <div class="payment-method-icon">🏦</div>
            <div class="payment-method-name">Chuyển Khoản</div>
            <div class="payment-method-desc">Chuyển khoản ngân hàng</div>
        </label>
    </div>
    
    <button type="submit" class="btn-continue">Tiếp Tục</button>
</form>
```

#### Bước 2: Form Thanh Toán (payment-tour-form.php)

**HTML Form:**
```html
<form id="paymentForm">
    <div class="form-section">
        <h5>Thông Tin Tài Khoản Chuyển Khoản</h5>
        
        <div class="form-group">
            <label>Chọn Ngân Hàng *</label>
            <select name="bank_name" required>
                <option value="">-- Chọn ngân hàng --</option>
                <option value="Vietcombank">Vietcombank</option>
                <option value="VietinBank">VietinBank</option>
                <option value="BIDV">BIDV</option>
                <option value="Agribank">Agribank</option>
                <option value="Techcombank">Techcombank</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Số Tài Khoản *</label>
            <input type="text" name="account_number" 
                   placeholder="Nhập số tài khoản" required>
        </div>
        
        <div class="form-group">
            <label>Tên Chủ Tài Khoản *</label>
            <input type="text" name="account_holder" 
                   placeholder="Nhập tên chủ tài khoản" required>
        </div>
        
        <div class="form-group">
            <label>Số Tiền Cần Chuyển *</label>
            <input type="number" name="transfer_amount" 
                   value="<?php echo $total_amount; ?>" required>
        </div>
    </div>
    
    <div class="form-section">
        <h5>Thông Tin Người Thanh Toán</h5>
        
        <div class="form-group">
            <label>Họ Tên *</label>
            <input type="text" name="payer_name" required>
        </div>
        
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="payer_email" required>
        </div>
        
        <div class="form-group">
            <label>Số Điện Thoại *</label>
            <input type="tel" name="payer_phone" required>
        </div>
    </div>
    
    <button type="submit" class="btn-payment">
        Xác Nhận Đã Chuyển Khoản
    </button>
</form>
```

**JavaScript AJAX:**
```javascript
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('ajax', '1');
    formData.append('booking_id', '<?php echo htmlspecialchars($booking['id']); ?>');
    
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('formContent').style.display = 'none';
            document.getElementById('successMessage').style.display = 'block';
        } else {
            alert('Lỗi: ' + data.error);
            btn.disabled = false;
            btn.innerHTML = 'Xác Nhận Đã Chuyển Khoản';
        }
    })
    .catch(error => {
        alert('Lỗi kết nối');
        btn.disabled = false;
        btn.innerHTML = 'Xác Nhận Đã Chuyển Khoản';
    });
});
```

**PHP Xử Lý AJAX:**
```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    
    $booking_id = $_POST['booking_id'] ?? '';
    $bank_name = $_POST['bank_name'] ?? '';
    $account_number = $_POST['account_number'] ?? '';
    $account_holder = $_POST['account_holder'] ?? '';
    
    try {
        // Validate
        if (empty($bank_name) || empty($account_number) || empty($account_holder)) {
            throw new Exception('Vui lòng điền đầy đủ thông tin');
        }
        
        // Lấy booking
        $query = "SELECT * FROM tour_bookings WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$booking) {
            throw new Exception('Không tìm thấy booking');
        }
        
        // Insert payment confirmation
        $insert_query = "INSERT INTO payment_confirmations 
                         (booking_code, bank_name, account_number, account_name, amount, status)
                         VALUES (:booking_code, :bank_name, :account_number, :account_holder, :amount, 'pending')";
        
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->execute([
            ':booking_code' => $booking['booking_code'],
            ':bank_name' => $bank_name,
            ':account_number' => $account_number,
            ':account_holder' => $account_holder,
            ':amount' => $booking['total_price']
        ]);
        
        echo json_encode(['success' => true]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
?>
```

## 3.8 Xử Lý Lỗi và Exception

### 3.8.1 Các Loại Lỗi Chính

| Lỗi | Nguyên Nhân | Giải Pháp |
|---|---|---|
| Validation Error | Dữ liệu không hợp lệ | Hiển thị thông báo lỗi |
| Database Error | Kết nối DB thất bại | Retry hoặc hiển thị lỗi |
| Payment Error | Thanh toán thất bại | Cho phép thử lại |
| Session Error | Session hết hạn | Redirect đến login |

### 3.8.2 Error Handling

```php
try {
    // Code chính
    if (!$data) {
        throw new Exception('Dữ liệu không hợp lệ');
    }
} catch (PDOException $e) {
    // Database error
    error_log('Database error: ' . $e->getMessage());
    throw new Exception('Lỗi kết nối database');
} catch (Exception $e) {
    // General error
    error_log('Error: ' . $e->getMessage());
    throw $e;
}
```

## 3.9 Kết Luận Chương

Chương 3 đã trình bày chi tiết về:
- Phân tích yêu cầu chức năng và phi chức năng
- Thiết kế database, API, giao diện
- Cài đặt môi trường
- Triển khai các chức năng chính với code chi tiết
- Xử lý lỗi và exception
- Testing
