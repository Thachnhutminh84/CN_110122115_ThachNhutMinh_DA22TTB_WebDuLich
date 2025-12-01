<?php
/**
 * Model Review - Quản lý đánh giá & bình luận
 */

class Review {
    private $conn;
    private $table = 'reviews';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Tạo review mới
     */
    public function create($data) {
        try {
            // Tạo review_id
            $review_id = 'REV' . date('YmdHis') . rand(100, 999);
            
            $query = "INSERT INTO {$this->table} 
                     (review_id, attraction_id, user_id, user_name, user_email, 
                      rating, title, content, visit_date, status) 
                     VALUES 
                     (:review_id, :attraction_id, :user_id, :user_name, :user_email, 
                      :rating, :title, :content, :visit_date, :status)";
            
            $stmt = $this->conn->prepare($query);
            
            $status = isset($data['user_id']) ? 'approved' : 'pending'; // Auto approve nếu đã đăng nhập
            
            $stmt->execute([
                ':review_id' => $review_id,
                ':attraction_id' => $data['attraction_id'],
                ':user_id' => $data['user_id'] ?? null,
                ':user_name' => $data['user_name'],
                ':user_email' => $data['user_email'] ?? null,
                ':rating' => $data['rating'],
                ':title' => $data['title'] ?? '',
                ':content' => $data['content'],
                ':visit_date' => $data['visit_date'] ?? null,
                ':status' => $status
            ]);
            
            return [
                'success' => true,
                'review_id' => $review_id,
                'message' => 'Cảm ơn bạn đã đánh giá!'
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Upload ảnh review
     */
    public function uploadImages($review_id, $files) {
        try {
            $uploadDir = 'hinhanh/reviews/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $uploaded = [];
            $order = 0;
            
            foreach ($files['tmp_name'] as $key => $tmp_name) {
                if ($files['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = $review_id . '_' . time() . '_' . $order . '.jpg';
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($tmp_name, $filePath)) {
                        // Lưu vào database
                        $query = "INSERT INTO review_images (review_id, image_path, display_order) 
                                 VALUES (:review_id, :image_path, :display_order)";
                        $stmt = $this->conn->prepare($query);
                        $stmt->execute([
                            ':review_id' => $review_id,
                            ':image_path' => $filePath,
                            ':display_order' => $order
                        ]);
                        
                        $uploaded[] = $filePath;
                        $order++;
                    }
                }
            }
            
            return [
                'success' => true,
                'uploaded' => count($uploaded),
                'files' => $uploaded
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi upload: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Lấy reviews theo địa điểm
     */
    public function getByAttraction($attraction_id, $limit = 10, $offset = 0) {
        $query = "SELECT r.*, 
                        (SELECT COUNT(*) FROM review_helpful WHERE review_id = r.review_id) as helpful_count,
                        (SELECT GROUP_CONCAT(image_path) FROM review_images WHERE review_id = r.review_id) as images
                 FROM {$this->table} r
                 WHERE r.attraction_id = :attraction_id 
                 AND r.status = 'approved'
                 ORDER BY r.created_at DESC
                 LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':attraction_id', $attraction_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy thống kê rating
     */
    public function getRatingStats($attraction_id) {
        $query = "SELECT * FROM attraction_ratings WHERE attraction_id = :attraction_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':attraction_id', $attraction_id);
        $stmt->execute();
        
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$stats) {
            return [
                'total_reviews' => 0,
                'average_rating' => 0,
                'rating_5_star' => 0,
                'rating_4_star' => 0,
                'rating_3_star' => 0,
                'rating_2_star' => 0,
                'rating_1_star' => 0
            ];
        }
        
        return $stats;
    }
    
    /**
     * Vote review hữu ích
     */
    public function markHelpful($review_id, $user_id = null, $ip_address = null) {
        try {
            $query = "INSERT INTO review_helpful (review_id, user_id, ip_address) 
                     VALUES (:review_id, :user_id, :ip_address)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':review_id' => $review_id,
                ':user_id' => $user_id,
                ':ip_address' => $ip_address
            ]);
            
            // Cập nhật count
            $updateQuery = "UPDATE {$this->table} 
                           SET helpful_count = (SELECT COUNT(*) FROM review_helpful WHERE review_id = :review_id)
                           WHERE review_id = :review_id2";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->execute([
                ':review_id' => $review_id,
                ':review_id2' => $review_id
            ]);
            
            return ['success' => true, 'message' => 'Cảm ơn phản hồi của bạn!'];
            
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                return ['success' => false, 'message' => 'Bạn đã vote rồi!'];
            }
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }
    
    /**
     * Lấy tất cả reviews (cho admin)
     */
    public function getAll($status = null) {
        $query = "SELECT r.*, a.name as attraction_name
                 FROM {$this->table} r
                 LEFT JOIN attractions a ON r.attraction_id = a.attraction_id";
        
        if ($status) {
            $query .= " WHERE r.status = :status";
        }
        
        $query .= " ORDER BY r.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Cập nhật trạng thái review
     */
    public function updateStatus($review_id, $status) {
        $query = "UPDATE {$this->table} SET status = :status WHERE review_id = :review_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':review_id' => $review_id
        ]);
    }
    
    /**
     * Xóa review
     */
    public function delete($review_id) {
        // Xóa ảnh trước
        $query = "SELECT image_path FROM review_images WHERE review_id = :review_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':review_id' => $review_id]);
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($images as $img) {
            if (file_exists($img['image_path'])) {
                unlink($img['image_path']);
            }
        }
        
        // Xóa review (cascade sẽ xóa images và helpful)
        $query = "DELETE FROM {$this->table} WHERE review_id = :review_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':review_id' => $review_id]);
    }
}
