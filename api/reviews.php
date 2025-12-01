<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();

require_once '../config/database.php';
require_once '../models/Review.php';

$database = new Database();
$db = $database->getConnection();
$review = new Review($db);

$method = $_SERVER['REQUEST_METHOD'];
$response = ['success' => false, 'message' => '', 'data' => null];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['attraction_id'])) {
                // Lấy reviews theo địa điểm
                $attraction_id = $_GET['attraction_id'];
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
                
                $reviews = $review->getByAttraction($attraction_id, $limit, $offset);
                $stats = $review->getRatingStats($attraction_id);
                
                $response['success'] = true;
                $response['data'] = [
                    'reviews' => $reviews,
                    'stats' => $stats
                ];
                
            } elseif (isset($_GET['stats'])) {
                // Chỉ lấy thống kê
                $attraction_id = $_GET['stats'];
                $stats = $review->getRatingStats($attraction_id);
                
                $response['success'] = true;
                $response['data'] = $stats;
                
            } elseif (isset($_GET['all'])) {
                // Lấy tất cả (admin)
                $status = $_GET['status'] ?? null;
                $reviews = $review->getAll($status);
                
                $response['success'] = true;
                $response['data'] = $reviews;
            }
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (isset($data['action'])) {
                switch ($data['action']) {
                    case 'create':
                        // Tạo review mới
                        if (empty($data['attraction_id']) || empty($data['rating']) || empty($data['content'])) {
                            throw new Exception("Vui lòng điền đầy đủ thông tin");
                        }
                        
                        // Lấy thông tin user nếu đã đăng nhập
                        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                            $data['user_id'] = $_SESSION['user_id'] ?? null;
                            $data['user_name'] = $_SESSION['full_name'] ?? $_SESSION['username'];
                            $data['user_email'] = $_SESSION['email'] ?? '';
                        }
                        
                        $result = $review->create($data);
                        $response = $result;
                        break;
                        
                    case 'helpful':
                        // Vote review hữu ích
                        $review_id = $data['review_id'];
                        $user_id = $_SESSION['user_id'] ?? null;
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        
                        $result = $review->markHelpful($review_id, $user_id, $ip_address);
                        $response = $result;
                        break;
                        
                    case 'upload_images':
                        // Upload ảnh
                        if (isset($_FILES['images']) && !empty($_POST['review_id'])) {
                            $result = $review->uploadImages($_POST['review_id'], $_FILES['images']);
                            $response = $result;
                        } else {
                            throw new Exception("Không có ảnh để upload");
                        }
                        break;
                }
            }
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            
            // Cập nhật trạng thái (admin only)
            if (isset($data['review_id']) && isset($data['status'])) {
                if ($review->updateStatus($data['review_id'], $data['status'])) {
                    $response['success'] = true;
                    $response['message'] = 'Đã cập nhật trạng thái';
                } else {
                    throw new Exception("Không thể cập nhật");
                }
            }
            break;
            
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"), true);
            
            // Xóa review (admin only)
            if (isset($data['review_id'])) {
                if ($review->delete($data['review_id'])) {
                    $response['success'] = true;
                    $response['message'] = 'Đã xóa review';
                } else {
                    throw new Exception("Không thể xóa");
                }
            }
            break;
    }
    
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
