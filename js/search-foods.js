/**
 * Search Foods - Tìm kiếm món ăn
 * Giống hệt search-attractions.js - Filter trực tiếp trên DOM
 */

/**
 * Hàm chính để xử lý việc tìm kiếm (lọc) các món ăn
 */
function handleFoodsSearch() {
    // Lấy giá trị tìm kiếm và chuyển về chữ thường
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    const clearBtn = document.getElementById('clearBtn');
    
    // Hiển thị hoặc ẩn nút xóa
    if (searchTerm.length > 0) {
        clearBtn.classList.add('show');
    } else {
        clearBtn.classList.remove('show');
    }
    
    // Lấy tất cả các thẻ món ăn
    const allFoodCards = document.querySelectorAll('.food-card');
    let foundCount = 0;
    
    // Lặp qua từng thẻ để so sánh
    allFoodCards.forEach(card => {
        // Lấy tên món ăn từ thuộc tính data-name
        const foodName = card.getAttribute('data-name') ? card.getAttribute('data-name').toLowerCase() : '';
        
        // Lấy tiêu đề chính
        let titleElement = card.querySelector('h3');
        const foodTitle = titleElement ? titleElement.textContent.toLowerCase() : '';
        
        // Lấy mô tả
        let descriptionElement = card.querySelector('p');
        const foodDescription = descriptionElement ? descriptionElement.textContent.toLowerCase() : '';
        
        // Lấy giá
        let priceElement = card.querySelector('.text-orange-600');
        const foodPrice = priceElement ? priceElement.textContent.toLowerCase() : '';
        
        // Kiểm tra xem từ khóa có trong data-name, title, description hoặc price không
        if (!searchTerm || 
            foodName.includes(searchTerm) || 
            foodTitle.includes(searchTerm) ||
            foodDescription.includes(searchTerm) ||
            foodPrice.includes(searchTerm)) {
            
            // Hiển thị thẻ
            card.style.display = 'block';
            foundCount++;
        } else {
            // Ẩn thẻ nếu không khớp
            card.style.display = 'none';
        }
    });
    
    // Cập nhật giao diện nếu không tìm thấy kết quả
    updateNoResultsMessage(foundCount, searchTerm);
}

/**
 * Xóa nội dung tìm kiếm và hiển thị lại tất cả các thẻ
 */
function clearSearch() {
    document.getElementById('searchInput').value = '';
    document.getElementById('clearBtn').classList.remove('show');
    
    // Gọi lại hàm tìm kiếm với chuỗi rỗng để hiển thị tất cả
    handleFoodsSearch();
    
    // Xóa thông báo không có kết quả
    const noResults = document.getElementById('no-results-message');
    if (noResults) {
        noResults.remove();
    }
}

/**
 * Hiển thị thông báo khi không có kết quả
 */
function updateNoResultsMessage(count, term) {
    const container = document.querySelector('.food-grid, main');
    let noResults = document.getElementById('no-results-message');
    
    if (count === 0 && term.length > 0) {
        if (!noResults) {
            noResults = document.createElement('div');
            noResults.id = 'no-results-message';
            noResults.className = 'no-results';
            noResults.style.gridColumn = '1 / -1'; // Chiếm toàn bộ grid
            
            if (container) {
                // Tìm food-grid hoặc thêm vào main
                const foodGrid = container.querySelector('.food-grid') || container;
                foodGrid.prepend(noResults);
            }
        }
        
        noResults.innerHTML = `
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <i class="fas fa-search" style="font-size: 4em; color: #fb923c; margin-bottom: 20px;"></i>
                <h3 style="font-size: 1.8em; color: #1f2937; margin-bottom: 15px;">Không tìm thấy món ăn nào</h3>
                <p style="color: #6b7280; font-size: 1.1em; margin-bottom: 20px;">
                    Không có món ăn nào khớp với từ khóa: <strong>"${term}"</strong>
                </p>
                <p style="color: #9ca3af; margin-bottom: 20px;">Vui lòng thử lại với từ khóa khác hoặc xóa tìm kiếm để xem tất cả món ăn.</p>
                <button onclick="clearSearch()" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; padding: 12px 30px; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 1em;">
                    <i class="fas fa-times" style="margin-right: 8px;"></i>Xóa Tìm Kiếm
                </button>
            </div>
        `;
    } else if (noResults) {
        // Xóa thông báo khi có kết quả hoặc khi ô tìm kiếm trống
        noResults.remove();
    }
}

// Khởi tạo khi trang load
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearBtn');
    
    if (searchInput && clearBtn) {
        // Ẩn nút clear khi load trang
        clearBtn.classList.remove('show');
        
        // Thêm event listener cho input
        searchInput.addEventListener('input', handleFoodsSearch);
        
        // Thêm event listener cho Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleFoodsSearch();
            }
        });
    }
});
