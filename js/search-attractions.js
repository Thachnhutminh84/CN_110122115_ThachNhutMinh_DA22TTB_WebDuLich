/**
 * Hàm chính để xử lý việc tìm kiếm (lọc) các địa điểm du lịch
 */
function handleAttractionsSearch() {
    // Lấy giá trị tìm kiếm và chuyển về chữ thường
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    const clearBtn = document.getElementById('clearBtn');

    // Hiển thị hoặc ẩn nút xóa
    if (clearBtn) {
        if (searchTerm.length > 0) {
            clearBtn.classList.add('show');
        } else {
            clearBtn.classList.remove('show');
        }
    }

    // Lấy tất cả các thẻ địa điểm du lịch
    const allAttractionCards = document.querySelectorAll('.attraction-card, .featured-card');
    let foundCount = 0;

    // Lặp qua từng thẻ để so sánh
    allAttractionCards.forEach(card => {
        // Lấy tên địa điểm từ thuộc tính data-name
        const attractionName = card.getAttribute('data-name') ? card.getAttribute('data-name').toLowerCase() : '';

        // Lấy tiêu đề chính
        let titleElement = card.querySelector('.featured-title, .card-title');
        const attractionTitle = titleElement ? titleElement.textContent.toLowerCase() : '';

        // Lấy mô tả
        let descriptionElement = card.querySelector('.featured-description, .card-description');
        const attractionDescription = descriptionElement ? descriptionElement.textContent.toLowerCase() : '';

        // Lấy địa điểm
        let locationElement = card.querySelector('.card-location');
        const attractionLocation = locationElement ? locationElement.textContent.toLowerCase() : '';

        // Kiểm tra xem từ khóa có trong data-name, title, description hoặc location không
        if (!searchTerm ||
            attractionName.includes(searchTerm) ||
            attractionTitle.includes(searchTerm) ||
            attractionDescription.includes(searchTerm) ||
            attractionLocation.includes(searchTerm)) {

            // Hiển thị thẻ
            card.style.display = 'block';

            // Đảm bảo thẻ Featured (nếu có) hiển thị đúng layout
            if (card.classList.contains('featured-card')) {
                card.style.display = 'grid';
            }

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
 * Lọc địa điểm theo category với hiệu ứng fade
 */
function filterByCategory(category) {
    console.log('🔍 Filtering by category:', category);
    
    const allAttractionCards = document.querySelectorAll('.attraction-card, .featured-card');
    let foundCount = 0;

    console.log('📦 Total cards found:', allAttractionCards.length);

    // Fade out tất cả cards trước
    allAttractionCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'scale(0.95)';
    });

    // Sau 200ms, ẩn/hiện cards và fade in
    setTimeout(() => {
        allAttractionCards.forEach((card, index) => {
            const cardCategory = card.getAttribute('data-category') || '';
            const cardName = card.getAttribute('data-name') || 'Unknown';
            
            console.log(`Card ${index + 1}: "${cardName}" - Category: "${cardCategory}"`);

            // So sánh không phân biệt hoa thường và loại bỏ khoảng trắng thừa
            const normalizedCardCategory = cardCategory.trim().toLowerCase();
            const normalizedFilterCategory = category.trim().toLowerCase();

            if (category === 'all' || normalizedCardCategory === normalizedFilterCategory) {
                console.log(`✅ Showing card: ${cardName}`);
                
                card.style.display = 'block';
                if (card.classList.contains('featured-card')) {
                    card.style.display = 'grid';
                }

                // Fade in với delay ngẫu nhiên để tạo hiệu ứng stagger
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, Math.random() * 100);

                foundCount++;
            } else {
                console.log(`❌ Hiding card: ${cardName}`);
                card.style.display = 'none';
                card.style.opacity = '0';
            }
        });

        console.log(`📊 Found ${foundCount} matching cards`);

        // Hiển thị thông báo nếu không có kết quả
        if (foundCount === 0) {
            updateNoResultsMessage(0, `danh mục ${category}`);
        } else {
            // Xóa thông báo không có kết quả
            const noResults = document.getElementById('no-results-message');
            if (noResults) {
                noResults.remove();
            }
        }
    }, 200);

    // Cập nhật active state cho các nút filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    const activeBtn = document.querySelector(`.filter-btn[data-category="${category}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
        console.log('✅ Active button set:', category);
    } else {
        console.log('⚠️ Active button not found for:', category);
    }
}

/**
 * Xóa nội dung tìm kiếm và hiển thị lại tất cả các thẻ
 */
function clearSearch() {
    document.getElementById('searchInput').value = '';
    document.getElementById('clearBtn').classList.remove('show');

    // Gọi lại hàm tìm kiếm với chuỗi rỗng để hiển thị tất cả
    handleAttractionsSearch();

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
    const container = document.querySelector('.attraction-grid');
    let noResults = document.getElementById('no-results-message');

    if (count === 0 && term.length > 0) {
        if (!noResults) {
            noResults = document.createElement('div');
            noResults.id = 'no-results-message';
            noResults.className = 'no-results';
            noResults.style.gridColumn = '1 / -1'; // Chiếm toàn bộ grid
            container.prepend(noResults);
        }

        noResults.innerHTML = `
            <div style="text-align: center; padding: 60px 20px;">
                <i class="fas fa-search" style="font-size: 4em; color: #d1d5db; margin-bottom: 20px;"></i>
                <h3 style="font-size: 1.8em; color: #1f2937; margin-bottom: 15px;">Không tìm thấy địa điểm nào</h3>
                <p style="color: #6b7280; font-size: 1.1em; margin-bottom: 20px;">
                    Không có địa điểm nào khớp với từ khóa: <strong>"${term}"</strong>
                </p>
                <p style="color: #9ca3af;">Vui lòng thử lại với từ khóa khác hoặc xóa tìm kiếm để xem tất cả địa điểm.</p>
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

    if (searchInput) {
        // Thêm event listener cho input
        searchInput.addEventListener('input', handleAttractionsSearch);

        // Thêm event listener cho Enter key
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleAttractionsSearch();
            }
        });
    }

    if (clearBtn) {
        clearBtn.classList.remove('show');
    }

    // Thêm event listener cho các nút filter
    const filterBtns = document.querySelectorAll('.filter-btn');
    console.log('🎯 Found filter buttons:', filterBtns.length);
    
    filterBtns.forEach((btn, index) => {
        const btnCategory = btn.getAttribute('data-category');
        console.log(`Button ${index + 1}: "${btn.textContent.trim()}" - Category: "${btnCategory}"`);
        
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const category = this.getAttribute('data-category');
            console.log('🖱️ Button clicked! Category:', category);
            
            filterByCategory(category);

            // Cập nhật URL mà không reload trang
            const url = new URL(window.location);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            window.history.pushState({}, '', url);
        });
    });
});
