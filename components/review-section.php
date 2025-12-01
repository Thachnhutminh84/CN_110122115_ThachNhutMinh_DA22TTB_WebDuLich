<?php
/**
 * Component: Review Section
 * Hiển thị đánh giá và form viết review
 * 
 * Sử dụng: include 'components/review-section.php';
 * Yêu cầu: $attraction_id phải được định nghĩa trước
 */

if (!isset($attraction_id)) {
    die('Error: $attraction_id is required');
}
?>

<!-- CSS cho Review Section -->
<style>
.review-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin: 30px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.rating-summary {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 30px;
    padding: 30px;
    background: #f9fafb;
    border-radius: 12px;
    margin-bottom: 30px;
}

.rating-overview {
    text-align: center;
}

.rating-number {
    font-size: 4em;
    font-weight: bold;
    color: #667eea;
    line-height: 1;
}

.rating-stars {
    font-size: 1.5em;
    color: #fbbf24;
    margin: 10px 0;
}

.rating-count {
    color: #6b7280;
    font-size: 0.9em;
}

.rating-bars {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.rating-bar {
    display: flex;
    align-items: center;
    gap: 10px;
}

.rating-bar-label {
    min-width: 60px;
    font-size: 0.9em;
    color: #6b7280;
}

.rating-bar-fill {
    flex: 1;
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
}

.rating-bar-progress {
    height: 100%;
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
    transition: width 0.3s;
}

.rating-bar-count {
    min-width: 40px;
    text-align: right;
    font-size: 0.9em;
    color: #6b7280;
}

.write-review-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 10px;
    font-size: 1.1em;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    margin: 20px 0;
    transition: all 0.3s;
}

.write-review-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.review-form {
    background: #f9fafb;
    padding: 30px;
    border-radius: 12px;
    margin: 20px 0;
    display: none;
}

.review-form.active {
    display: block;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1em;
    transition: all 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
}

.star-rating {
    display: flex;
    gap: 10px;
    font-size: 2em;
}

.star-rating i {
    cursor: pointer;
    color: #d1d5db;
    transition: all 0.2s;
}

.star-rating i.active,
.star-rating i:hover {
    color: #fbbf24;
}

.image-upload {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
}

.image-upload:hover {
    border-color: #667eea;
    background: #f9fafb;
}

.image-preview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
    margin-top: 15px;
}

.image-preview img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
}

.reviews-list {
    margin-top: 30px;
}

.review-item {
    padding: 25px;
    border-bottom: 1px solid #e5e7eb;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 15px;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.reviewer-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5em;
    font-weight: bold;
}

.reviewer-name {
    font-weight: 600;
    color: #1f2937;
}

.review-date {
    font-size: 0.85em;
    color: #6b7280;
}

.review-rating {
    color: #fbbf24;
}

.review-title {
    font-weight: 600;
    font-size: 1.1em;
    margin-bottom: 10px;
    color: #1f2937;
}

.review-content {
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 15px;
}

.review-images {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
    margin: 15px 0;
}

.review-images img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.review-images img:hover {
    transform: scale(1.05);
}

.review-actions {
    display: flex;
    gap: 20px;
    margin-top: 15px;
}

.helpful-btn {
    background: none;
    border: 1px solid #d1d5db;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
    color: #6b7280;
}

.helpful-btn:hover {
    border-color: #667eea;
    color: #667eea;
}

.helpful-btn.voted {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

@media (max-width: 768px) {
    .rating-summary {
        grid-template-columns: 1fr;
    }
    
    .review-header {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

<!-- HTML Review Section -->
<div class="review-section" id="reviews">
    <h2 style="font-size: 2em; margin-bottom: 20px; color: #1f2937;">
        <i class="fas fa-star" style="color: #fbbf24;"></i>
        Đánh Giá & Nhận Xét
    </h2>
    
    <!-- Rating Summary -->
    <div class="rating-summary">
        <div class="rating-overview">
            <div class="rating-number" id="avgRating">0</div>
            <div class="rating-stars" id="avgStars"></div>
            <div class="rating-count" id="totalReviews">0 đánh giá</div>
        </div>
        
        <div class="rating-bars" id="ratingBars">
            <!-- Sẽ được load bằng JavaScript -->
        </div>
    </div>
    
    <!-- Write Review Button -->
    <button class="write-review-btn" onclick="toggleReviewForm()">
        <i class="fas fa-edit"></i> Viết Đánh Giá
    </button>
    
    <!-- Review Form -->
    <div class="review-form" id="reviewForm">
        <h3 style="margin-bottom: 20px;">Chia sẻ trải nghiệm của bạn</h3>
        
        <form id="submitReviewForm" enctype="multipart/form-data">
            <input type="hidden" name="attraction_id" value="<?php echo htmlspecialchars($attraction_id); ?>">
            
            <div class="form-group">
                <label>Đánh giá của bạn *</label>
                <div class="star-rating" id="starRating">
                    <i class="far fa-star" data-rating="1"></i>
                    <i class="far fa-star" data-rating="2"></i>
                    <i class="far fa-star" data-rating="3"></i>
                    <i class="far fa-star" data-rating="4"></i>
                    <i class="far fa-star" data-rating="5"></i>
                </div>
                <input type="hidden" name="rating" id="ratingValue" required>
            </div>
            
            <div class="form-group">
                <label>Họ và tên *</label>
                <input type="text" name="user_name" class="form-control" required 
                       value="<?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="user_email" class="form-control"
                       value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Tiêu đề</label>
                <input type="text" name="title" class="form-control" placeholder="Tóm tắt trải nghiệm của bạn">
            </div>
            
            <div class="form-group">
                <label>Nội dung đánh giá *</label>
                <textarea name="content" class="form-control" rows="5" required 
                          placeholder="Chia sẻ chi tiết về trải nghiệm của bạn..."></textarea>
            </div>
            
            <div class="form-group">
                <label>Ngày tham quan</label>
                <input type="date" name="visit_date" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Thêm ảnh (tối đa 5 ảnh)</label>
                <div class="image-upload" onclick="document.getElementById('reviewImages').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 3em; color: #d1d5db;"></i>
                    <p>Click để chọn ảnh</p>
                    <input type="file" id="reviewImages" name="images[]" multiple accept="image/*" 
                           style="display: none;" onchange="previewImages(this)">
                </div>
                <div class="image-preview" id="imagePreview"></div>
            </div>
            
            <button type="submit" class="write-review-btn">
                <i class="fas fa-paper-plane"></i> Gửi Đánh Giá
            </button>
        </form>
    </div>
    
    <!-- Reviews List -->
    <div class="reviews-list" id="reviewsList">
        <div style="text-align: center; padding: 40px; color: #6b7280;">
            <i class="fas fa-spinner fa-spin" style="font-size: 2em;"></i>
            <p>Đang tải đánh giá...</p>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="js/reviews.js"></script>
<script>
// Khởi tạo review system
const attractionId = '<?php echo $attraction_id; ?>';
loadReviews(attractionId);
</script>
