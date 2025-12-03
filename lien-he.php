<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - Du Lịch Trà Vinh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/attractions-style.css">
    <link rel="stylesheet" href="css/google-maps.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/mobile-enhancements.css">
    <link rel="stylesheet" href="css/header-responsive-fix.css">
</head>

<body class="bg-gradient-to-br from-purple-50 via-white to-blue-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-purple-100">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="index.php"
                    class="flex items-center space-x-3 text-purple-800 hover:text-purple-600 transition-colors">
                    <i class="fas fa-home text-2xl"></i>
                    <span class="text-xl font-bold">Trang Chủ</span>
                </a>

                <nav class="hidden md:flex space-x-8">
                    <a href="index.php" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Trang
                        Chủ</a>
                    <a href="dia-diem-du-lich-dynamic.php"
                        class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Địa Điểm</a>
                    <a href="am-thuc.php" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Ẩm
                        Thực</a>
                    <a href="lien-he.php" class="text-purple-600 font-bold">Liên Hệ</a>
                    <a href="quan-ly-lien-he.php" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                        <i class="fas fa-cog"></i> Quản Lý
                    </a>
                    <a href="dang-nhap.php"
                        class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-colors">
                        <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                    </a>
                    <a href="quan-ly-users.php"
                        class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition-colors">
                        <i class="fas fa-users-cog"></i> Quản Lý
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-blue-600/20"></div>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-gray-800 mb-6">
                    <span class="bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                        Liên Hệ Với Chúng Tôi
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Hãy để chúng tôi hỗ trợ bạn trong hành trình khám phá Trà Vinh
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Gửi Tin Nhắn</h2>
                
                <!-- Alert Messages -->
                <div id="alertMessage" class="hidden mb-4 p-4 rounded-lg"></div>
                
                <form id="contactForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                            <input type="text" id="fullName" name="full_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chủ đề *</label>
                        <select id="subject" name="subject" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option>Tư vấn du lịch</option>
                            <option>Đặt tour</option>
                            <option>Thông tin địa điểm</option>
                            <option>Khác</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tin nhắn *</label>
                        <textarea id="message" name="message" required rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            placeholder="Nhập tin nhắn của bạn..."></textarea>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-paper-plane mr-2"></i>Gửi Tin Nhắn
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <!-- Office Info -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Thông Tin Liên Hệ</h3>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <i class="fas fa-map-marker-alt text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Địa chỉ</h4>
                                <p class="text-gray-600">Trường Đại học Trà Vinh<br>126 Nguyễn Thiện Thành, Khóm 4,
                                    Phường 5<br>TP. Trà Vinh, Tỉnh Trà Vinh</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <i class="fas fa-phone text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Điện thoại</h4>
                                <p class="text-gray-600">Hotline: 0294.3855.246<br>Fax: 0294.3855.269</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-green-100 p-3 rounded-lg">
                                <i class="fas fa-envelope text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Email</h4>
                                <p class="text-gray-600">info@tvu.edu.vn<br>dulich@travinh.gov.vn</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-orange-100 p-3 rounded-lg">
                                <i class="fas fa-clock text-orange-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Giờ làm việc</h4>
                                <p class="text-gray-600">Thứ 2 - Thứ 6: 7:30 - 17:00<br>Thứ 7: 7:30 - 11:30<br>Chủ nhật:
                                    Nghỉ</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Du Lịch Trà Vinh</h3>
                    <p class="text-gray-300">Khám phá vẻ đẹp văn hóa Khmer và thiên nhiên tuyệt vời</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Liên Kết</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="index.php" class="hover:text-white transition-colors">Trang Chủ</a></li>
                        <li><a href="dia-diem-du-lich-dynamic.php" class="hover:text-white transition-colors">Địa Điểm</a></li>
                        <li><a href="am-thuc.php" class="hover:text-white transition-colors">Ẩm Thực</a></li>
                        <li><a href="lien-he.php" class="hover:text-white transition-colors">Liên Hệ</a></li>
                        <li><a href="dang-nhap.php" class="hover:text-white transition-colors">Đăng Nhập</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Liên Hệ</h4>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-phone mr-2"></i>0294.3855.246</p>
                        <p><i class="fas fa-envelope mr-2"></i>info@tvu.edu.vn</p>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Thông Tin Tác Giả</h4>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-user mr-2 text-blue-400"></i>Thạch Nhựt Minh</p>
                        <p><i class="fas fa-id-card mr-2 text-green-400"></i>MSSV: 110122115</p>
                        <p><i class="fas fa-graduation-cap mr-2 text-yellow-400"></i>Lớp: Da22TTB</p>
                        <p><i class="fas fa-university mr-2 text-purple-400"></i>Trường ĐH Trà Vinh</p>
                    </div>
                </div>
            </div>
            
            <!-- Copyright & Social Icons -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 mb-4">&copy; 2024 Du Lịch Trà Vinh. All rights reserved.</p>
                <div class="flex justify-center gap-4 mt-4">
                    <a href="https://www.facebook.com/travinh.tourism" target="_blank" rel="noopener noreferrer"
                        class="w-12 h-12 rounded-full bg-blue-600 hover:bg-blue-500 flex items-center justify-center text-white text-xl transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/50" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/travinh.tourism" target="_blank" rel="noopener noreferrer"
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 via-pink-500 to-orange-400 hover:from-purple-500 hover:via-pink-400 hover:to-orange-300 flex items-center justify-center text-white text-xl transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-pink-500/50" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/@travinhtourism" target="_blank" rel="noopener noreferrer"
                        class="w-12 h-12 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white text-xl transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-red-500/50" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Xử lý form submit
        document.getElementById('contactForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const alertMessage = document.getElementById('alertMessage');
            
            // Disable button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang gửi...';
            
            // Lấy dữ liệu form
            const formData = {
                full_name: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                subject: document.getElementById('subject').value,
                message: document.getElementById('message').value
            };
            
            try {
                const response = await fetch('api/contact.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                
                const result = await response.json();
                
                // Hiển thị thông báo
                alertMessage.classList.remove('hidden');
                
                if (result.success) {
                    alertMessage.className = 'mb-4 p-4 rounded-lg bg-green-100 border border-green-400 text-green-700';
                    alertMessage.innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + result.message;
                    
                    // Reset form
                    document.getElementById('contactForm').reset();
                    
                    // Ẩn thông báo sau 5 giây
                    setTimeout(() => {
                        alertMessage.classList.add('hidden');
                    }, 5000);
                } else {
                    alertMessage.className = 'mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700';
                    alertMessage.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>' + result.message;
                }
                
            } catch (error) {
                alertMessage.classList.remove('hidden');
                alertMessage.className = 'mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700';
                alertMessage.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Có lỗi xảy ra. Vui lòng thử lại!';
            } finally {
                // Enable button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Gửi Tin Nhắn';
            }
        });
    </script>
    
    <!-- Mobile Menu & Responsive JS -->
    <script src="js/mobile-menu.js"></script>
</body>

</html>
