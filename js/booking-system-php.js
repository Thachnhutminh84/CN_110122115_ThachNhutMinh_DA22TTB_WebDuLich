/**
 * Hệ thống đặt tour PHP - Client Side
 * Kết nối với PHP API và MySQL Database
 */

class TourBookingPHP {
    constructor() {
        this.apiBaseUrl = 'api/';
        this.currentBooking = null;
        this.attractions = [];
        this.init();
    }

    async init() {
        console.log('🚀 Tour Booking PHP System initialized');
        await this.loadAttractions();
    }

    /**
     * Load danh sách attractions từ API
     */
    async loadAttractions() {
        try {
            const response = await fetch(`${this.apiBaseUrl}attractions.php`);
            const result = await response.json();
            
            if (result.success) {
                this.attractions = result.data;
                console.log('✅ Loaded attractions:', this.attractions.length);
            } else {
                console.error('❌ Error loading attractions:', result.message);
            }
        } catch (error) {
            console.error('❌ Network error loading attractions:', error);
        }
    }

    /**
     * Lấy thông tin attraction theo ID
     */
    async getAttractionInfo(attractionId) {
        try {
            const response = await fetch(`${this.apiBaseUrl}attractions.php?attraction_id=${attractionId}`);
            const result = await response.json();
            
            if (result.success) {
                return result.data;
            } else {
                console.error('❌ Error getting attraction:', result.message);
                return null;
            }
        } catch (error) {
            console.error('❌ Network error getting attraction:', error);
            return null;
        }
    }

