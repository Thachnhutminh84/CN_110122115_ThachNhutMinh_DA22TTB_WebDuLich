<!-- Modal Lập Kế Hoạch Tour -->
<div class="modal fade" id="tourModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-route me-2"></i>Lập Kế Hoạch Tour Du Lịch</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="tourForm">
                    <input type="hidden" name="service_id" value="1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Họ và tên *</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số điện thoại *</label>
                            <input type="tel" name="customer_phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="customer_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày khởi hành</label>
                            <input type="date" name="service_date" class="form-control" id="tourStartDate">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày về</label>
                            <input type="date" name="return_date" class="form-control" id="tourReturnDate">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số người</label>
                            <input type="number" name="number_of_people" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số ngày</label>
                            <input type="number" name="number_of_days" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Yêu cầu đặc biệt</label>
                            <textarea name="special_requests" class="form-control" rows="3" placeholder="Nhập yêu cầu của bạn..."></textarea>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Chúng tôi sẽ liên hệ với bạn trong vòng 24h để xác nhận và tư vấn chi tiết.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="submitBookingWithPayment('tourForm')">
                    <i class="fas fa-paper-plane me-2"></i>Đặt Dịch Vụ
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Đặt Phòng Khách Sạn -->
<div class="modal fade" id="hotelModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-hotel me-2"></i>Đặt Phòng Khách Sạn</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="hotelForm">
                    <input type="hidden" name="service_id" value="2">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Họ và tên *</label>
                            <input type="text" name="customer_name" class="form-control" required placeholder="Nhập họ và tên">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số điện thoại *</label>
                            <input type="tel" name="customer_phone" class="form-control" required placeholder="Nhập số điện thoại">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="customer_email" class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Du Lịch Ở Đâu *</label>
                            <input type="text" name="destination" class="form-control" id="hotelDestination" placeholder="VD: Hà Nội, Sapa, Hạ Long, Đà Nẵng..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Chọn Khách Sạn *</label>
                            <select name="hotel_id" class="form-select" id="hotelSelect" required>
                                <option value="">-- Chọn khách sạn --</option>
                                <option value="1">Khách Sạn A - Ba Động</option>
                                <option value="2">Khách Sạn B - Trà Vinh</option>
                                <option value="3">Khách Sạn C - Chợ Lớn</option>
                                <option value="4">Khách Sạn D - Sông Hậu</option>
                                <option value="5">Khách Sạn E - Trung Tâm</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày nhận phòng</label>
                            <input type="date" name="service_date" class="form-control" id="hotelCheckinDate">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày trả phòng</label>
                            <input type="date" name="return_date" class="form-control" id="hotelCheckoutDate">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số người</label>
                            <input type="number" name="number_of_people" class="form-control" value="2" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số đêm</label>
                            <input type="number" name="number_of_days" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Yêu cầu đặc biệt</label>
                            <textarea name="special_requests" class="form-control" rows="3" placeholder="Loại phòng, tầng, view..."></textarea>
                        </div>
                    </div>
                    <div class="alert alert-success mt-3 mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        Chúng tôi sẽ tìm kiếm và đề xuất các khách sạn phù hợp nhất cho bạn.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success" onclick="submitBookingWithPayment('hotelForm')">
                    <i class="fas fa-paper-plane me-2"></i>Đặt Dịch Vụ
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thuê Xe Du Lịch -->
<div class="modal fade" id="carModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-car me-2"></i>Thuê Xe Du Lịch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="carForm">
                    <input type="hidden" name="service_id" value="3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Họ và tên *</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số điện thoại *</label>
                            <input type="tel" name="customer_phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="customer_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày thuê xe</label>
                            <input type="date" name="service_date" class="form-control">
                        </div>
                         <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày trả xe</label>
                            <input type="date" name="service_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số chỗ ngồi</label>
                            <select name="number_of_people" class="form-select">
                                <option value="4">4-7 chỗ</option>
                                <option value="16">16-29 chỗ</option>
                                <option value="35">35-45 chỗ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số ngày thuê</label>
                            <input type="number" name="number_of_days" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Lộ trình & Yêu cầu</label>
                            <textarea name="special_requests" class="form-control" rows="3" placeholder="Điểm đón, điểm đến, lộ trình..."></textarea>
                        </div>
                    </div>
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="fas fa-car-side me-2"></i>
                        Giá thuê xe đã bao gồm tài xế, xăng và phí đường.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-warning" onclick="submitBookingWithPayment('carForm')">
                    <i class="fas fa-paper-plane me-2"></i>Đặt Dịch Vụ
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hỗ Trợ 24/7 -->
<div class="modal fade" id="supportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-headset me-2"></i>Hỗ Trợ Khách Hàng 24/7</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-phone-alt fs-4 text-info"></i>
                                </div>
                                <h5 class="fw-bold">Hotline</h5>
                                <p class="text-info fs-4 fw-bold mb-2">0292.3851.237</p>
                                <p class="text-muted small mb-0">Hỗ trợ 24/7</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-envelope fs-4 text-success"></i>
                                </div>
                                <h5 class="fw-bold">Email</h5>
                                <p class="text-success fw-bold mb-2">support@travinh-travel.com</p>
                                <p class="text-muted small mb-0">Phản hồi trong 2h</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fab fa-facebook fs-4 text-primary"></i>
                                </div>
                                <h5 class="fw-bold">Facebook</h5>
                                <p class="text-primary fw-bold mb-2">Du Lịch Trà Vinh</p>
                                <p class="text-muted small mb-0">Chat trực tuyến</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-map-marker-alt fs-4 text-warning"></i>
                                </div>
                                <h5 class="fw-bold">Văn Phòng</h5>
                                <p class="fw-bold mb-2">Số 123, Đường Nguyễn Đáng</p>
                                <p class="text-muted small mb-0">TP. Trà Vinh</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Thanh Toán -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>Đặt Dịch Vụ Thành Công!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="fw-bold">Yêu cầu của bạn đã được gửi thành công!</h5>
                    <p class="text-muted">Mã đặt dịch vụ: <span class="fw-bold text-success" id="bookingCodeDisplay"></span></p>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Chúng tôi sẽ liên hệ với bạn trong vòng 24h để xác nhận chi tiết dịch vụ.
                </div>

                <h6 class="fw-bold mb-3">
                    <i class="fas fa-credit-card me-2"></i>Chọn phương thức thanh toán
                </h6>

                <div class="d-grid gap-3">
                    <button class="btn btn-primary btn-lg" onclick="processPaymentMethod('vnpay')">
                        <i class="fas fa-credit-card me-2"></i>
                        Thanh Toán Ngay (VNPay)
                    </button>
                    
                    <button class="btn btn-info btn-lg" onclick="processPaymentMethod('bank')">
                        <i class="fas fa-university me-2"></i>
                        Chuyển khoản ngân hàng
                    </button>

                    <button class="btn btn-success btn-lg" onclick="processPaymentMethod('momo')">
                        <i class="fas fa-wallet me-2"></i>
                        Thanh Toán Momo
                    </button>
                    
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-clock me-2"></i>
                        Thanh toán sau
                    </button>
                </div>
                
                <div class="alert alert-info mt-3 mb-0">
                    <small>
                        <i class="fas fa-info-circle me-1"></i>
                        Chuyển khoản ngân hàng: Nhanh chóng, an toàn và được xác nhận trong 30 phút
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentBookingCode = '';



