/**
 * Review System JavaScript
 * Xử lý đánh giá & bình luận
 */

let selectedRating = 0;

// Toggle form đánh giá
function toggleReviewForm() {
    const form = document.getElementById('reviewForm');
    form.classList.toggle('active');
    
    if (form.classList.contains('active')) {
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// Xử lý chọn sao
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#starRating i');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            document.getElementById('ratingValue').value = selectedRating;
            
            // Cập nhật hiển thị sao
            stars.forEach((s, index) => {
                if (index < selectedRating) {
                    s.classList.remove('far');
                    s.classList.add('fas', 'active');
                } else {
                    s.classList.remove('fas', 'active');
                    s.classList.add('far');
                }
            });
        });
        
        // Hover effect
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });
    
    // Reset khi rời chuột
    document.getElementById('starRating').addEventListener('mouseleave', function() {
        stars.forEach((s, index) => {
            if (index < selectedRating) {
                s.classList.add('active');
            } else {
                s.classList.remove('active');
            }
        });
    });
});

// Preview ảnh trước khi upload
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files) {
        const files = Array.from(input.files).slice(0, 5); // Tối đa 5 ảnh
        
        files.forEach(file => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            };
            
            reader.readAsDataURL(file);
        });
    }
}

// Submit review
document.getElementById('submitReviewForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (selectedRating === 0) {
        alert('Vui lòng chọn số sao đánh giá!');
        return;
    }
    
    const formData = new FormData(this);
    const data = {
        action: 'create',
        attraction_id: formData.get('attraction_id'),
        rating: parseInt(formData.get('rating')),
        user_name: formData.get('user_name'),
        user_email: formData.get('user_email'),
        title: formData.get('title'),
        content: formData.get('content'),
        visit_date: formData.get('visit_date')
    };
    
    try {
        const response = await fetch('api/reviews.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Upload ảnh nếu có
            const images = document.getElementById('reviewImages').files;
            if (images.length > 0) {
                await uploadReviewImages(result.review_id, images);
            }
            
            alert('✅ ' + result.message);
            
            // Reset form
            this.reset();
            selectedRating = 0;
            document.getElementById('imagePreview').innerHTML = '';
            document.querySelectorAll('#starRating i').forEach(s => {
                s.classList.remove('fas', 'active');
                s.classList.add('far');
            });
            
            // Reload reviews
            loadReviews(data.attraction_id);
            
            // Đóng form
            toggleReviewForm();
        } else {
            alert('❌ ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Có lỗi xảy ra. Vui lòng thử lại!');
    }
});

// Upload ảnh review
async function uploadReviewImages(reviewId, files) {
    const formData = new FormData();
    formData.append('action', 'upload_images');
    formData.append('review_id', reviewId);
    
    for (let i = 0; i < files.length; i++) {
        formData.append('images[]', files[i]);
    }
    
    try {
        const response = await fetch('api/reviews.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error uploading images:', error);
        return { success: false };
    }
}

// Load reviews
async function loadReviews(attractionId) {
    try {
        const response = await fetch(`api/reviews.php?attraction_id=${attractionId}`);
        const result = await response.json();
        
        if (result.success) {
            displayRatingStats(result.data.stats);
            displayReviews(result.data.reviews);
        }
    } catch (error) {
        console.error('Error loading reviews:', error);
        document.getElementById('reviewsList').innerHTML = `
            <div style="text-align: center; padding: 40px; color: #ef4444;">
                <i class="fas fa-exclamation-circle" style="font-size: 2em;"></i>
                <p>Không thể tải đánh giá. Vui lòng thử lại!</p>
            </div>
        `;
    }
}

