// Service Modal Manager
// Quản lý modal dịch vụ du lịch

class ServiceModalManager {
    constructor() {
        this.services = this.initializeServices();
        this.init();
    }

    init() {
        this.createModalContainer();
        this.setupEventListeners();
    }

    // Khởi tạo dữ liệu dịch vụ
    initializeServices() {
        return {
            'tour-planning': {
                title: 'Lập Kế Hoạch Tour Du Lịch',
                icon: 'fas fa-route',
                color: 'blue',
                description: 'Dịch vụ tư vấn và thiết kế hành trình du lịch chuyên nghiệp, phù hợp với mọi nhu cầu và ngân sách.',
                features: [
                    {
                        icon: 'fas fa-map-marked-alt',
                        title: 'Thiết Kế Hành Trình',
                        description: 'Lập kế hoạch chi tiết từng ngày với các điểm tham quan tối ưu'
                    },
                    {
                        icon: 'fas fa-calendar-check',
                        title: 'Lịch Trình Linh Hoạt',
                        description: 'Điều chỉnh lịch trình theo yêu cầu và thời gian của bạn'
                    },
                    {
                        icon: 'fas fa-dollar-sign',
                        title: 'Tối Ưu Chi Phí',
                        description: 'Tư vấn ngân sách hợp lý và tìm kiếm ưu đãi tốt nhất'
                    },
                    {
                        icon: 'fas fa-users',
                        title: 'Tour Theo Nhóm',
                        description: 'Thiết kế tour phù hợp với gia đình, bạn bè hoặc công ty'
                    }
                ],
                packages: [
                    {
                        name: 'Tour 1 Ngày',
                        price: '500.000 VNĐ',
                        duration: '8 giờ',
                        includes: ['Xe đưa đón', 'Hướng dẫn viên', 'Vé tham quan', 'Ăn trưa']
                    },
                    {
                        name: 'Tour 2-3 Ngày',
                        price: '1.200.000 VNĐ',
                        duration: '2-3 ngày',
                        includes: ['Xe đưa đón', 'Khách sạn 3*', 'Hướng dẫn viên', 'Các bữa ăn', 'Vé tham quan']
                    },
                    {
                        name: 'Tour Trọn Gói',
                        price: 'Liên hệ',
                        duration: 'Tùy chỉnh',
                        includes: ['Thiết kế riêng', 'Dịch vụ VIP', 'Hỗ trợ 24/7', 'Bảo hiểm du lịch']
                    }
                ],
                contact: {
                    phone: '0292.3851.234',
                    email: 'tour@travinh-travel.com',
                    address: 'Số 123, Đường Nguyễn Đáng, TP. Trà Vinh'
                }
            },

            'hotel-booking': {
                title: 'Đặt Phòng Khách Sạn',
                icon: 'fas fa-hotel',
                color: 'green',
                description: 'Hỗ trợ đặt phòng tại các khách sạn, resort uy tín với giá tốt nhất và dịch vụ chất lượng.',
                features: [
                    {
                        icon: 'fas fa-bed',
                        title: 'Đa Dạng Lựa Chọn',
                        description: 'Từ khách sạn bình dân đến resort cao cấp'
                    },
                    {
                        icon: 'fas fa-percent',
                        title: 'Giá Ưu Đãi',
                        description: 'Đảm bảo giá tốt nhất với nhiều chương trình khuyến mãi'
                    },
                    {
                        icon: 'fas fa-shield-alt',
                        title: 'Đảm Bảo Chất Lượng',
                        description: 'Chỉ hợp tác với các khách sạn có uy tín và chất lượng'
                    },
                    {
                        icon: 'fas fa-clock',
                        title: 'Hỗ Trợ Nhanh Chóng',
                        description: 'Xử lý đặt phòng trong vòng 30 phút'
                    }
                ],
                packages: [
                    {
                        name: 'Khách Sạn 2-3 Sao',
                        price: '300.000 - 600.000 VNĐ',
                        duration: '/đêm',
                        includes: ['Phòng tiêu chuẩn', 'Wifi miễn phí', 'Bữa sáng', 'Dịch vụ lễ tân 24h']
                    },
                    {
                        name: 'Khách Sạn 4 Sao',
                        price: '800.000 - 1.500.000 VNĐ',
                        duration: '/đêm',
                        includes: ['Phòng cao cấp', 'Hồ bơi', 'Gym', 'Spa', 'Nhà hàng', 'Room service']
                    },
                    {
                        name: 'Resort 5 Sao',
                        price: '2.000.000+ VNĐ',
                        duration: '/đêm',
                        includes: ['Villa riêng biệt', 'Bãi biển riêng', 'Butler service', 'All-inclusive']
                    }
                ],
                contact: {
                    phone: '0292.3851.235',
                    email: 'hotel@travinh-travel.com',
                    address: 'Số 123, Đường Nguyễn Đáng, TP. Trà Vinh'
                }
            },

            'car-rental': {
                title: 'Thuê Xe Du Lịch',
                icon: 'fas fa-car',
                color: 'orange',
                description: 'Dịch vụ cho thuê xe du lịch với đội ngũ tài xế kinh nghiệm, xe mới, an toàn và giá cả hợp lý.',
                features: [
                    {
                        icon: 'fas fa-car-side',
                        title: 'Đa Dạng Loại Xe',
                        description: 'Từ xe 4 chỗ đến xe 45 chỗ, phù hợp mọi nhóm'
                    },
                    {
                        icon: 'fas fa-user-tie',
                        title: 'Tài Xế Chuyên Nghiệp',
                        description: 'Kinh nghiệm lâu năm, am hiểu địa phương'
                    },
                    {
                        icon: 'fas fa-tools',
                        title: 'Xe Được Bảo Dưỡng',
                        description: 'Định kỳ kiểm tra, bảo dưỡng đảm bảo an toàn'
                    },
                    {
                        icon: 'fas fa-route',
                        title: 'Tư Vấn Lộ Trình',
                        description: 'Gợi ý đường đi tối ưu và điểm tham quan hay'
                    }
                ],
                packages: [
                    {
                        name: 'Xe 4-7 Chỗ',
                        price: '800.000 - 1.200.000 VNĐ',
                        duration: '/ngày',
                        includes: ['Tài xế', 'Xăng', 'Phí đường', 'Nước uống', 'Khăn lạnh']
                    },
                    {
                        name: 'Xe 16-29 Chỗ',
                        price: '1.500.000 - 2.500.000 VNĐ',
                        duration: '/ngày',
                        includes: ['Tài xế', 'Xăng', 'Phí đường', 'Điều hòa', 'Micro', 'Nước uống']
                    },
                    {
                        name: 'Xe 35-45 Chỗ',
                        price: '3.000.000 - 4.000.000 VNĐ',
                        duration: '/ngày',
                        includes: ['Tài xế', 'Xăng', 'Phí đường', 'Karaoke', 'Tivi', 'Tủ lạnh mini']
                    }
                ],
                contact: {
                    phone: '0292.3851.236',
                    email: 'car@travinh-travel.com',
                    address: 'Số 123, Đường Nguyễn Đáng, TP. Trà Vinh'
                }
            },

            'support': {
                title: 'Hỗ Trợ Khách Hàng 24/7',
                icon: 'fas fa-headset',
                color: 'purple',
                description: 'Đội ngũ hỗ trợ khách hàng chuyên nghiệp, sẵn sàng giải đáp mọi thắc mắc và hỗ trợ trong suốt hành trình.',
                features: [
                    {
                        icon: 'fas fa-phone-alt',
                        title: 'Hotline 24/7',
                        description: 'Luôn sẵn sàng tiếp nhận cuộc gọi mọi lúc'
                    },
                    {
                        icon: 'fas fa-comments',
                        title: 'Chat Trực Tuyến',
                        description: 'Hỗ trợ qua website, Facebook, Zalo'
                    },
                    {
                        icon: 'fas fa-ambulance',
                        title: 'Hỗ Trợ Khẩn Cấp',
                        description: 'Xử lý nhanh chóng các tình huống bất ngờ'
                    },
                    {
                        icon: 'fas fa-language',
                        title: 'Đa Ngôn Ngữ',
                        description: 'Hỗ trợ tiếng Việt, Khmer, Anh'
                    }
                ],
                packages: [
                    {
                        name: 'Hỗ Trợ Cơ Bản',
                        price: 'Miễn Phí',
                        duration: 'Luôn luôn',
                        includes: ['Tư vấn tour', 'Thông tin địa điểm', 'Hỗ trợ đặt chỗ', 'Giải đáp thắc mắc']
                    },
                    {
                        name: 'Hỗ Trợ VIP',
                        price: '200.000 VNĐ',
                        duration: '/tour',
                        includes: ['Hỗ trợ riêng', 'Ưu tiên xử lý', 'Tư vấn chuyên sâu', 'Theo dõi hành trình']
                    },
                    {
                        name: 'Hỗ Trợ Doanh Nghiệp',
                        price: 'Thỏa thuận',
                        duration: 'Theo hợp đồng',
                        includes: ['Account manager', 'Báo cáo định kỳ', 'Ưu đãi đặc biệt', 'Hỗ trợ sự kiện']
                    }
                ],
                contact: {
                    phone: '0292.3851.237',
                    email: 'support@travinh-travel.com',
                    address: 'Số 123, Đường Nguyễn Đáng, TP. Trà Vinh'
                }
            }
        };
    }

