// ===== SETUP NÚT TÌM QUÁN CHO TRANG ẨM THỰC =====

// Danh sách món ăn theo thứ tự xuất hiện trên trang
const FOOD_TYPES_ORDER = [
    'bun-nuoc-leo',        // Bún Nước Lèo
    'banh-canh-ben-co',    // Bánh Canh Bến Có  
    'chu-u-rang-me',       // Chù Ụ Rang Me
    'bun-suong',           // Bún Suông
    'banh-xeo-khmer',      // Bánh Xèo Khmer
    'nom-banh-chok',       // Nom Banh Chok
    'banh-it',             // Bánh Ít Lá Gai
    'banh-can',            // Bánh Căn
    'che-khmer',           // Chè Khmer
    'com-tam',             // Cơm Tấm Sườn Nướng
    'ca-loc-nuong-trui',   // Cá Lóc Nướng Trui
    'lau-mam'              // Lẩu Mắm
];

// Function setup nút tìm quán
function setupRestaurantButtons() {
    console.log('🔧 Setting up restaurant finder buttons...');
    
    // Tìm tất cả nút có text "Tìm Quán"
    const allButtons = document.querySelectorAll('button');
    const restaurantButtons = [];
    
    allButtons.forEach(button => {
        if (button.textContent.includes('Tìm Quán')) {
            restaurantButtons.push(button);
        }
    });
    
    console.log(`📊 Found ${restaurantButtons.length} restaurant buttons`);
    
    // Gán sự kiện cho từng nút theo thứ tự
    restaurantButtons.forEach((button, index) => {
        if (index < FOOD_TYPES_ORDER.length) {
            const foodType = FOOD_TYPES_ORDER[index];
            
            // Gán sự kiện click
            button.onclick = function(e) {
                e.preventDefault();
                console.log(`🍽️ Opening restaurant finder for: ${foodType}`);
                
                try {
                    if (typeof findRestaurants === 'function') {
                        findRestaurants(foodType);
                    } else if (typeof restaurantFinder !== 'undefined' && 
                               typeof restaurantFinder.openRestaurantModal === 'function') {
                        restaurantFinder.openRestaurantModal(foodType);
                    } else {
                        throw new Error('Restaurant finder system not available');
                    }
                } catch (error) {
                    console.error('❌ Error opening restaurant finder:', error);
                    alert(`❌ Không thể mở tìm quán: ${error.message}`);
                }
            };
            
            console.log(`✅ Setup button ${index + 1}: ${foodType}`);
        } else {
            console.warn(`⚠️ No food type for button ${index + 1}`);
        }
    });
    
    console.log(`🎯 Setup completed for ${restaurantButtons.length} buttons`);
}

// Function kiểm tra hệ thống
function checkRestaurantSystem() {
    console.log('🔍 Checking restaurant system...');
    
    let status = {
        restaurantFinder: typeof restaurantFinder !== 'undefined',
        findRestaurants: typeof findRestaurants === 'function',
        dataLoaded: false,
        totalRestaurants: 0
    };
    
    if (status.restaurantFinder && restaurantFinder.restaurants) {
        status.dataLoaded = true;
        status.totalRestaurants = Object.keys(restaurantFinder.restaurants).length;
    }
    
    console.log('📊 System status:', status);
    return status;
}

// Function test nhanh
function quickTestRestaurant(foodType = 'bun-nuoc-leo') {
    console.log(`🧪 Quick test: ${foodType}`);
    
    try {
        if (typeof findRestaurants === 'function') {
            findRestaurants(foodType);
            console.log('✅ Test successful via findRestaurants');
        } else if (typeof restaurantFinder !== 'undefined') {
            restaurantFinder.openRestaurantModal(foodType);
            console.log('✅ Test successful via restaurantFinder');
        } else {
            throw new Error('No restaurant system available');
        }
    } catch (error) {
        console.error('❌ Test failed:', error);
        alert(`❌ Test thất bại: ${error.message}`);
    }
}

// Auto setup khi DOM ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Restaurant button setup script loaded');
    
    // Đợi một chút để các script khác load xong
    setTimeout(() => {
        setupRestaurantButtons();
        checkRestaurantSystem();
    }, 1500);
});

// Export functions để có thể gọi từ console
window.setupRestaurantButtons = setupRestaurantButtons;
window.checkRestaurantSystem = checkRestaurantSystem;
window.quickTestRestaurant = quickTestRestaurant;

console.log('✅ Restaurant button setup script ready!');