// Hiển thị thống kê rating
function displayRatingStats(stats) {
    const avgRating = parseFloat(stats.average_rating).toFixed(1);
    const totalReviews = stats.total_reviews;
    
    // Số rating
    document.getElementById('avgRating').textContent = avgRating;
    
    // Sao
    const starsHtml = generateStars(avgRating);
    document.getElementById('avgStars').innerHTML = starsHtml;
    
    // Số lượng
    document.getElementById('totalReviews').textContent = `${totalReviews} đánh giá`;
    
    // Rating bars
    const barsHtml = `
        ${generateRatingBar(5, stats.rating_5_star, totalReviews)}
        ${generateRatingBar(4, stats.rating_4_star, totalReviews)}
        ${generateRatingBar(3, stats.rating_3_star, totalReviews)}
        ${generateRatingBar(2, stats.rating_2_star, totalReviews)}
        ${generateRatingBar(1, stats.rating_1_star, totalReviews)}
    `;
    document.getElementById('ratingBars').innerHTML = barsHtml;
}

// Tạo HTML sao
function generateStars(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    
    let html = '';
    for (let i = 0; i < fullStars; i++) {
        html += '<i class="fas fa-star"></i>';
    }
    if (hasHalfStar) {
        html += '<i class="fas fa-star-half-alt"></i>';
    }
    for (let i = 0; i < emptyStars; i++) {
        html += '<i class="far fa-star"></i>';
    }
    
    return html;
}

// Tạo rating bar
function generateRatingBar(star, count, total) {
    const percentage = total > 0 ? (count / total * 100) : 0;
    
    return `
        <div class="rating-bar">
            <div class="rating-bar-label">${star} <i class="fas fa-star" style="color: #fbbf24; font-size: 0.8em;"></i></div>
            <div class="rating-bar-fill">
                <div class="rating-bar-progress" style="width: ${percentage}%"></div>
            </div>
            <div class="rating-bar-count">${count}</div>
        </div>
    `;
}

// Hiển thị danh sách reviews
function displayReviews(reviews) {
    const container = document.getElementById('reviewsList');
    
    if (reviews.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #6b7280;">
                <i class="fas fa-comments" style="font-size: 3em; color: #d1d5db;"></i>
                <h3>Chưa có đánh giá nào</h3>
                <p>Hãy là người đầu tiên đánh giá địa điểm này!</p>
            </div>
        `;
        return;
    }
    
    const html = reviews.map(review => {
        const images = review.images ? review.images.split(',') : [];
        const imagesHtml = images.length > 0 ? `
            <div class="review-images">
                ${images.map(img => `<img src="${img}" alt="Review image" onclick="viewImage('${img}')">`).join('')}
            </div>
        ` : '';
        
        return `
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            ${review.user_name.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <div class="reviewer-name">${review.user_name}</div>
                            <div class="review-date">${formatDate(review.created_at)}</div>
                        </div>
                    </div>
                    <div class="review-rating">
                        ${generateStars(review.rating)}
                    </div>
                </div>
                
                ${review.title ? `<div class="review-title">${review.title}</div>` : ''}
                
                <div class="review-content">${review.content}</div>
                
                ${imagesHtml}
                
                <div class="review-actions">
                    <button class="helpful-btn" onclick="markHelpful('${review.review_id}', this)">
                        <i class="far fa-thumbs-up"></i> Hữu ích (${review.helpful_count || 0})
                    </button>
                </div>
            </div>
        `;
    }).join('');
    
    container.innerHTML = html;
}

// Format ngày
function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

// Đánh dấu review hữu ích
async function markHelpful(reviewId, button) {
    if (button.classList.contains('voted')) {
        return;
    }
    
    try {
        const response = await fetch('api/reviews.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'helpful',
                review_id: reviewId
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            button.classList.add('voted');
            const countText = button.textContent.match(/\d+/);
            const newCount = countText ? parseInt(countText[0]) + 1 : 1;
            button.innerHTML = `<i class="fas fa-thumbs-up"></i> Hữu ích (${newCount})`;
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Xem ảnh full size
function viewImage(src) {
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        cursor: pointer;
    `;
    
    const img = document.createElement('img');
    img.src = src;
    img.style.cssText = 'max-width: 90%; max-height: 90%; border-radius: 8px;';
    
    modal.appendChild(img);
    modal.onclick = () => modal.remove();
    
    document.body.appendChild(modal);
}