    // Tạo container modal
    createModalContainer() {
        if (!document.getElementById('serviceModalContainer')) {
            const container = document.createElement('div');
            container.id = 'serviceModalContainer';
            container.className = 'hidden';
            document.body.appendChild(container);
        }
    }

    // Mở modal dịch vụ
    openServiceModal(serviceId) {
        const service = this.services[serviceId];
        if (!service) return;

        const modalHTML = this.createModalHTML(service);
        const container = document.getElementById('serviceModalContainer');

        container.innerHTML = modalHTML;
        container.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Animation
        setTimeout(() => {
            const modal = container.querySelector('.modal-content');
            if (modal) {
                modal.classList.add('animate-in');
            }
        }, 50);
    }

    // Tạo HTML cho modal
    createModalHTML(service) {
        return `
            <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center p-4 pt-8 modal-overlay overflow-y-auto" onclick="serviceModalManager.closeModal(event)">
                <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto modal-content transform scale-95 opacity-0 transition-all duration-300">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-${service.color}-500 to-${service.color}-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                    <i class="${service.icon} text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold">${service.title}</h2>
                                    <p class="text-${service.color}-100 mt-1">${service.description}</p>
                                </div>
                            </div>
                            <button onclick="serviceModalManager.closeModal()" class="text-white hover:text-gray-200 text-2xl">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Features -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-star text-${service.color}-500 mr-2"></i>
                                Tính Năng Nổi Bật
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                ${service.features.map(feature => `
                                    <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg hover:bg-${service.color}-50 transition-colors">
                                        <div class="bg-${service.color}-100 p-2 rounded-full flex-shrink-0">
                                            <i class="${feature.icon} text-${service.color}-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">${feature.title}</h4>
                                            <p class="text-gray-600 text-sm mt-1">${feature.description}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <!-- Packages -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-tags text-${service.color}-500 mr-2"></i>
                                Gói Dịch Vụ
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                ${service.packages.map((pkg, index) => `
                                    <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-${service.color}-300 transition-colors ${index === 1 ? 'border-' + service.color + '-300 bg-' + service.color + '-50' : ''}">
                                        <div class="text-center mb-4">
                                            <h4 class="font-bold text-lg text-gray-800">${pkg.name}</h4>
                                            <div class="text-2xl font-bold text-${service.color}-600 mt-2">${pkg.price}</div>
                                            <div class="text-gray-500 text-sm">${pkg.duration}</div>
                                        </div>
                                        <ul class="space-y-2">
                                            ${pkg.includes.map(item => `
                                                <li class="flex items-center text-sm text-gray-600">
                                                    <i class="fas fa-check text-${service.color}-500 mr-2"></i>
                                                    ${item}
                                                </li>
                                            `).join('')}
                                        </ul>
                                        <button onclick="serviceModalManager.bookService('${service.title}', '${pkg.name}')" 
                                                class="w-full mt-4 bg-${service.color}-500 text-white py-2 rounded-lg hover:bg-${service.color}-600 transition-colors">
                                            Đặt Ngay
                                        </button>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <!-- Contact -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-phone text-${service.color}-500 mr-2"></i>
                                Liên Hệ Tư Vấn
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-${service.color}-100 p-2 rounded-full">
                                        <i class="fas fa-phone text-${service.color}-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">Hotline</div>
                                        <div class="text-${service.color}-600 font-medium">${service.contact.phone}</div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="bg-${service.color}-100 p-2 rounded-full">
                                        <i class="fas fa-envelope text-${service.color}-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">Email</div>
                                        <div class="text-${service.color}-600 font-medium">${service.contact.email}</div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="bg-${service.color}-100 p-2 rounded-full">
                                        <i class="fas fa-map-marker-alt text-${service.color}-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">Địa chỉ</div>
                                        <div class="text-gray-600 text-sm">${service.contact.address}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Form Section (Hidden by default - Ẩn ở trên) -->
                        <div id="bookingFormSection" class="hidden border-t-2 border-gray-200 pt-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-edit text-${service.color}-500 mr-2"></i>
                                Đặt Dịch Vụ
                            </h3>
                            
                            <form onsubmit="return serviceModalManager.submitBookingInline(event)">
                                <input type="hidden" id="selectedService" value="">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Dịch vụ</label>
                                        <input type="text" id="serviceDisplay" readonly 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Họ tên *</label>
                                        <input type="text" name="name" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-${service.color}-500 focus:ring-2 focus:ring-${service.color}-200 focus:outline-none transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                                        <input type="tel" name="phone" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-${service.color}-500 focus:ring-2 focus:ring-${service.color}-200 focus:outline-none transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" name="email" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-${service.color}-500 focus:ring-2 focus:ring-${service.color}-200 focus:outline-none transition-all">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                                        <textarea name="note" rows="3" 
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-${service.color}-500 focus:ring-2 focus:ring-${service.color}-200 focus:outline-none transition-all resize-none"></textarea>
                                    </div>
                                </div>
                                <div class="flex space-x-3 mt-6">
                                    <button type="button" onclick="serviceModalManager.hideBookingForm()" 
                                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition-all">
                                        Hủy
                                    </button>
                                    <button type="submit" 
                                            class="px-6 py-3 bg-${service.color}-500 text-white rounded-lg hover:bg-${service.color}-600 font-semibold shadow-lg hover:shadow-xl transition-all">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Gửi Yêu Cầu
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Planning Form Section (Always visible - Ở dưới) -->
                        <div id="planningFormSection" class="border-t-2 border-gray-200 pt-8 mt-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-route text-${service.color}-500 mr-2"></i>
                                Lập Kế Hoạch Đặt Tour Du Lịch
                            </h3>
                            
                            <div class="bg-gradient-to-br from-${service.color}-50 to-white p-6 rounded-lg border-2 border-${service.color}-100">
                                <p class="text-gray-700 mb-4">
                                    <i class="fas fa-info-circle text-${service.color}-500 mr-2"></i>
                                    Vui lòng chọn gói dịch vụ phù hợp ở trên và nhấn <strong>"Đặt Ngay"</strong> để điền thông tin đặt tour.
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex items-center space-x-3 bg-white p-3 rounded-lg">
                                        <div class="bg-${service.color}-100 p-2 rounded-full">
                                            <i class="fas fa-check text-${service.color}-600"></i>
                                        </div>
                                        <span class="text-sm text-gray-700">Chọn gói tour</span>
                                    </div>
                                    <div class="flex items-center space-x-3 bg-white p-3 rounded-lg">
                                        <div class="bg-${service.color}-100 p-2 rounded-full">
                                            <i class="fas fa-edit text-${service.color}-600"></i>
                                        </div>
                                        <span class="text-sm text-gray-700">Điền thông tin</span>
                                    </div>
                                    <div class="flex items-center space-x-3 bg-white p-3 rounded-lg">
                                        <div class="bg-${service.color}-100 p-2 rounded-full">
                                            <i class="fas fa-paper-plane text-${service.color}-600"></i>
                                        </div>
                                        <span class="text-sm text-gray-700">Gửi yêu cầu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Đóng modal
    closeModal(event) {
        if (event && event.target !== event.currentTarget) return;

        const container = document.getElementById('serviceModalContainer');
        const modal = container.querySelector('.modal-content');

        if (modal) {
            modal.classList.remove('animate-in');
            modal.classList.add('animate-out');
        }

        setTimeout(() => {
            container.classList.add('hidden');
            container.innerHTML = '';
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Đặt dịch vụ - Hiển thị form đặt dịch vụ và ẩn form lập kế hoạch
    bookService(serviceName, packageName) {
        const bookingSection = document.getElementById('bookingFormSection');
        const planningSection = document.getElementById('planningFormSection');
        const serviceDisplay = document.getElementById('serviceDisplay');
        const selectedService = document.getElementById('selectedService');

        if (!bookingSection || !serviceDisplay) return;

        // Cập nhật thông tin dịch vụ
        serviceDisplay.value = `${serviceName} - ${packageName}`;
        selectedService.value = `${serviceName} - ${packageName}`;

        // Ẩn form lập kế hoạch
        if (planningSection) {
            planningSection.classList.add('hidden');
        }

        // Hiển thị form đặt dịch vụ
        bookingSection.classList.remove('hidden');

        // Scroll xuống form đặt dịch vụ
        setTimeout(() => {
            bookingSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 100);
    }

    // Ẩn form đặt dịch vụ và hiện lại form lập kế hoạch
    hideBookingForm() {
        const bookingSection = document.getElementById('bookingFormSection');
        const planningSection = document.getElementById('planningFormSection');

        if (bookingSection) {
            bookingSection.classList.add('hidden');
        }

        // Hiện lại form lập kế hoạch
        if (planningSection) {
            planningSection.classList.remove('hidden');

            // Scroll đến form lập kế hoạch
            setTimeout(() => {
                planningSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        }
    }

    // Submit form inline
    async submitBookingInline(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const serviceInfo = document.getElementById('selectedService').value;

        // Parse service info để lấy service_id
        // Format: "Tên dịch vụ - Tên gói"
        const serviceName = serviceInfo.split(' - ')[0];

        // Map tên dịch vụ sang service_id
        const serviceMap = {
            'Lập Kế Hoạch Tour Du Lịch': 1,
            'Đặt Phòng Khách Sạn': 2,
            'Thuê Xe Du Lịch': 3,
            'Hỗ Trợ Khách Hàng 24/7': 4
        };

        const booking = {
            service_id: serviceMap[serviceName] || 1,
            customer_name: formData.get('name'),
            customer_phone: formData.get('phone'),
            customer_email: formData.get('email') || '',
            service_date: null,
            number_of_people: 1,
            number_of_days: 1,
            special_requests: formData.get('note') || '',
            total_price: 0
        };

        try {
            // Gửi dữ liệu lên server
            const response = await fetch('api/service-bookings.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(booking)
            });

            const result = await response.json();

            if (result.success) {
                // Hiển thị thông báo thành công
                this.showNotification('✅ ' + result.message, 'success');

                // Reset form
                event.target.reset();

                // Hiển thị modal thanh toán
                setTimeout(() => {
                    this.showPaymentModal(result.data.booking_code, serviceInfo);
                }, 1000);
            } else {
                this.showNotification('❌ ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('❌ Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại!', 'error');
        }

        return false;
    }

    // Hiển thị modal thanh toán
    showPaymentModal(bookingCode, serviceInfo) {
        const bookingSection = document.getElementById('bookingFormSection');
        if (bookingSection) {
            bookingSection.classList.add('hidden');
        }

        // Tạo modal thanh toán
        const paymentHTML = `
            <div id="paymentSection" class="border-t-2 border-green-200 pt-8 mt-8 bg-gradient-to-br from-green-50 to-white p-6 rounded-lg">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Đặt Dịch Vụ Thành Công!</h3>
                    <p class="text-gray-600">Mã đặt dịch vụ: <span class="font-bold text-green-600">${bookingCode}</span></p>
                    <p class="text-sm text-gray-500 mt-2">${serviceInfo}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <h4 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-credit-card text-blue-500 mr-2"></i>
                        Chọn Phương Thức Thanh Toán
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button onclick="serviceModalManager.processPayment('${bookingCode}', 'vnpay')" 
                                class="payment-option-btn border-2 border-blue-200 hover:border-blue-500 bg-white hover:bg-blue-50 p-4 rounded-lg transition-all group">
                            <div class="flex flex-col items-center space-y-2">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
                                </div>
                                <span class="font-semibold text-gray-800">VNPay</span>
                                <span class="text-xs text-gray-500">Thanh toán qua VNPay</span>
                            </div>
                        </button>

                        <button onclick="serviceModalManager.processPayment('${bookingCode}', 'bank')" 
                                class="payment-option-btn border-2 border-green-200 hover:border-green-500 bg-white hover:bg-green-50 p-4 rounded-lg transition-all group">
                            <div class="flex flex-col items-center space-y-2">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                    <i class="fas fa-university text-green-600 text-2xl"></i>
                                </div>
                                <span class="font-semibold text-gray-800">Chuyển Khoản</span>
                                <span class="text-xs text-gray-500">Chuyển khoản ngân hàng</span>
                            </div>
                        </button>

                        <button onclick="serviceModalManager.processPayment('${bookingCode}', 'momo')" 
                                class="payment-option-btn border-2 border-pink-200 hover:border-pink-500 bg-white hover:bg-pink-50 p-4 rounded-lg transition-all group">
                            <div class="flex flex-col items-center space-y-2">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center group-hover:bg-pink-200 transition-colors">
                                    <i class="fas fa-wallet text-pink-600 text-2xl"></i>
                                </div>
                                <span class="font-semibold text-gray-800">MoMo</span>
                                <span class="text-xs text-gray-500">Ví điện tử MoMo</span>
                            </div>
                        </button>

                        <button onclick="serviceModalManager.skipPayment()" 
                                class="payment-option-btn border-2 border-gray-200 hover:border-gray-400 bg-white hover:bg-gray-50 p-4 rounded-lg transition-all group">
                            <div class="flex flex-col items-center space-y-2">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-money-bill-wave text-gray-600 text-2xl"></i>
                                </div>
                                <span class="font-semibold text-gray-800">Thanh toán sau</span>
                                <span class="text-xs text-gray-500">Thanh toán khi sử dụng</span>
                            </div>
                        </button>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                        <div class="text-sm text-gray-700">
                            <p class="font-semibold mb-1">Lưu ý:</p>
                            <ul class="list-disc list-inside space-y-1 text-gray-600">
                                <li>Chúng tôi sẽ liên hệ với bạn trong vòng 24h để xác nhận chi tiết</li>
                                <li>Bạn có thể thanh toán ngay hoặc thanh toán sau khi sử dụng dịch vụ</li>
                                <li>Mã đặt dịch vụ đã được gửi qua SMS/Email (nếu có)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Thêm vào modal
        const planningSection = document.getElementById('planningFormSection');
        if (planningSection) {
            planningSection.insertAdjacentHTML('beforebegin', paymentHTML);
            planningSection.classList.add('hidden');

            // Scroll đến phần thanh toán
            setTimeout(() => {
                document.getElementById('paymentSection').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 100);
        }
    }

    // Xử lý thanh toán
    processPayment(bookingCode, method) {
        if (method === 'vnpay') {
            // Chuyển đến trang thanh toán VNPay
            window.location.href = `payment-service-method.php?booking_id=${bookingCode}&method=vnpay`;
        } else if (method === 'bank') {
            // Chuyển đến trang chi tiết chuyển khoản
            window.location.href = `chi-tiet-chuyen-khoan.php?code=${bookingCode}`;
        } else if (method === 'momo') {
            // Chuyển đến trang thanh toán MoMo
            window.location.href = `payment-service-method.php?booking_id=${bookingCode}&method=momo`;
        }
    }

    // Bỏ qua thanh toán
    skipPayment() {
        this.showNotification('✅ Cảm ơn bạn! Chúng tôi sẽ liên hệ sớm nhất.', 'success');
        setTimeout(() => {
            this.closeModal();
        }, 2000);
    }

    // Gửi form đặt dịch vụ
    async submitBooking(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const serviceInfo = event.target.querySelector('input[readonly]').value;

        // Parse service info để lấy service_id
        const serviceName = serviceInfo.split(' - ')[0];

        // Map tên dịch vụ sang service_id
        const serviceMap = {
            'Lập Kế Hoạch Tour Du Lịch': 1,
            'Đặt Phòng Khách Sạn': 2,
            'Thuê Xe Du Lịch': 3,
            'Hỗ Trợ Khách Hàng 24/7': 4
        };

        const booking = {
            service_id: serviceMap[serviceName] || 1,
            customer_name: formData.get('name'),
            customer_phone: formData.get('phone'),
            customer_email: formData.get('email') || '',
            service_date: null,
            number_of_people: 1,
            number_of_days: 1,
            special_requests: formData.get('note') || '',
            total_price: 0
        };

        try {
            // Gửi dữ liệu lên server
            const response = await fetch('api/service-bookings.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(booking)
            });

            const result = await response.json();

            if (result.success) {
                // Hiển thị thông báo thành công
                this.showNotification('✅ ' + result.message, 'success');

                // Hiển thị modal thanh toán
                setTimeout(() => {
                    this.showPaymentModal(result.data.booking_code, 'Dịch vụ đã đặt');
                }, 1000);
            } else {
                this.showNotification('❌ ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('❌ Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại!', 'error');
        }

        return false;
    }

    // Hiển thị thông báo
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-[70] p-4 rounded-lg shadow-lg text-white transform translate-x-full transition-transform duration-300`;

        switch (type) {
            case 'success':
                notification.classList.add('bg-green-500');
                break;
            case 'error':
                notification.classList.add('bg-red-500');
                break;
            default:
                notification.classList.add('bg-blue-500');
        }

        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }

    // Thiết lập event listeners
    setupEventListeners() {
        // Đóng modal khi nhấn Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModal();
            }
        });
    }
}

// Khởi tạo ServiceModalManager
let serviceModalManager;

document.addEventListener('DOMContentLoaded', function () {
    serviceModalManager = new ServiceModalManager();
});

// Hàm global để sử dụng trong HTML
function openServiceModal(serviceId) {
    if (serviceModalManager) {
        serviceModalManager.openServiceModal(serviceId);
    }
}

// CSS cho animation
const modalStyles = `
    .modal-content.animate-in {
        transform: scale(1);
        opacity: 1;
    }
    
    .modal-content.animate-out {
        transform: scale(0.95);
        opacity: 0;
    }
    
    .service-card {
        transition: all 0.3s ease;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
`;

// Inject styles
if (!document.querySelector('#service-modal-styles')) {
    const styleSheet = document.createElement('style');
    styleSheet.id = 'service-modal-styles';
    styleSheet.textContent = modalStyles;
    document.head.appendChild(styleSheet);
}