// Hàm submit booking với thanh toán
async function submitBookingWithPayment(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const formData = new FormData(form);
    
    // Tạo object booking
    const booking = {
        service_id: formData.get('service_id'),
        customer_name: formData.get('customer_name'),
        customer_phone: formData.get('customer_phone'),
        customer_email: formData.get('customer_email') || '',
        service_date: formData.get('service_date') || null,
        number_of_people: formData.get('number_of_people') || 1,
        number_of_days: formData.get('number_of_days') || 1,
        special_requests: formData.get('special_requests') || '',
        total_price: 0
    };

    // Hiển thị loading
    const submitBtn = form.closest('.modal').querySelector('.modal-footer button[onclick*="submitBooking"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';

    try {
        const response = await fetch('api/service-bookings.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(booking)
        });

        const result = await response.json();

        if (result.success) {
            // Lưu booking code
            currentBookingCode = result.data.booking_code;
            
            // Đóng modal hiện tại
            const currentModal = bootstrap.Modal.getInstance(form.closest('.modal'));
            if (currentModal) {
                currentModal.hide();
            }

            // Hiển thị modal thanh toán
            document.getElementById('bookingCodeDisplay').textContent = currentBookingCode;
            const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();

            // Reset form
            form.reset();
        } else {
            alert('Lỗi: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại!');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}

// Xử lý thanh toán
function processPaymentMethod(method) {
    if (!currentBookingCode) {
        alert('Không tìm thấy mã đặt dịch vụ');
        return;
    }

    if (method === 'vnpay') {
        // Chuyển đến trang thanh toán VNPay
        window.location.href = `payment-service-method.php?booking_id=${currentBookingCode}&method=vnpay`;
    } else if (method === 'bank') {
        // Chuyển đến trang chi tiết chuyển khoản
        window.location.href = `chi-tiet-chuyen-khoan.php?code=${currentBookingCode}`;
    } else if (method === 'momo') {
        // Chuyển đến trang thanh toán MoMo
        window.location.href = `payment-service-method.php?booking_id=${currentBookingCode}&method=momo`;
    }
}

// Hàm cũ để tương thích
function submitBooking(formId) {
    submitBookingWithPayment(formId);
}
</script>
