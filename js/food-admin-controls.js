// Food Admin Controls - CRUD System for Food Management
class FoodAdminControls {
    constructor() {
        this.isAdminMode = false;
        this.foods = this.loadFoods();
        this.init();
    }

    // Initialize the system
    init() {
        this.addAdminStyles();
        this.bindEvents();
        this.injectAdminButtons();
        console.log('✅ Food Admin Controls initialized');
    }

    // Load foods from localStorage or default data
    loadFoods() {
        const stored = localStorage.getItem('foods');
        if (stored) {
            return JSON.parse(stored);
        }
        
        // Default food data
        return {
            'bun-nuoc-leo': {
                id: 'bun-nuoc-leo',
                name: 'Bún Nước Lèo',
                description: 'Món ăn đặc trưng của người Khmer với nước dùng đậm đà từ cá lóc, tôm khô và các loại rau thơm.',
                price: '25.000 - 35.000 VNĐ',
                category: 'Đặc Sản Nổi Tiếng',
                image: 'images/bun-nuoc-leo.jpg',
                ingredients: ['Bún tươi', 'Cá lóc', 'Tôm khô', 'Rau thơm', 'Nước mắm'],
                createdAt: new Date().toISOString()
            },
            'banh-canh-ben-co': {
                id: 'banh-canh-ben-co',
                name: 'Bánh Canh Bến Có',
                description: 'Bánh canh đặc biệt với nước dùng trong vắt và bánh canh dai ngon.',
                price: '20.000 - 30.000 VNĐ',
                category: 'Món Địa Phương',
                image: 'images/banh-canh.jpg',
                ingredients: ['Bánh canh', 'Tôm', 'Thịt heo', 'Hành lá'],
                createdAt: new Date().toISOString()
            }
        };
    }

    // Save foods to localStorage
    saveFoods() {
        localStorage.setItem('foods', JSON.stringify(this.foods));
        console.log('💾 Foods saved to localStorage');
    }

    // Add admin styles
    addAdminStyles() {
        const styles = `
            <style id="food-admin-styles">
                .food-admin-toggle-btn {
                    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                    color: white;
                    border: none;
                    padding: 0.75rem;
                    border-radius: 50%;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    margin-left: 0.5rem;
                    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
                    position: relative;
                    z-index: 10;
                }
                
                .food-admin-toggle-btn:hover {
                    transform: scale(1.1);
                    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
                }
                
                .food-admin-toggle-btn.active {
                    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                    animation: foodPulse 2s infinite;
                }
                
                @keyframes foodPulse {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.05); }
                }
                
                .food-admin-toolbar {
                    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                    color: white;
                    padding: 1rem 0;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                    border-bottom: 3px solid #f59e0b;
                    position: sticky;
                    top: 0;
                    z-index: 40;
                }
                
                .food-admin-toolbar-content {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 0 1rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 1rem;
                }
                
                .food-admin-info {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    font-weight: 600;
                }
                
                .food-admin-info i {
                    color: #fbbf24;
                    font-size: 1.2rem;
                }
                
                .food-admin-actions {
                    display: flex;
                    gap: 0.75rem;
                    flex-wrap: wrap;
                }
                
                .food-admin-actions-card {
                    display: flex;
                    gap: 0.5rem;
                    margin-top: 0.75rem;
                    padding-top: 0.75rem;
                    border-top: 1px solid #e5e7eb;
                    justify-content: center;
                }
                
                .food-admin-mode .food-card {
                    border: 2px dashed #f59e0b !important;
                    position: relative;
                    background: rgba(245, 158, 11, 0.05) !important;
                }
                
                .food-admin-mode .food-card::before {
                    content: '🍽️ Chế độ chỉnh sửa món ăn';
                    position: absolute;
                    top: -10px;
                    left: 10px;
                    background: #f59e0b;
                    color: white;
                    padding: 0.25rem 0.5rem;
                    border-radius: 0.25rem;
                    font-size: 0.75rem;
                    font-weight: 600;
                    z-index: 10;
                }
                
                .food-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    padding: 0.5rem 1rem;
                    border: none;
                    border-radius: 0.5rem;
                    font-weight: 600;
                    font-size: 0.875rem;
                    cursor: pointer;
                    transition: all 0.2s ease;
                    text-decoration: none;
                }
                
                .food-btn-success {
                    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                    color: white;
                }
                
                .food-btn-success:hover {
                    background: linear-gradient(135deg, #059669 0%, #047857 100%);
                    transform: translateY(-1px);
                }
                
                .food-btn-primary {
                    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                    color: white;
                }
                
                .food-btn-primary:hover {
                    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
                    transform: translateY(-1px);
                }
                
                .food-btn-secondary {
                    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
                    color: white;
                }
                
                .food-btn-secondary:hover {
                    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
                    transform: translateY(-1px);
                }
                
                .food-btn-warning {
                    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                    color: white;
                }
                
                .food-btn-warning:hover {
                    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
                    transform: translateY(-1px);
                }
                
                .food-btn-danger {
                    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                    color: white;
                }
                
                .food-btn-danger:hover {
                    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
                    transform: translateY(-1px);
                }
                
                .hidden {
                    display: none !important;
                }
                
                /* Modal styles */
                .food-modal {
                    backdrop-filter: blur(4px);
                }
                
                .food-modal .bg-white {
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                }
                
                /* Form styles */
                .food-form input:focus,
                .food-form textarea:focus,
                .food-form select:focus {
                    outline: none;
                    border-color: #f59e0b;
                    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
                }
                
                /* New food card animation */
                .food-card-new {
                    animation: foodCardSlideIn 0.6s ease-out;
                }
                
                @keyframes foodCardSlideIn {
                    from {
                        opacity: 0;
                        transform: translateY(30px) scale(0.95);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0) scale(1);
                    }
                }
                
                /* Success highlight */
                .food-card-highlight {
                    animation: foodCardHighlight 3s ease-out;
                }
                
                @keyframes foodCardHighlight {
                    0% {
                        box-shadow: 0 0 0 rgba(245, 158, 11, 0.5);
                    }
                    50% {
                        box-shadow: 0 0 30px rgba(245, 158, 11, 0.8);
                    }
                    100% {
                        box-shadow: 0 0 0 rgba(245, 158, 11, 0);
                    }
                }
                
                /* Responsive design */
                @media (max-width: 768px) {
                    .food-admin-toolbar-content {
                        flex-direction: column;
                        text-align: center;
                    }
                    
                    .food-admin-actions {
                        justify-content: center;
                    }
                    
                    .food-admin-actions-card {
                        justify-content: center;
                    }
                }
            </style>
        `;
        
        if (!document.getElementById('food-admin-styles')) {
            document.head.insertAdjacentHTML('beforeend', styles);
        }
    }

