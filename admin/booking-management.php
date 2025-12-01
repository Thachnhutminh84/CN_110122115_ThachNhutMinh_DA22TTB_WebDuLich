<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đặt Tour - PHP MySQL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-pending { @apply bg-yellow-100 text-yellow-800; }
        .status-confirmed { @apply bg-green-100 text-green-800; }
        .status-cancelled { @apply bg-red-100 text-red-800; }
        .status-completed { @apply bg-blue-100 text-blue-800; }
        
        .booking-card {
            transition: all 0.3s ease;
        }
        
        .booking-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-calendar-check text-blue-600 mr-2"></i>
                        Quản Lý Đặt Tour
                    </h1>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        PHP + MySQL
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="refreshBookings()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Làm mới
                    </button>
                    <a href="../index.php" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-home mr-2"></i>
                        Về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Statistics Cards -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tổng Booking</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalBookings">-</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Chờ xác nhận</p>
                        <p class="text-2xl font-bold text-gray-900" id="pendingBookings">-</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Đã xác nhận</p>
                        <p class="text-2xl font-bold text-gray-900" id="confirmedBookings">-</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tổng khách</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalPeople">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                    <input type="text" id="searchInput" placeholder="Tên, SĐT, Mã booking..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                    <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending">Chờ xác nhận</option>
                        <option value="confirmed">Đã xác nhận</option>
                        <option value="cancelled">Đã hủy</option>
                        <option value="completed">Hoàn thành</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Từ ngày</label>
                    <input type="date" id="dateFrom" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Đến ngày</label>
                    <input type="date" id="dateTo" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="mt-4 flex space-x-3">
                <button onclick="searchBookings()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Tìm kiếm
                </button>
                <button onclick="clearFilters()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Xóa bộ lọc
                </button>
            </div>
        </div>

        <!-- Bookings List -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Danh Sách Đặt Tour</h3>
            </div>
            
            <div id="loadingIndicator" class="p-8 text-center">
                <div class="loading mx-auto mb-4"></div>
                <p class="text-gray-600">Đang tải dữ liệu...</p>
            </div>
            
            <div id="bookingsList" class="hidden">
                <!-- Bookings sẽ được load bằng JavaScript -->
            </div>
            
            <div id="noBookings" class="hidden p-8 text-center">
                <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-600">Không có booking nào được tìm thấy</p>
            </div>
        </div>
    </div>

    <!-- Booking Detail Modal -->
    <div id="bookingDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Chi Tiết Booking</h2>
                <button onclick="closeBookingDetail()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="bookingDetailContent" class="p-6">
                <!-- Content sẽ được load bằng JavaScript -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/booking-system-php.js"></script>
    <script>
        let currentBookings = [];
        let currentStats = {};

        // Load dữ liệu khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            loadStatistics();
            loadBookings();
            
            // Setup search on enter
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchBookings();
                }
            });
        });

        // Load thống kê
        async function loadStatistics() {
            try {
                const response = await fetch('../api/booking.php?statistics=1');
                const result = await response.json();
                
                if (result.success) {
                    currentStats = result.data;
                    updateStatisticsDisplay();
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        // Cập nhật hiển thị thống kê
        function updateStatisticsDisplay() {
            document.getElementById('totalBookings').textContent = currentStats.total_bookings || 0;
            document.getElementById('pendingBookings').textContent = currentStats.pending_bookings || 0;
            document.getElementById('confirmedBookings').textContent = currentStats.confirmed_bookings || 0;
            document.getElementById('totalPeople').textContent = currentStats.total_people || 0;
        }

        // Load danh sách bookings
        async function loadBookings() {
            showLoading();
            
            try {
                const response = await fetch('../api/booking.php');
                const result = await response.json();
                
                if (result.success) {
                    currentBookings = result.data;
                    displayBookings(currentBookings);
                } else {
                    showNoBookings();
                }
            } catch (error) {
                console.error('Error loading bookings:', error);
                showNoBookings();
            }
        }

        // Hiển thị loading
        function showLoading() {
            document.getElementById('loadingIndicator').classList.remove('hidden');
            document.getElementById('bookingsList').classList.add('hidden');
            document.getElementById('noBookings').classList.add('hidden');
        }

        // Hiển thị danh sách bookings
        function displayBookings(bookings) {
            const container = document.getElementById('bookingsList');
            
            if (bookings.length === 0) {
                showNoBookings();
                return;
            }
            
            const html = bookings.map(booking => createBookingCard(booking)).join('');
            container.innerHTML = html;
            
            document.getElementById('loadingIndicator').classList.add('hidden');
            document.getElementById('bookingsList').classList.remove('hidden');
            document.getElementById('noBookings').classList.add('hidden');
        }

        // Tạo card booking
        function createBookingCard(booking) {
            const statusClass = `status-${booking.status}`;
            const statusText = getStatusText(booking.status);
            const tourTimeText = getTourTimeText(booking.tour_time);
            
            return `
                <div class="booking-card border-b border-gray-200 p-6 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h4 class="text-lg font-semibold text-gray-900">${booking.customer_name}</h4>
                                <span class="px-2 py-1 rounded-full text-xs font-medium ${statusClass}">
                                    ${statusText}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <p><i class="fas fa-map-marker-alt w-4"></i> ${booking.attraction_name}</p>
                                    <p><i class="fas fa-phone w-4"></i> ${booking.customer_phone}</p>
                                    <p><i class="fas fa-envelope w-4"></i> ${booking.customer_email || 'Không có'}</p>
                                </div>
                                <div>
                                    <p><i class="fas fa-calendar w-4"></i> ${formatDate(booking.tour_date)}</p>
                                    <p><i class="fas fa-users w-4"></i> ${booking.number_of_people} người</p>
                                    <p><i class="fas fa-clock w-4"></i> ${tourTimeText}</p>
                                </div>
                            </div>
                            
                            <div class="mt-3 flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    <span class="font-medium">Mã:</span> ${booking.booking_id} | 
                                    <span class="font-medium">Đặt lúc:</span> ${formatDateTime(booking.booking_time)}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col space-y-2 ml-4">
                            <button onclick="viewBookingDetail('${booking.booking_id}')" 
                                    class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">
                                <i class="fas fa-eye mr-1"></i> Xem
                            </button>
                            
                            ${booking.status === 'pending' ? `
                                <button onclick="updateBookingStatus('${booking.booking_id}', 'confirmed')" 
                                        class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition-colors">
                                    <i class="fas fa-check mr-1"></i> Xác nhận
                                </button>
                                <button onclick="updateBookingStatus('${booking.booking_id}', 'cancelled')" 
                                        class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                                    <i class="fas fa-times mr-1"></i> Hủy
                                </button>
                            ` : ''}
                            
                            ${booking.status === 'confirmed' ? `
                                <button onclick="updateBookingStatus('${booking.booking_id}', 'completed')" 
                                        class="bg-purple-600 text-white px-3 py-1 rounded text-sm hover:bg-purple-700 transition-colors">
                                    <i class="fas fa-flag-checkered mr-1"></i> Hoàn thành
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        }

        // Hiển thị không có bookings
        function showNoBookings() {
            document.getElementById('loadingIndicator').classList.add('hidden');
            document.getElementById('bookingsList').classList.add('hidden');
            document.getElementById('noBookings').classList.remove('hidden');
        }

        // Tìm kiếm bookings
        async function searchBookings() {
            const keyword = document.getElementById('searchInput').value.trim();
            const status = document.getElementById('statusFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            
            showLoading();
            
            try {
                const params = new URLSearchParams();
                if (keyword) params.append('search', keyword);
                if (status) params.append('status', status);
                if (dateFrom) params.append('date_from', dateFrom);
                if (dateTo) params.append('date_to', dateTo);
                
                const response = await fetch(`../api/booking.php?${params.toString()}`);
                const result = await response.json();
                
                if (result.success) {
                    displayBookings(result.data);
                } else {
                    showNoBookings();
                }
            } catch (error) {
                console.error('Error searching bookings:', error);
                showNoBookings();
            }
        }

        // Xóa bộ lọc
        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            loadBookings();
        }

        // Làm mới dữ liệu
        function refreshBookings() {
            loadStatistics();
            loadBookings();
        }

        // Cập nhật trạng thái booking
        async function updateBookingStatus(bookingId, newStatus) {
            const statusNames = {
                'confirmed': 'xác nhận',
                'cancelled': 'hủy',
                'completed': 'hoàn thành'
            };
            
            if (!confirm(`Bạn có chắc chắn muốn ${statusNames[newStatus]} booking này?`)) {
                return;
            }
            
            try {
                const success = await tourBookingPHP.updateBookingStatus(bookingId, newStatus);
                if (success) {
                    alert(`Đã ${statusNames[newStatus]} booking thành công!`);
                    refreshBookings();
                }
            } catch (error) {
                alert('Có lỗi xảy ra: ' + error.message);
            }
        }

        // Xem chi tiết booking
        async function viewBookingDetail(bookingId) {
            try {
                const response = await fetch(`../api/booking.php?booking_id=${bookingId}`);
                const result = await response.json();
                
                if (result.success) {
                    showBookingDetailModal(result.data);
                } else {
                    alert('Không thể tải chi tiết booking');
                }
            } catch (error) {
                console.error('Error loading booking detail:', error);
                alert('Có lỗi xảy ra khi tải chi tiết booking');
            }
        }

        // Hiển thị modal chi tiết
        function showBookingDetailModal(booking) {
            const modal = document.getElementById('bookingDetailModal');
            const content = document.getElementById('bookingDetailContent');
            
            content.innerHTML = `
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Thông tin khách hàng</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Tên:</span> ${booking.customer_name}</p>
                                <p><span class="font-medium">SĐT:</span> ${booking.customer_phone}</p>
                                <p><span class="font-medium">Email:</span> ${booking.customer_email || 'Không có'}</p>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Thông tin tour</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Địa điểm:</span> ${booking.attraction_name}</p>
                                <p><span class="font-medium">Ngày:</span> ${formatDate(booking.tour_date)}</p>
                                <p><span class="font-medium">Số người:</span> ${booking.number_of_people}</p>
                                <p><span class="font-medium">Thời gian:</span> ${getTourTimeText(booking.tour_time)}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Yêu cầu đặc biệt</h3>
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">
                            ${booking.special_requests || 'Không có yêu cầu đặc biệt'}
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Ghi chú</h3>
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">
                            ${booking.notes || 'Không có ghi chú'}
                        </p>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-600">Mã booking: <span class="font-medium">${booking.booking_id}</span></p>
                                <p class="text-sm text-gray-600">Trạng thái: <span class="font-medium ${`status-${booking.status}`} px-2 py-1 rounded">${getStatusText(booking.status)}</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Đặt lúc: ${formatDateTime(booking.booking_time)}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
        }

        // Đóng modal chi tiết
        function closeBookingDetail() {
            document.getElementById('bookingDetailModal').classList.add('hidden');
        }

        // Helper functions
        function getStatusText(status) {
            const statusMap = {
                'pending': 'Chờ xác nhận',
                'confirmed': 'Đã xác nhận',
                'cancelled': 'Đã hủy',
                'completed': 'Hoàn thành'
            };
            return statusMap[status] || status;
        }

        function getTourTimeText(time) {
            const timeMap = {
                'morning': 'Sáng (8:00-11:00)',
                'afternoon': 'Chiều (14:00-17:00)',
                'fullday': 'Cả ngày (8:00-17:00)',
                'flexible': 'Linh hoạt'
            };
            return timeMap[time] || 'Linh hoạt';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }

        function formatDateTime(dateTimeString) {
            const date = new Date(dateTimeString);
            return date.toLocaleString('vi-VN');
        }
    </script>
</body>
</html>