    /**
     * Mở modal đặt lịch
     */
    async openBookingModal(attractionId) {
        console.log('📅 Opening booking modal for:', attractionId);
        
        // Lấy thông tin địa điểm từ API
        const attraction = await this.getAttractionInfo(attractionId);
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

    /**
     * Tạo HTML modal đặt lịch
     */
    createBookingModalHTML(attraction) {
        return `
            <div class="booking-modal-overlay" id="bookingModal" onclick="tourBookingPHP.closeBookingModal()">
                <div class="booking-modal-content" onclick="event.stopPropagation()">
                    <div class="booking-modal-header">
                        <h2>📅 Đặt Tour - ${attraction.name}</h2>
                        <button class="booking-close-btn" onclick="tourBookingPHP.closeBookingModal()">&times;</button>
                    </div>
                    
                    <div class="booking-modal-body">
                        <div class="attraction-summary">
                            <div class="attraction-info">
                                <h3>${attraction.name}</h3>
                                <p class="price">💰 Giá vé: ${attraction.ticket_price}</p>
                                <p class="location">📍 Địa điểm: ${attraction.location || 'Trà Vinh'}</p>
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
                                        <option value="15">15 người</option>
                                        <option value="20">20 người</option>
                                        <option value="30">30+ người</option>
                                    </select>
                                    <div class="error-message" id="peopleError"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="tourTime">
                                        <i class="fas fa-clock"></i>
                                        Thời gian
                                    </label>
                                    <select id="tourTime" name="tourTime">
                                        <option value="flexible">Linh hoạt</option>
                                        <option value="morning">Sáng (8:00 - 11:00)</option>
                                        <option value="afternoon">Chiều (14:00 - 17:00)</option>
                                        <option value="fullday">Cả ngày (8:00 - 17:00)</option>
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
                        <button type="button" class="btn-secondary" onclick="tourBookingPHP.closeBookingModal()">
                            <i class="fas fa-times"></i>
                            Hủy bỏ
                        </button>
                        <button type="button" class="btn-primary" onclick="tourBookingPHP.submitBooking()" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            Gửi yêu cầu đặt tour
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Thiết lập sự kiện cho modal
     */
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

    /**
     * Thiết lập ràng buộc ngày
     */
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

    /**
     * Validation các trường
     */
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

    /**
     * Hiển thị lỗi field
     */
    showFieldError(errorElement, message) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    /**
     * Xóa lỗi field
     */
    clearFieldError(errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
    }

    /**
     * Gửi đặt tour
     */
    async submitBooking() {
        console.log('📝 Submitting booking...');
        
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Disable button và hiển thị loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        
        try {
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
                throw new Error('Vui lòng kiểm tra lại thông tin đã nhập');
            }
            
            // Thu thập dữ liệu
            const bookingData = this.collectBookingData();
            
            // Gửi API request
            const response = await fetch(`${this.apiBaseUrl}booking.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(bookingData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Hiển thị thành công
                this.showBookingSuccess(result.data);
                
                // Đóng modal
                this.closeBookingModal();
            } else {
                throw new Error(result.message || 'Có lỗi xảy ra khi đặt tour');
            }
            
        } catch (error) {
            console.error('❌ Booking error:', error);
            this.showError(error.message);
        } finally {
            // Restore button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }

    /**
     * Thu thập dữ liệu đặt tour
     */
    collectBookingData() {
        return {
            attraction_id: this.currentBooking.attractionId,
            customer_name: document.getElementById('customerName').value.trim(),
            customer_phone: document.getElementById('customerPhone').value.trim(),
            customer_email: document.getElementById('customerEmail').value.trim(),
            tour_date: document.getElementById('tourDate').value,
            number_of_people: parseInt(document.getElementById('numberOfPeople').value),
            tour_time: document.getElementById('tourTime').value,
            special_requests: document.getElementById('specialRequests').value.trim(),
            notes: document.getElementById('notes').value.trim(),
            total_amount: 0 // Sẽ tính sau
        };
    }

    /**
     * Hiển thị thành công
     */
    showBookingSuccess(bookingData) {
        const timeText = this.getTimeText(bookingData.tour_time || 'flexible');
        const peopleText = bookingData.number_of_people + ' người';
        
        const message = `
✅ Đặt tour thành công!

📋 Thông tin đặt tour:
🎯 Địa điểm: ${bookingData.attraction_name}
👤 Khách hàng: ${bookingData.customer_name}
📞 Điện thoại: ${bookingData.customer_phone}
📅 Ngày: ${this.formatDate(bookingData.tour_date)}
👥 Số người: ${peopleText}
⏰ Thời gian: ${timeText}
🆔 Mã đặt tour: ${bookingData.booking_id}

📞 Chúng tôi sẽ liên hệ với bạn trong vòng 24h để xác nhận!

💡 Lưu lại mã đặt tour để tra cứu sau này.
        `;
        
        alert(message);
    }

    /**
     * Chuyển đổi text thời gian
     */
    getTimeText(timeValue) {
        const timeMap = {
            'morning': 'Sáng (8:00 - 11:00)',
            'afternoon': 'Chiều (14:00 - 17:00)',
            'fullday': 'Cả ngày (8:00 - 17:00)',
            'flexible': 'Linh hoạt'
        };
        return timeMap[timeValue] || 'Linh hoạt';
    }

    /**
     * Format ngày
     */
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    /**
     * Đóng modal chi tiết
     */
    closeDetailModal() {
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.remove();
        }
    }

    /**
     * Đóng modal đặt lịch
     */
    closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.remove();
        }
        this.currentBooking = null;
    }

    /**
     * Hiển thị lỗi
     */
    showError(message) {
        alert('❌ Lỗi: ' + message);
    }

    /**
     * Lấy danh sách bookings (cho admin)
     */
    async getBookings(params = {}) {
        try {
            const queryString = new URLSearchParams(params).toString();
            const response = await fetch(`${this.apiBaseUrl}booking.php?${queryString}`);
            const result = await response.json();
            
            if (result.success) {
                return result.data;
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('❌ Error getting bookings:', error);
            throw error;
        }
    }

    /**
     * Cập nhật trạng thái booking (cho admin)
     */
    async updateBookingStatus(bookingId, status, reason = '') {
        try {
            const response = await fetch(`${this.apiBaseUrl}booking.php`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    booking_id: bookingId,
                    status: status,
                    reason: reason,
                    changed_by: 'Admin'
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                return true;
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('❌ Error updating booking status:', error);
            throw error;
        }
    }
}

// Khởi tạo hệ thống
const tourBookingPHP = new TourBookingPHP();

// Export cho global scope
window.tourBookingPHP = tourBookingPHP;
window.openBookingModal = (attractionId) => tourBookingPHP.openBookingModal(attractionId);

console.log('✅ Tour Booking PHP System loaded successfully!');