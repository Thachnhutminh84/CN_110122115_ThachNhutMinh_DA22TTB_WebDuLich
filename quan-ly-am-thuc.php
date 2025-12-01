<?php
/**
 * Trang Quản Lý Ẩm Thực
 * CHỈ ADMIN VÀ MANAGER MỚI TRUY CẬP ĐƯỢC
 */

session_start();

// Kiểm tra quyền truy cập - CHỈ ADMIN
require_once 'check-auth.php';
requireAdmin(); // Chỉ admin mới vào được
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Ẩm Thực - Trà Vinh</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .food-card {
            transition: all 0.3s ease;
        }
        .food-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .food-image {
            transition: transform 0.3s ease;
        }
        .food-card:hover .food-image {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-red-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-utensils text-orange-600 mr-2"></i>
                        Quản Lý Ẩm Thực
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="exportFoodData()" 
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-download mr-2"></i>Xuất Dữ Liệu
                    </button>
                    <label class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors cursor-pointer">
                        <i class="fas fa-upload mr-2"></i>Nhập Dữ Liệu
                        <input type="file" accept=".json" class="hidden" onchange="importFoodData(this.files[0])">
                    </label>
                    <a href="am-thuc.php" 
                       class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fas fa-eye mr-2"></i>Xem Trang Chính
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                        <i class="fas fa-utensils text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tổng Món Ăn</p>
                        <p class="text-2xl font-semibold text-gray-900" id="totalFoods">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-plus text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Thêm Tuần Này</p>
                        <p class="text-2xl font-semibold text-gray-900" id="recentFoods">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-tags text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Danh Mục</p>
                        <p class="text-2xl font-semibold text-gray-900" id="totalFoodCategories">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Trạng Thái</p>
                        <p class="text-2xl font-semibold text-green-600">Hoạt Động</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Foods List Container -->
        <div id="foodsListContainer" class="bg-white rounded-lg shadow">
            <!-- Header Controls -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <h2 class="text-xl font-semibold text-gray-900">Danh Sách Món Ăn</h2>
                    
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" id="foodSearchInput" 
                                   placeholder="Tìm kiếm món ăn..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 w-full sm:w-64"
                                   onkeyup="searchFoods()">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        
                        <!-- Category Filter -->
                        <select id="foodCategoryFilter" 
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                onchange="filterFoodsByCategory()">
                            <option value="all">Tất cả danh mục</option>
                            <option value="Đặc Sản Nổi Tiếng">Đặc Sản Nổi Tiếng</option>
                            <option value="Món Địa Phương">Món Địa Phương</option>
                            <option value="Món Chay">Món Chay</option>
                            <option value="Đồ Uống">Đồ Uống</option>
                            <option value="Bánh Kẹo">Bánh Kẹo</option>
                        </select>
                        
                        <!-- Add Button -->
                        <button id="addFoodBtn" 
                                class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors whitespace-nowrap">
                            <i class="fas fa-plus mr-2"></i>Thêm Món Ăn
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div id="foodsListContent" class="p-6">
                <!-- Foods will be rendered here -->
            </div>
        </div>

        <!-- Form Container -->
        <div id="foodFormContainer" class="hidden bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 id="foodFormTitle" class="text-xl font-semibold text-gray-900">Thêm Món Ăn Mới</h2>
            </div>
            
            <form id="foodForm" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tên món ăn -->
                    <div class="md:col-span-2">
                        <label for="foodName" class="block text-sm font-medium text-gray-700 mb-2">
                            Tên Món Ăn *
                        </label>
                        <input type="text" id="foodName" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               placeholder="Nhập tên món ăn đặc sản">
                    </div>
                    
                    <!-- Danh mục -->
                    <div>
                        <label for="foodCategory" class="block text-sm font-medium text-gray-700 mb-2">
                            Danh Mục
                        </label>
                        <select id="foodCategory" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Chọn danh mục</option>
                            <option value="Đặc Sản Nổi Tiếng">Đặc Sản Nổi Tiếng</option>
                            <option value="Món Địa Phương">Món Địa Phương</option>
                            <option value="Món Chay">Món Chay</option>
                            <option value="Đồ Uống">Đồ Uống</option>
                            <option value="Bánh Kẹo">Bánh Kẹo</option>
                            <option value="Món Khmer">Món Khmer</option>
                        </select>
                    </div>
                    
                    <!-- Giá -->
                    <div>
                        <label for="foodPrice" class="block text-sm font-medium text-gray-700 mb-2">
                            Giá
                        </label>
                        <input type="text" id="foodPrice" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               placeholder="VD: 25.000 - 35.000 VNĐ">
                    </div>
                    
                    <!-- Thời gian phục vụ -->
                    <div>
                        <label for="foodServeTime" class="block text-sm font-medium text-gray-700 mb-2">
                            Thời Gian Phục Vụ
                        </label>
                        <input type="text" id="foodServeTime" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               placeholder="VD: Cả ngày, Chỉ buổi sáng">
                    </div>
                    
                    <!-- Độ cay -->
                    <div>
                        <label for="foodSpiceLevel" class="block text-sm font-medium text-gray-700 mb-2">
                            Độ Cay
                        </label>
                        <select id="foodSpiceLevel" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Chọn độ cay</option>
                            <option value="Không cay">Không cay</option>
                            <option value="Ít cay">Ít cay</option>
                            <option value="Vừa cay">Vừa cay</option>
                            <option value="Cay">Cay</option>
                            <option value="Rất cay">Rất cay</option>
                        </select>
                    </div>
                </div>
                
                <!-- Mô tả -->
                <div class="mt-6">
                    <label for="foodDescription" class="block text-sm font-medium text-gray-700 mb-2">
                        Mô Tả *
                    </label>
                    <textarea id="foodDescription" rows="4" required 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Nhập mô tả chi tiết về món ăn, hương vị, cách chế biến..."></textarea>
                </div>
                
                <!-- Hình ảnh -->
                <div class="mt-6">
                    <label for="foodImages" class="block text-sm font-medium text-gray-700 mb-2">
                        Đường Dẫn Hình Ảnh
                    </label>
                    <textarea id="foodImages" rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Nhập đường dẫn hình ảnh, mỗi dòng một đường dẫn&#10;VD:&#10;images/mon-an-1.jpg&#10;images/mon-an-2.jpg"></textarea>
                    <p class="text-sm text-gray-500 mt-1">Mỗi dòng một đường dẫn hình ảnh</p>
                </div>
                
                <!-- Nguyên liệu -->
                <div class="mt-6">
                    <label for="foodIngredients" class="block text-sm font-medium text-gray-700 mb-2">
                        Nguyên Liệu Chính
                    </label>
                    <textarea id="foodIngredients" rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Nhập nguyên liệu chính, mỗi dòng một nguyên liệu&#10;VD:&#10;🥩 Thịt heo&#10;🍜 Bún tươi&#10;🌿 Rau thơm&#10;🧄 Tỏi phi"></textarea>
                    <p class="text-sm text-gray-500 mt-1">Mỗi dòng một nguyên liệu (có thể dùng emoji)</p>
                </div>
                
                <!-- Buttons -->
                <div class="flex space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="submit" id="foodSubmitBtn" 
                            class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Thêm Món Ăn
                    </button>
                    <button type="button" id="foodCancelBtn" 
                            class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-times mr-2"></i>Hủy
                    </button>
                </div>
            </form>
        </div>

        <!-- Food List -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <i class="fas fa-list text-orange-600 mr-2"></i>
                        Danh Sách Món Ăn
                    </h2>
                    
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" id="foodSearchInput" 
                                   placeholder="Tìm kiếm món ăn..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 w-full sm:w-64"
                                   onkeyup="searchFoods()">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        
                        <!-- Category Filter -->
                        <select id="foodCategoryFilter" 
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                onchange="filterFoodsByCategory()">
                            <option value="all">Tất cả danh mục</option>
                            <option value="Đặc Sản Nổi Tiếng">Đặc Sản Nổi Tiếng</option>
                            <option value="Món Địa Phương">Món Địa Phương</option>
                            <option value="Món Chay">Món Chay</option>
                            <option value="Đồ Uống">Đồ Uống</option>
                            <option value="Bánh Kẹo">Bánh Kẹo</option>
                        </select>
                        
                        <!-- Refresh Button -->
                        <button onclick="renderFoodsList(); updateStatistics()" 
                                class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors whitespace-nowrap">
                            <i class="fas fa-sync-alt mr-2"></i>Làm Mới
                        </button>
                    </div>
                </div>
            </div>
            
            <div id="foodsList" class="p-6">
                <!-- Foods will be rendered here -->
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="js/food-admin-controls.js"></script>
    
    <script>
        // Food management functions
        function addFood(event) {
            event.preventDefault();
            
            const name = document.getElementById('foodName').value.trim();
            const category = document.getElementById('foodCategory').value;
            const description = document.getElementById('foodDescription').value.trim();
            const price = document.getElementById('foodPrice').value.trim();
            const image = document.getElementById('foodImage').value.trim();
            const ingredients = document.getElementById('foodIngredients').value.trim();
            
            if (!name || !description) {
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
                return;
            }
            
            const id = generateId(name);
            const food = {
                id,
                name,
                category,
                description,
                price,
                image,
                ingredients: ingredients ? ingredients.split('\n').filter(item => item.trim()) : [],
                createdAt: new Date().toISOString()
            };
            
            // Save to localStorage
            const foods = JSON.parse(localStorage.getItem('foods') || '{}');
            foods[id] = food;
            localStorage.setItem('foods', JSON.stringify(foods));
            
            // Reset form
            document.getElementById('addFoodForm').reset();
            
            // Refresh list
            renderFoodsList();
            
            alert('✅ Đã thêm món ăn thành công!');
        }
        
        function generateId(name) {
            return name.toLowerCase()
                .replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a')
                .replace(/[èéẹẻẽêềếệểễ]/g, 'e')
                .replace(/[ìíịỉĩ]/g, 'i')
                .replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, 'o')
                .replace(/[ùúụủũưừứựửữ]/g, 'u')
                .replace(/[ỳýỵỷỹ]/g, 'y')
                .replace(/đ/g, 'd')
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '') + '-' + Date.now();
        }
        
        function renderFoodsList() {
            const foods = JSON.parse(localStorage.getItem('foods') || '{}');
            const container = document.getElementById('foodsList');
            
            if (Object.keys(foods).length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-utensils text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có món ăn nào</h3>
                        <p class="text-gray-500">Hãy thêm món ăn đầu tiên</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    ${Object.values(foods).map(food => renderFoodCard(food)).join('')}
                </div>
            `;
        }
        
        function renderFoodCard(food) {
            const image = food.image || 'https://via.placeholder.com/300x200/f59e0b/ffffff?text=' + encodeURIComponent(food.name);
            
            return `
                <div class="food-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="relative">
                        <img src="${image}" alt="${food.name}" 
                             class="food-image w-full h-48 object-cover"
                             onerror="this.src='https://via.placeholder.com/300x200/f59e0b/ffffff?text=No+Image'">
                        ${food.category ? `
                            <div class="absolute top-2 right-2">
                                <span class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                    ${food.category}
                                </span>
                            </div>
                        ` : ''}
                        <div class="absolute bottom-2 left-2">
                            <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">
                                <i class="fas fa-utensils mr-1"></i>ID: ${food.id.split('-')[0]}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg text-gray-800 flex-1">${food.name}</h3>
                            <div class="ml-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600">4.${Math.floor(Math.random() * 9) + 1}</span>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">${food.description}</p>
                        
                        ${food.price ? `
                            <div class="flex items-center mb-3">
                                <i class="fas fa-tag text-orange-500 mr-2"></i>
                                <span class="text-orange-600 font-bold">${food.price}</span>
                            </div>
                        ` : ''}
                        
                        ${food.ingredients && food.ingredients.length > 0 ? `
                            <div class="mb-4">
                                <p class="text-xs text-gray-500 mb-2 flex items-center">
                                    <i class="fas fa-list-ul mr-1"></i>
                                    Nguyên liệu (${food.ingredients.length}):
                                </p>
                                <div class="flex flex-wrap gap-1">
                                    ${food.ingredients.slice(0, 4).map(ingredient => `
                                        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-xs font-medium">${ingredient}</span>
                                    `).join('')}
                                    ${food.ingredients.length > 4 ? `<span class="text-xs text-gray-400 px-2 py-1">+${food.ingredients.length - 4} khác</span>` : ''}
                                </div>
                            </div>
                        ` : ''}
                        
                        <div class="border-t pt-3 mt-3">
                            <div class="flex space-x-2 mb-3">
                                <button onclick="viewFood('${food.id}')" 
                                        class="flex-1 bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>Xem
                                </button>
                                <button onclick="editFood('${food.id}')" 
                                        class="flex-1 bg-yellow-500 text-white py-2 px-3 rounded-lg hover:bg-yellow-600 transition-colors text-sm font-medium">
                                    <i class="fas fa-edit mr-1"></i>Sửa
                                </button>
                                <button onclick="deleteFood('${food.id}')" 
                                        class="flex-1 bg-red-500 text-white py-2 px-3 rounded-lg hover:bg-red-600 transition-colors text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i>Xóa
                                </button>
                            </div>
                            
                            <div class="flex justify-between items-center text-xs text-gray-400">
                                <span>
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    ${new Date(food.createdAt).toLocaleDateString('vi-VN')}
                                </span>
                                <span>
                                    <i class="fas fa-clock mr-1"></i>
                                    ${new Date(food.createdAt).toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'})}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // View food details
        function viewFood(id) {
            const foods = JSON.parse(localStorage.getItem('foods') || '{}');
            const food = foods[id];
            
            if (!food) {
                alert('Không tìm thấy món ăn!');
                return;
            }
            
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.onclick = (e) => {
                if (e.target === modal) modal.remove();
            };
            
            modal.innerHTML = `
                <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-orange-600">
                            <i class="fas fa-utensils mr-2"></i>${food.name}
                        </h2>
                        <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        ${food.image ? `
                            <img src="${food.image}" alt="${food.name}" class="w-full h-64 object-cover rounded-lg mb-4"
                                 onerror="this.style.display='none'">
                        ` : ''}
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Danh mục</label>
                                <p class="text-gray-900">${food.category || 'Chưa phân loại'}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Giá</label>
                                <p class="text-orange-600 font-bold">${food.price || 'Chưa cập nhật'}</p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                            <p class="text-gray-700 leading-relaxed">${food.description}</p>
                        </div>
                        
                        ${food.ingredients && food.ingredients.length > 0 ? `
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nguyên liệu</label>
                                <div class="flex flex-wrap gap-2">
                                    ${food.ingredients.map(ingredient => `
                                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm">${ingredient}</span>
                                    `).join('')}
                                </div>
                            </div>
                        ` : ''}
                        
                        <div class="border-t pt-4">
                            <div class="text-sm text-gray-500">
                                <p>Tạo: ${new Date(food.createdAt).toLocaleString('vi-VN')}</p>
                                ${food.updatedAt && food.updatedAt !== food.createdAt ? 
                                    `<p>Cập nhật: ${new Date(food.updatedAt).toLocaleString('vi-VN')}</p>` : ''}
                            </div>
                        </div>
                        
                        <div class="flex space-x-3 mt-6">
                            <button onclick="editFood('${food.id}'); this.closest('.fixed').remove();" 
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                                <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                            </button>
                            <button onclick="this.closest('.fixed').remove()" 
                                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                                Đóng
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
        }
        
        function editFood(id) {
            // This will be handled by the food admin controls
            if (window.foodAdminControls) {
                window.foodAdminControls.editFood(id);
            }
        }
        
        function deleteFood(id) {
            // This will be handled by the food admin controls
            if (window.foodAdminControls) {
                window.foodAdminControls.deleteFood(id);
            }
        }
        
        function exportFoodData() {
            const foods = JSON.parse(localStorage.getItem('foods') || '{}');
            const data = JSON.stringify(foods, null, 2);
            const blob = new Blob([data], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            
            const a = document.createElement('a');
            a.href = url;
            a.download = `foods_${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            
            alert('✅ Đã xuất dữ liệu thành công!');
        }
        
        function importFoodData(file) {
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                try {
                    const data = JSON.parse(e.target.result);
                    localStorage.setItem('foods', JSON.stringify(data));
                    renderFoodsList();
                    alert('✅ Đã nhập dữ liệu thành công!');
                } catch (error) {
                    alert('❌ File không hợp lệ!');
                }
            };
            reader.readAsText(file);
        }
        
        // Show add form
        function showAddForm() {
            const formContainer = document.getElementById('foodFormContainer');
            const listContainer = document.getElementById('foodsListContainer');
            
            if (formContainer && listContainer) {
                formContainer.classList.remove('hidden');
                listContainer.classList.add('hidden');
                document.getElementById('foodFormTitle').textContent = 'Thêm Món Ăn Mới';
                document.getElementById('foodSubmitBtn').innerHTML = '<i class="fas fa-save mr-2"></i>Thêm Món Ăn';
                resetFoodForm();
            }
        }
        
        // Hide form
        function hideForm() {
            const formContainer = document.getElementById('foodFormContainer');
            const listContainer = document.getElementById('foodsListContainer');
            
            if (formContainer && listContainer) {
                formContainer.classList.add('hidden');
                listContainer.classList.remove('hidden');
                resetFoodForm();
            }
        }
        
        // Reset form
        function resetFoodForm() {
            const form = document.getElementById('foodForm');
            if (form) {
                form.reset();
            }
        }
        
        // Update statistics
        function updateStatistics() {
            const foods = JSON.parse(localStorage.getItem('foods') || '{}');
            const foodsArray = Object.values(foods);
            
            // Total foods
            document.getElementById('totalFoods').textContent = foodsArray.length;
            
            // Recent foods (last 7 days)
            const weekAgo = new Date();
            weekAgo.setDate(weekAgo.getDate() - 7);
            const recentFoods = foodsArray.filter(food => {
                const created = new Date(food.createdAt);
                return created > weekAgo;
            });
            document.getElementById('recentFoods').textContent = recentFoods.length;
            
            // Categories
            const categories = new Set(foodsArray.map(food => food.category).filter(cat => cat));
            document.getElementById('totalFoodCategories').textContent = categories.size;
        }
        
        // Add food function
        function addFood(event) {
            event.preventDefault();
            
            const name = document.getElementById('foodName').value.trim();
            const category = document.getElementById('foodCategory').value;
            const description = document.getElementById('foodDescription').value.trim();
            const price = document.getElementById('foodPrice').value.trim();
            const serveTime = document.getElementById('foodServeTime').value.trim();
            const spiceLevel = document.getElementById('foodSpiceLevel').value;
            const images = document.getElementById('foodImages').value.trim();
            const ingredients = document.getElementById('foodIngredients').value.trim();
            
            if (!name || !description) {
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
                return;
            }
            
            const id = generateId(name);
            const food = {
                id,
                name,
                category,
                description,
                price,
                serveTime,
                spiceLevel,
                images: images ? images.split('\n').filter(img => img.trim()) : [],
                ingredients: ingredients ? ingredients.split('\n').filter(item => item.trim()) : [],
                createdAt: new Date().toISOString(),
                updatedAt: new Date().toISOString()
            };
            
            // Save to localStorage
            const foods = JSON.parse(localStorage.getItem('foods') || '{}');
            foods[id] = food;
            localStorage.setItem('foods', JSON.stringify(foods));
            
            // Hide form and show list
            hideForm();
            
            // Refresh list and stats
            renderFoodsList();
            updateStatistics();
            
            // Show success message
            showSuccessMessage(`✅ Đã thêm món "${name}" thành công!`);
        }
        
        // Show success message
        function showSuccessMessage(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 z-50 bg-green-500 text-white p-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300';
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
        // Search foods
        function searchFoods() {
            const searchTerm = document.getElementById('foodSearchInput').value.toLowerCase();
            const foods = JSON.parse(localStorage.getItem('foods') || '{}');
            const foodsArray = Object.values(foods);
            
            const filtered = foodsArray.filter(food => 
                food.name.toLowerCase().includes(searchTerm) ||
                food.description.toLowerCase().includes(searchTerm) ||
                (food.category && food.category.toLowerCase().includes(searchTerm)) ||
                (food.ingredients && food.ingredients.some(ing => ing.toLowerCase().includes(searchTerm)))
            );
            
            renderFilteredFoods(filtered);
        }
        
        // Filter foods by category
        function filterFoodsByCategory() {
            const category = document.getElementById('foodCategoryFilter').value;
            const foods = JSON.parse(localStorage.getItem('foods') || '{}');
            const foodsArray = Object.values(foods);
            
            const filtered = category === 'all' ? 
                foodsArray : 
                foodsArray.filter(food => food.category === category);
            
            renderFilteredFoods(filtered);
        }
        
        // Render filtered foods
        function renderFilteredFoods(foods) {
            const container = document.getElementById('foodsList');
            
            if (foods.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Không tìm thấy món ăn</h3>
                        <p class="text-gray-500">Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc</p>
                        <button onclick="clearFilters()" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                            <i class="fas fa-times mr-2"></i>Xóa Bộ Lọc
                        </button>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = `
                <div class="mb-4 text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Hiển thị ${foods.length} món ăn
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    ${foods.map(food => renderFoodCard(food)).join('')}
                </div>
            `;
        }
        
        // Clear filters
        function clearFilters() {
            document.getElementById('foodSearchInput').value = '';
            document.getElementById('foodCategoryFilter').value = 'all';
            renderFoodsList();
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addFoodForm').addEventListener('submit', addFood);
            renderFoodsList();
            updateStatistics();
            
            // Update stats every 30 seconds
            setInterval(updateStatistics, 30000);
        });
    </script>
</body>
</html>