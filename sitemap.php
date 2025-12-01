<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap - Du Lịch Trà Vinh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">
    <div class="max-w-6xl mx-auto p-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-800 mb-4">
                <span class="bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                    🗺️ Sitemap
                </span>
            </h1>
            <p class="text-xl text-gray-600">Cấu trúc website Du Lịch Trà Vinh</p>
            <div class="mt-4">
                <a href="index.php" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition-colors">
                    <i class="fas fa-home mr-2"></i>Về Trang Chủ
                </a>
            </div>
        </div>

        <!-- Website Structure -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">🏗️ Cấu Trúc Website</h2>
            
            <!-- Main Pages Tree -->
            <div class="flex flex-col items-center">
                <!-- Root -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white p-6 rounded-2xl shadow-lg mb-8 text-center">
                    <i class="fas fa-home text-3xl mb-2"></i>
                    <h3 class="text-xl font-bold">Trang Chủ</h3>
                    <p class="text-sm opacity-90">index.html</p>
                    <a href="index.php" class="inline-block mt-2 bg-white/20 px-4 py-2 rounded-lg hover:bg-white/30 transition-colors">
                        Xem trang
                    </a>
                </div>

                <!-- Branches -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 w-full">
                    
                    <!-- Địa Điểm Du Lịch -->
                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map-marker-alt text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Địa Điểm Du Lịch</h3>
                        <p class="text-sm text-gray-600 mb-4">dia-diem-du-lich.html</p>
                        <div class="space-y-2 text-xs text-gray-500 mb-4">
                            <p>• Ao Bà Om</p>
                            <p>• Chùa Âng</p>
                            <p>• Đền Bác Hồ</p>
                            <p>• Chùa Hang</p>
                            <p>• Rừng Đước</p>
                        </div>
                        <a href="dia-diem-du-lich-dynamic.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            Xem trang
                        </a>
                    </div>

                    <!-- Ẩm Thực -->
                    <div class="bg-white border-2 border-orange-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-utensils text-2xl text-orange-600"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Ẩm Thực</h3>
                        <p class="text-sm text-gray-600 mb-4">am-thuc.html</p>
                        <div class="space-y-2 text-xs text-gray-500 mb-4">
                            <p>• Bún Nước Lèo</p>
                            <p>• Bánh Canh Bến Có</p>
                            <p>• Chù Ụ Rang Me</p>
                            <p>• Đặc sản Khmer</p>
                        </div>
                        <a href="am-thuc.php" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors text-sm">
                            Xem trang
                        </a>
                    </div>

                    <!-- Liên Hệ -->
                    <div class="bg-white border-2 border-purple-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Liên Hệ</h3>
                        <p class="text-sm text-gray-600 mb-4">lien-he.html</p>
                        <div class="space-y-2 text-xs text-gray-500 mb-4">
                            <p>• Form liên hệ</p>
                            <p>• Thông tin văn phòng</p>
                            <p>• Bản đồ</p>
                            <p>• Social media</p>
                        </div>
                        <a href="lien-he.php" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors text-sm">
                            Xem trang
                        </a>
                    </div>

                    <!-- Đăng Nhập -->
                    <div class="bg-white border-2 border-indigo-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center">
                        <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-circle text-2xl text-indigo-600"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Đăng Nhập</h3>
                        <p class="text-sm text-gray-600 mb-4">dang-nhap.html</p>
                        <div class="space-y-2 text-xs text-gray-500 mb-4">
                            <p>• Form đăng nhập</p>
                            <p>• Social login</p>
                            <p>• Quên mật khẩu</p>
                            <p>• Đăng ký mới</p>
                        </div>
                        <a href="dang-nhap.php" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors text-sm">
                            Xem trang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical Files -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            
            <!-- CSS Files -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-palette text-blue-600 mr-2"></i>CSS Files
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">styles.css</span>
                        <span class="text-sm text-gray-500">Main styles</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">attractions-style.css</span>
                        <span class="text-sm text-gray-500">Attractions page</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">animations.css</span>
                        <span class="text-sm text-gray-500">Animations</span>
                    </div>
                </div>
            </div>

            <!-- JavaScript Files -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-code text-yellow-600 mr-2"></i>JavaScript Files
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">navigation.js</span>
                        <span class="text-sm text-gray-500">Navigation system</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">attractions.js</span>
                        <span class="text-sm text-gray-500">Attractions functionality</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">booking.js</span>
                        <span class="text-sm text-gray-500">Booking system</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">index-effects.js</span>
                        <span class="text-sm text-gray-500">Homepage effects</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Flow -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">🔄 Navigation Flow</h3>
            
            <div class="flex flex-wrap justify-center items-center gap-4">
                <div class="bg-blue-100 p-4 rounded-lg text-center">
                    <i class="fas fa-home text-2xl text-blue-600 mb-2"></i>
                    <p class="font-semibold text-sm">Trang Chủ</p>
                </div>
                
                <i class="fas fa-arrows-alt-h text-gray-400"></i>
                
                <div class="bg-green-100 p-4 rounded-lg text-center">
                    <i class="fas fa-map-marker-alt text-2xl text-green-600 mb-2"></i>
                    <p class="font-semibold text-sm">Địa Điểm</p>
                </div>
                
                <i class="fas fa-arrows-alt-h text-gray-400"></i>
                
                <div class="bg-orange-100 p-4 rounded-lg text-center">
                    <i class="fas fa-utensils text-2xl text-orange-600 mb-2"></i>
                    <p class="font-semibold text-sm">Ẩm Thực</p>
                </div>
                
                <i class="fas fa-arrows-alt-h text-gray-400"></i>
                
                <div class="bg-purple-100 p-4 rounded-lg text-center">
                    <i class="fas fa-envelope text-2xl text-purple-600 mb-2"></i>
                    <p class="font-semibold text-sm">Liên Hệ</p>
                </div>
                
                <i class="fas fa-arrows-alt-h text-gray-400"></i>
                
                <div class="bg-indigo-100 p-4 rounded-lg text-center">
                    <i class="fas fa-user-circle text-2xl text-indigo-600 mb-2"></i>
                    <p class="font-semibold text-sm">Đăng Nhập</p>
                </div>
            </div>
            
            <p class="text-center text-gray-600 mt-4 text-sm">
                Tất cả các trang đều có navigation menu để chuyển đổi qua lại dễ dàng
            </p>
        </div>

        <!-- Quick Actions -->
        <div class="text-center mt-8">
            <div class="bg-gradient-to-r from-blue-600 to-green-600 rounded-xl p-6 text-white">
                <h3 class="text-xl font-bold mb-4">🚀 Quick Actions</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="test-navigation.php" class="bg-white/20 px-4 py-2 rounded-lg hover:bg-white/30 transition-colors">
                        <i class="fas fa-vial mr-2"></i>Test Navigation
                    </a>
                    <a href="index.php" class="bg-white/20 px-4 py-2 rounded-lg hover:bg-white/30 transition-colors">
                        <i class="fas fa-home mr-2"></i>Trang Chủ
                    </a>
                    <a href="dia-diem-du-lich.php" class="bg-white/20 px-4 py-2 rounded-lg hover:bg-white/30 transition-colors">
                        <i class="fas fa-map-marker-alt mr-2"></i>Địa Điểm
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>