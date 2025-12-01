// ===== HỆ THỐNG ĐẶT LỊCH TOUR MỚI - KHÔNG LỖI =====

class TourBookingSystem {
    constructor() {
        this.bookings = [];
        this.currentBooking = null;
        this.init();
    }

    init() {
        console.log('🚀 Tour Booking System initialized');
        this.loadBookingsFromStorage();
    }

    // Mở modal đặt lịch
    openBookingModal(attractionId) {
        console.log('📅 Opening booking modal for:', attractionId);
        
        // Lấy thông tin địa điểm
        const attraction = this.getAttractionInfo(attractionId);
        if (!attraction) {
            this.showError('Không tìm thấy thông tin địa điểm');
            return;
        }

        // Đóng modal chi tiết nếu đang mở
        this.closeDetailModal();

        // Tạo modal đặt lịch
        const modalHTML = this.createBookingModalHTML(attraction);
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Thiết lập sự kiện
        this.setupBookingModalEvents(attractionId);
        
        // Thiết lập ngày tối thiểu (hôm nay)
        this.setupDateConstraints();
    }

    // Lấy thông tin địa điểm
    getAttractionInfo(attractionId) {
        // Sử dụng function có sẵn từ hệ thống chi tiết
        if (typeof getAttractionDetails === 'function') {
            return getAttractionDetails(attractionId);
        }
        
        // Fallback data đầy đủ cho tất cả địa điểm
        const fallbackData = {
            aobaom: { name: 'Ao Bà Om', ticketPrice: 'Miễn phí' },
            chuaang: { name: 'Chùa Âng', ticketPrice: 'Miễn phí' },
            chuavamray: { name: 'Chùa Vàm Rây', ticketPrice: 'Miễn phí' },
            bienbadong: { name: 'Biển Ba Động', ticketPrice: 'Miễn phí' },
            rungduoc: { name: 'Rừng Đước', ticketPrice: '50.000 VNĐ' },
            conchim: { name: 'Cồn Chim', ticketPrice: 'Miễn phí' },
            chuahang: { name: 'Chùa Hang', ticketPrice: 'Miễn phí' },
            somrongek: { name: 'Chùa Somrong Ek', ticketPrice: 'Miễn phí' },
            denbacho: { name: 'Đền Thờ Bác Hồ', ticketPrice: 'Miễn phí' },
            nhathoducmy: { name: 'Nhà Thờ Đức Mỹ', ticketPrice: 'Miễn phí' },
            chuacanh: { name: 'Chùa Cành', ticketPrice: 'Miễn phí' },
            baotangkhmer: { name: 'Bảo tàng Khmer', ticketPrice: '20.000 VNĐ' },
            thienvientriclam: { name: 'Thiền viện Trúc Lâm', ticketPrice: 'Miễn phí' },
            chuaphuongthanhpisay: { name: 'Chùa Phương Thạnh Pisay', ticketPrice: 'Miễn phí' },
            nhathomacbac: { name: 'Nhà Thờ Mặc Bắc', ticketPrice: 'Miễn phí' }
        };
        
        return fallbackData[attractionId] || { name: 'Địa điểm du lịch', ticketPrice: 'Liên hệ' };
    }