    // Bind events
    bindEvents() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('#foodAdminToggle')) {
                this.toggleAdminMode();
            }
        });
    }

    // Inject admin buttons into existing food cards
    injectAdminButtons() {
        const foodCards = document.querySelectorAll('.food-card');
        console.log(`🍽️ Found ${foodCards.length} food cards`);
        
        foodCards.forEach((card, index) => {
            // Try to extract food ID from the card
            const foodName = card.querySelector('h3')?.textContent?.trim();
            let foodId = this.generateIdFromName(foodName) || `food_${index}`;
            
            // Look for existing buttons to get ID
            const findButton = card.querySelector('button[onclick*="findRestaurants"]');
            if (findButton) {
                const onclick = findButton.getAttribute('onclick');
                const match = onclick.match(/'([^']+)'/);
                if (match) {
                    foodId = match[1];
                }
            }
            
            console.log(`🍽️ Processing food card: ${foodName} (ID: ${foodId})`);
            
            // Find the button container (usually the div with price and find button)
            const buttonContainer = card.querySelector('.flex.items-center.justify-between') || 
                                  card.querySelector('.p-6') || 
                                  card.querySelector('.p-4');
            
            if (buttonContainer && !buttonContainer.querySelector(`#adminActions-${foodId}`)) {
                const adminActions = document.createElement('div');
                adminActions.className = 'admin-actions-card hidden';
                adminActions.id = `adminActions-${foodId}`;
                adminActions.innerHTML = `
                    <button class="btn btn-warning" onclick="foodAdminControls.editFood('${foodId}')">
                        <i class="fas fa-edit"></i>
                        Sửa
                    </button>
                    <button class="btn btn-danger" onclick="foodAdminControls.deleteFood('${foodId}')">
                        <i class="fas fa-trash"></i>
                        Xóa
                    </button>
                `;
                
                buttonContainer.appendChild(adminActions);
                console.log(`✅ Added admin buttons for ${foodId}`);
            }
        });
    }

    // Generate ID from food name
    generateIdFromName(name) {
        if (!name) return null;
        
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
            .replace(/^-|-$/g, '');
    }

    // Toggle admin mode
    toggleAdminMode() {
        this.isAdminMode = !this.isAdminMode;
        
        const toggleBtn = document.getElementById('foodAdminToggle');
        const toolbar = document.getElementById('foodAdminToolbar');
        const body = document.body;
        
        if (this.isAdminMode) {
            // Enable admin mode
            if (toggleBtn) toggleBtn.classList.add('active');
            if (toolbar) toolbar.classList.remove('hidden');
            if (body) {
                body.classList.add('food-admin-mode');
                body.classList.add('admin-mode'); // Also add generic admin-mode class
            }
            
            // Show all admin action buttons
            document.querySelectorAll('.food-admin-actions-card, .admin-actions-card').forEach(el => {
                el.classList.remove('hidden');
            });
            
            this.showNotification('Chế độ quản lý ẩm thực đã được bật', 'success');
        } else {
            // Disable admin mode
            if (toggleBtn) toggleBtn.classList.remove('active');
            if (toolbar) toolbar.classList.add('hidden');
            if (body) {
                body.classList.remove('food-admin-mode');
                body.classList.remove('admin-mode');
            }
            
            // Hide all admin action buttons
            document.querySelectorAll('.food-admin-actions-card, .admin-actions-card').forEach(el => {
                el.classList.add('hidden');
            });
            
            this.showNotification('Chế độ quản lý ẩm thực đã được tắt', 'info');
        }
    }

    // Edit food
    editFood(id) {
        const food = this.getFoodData(id);
        if (!food) {
            this.showNotification('Không tìm thấy dữ liệu món ăn', 'error');
            return;
        }
        
        this.showEditModal(id, food);
    }

    // Delete food
    deleteFood(id) {
        const food = this.getFoodData(id);
        if (!food) {
            this.showNotification('Không tìm thấy món ăn để xóa', 'error');
            return;
        }
        
        const confirmMessage = `Bạn có chắc chắn muốn xóa "${food.name || id}"?\n\nHành động này sẽ:\n- Xóa hoàn toàn món ăn khỏi trang web\n- Không thể hoàn tác\n\nNhấn OK để xác nhận xóa.`;
        
        if (confirm(confirmMessage)) {
            this.performDelete(id);
        }
    }

    // Get food data
    getFoodData(id) {
        // Try to get from localStorage first
        if (this.foods[id]) {
            return this.foods[id];
        }
        
        // Try to extract from DOM
        const card = this.findCardById(id);
        if (card) {
            return this.extractDataFromCard(card, id);
        }
        
        return null;
    }

    // Find card by ID
    findCardById(id) {
        // Look for buttons with onclick containing the ID
        const buttons = document.querySelectorAll(`button[onclick*="${id}"]`);
        for (let button of buttons) {
            const card = button.closest('.food-card');
            if (card) return card;
        }
        
        // Fallback: try to match by food name
        const cards = document.querySelectorAll('.food-card');
        for (let card of cards) {
            const name = card.querySelector('h3')?.textContent?.trim();
            if (name && this.generateIdFromName(name) === id) {
                return card;
            }
        }
        
        return null;
    }

    // Extract data from card DOM
    extractDataFromCard(card, id) {
        const name = card.querySelector('h3')?.textContent?.trim() || 'Không có tên';
        const description = card.querySelector('p')?.textContent?.trim() || '';
        const priceEl = card.querySelector('.text-orange-600, .font-bold');
        const price = priceEl?.textContent?.trim() || '';
        const categoryEl = card.querySelector('.bg-gradient-to-r span');
        const category = categoryEl?.textContent?.trim() || '';
        const imageEl = card.querySelector('img');
        const image = imageEl?.src || '';
        
        return {
            id,
            name,
            description,
            price,
            category,
            image,
            extractedFromDOM: true
        };
    }

    // Show edit modal
    showEditModal(id, food) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
        modal.onclick = (e) => {
            if (e.target === modal) modal.remove();
        };
        
        modal.innerHTML = `
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-orange-600">
                        <i class="fas fa-utensils mr-2"></i>Chỉnh Sửa Món Ăn
                    </h2>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form class="p-6" onsubmit="foodAdminControls.saveEdit(event, '${id}')">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tên Món Ăn</label>
                            <input type="text" name="name" value="${food.name || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mô Tả</label>
                            <textarea name="description" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">${food.description || ''}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Giá</label>
                                <input type="text" name="price" value="${food.price || ''}" 
                                       placeholder="VD: 25.000 - 35.000 VNĐ"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Danh Mục</label>
                                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                    <option value="">Chọn danh mục</option>
                                    <option value="Đặc Sản Nổi Tiếng" ${food.category === 'Đặc Sản Nổi Tiếng' ? 'selected' : ''}>Đặc Sản Nổi Tiếng</option>
                                    <option value="Món Địa Phương" ${food.category === 'Món Địa Phương' ? 'selected' : ''}>Món Địa Phương</option>
                                    <option value="Món Chay" ${food.category === 'Món Chay' ? 'selected' : ''}>Món Chay</option>
                                    <option value="Đồ Uống" ${food.category === 'Đồ Uống' ? 'selected' : ''}>Đồ Uống</option>
                                    <option value="Bánh Kẹo" ${food.category === 'Bánh Kẹo' ? 'selected' : ''}>Bánh Kẹo</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Đường Dẫn Hình Ảnh</label>
                            <input type="url" name="image" value="${food.image || ''}" 
                                   placeholder="https://example.com/image.jpg"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nguyên Liệu (mỗi dòng một nguyên liệu)</label>
                            <textarea name="ingredients" rows="3" 
                                      placeholder="Bún tươi&#10;Cá lóc&#10;Tôm khô&#10;Rau thơm"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">${food.ingredients ? food.ingredients.join('\n') : ''}</textarea>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3 mt-6 pt-4 border-t">
                        <button type="submit" class="food-btn food-btn-primary">
                            <i class="fas fa-save"></i>
                            Lưu Thay Đổi
                        </button>
                        <button type="button" onclick="this.closest('.fixed').remove()" class="food-btn food-btn-secondary">
                            Hủy
                        </button>
                    </div>
                </form>
            </div>
        `;
        
        document.body.appendChild(modal);
    }

    // Save edit
    saveEdit(event, id) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        
        // Process ingredients
        if (data.ingredients) {
            data.ingredients = data.ingredients.split('\n').filter(item => item.trim());
        }
        
        // Save to localStorage
        this.foods[id] = {
            ...this.foods[id],
            ...data,
            id,
            updatedAt: new Date().toISOString()
        };
        
        this.saveFoods();
        
        // Update DOM if possible
        this.updateCardInDOM(id, data);
        
        // Close modal
        event.target.closest('.fixed').remove();
        
        this.showNotification('Đã cập nhật món ăn thành công!', 'success');
    }

    // Update card in DOM
    updateCardInDOM(id, data) {
        const card = this.findCardById(id);
        if (!card) return;
        
        // Update name
        const nameEl = card.querySelector('h3');
        if (nameEl && data.name) {
            nameEl.textContent = data.name;
        }
        
        // Update description
        const descEl = card.querySelector('p');
        if (descEl && data.description) {
            descEl.textContent = data.description;
        }
        
        // Update price
        const priceEl = card.querySelector('.text-orange-600');
        if (priceEl && data.price) {
            priceEl.textContent = data.price;
        }
        
        // Update category
        const categoryEl = card.querySelector('.bg-gradient-to-r span');
        if (categoryEl && data.category) {
            categoryEl.textContent = data.category;
        }
        
        // Update image
        const imageEl = card.querySelector('img');
        if (imageEl && data.image) {
            imageEl.src = data.image;
        }
    }

    // Perform delete
    performDelete(id) {
        const card = this.findCardById(id);
        
        if (card) {
            // Animate out
            card.style.transition = 'all 0.5s ease';
            card.style.transform = 'scale(0.8)';
            card.style.opacity = '0';
            
            setTimeout(() => {
                card.remove();
                this.showNotification('Đã xóa món ăn thành công!', 'success');
            }, 500);
        }
        
        // Remove from storage
        delete this.foods[id];
        this.saveFoods();
    }

    // Show notification
    showNotification(message, type = 'info') {
        // Remove existing notification
        const existing = document.getElementById('food-admin-notification');
        if (existing) existing.remove();
        
        const notification = document.createElement('div');
        notification.id = 'food-admin-notification';
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transform translate-x-full transition-transform duration-300`;
        
        switch (type) {
            case 'success':
                notification.classList.add('bg-green-500');
                break;
            case 'error':
                notification.classList.add('bg-red-500');
                break;
            case 'warning':
                notification.classList.add('bg-yellow-500');
                break;
            default:
                notification.classList.add('bg-orange-500');
        }
        
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation' : 'info'}-circle"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 4 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }

    // Show add food modal
    showAddFoodModal() {
        const modal = document.createElement('div');
        modal.className = 'food-modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
        modal.onclick = (e) => {
            if (e.target === modal) modal.remove();
        };
        
        modal.innerHTML = `
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-orange-600">
                        <i class="fas fa-plus mr-2"></i>Thêm Món Ăn Mới
                    </h2>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form class="food-form p-6" onsubmit="foodAdminControls.addNewFood(event)">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tên Món Ăn <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" required 
                                   placeholder="VD: Bún Nước Lèo"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mô Tả <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" rows="4" required
                                      placeholder="Mô tả chi tiết về món ăn, hương vị, cách chế biến..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Giá <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="price" required
                                       placeholder="VD: 25.000 - 35.000 VNĐ"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Danh Mục <span class="text-red-500">*</span>
                                </label>
                                <select name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                    <option value="">Chọn danh mục</option>
                                    <option value="Đặc Sản Nổi Tiếng">Đặc Sản Nổi Tiếng</option>
                                    <option value="Món Địa Phương">Món Địa Phương</option>
                                    <option value="Đặc Sản Khmer">Đặc Sản Khmer</option>
                                    <option value="Món Truyền Thống">Món Truyền Thống</option>
                                    <option value="Bánh Đặc Sản">Bánh Đặc Sản</option>
                                    <option value="Món Sáng">Món Sáng</option>
                                    <option value="Tráng Miệng">Tráng Miệng</option>
                                    <option value="Đặc Sản Sông Nước">Đặc Sản Sông Nước</option>
                                    <option value="Món Tập Thể">Món Tập Thể</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Đường Dẫn Hình Ảnh
                            </label>
                            <input type="url" name="image" 
                                   placeholder="https://example.com/image.jpg hoặc để trống để dùng ảnh mặc định"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <p class="text-xs text-gray-500 mt-1">Nếu để trống, hệ thống sẽ sử dụng ảnh mặc định</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nguyên Liệu
                            </label>
                            <textarea name="ingredients" rows="3" 
                                      placeholder="Mỗi dòng một nguyên liệu:&#10;Bún tươi&#10;Cá lóc&#10;Tôm khô&#10;Rau thơm"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Địa Chỉ Quán Ăn Gợi Ý
                            </label>
                            <textarea name="restaurants" rows="2" 
                                      placeholder="Mỗi dòng một địa chỉ:&#10;Quán Cô Ba - Chợ Trà Vinh&#10;Quán Chú Năm - Đường Nguyễn Đáng"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3 mt-6 pt-4 border-t">
                        <button type="submit" class="food-btn food-btn-success">
                            <i class="fas fa-plus"></i>
                            Thêm Món Ăn
                        </button>
                        <button type="button" onclick="this.closest('.fixed').remove()" class="food-btn food-btn-secondary">
                            Hủy
                        </button>
                    </div>
                </form>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Focus on first input
        setTimeout(() => {
            const firstInput = modal.querySelector('input[name="name"]');
            if (firstInput) firstInput.focus();
        }, 100);
    }

    // Add new food
    addNewFood(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        
        // Validate required fields
        if (!data.name || !data.description || !data.price || !data.category) {
            this.showNotification('Vui lòng điền đầy đủ thông tin bắt buộc!', 'error');
            return;
        }
        
        // Generate ID from name
        const id = this.generateIdFromName(data.name);
        if (!id) {
            this.showNotification('Tên món ăn không hợp lệ!', 'error');
            return;
        }
        
        // Check if food already exists
        if (this.foods[id]) {
            this.showNotification('Món ăn này đã tồn tại!', 'error');
            return;
        }
        
        // Process ingredients
        if (data.ingredients) {
            data.ingredients = data.ingredients.split('\n').filter(item => item.trim());
        } else {
            data.ingredients = [];
        }
        
        // Process restaurants
        if (data.restaurants) {
            data.restaurants = data.restaurants.split('\n').filter(item => item.trim());
        } else {
            data.restaurants = [];
        }
        
        // Set default image if not provided
        if (!data.image) {
            data.image = 'images/placeholder.jpg';
        }
        
        // Create food object
        const newFood = {
            id,
            name: data.name,
            description: data.description,
            price: data.price,
            category: data.category,
            image: data.image,
            ingredients: data.ingredients,
            restaurants: data.restaurants,
            createdAt: new Date().toISOString()
        };
        
        // Save to localStorage
        this.foods[id] = newFood;
        this.saveFoods();
        
        // Add to DOM
        this.addFoodCardToDOM(newFood);
        
        // Close modal
        event.target.closest('.fixed').remove();
        
        this.showNotification(`Đã thêm món ăn "${data.name}" thành công!`, 'success');
        
        // Scroll to new card and highlight
        setTimeout(() => {
            const newCard = this.findCardById(id);
            if (newCard) {
                newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Add highlight animation
                newCard.classList.add('food-card-highlight');
                setTimeout(() => {
                    newCard.classList.remove('food-card-highlight');
                }, 3000);
            }
        }, 500);
    }

    // Add food card to DOM
    addFoodCardToDOM(food) {
        const container = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3.gap-8');
        if (!container) {
            console.error('Could not find food container');
            return;
        }
        
        // Get category color
        const categoryColors = {
            'Đặc Sản Nổi Tiếng': 'from-orange-500 to-red-500',
            'Món Địa Phương': 'from-blue-500 to-green-500',
            'Đặc Sản Khmer': 'from-purple-500 to-pink-500',
            'Món Truyền Thống': 'from-green-500 to-teal-500',
            'Bánh Đặc Sản': 'from-yellow-500 to-orange-500',
            'Món Sáng': 'from-red-500 to-pink-500',
            'Tráng Miệng': 'from-cyan-500 to-blue-500',
            'Đặc Sản Sông Nước': 'from-emerald-500 to-teal-500',
            'Món Tập Thể': 'from-red-500 to-pink-500'
        };
        
        const categoryColor = categoryColors[food.category] || 'from-gray-500 to-gray-600';
        
        const cardHTML = `
            <div class="food-card bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500">
                <div class="relative h-64 overflow-hidden">
                    <img src="${food.image}" alt="${food.name}"
                        class="w-full h-full object-cover hover:scale-110 transition-transform duration-700"
                        onerror="this.src='images/placeholder.jpg'">
                    <div class="absolute top-4 left-4">
                        <span class="bg-gradient-to-r ${categoryColor} text-white px-3 py-1 rounded-full text-sm font-semibold">
                            ${food.category}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">${food.name}</h3>
                    <p class="text-gray-600 mb-4">${food.description}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-orange-600 font-bold text-lg">${food.price}</span>
                        <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors"
                                onclick="findRestaurants('${food.id}')">
                            <i class="fas fa-map-marker-alt mr-2"></i>Tìm Quán
                        </button>
                    </div>
                    <div class="admin-actions-card hidden" id="adminActions-${food.id}">
                        <button class="btn btn-warning" onclick="foodAdminControls.editFood('${food.id}')">
                            <i class="fas fa-edit"></i>
                            Sửa
                        </button>
                        <button class="btn btn-danger" onclick="foodAdminControls.deleteFood('${food.id}')">
                            <i class="fas fa-trash"></i>
                            Xóa
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Create temporary container to parse HTML
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = cardHTML;
        const newCard = tempDiv.firstElementChild;
        
        // Add animation class
        newCard.classList.add('food-card-new');
        
        // Insert the card
        container.appendChild(newCard);
        
        // Show admin buttons if in admin mode
        if (this.isAdminMode) {
            const adminActions = newCard.querySelector('.admin-actions-card');
            if (adminActions) {
                adminActions.classList.remove('hidden');
            }
        }
    }

    // Export foods data
    exportFoods() {
        const data = JSON.stringify(this.foods, null, 2);
        const blob = new Blob([data], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        
        const a = document.createElement('a');
        a.href = url;
        a.download = `foods_${new Date().toISOString().split('T')[0]}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        this.showNotification('Đã xuất dữ liệu món ăn thành công!', 'success');
    }
}

// Global functions for onclick handlers
function toggleFoodAdminMode() {
    if (window.foodAdminControls) {
        window.foodAdminControls.toggleAdminMode();
    }
}

function showAddFoodForm() {
    if (window.foodAdminControls) {
        window.foodAdminControls.showAddFoodModal();
    }
}

function exportFoods() {
    if (window.foodAdminControls) {
        window.foodAdminControls.exportFoods();
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.foodAdminControls = new FoodAdminControls();
});

console.log('✅ Food admin controls script loaded successfully!');