    // Tạo HTML modal đặt lịch
    createBookingModalHTML(attraction) {
        return `
            <div class="booking-modal-overlay" id="bookingModal" onclick="tourBooking.closeBookingModal()">
                <div class="booking-modal-content" onclick="event.stopPropagation()">
                    <div class="booking-modal-header">
                        <h2>📅 Đặt Tour - ${attraction.name}</h2>
                        <button class="booking-close-btn" onclick="tourBooking.closeBookingModal()">&times;</button>
                    </div>
                    
                    <div class="booking-modal-body">
                        <div class="attraction-summary">
                            <div class="attraction-info">
                                <h3>${attraction.name}</h3>
                                <p class="price">💰 Giá vé: ${attraction.ticketPrice}</p>
                            </div>
                        </div>
                        
                        <form class="booking-form" id="bookingForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="customerName">
                                        <i class="fas fa-user"></i>
                                        Họ và tên <span class="required">*</span>
                                    </label>
                                    <input type="text" id="customerName" name="customerName" required 
                                           placeholder="Nhập họ và tên đầy đủ">
                                    <div class="error-message" id="nameError"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="customerPhone">
                                        <i class="fas fa-phone"></i>
                                        Số điện thoại <span class="required">*</span>
                                    </label>
                                    <input type="tel" id="customerPhone" name="customerPhone" required 
                                           placeholder="0xxx xxx xxx" pattern="[0-9]{10,11}">
                                    <div class="error-message" id="phoneError"></div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="customerEmail">
                                        <i class="fas fa-envelope"></i>
                                        Email
                                    </label>
                                    <input type="email" id="customerEmail" name="customerEmail" 
                                           placeholder="email@example.com">
                                    <div class="error-message" id="emailError"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="tourDate">
                                        <i class="fas fa-calendar"></i>
                                        Ngày tham quan <span class="required">*</span>
                                    </label>
                                    <input type="date" id="tourDate" name="tourDate" required>
                                    <div class="error-message" id="dateError"></div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="numberOfPeople">
                                        <i class="fas fa-users"></i>
                                        Số người <span class="required">*</span>
                                    </label>
                                    <select id="numberOfPeople" name="numberOfPeople" required>
                                        <option value="">Chọn số người</option>
                                        <option value="1">1 người</option>
                                        <option value="2">2 người</option>
                                        <option value="3">3 người</option>
                                        <option value="4">4 người</option>
                                        <option value="5">5 người</option>
                                        <option value="6">6 người</option>
                                        <option value="7">7 người</option>
                                        <option value="8">8 người</option>
                                        <option value="9">9 người</option>
                                        <option value="10">10 người</option>
                                        <option value="more">Hơn 10 người</option>
                                    </select>
                                    <div class="error-message" id="peopleError"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="tourTime">
                                        <i class="fas fa-clock"></i>
                                        Thời gian
                                    </label>
                                    <select id="tourTime" name="tourTime">
                                        <option value="">Chọn thời gian</option>
                                        <option value="morning">Sáng (8:00 - 11:00)</option>
                                        <option value="afternoon">Chiều (14:00 - 17:00)</option>
                                        <option value="fullday">Cả ngày (8:00 - 17:00)</option>
                                        <option value="flexible">Linh hoạt</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="specialRequests">
                                    <i class="fas fa-comment"></i>
                                    Yêu cầu đặc biệt
                                </label>
                                <textarea id="specialRequests" name="specialRequests" rows="3" 
                                          placeholder="Ví dụ: Cần hướng dẫn viên, có trẻ em, người cao tuổi..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="notes">
                                    <i class="fas fa-sticky-note"></i>
                                    Ghi chú thêm
                                </label>
                                <textarea id="notes" name="notes" rows="2" 
                                          placeholder="Thông tin bổ sung khác..."></textarea>
                            </div>
                        </form>
                    </div>
                    
                    <div class="booking-modal-footer">
                        <button type="button" class="btn-secondary" onclick="tourBooking.closeBookingModal()">
                            <i class="fas fa-times"></i>
                            Hủy bỏ
                        </button>
                        <button type="button" class="btn-primary" onclick="tourBooking.submitBooking()">
                            <i class="fas fa-paper-plane"></i>
                            Gửi yêu cầu đặt tour
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Thiết lập sự kiện cho modal
    setupBookingModalEvents(attractionId) {
        this.currentBooking = { attractionId };
        
        // Validation real-time
        const nameInput = document.getElementById('customerName');
        const phoneInput = document.getElementById('customerPhone');
        const emailInput = document.getElementById('customerEmail');
        
        if (nameInput) {
            nameInput.addEventListener('blur', () => this.validateName());
        }
        
        if (phoneInput) {
            phoneInput.addEventListener('blur', () => this.validatePhone());
        }
        
        if (emailInput) {
            emailInput.addEventListener('blur', () => this.validateEmail());
        }
    }

    // Thiết lập ràng buộc ngày
    setupDateConstraints() {
        const dateInput = document.getElementById('tourDate');
        if (dateInput) {
            // Ngày tối thiểu là hôm nay
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
            
            // Ngày tối đa là 6 tháng sau
            const maxDate = new Date();
            maxDate.setMonth(maxDate.getMonth() + 6);
            dateInput.max = maxDate.toISOString().split('T')[0];
        }
    }

    // Validation các trường
    validateName() {
        const nameInput = document.getElementById('customerName');
        const nameError = document.getElementById('nameError');
        
        if (!nameInput || !nameError) return false;
        
        const name = nameInput.value.trim();
        
        if (!name) {
            this.showFieldError(nameError, 'Vui lòng nhập họ và tên');
            return false;
        }
        
        if (name.length < 2) {
            this.showFieldError(nameError, 'Họ tên phải có ít nhất 2 ký tự');
            return false;
        }
        
        this.clearFieldError(nameError);
        return true;
    }

    validatePhone() {
        const phoneInput = document.getElementById('customerPhone');
        const phoneError = document.getElementById('phoneError');
        
        if (!phoneInput || !phoneError) return false;
        
        const phone = phoneInput.value.trim();
        
        if (!phone) {
            this.showFieldError(phoneError, 'Vui lòng nhập số điện thoại');
            return false;
        }
        
        const phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneRegex.test(phone)) {
            this.showFieldError(phoneError, 'Số điện thoại không hợp lệ (10-11 số)');
            return false;
        }
        
        this.clearFieldError(phoneError);
        return true;
    }

    validateEmail() {
        const emailInput = document.getElementById('customerEmail');
        const emailError = document.getElementById('emailError');
        
        if (!emailInput || !emailError) return true; // Email không bắt buộc
        
        const email = emailInput.value.trim();
        
        if (email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                this.showFieldError(emailError, 'Email không hợp lệ');
                return false;
            }
        }
        
        this.clearFieldError(emailError);
        return true;
    }

    // Hiển thị lỗi field
    showFieldError(errorElement, message) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    // Xóa lỗi field
    clearFieldError(errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
    }

    // Gửi đặt tour
    submitBooking() {
        console.log('📝 Submitting booking...');
        
        // Validate tất cả các trường
        const isNameValid = this.validateName();
        const isPhoneValid = this.validatePhone();
        const isEmailValid = this.validateEmail();
        
        // Kiểm tra ngày
        const dateInput = document.getElementById('tourDate');
        const dateError = document.getElementById('dateError');
        const peopleSelect = document.getElementById('numberOfPeople');
        const peopleError = document.getElementById('peopleError');
        
        let isDateValid = true;
        let isPeopleValid = true;
        
        if (!dateInput.value) {
            this.showFieldError(dateError, 'Vui lòng chọn ngày tham quan');
            isDateValid = false;
        } else {
            this.clearFieldError(dateError);
        }
        
        if (!peopleSelect.value) {
            this.showFieldError(peopleError, 'Vui lòng chọn số người');
            isPeopleValid = false;
        } else {
            this.clearFieldError(peopleError);
        }
        
        // Nếu có lỗi, không gửi
        if (!isNameValid || !isPhoneValid || !isEmailValid || !isDateValid || !isPeopleValid) {
            this.showError('Vui lòng kiểm tra lại thông tin đã nhập');
            return;
        }
        
        // Thu thập dữ liệu
        const bookingData = this.collectBookingData();
        
        // Lưu booking
        this.saveBooking(bookingData);
        
        // Hiển thị thành công
        this.showBookingSuccess(bookingData);
        
        // Đóng modal
        this.closeBookingModal();
    }

    // Thu thập dữ liệu đặt tour
    collectBookingData() {
        const attraction = this.getAttractionInfo(this.currentBooking.attractionId);
        
        return {
            id: this.generateBookingId(),
            attractionId: this.currentBooking.attractionId,
            attractionName: attraction.name,
            customerName: document.getElementById('customerName').value.trim(),
            customerPhone: document.getElementById('customerPhone').value.trim(),
            customerEmail: document.getElementById('customerEmail').value.trim(),
            tourDate: document.getElementById('tourDate').value,
            numberOfPeople: document.getElementById('numberOfPeople').value,
            tourTime: document.getElementById('tourTime').value,
            specialRequests: document.getElementById('specialRequests').value.trim(),
            notes: document.getElementById('notes').value.trim(),
            bookingTime: new Date().toISOString(),
            status: 'pending'
        };
    }

    // Tạo ID booking
    generateBookingId() {
        return 'BK' + Date.now() + Math.random().toString(36).substr(2, 5).toUpperCase();
    }

    // Lưu booking
    saveBooking(bookingData) {
        this.bookings.push(bookingData);
        this.saveBookingsToStorage();
        console.log('💾 Booking saved:', bookingData);
    }

    // Hiển thị thành công
    showBookingSuccess(bookingData) {
        const timeText = this.getTimeText(bookingData.tourTime);
        const peopleText = bookingData.numberOfPeople === 'more' ? 'Hơn 10 người' : bookingData.numberOfPeople + ' người';
        
        const message = `
✅ Đặt tour thành công!

📋 Thông tin đặt tour:
🎯 Địa điểm: ${bookingData.attractionName}
👤 Khách hàng: ${bookingData.customerName}
📞 Điện thoại: ${bookingData.customerPhone}
📅 Ngày: ${this.formatDate(bookingData.tourDate)}
👥 Số người: ${peopleText}
⏰ Thời gian: ${timeText}
🆔 Mã đặt tour: ${bookingData.id}

📞 Chúng tôi sẽ liên hệ với bạn trong vòng 24h để xác nhận!
        `;
        
        alert(message);
    }

    // Chuyển đổi text thời gian
    getTimeText(timeValue) {
        const timeMap = {
            'morning': 'Sáng (8:00 - 11:00)',
            'afternoon': 'Chiều (14:00 - 17:00)',
            'fullday': 'Cả ngày (8:00 - 17:00)',
            'flexible': 'Linh hoạt'
        };
        return timeMap[timeValue] || 'Chưa chọn';
    }

    // Format ngày
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    // Đóng modal chi tiết
    closeDetailModal() {
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.remove();
        }
    }

    // Đóng modal đặt lịch
    closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.remove();
        }
        this.currentBooking = null;
    }

    // Hiển thị lỗi
    showError(message) {
        alert('❌ Lỗi: ' + message);
    }

    // Lưu vào localStorage
    saveBookingsToStorage() {
        try {
            localStorage.setItem('tourBookings', JSON.stringify(this.bookings));
        } catch (e) {
            console.error('Cannot save to localStorage:', e);
        }
    }

    // Load từ localStorage
    loadBookingsFromStorage() {
        try {
            const saved = localStorage.getItem('tourBookings');
            if (saved) {
                this.bookings = JSON.parse(saved);
                console.log('📚 Loaded bookings:', this.bookings.length);
            }
        } catch (e) {
            console.error('Cannot load from localStorage:', e);
            this.bookings = [];
        }
    }

    // Lấy danh sách booking
    getBookings() {
        return this.bookings;
    }

    // Xóa booking
    deleteBooking(bookingId) {
        this.bookings = this.bookings.filter(b => b.id !== bookingId);
        this.saveBookingsToStorage();
    }
}

// Khởi tạo hệ thống
const tourBooking = new TourBookingSystem();

// Export cho global scope
window.tourBooking = tourBooking;
window.openBookingModal = (attractionId) => tourBooking.openBookingModal(attractionId);

console.log('✅ Tour Booking System loaded successfully!');