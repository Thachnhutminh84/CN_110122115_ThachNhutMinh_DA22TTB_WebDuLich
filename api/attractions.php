<?php
/**
 * API quản lý địa điểm du lịch
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

require_once '../config/database.php';
require_once '../models/Attraction.php';

// Lấy method và dữ liệu
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

try {
    $database = new Database();
    $db = $database->getConnection();
    $attraction = new Attraction($db);

    switch ($method) {
        case 'GET':
            // Lấy danh sách hoặc chi tiết
            if (isset($_GET['id'])) {
                $attraction->attraction_id = $_GET['id'];
                if ($attraction->readOne()) {
                    echo json_encode([
                        'success' => true,
                        'data' => [
                            'id' => $attraction->attraction_id,
                            'name' => $attraction->name,
                            'description' => $attraction->description,
                            'location' => $attraction->location,
                            'category' => $attraction->category,
                            'ticket_price' => $attraction->ticket_price,
                            'image_url' => $attraction->image_url,
                            'status' => $attraction->status
                        ]
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không tìm thấy địa điểm']);
                }
            } else {
                $stmt = $attraction->readAll();
                $attractions = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $attractions[] = $row;
                }
                echo json_encode(['success' => true, 'data' => $attractions]);
            }
            break;

        case 'POST':
            // Thêm địa điểm mới
            if (empty($input['name']) || empty($input['description'])) {
                echo json_encode(['success' => false, 'message' => 'Thiếu thông tin bắt buộc']);
                break;
            }

            // Tạo attraction_id từ tên
            $attraction->attraction_id = generateAttractionId($input['name']);
            $attraction->name = $input['name'];
            $attraction->description = $input['description'];
            $attraction->location = $input['location'] ?? '';
            $attraction->category = $input['category'] ?? '';
            $attraction->ticket_price = $input['price'] ?? 'Miễn phí';
            $attraction->image_url = $input['image_url'] ?? 'hinhanh/placeholder.jpg';
            $attraction->status = 'active';

            // Thêm vào database
            $query = "INSERT INTO attractions 
                     (attraction_id, name, description, location, category, ticket_price, image_url, status) 
                     VALUES 
                     (:attraction_id, :name, :description, :location, :category, :ticket_price, :image_url, :status)";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':attraction_id', $attraction->attraction_id);
            $stmt->bindParam(':name', $attraction->name);
            $stmt->bindParam(':description', $attraction->description);
            $stmt->bindParam(':location', $attraction->location);
            $stmt->bindParam(':category', $attraction->category);
            $stmt->bindParam(':ticket_price', $attraction->ticket_price);
            $stmt->bindParam(':image_url', $attraction->image_url);
            $stmt->bindParam(':status', $attraction->status);

            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã thêm địa điểm thành công!',
                    'data' => [
                        'id' => $attraction->attraction_id,
                        'name' => $attraction->name
                    ]
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể thêm địa điểm']);
            }
            break;

        case 'PUT':
            // Cập nhật địa điểm
            if (empty($input['id'])) {
                echo json_encode(['success' => false, 'message' => 'Thiếu ID địa điểm']);
                break;
            }

            $attraction->attraction_id = $input['id'];
            $attraction->name = $input['name'];
            $attraction->description = $input['description'];
            $attraction->location = $input['location'] ?? '';
            $attraction->category = $input['category'] ?? '';
            $attraction->ticket_price = $input['price'] ?? '';
            $attraction->image_url = $input['image_url'] ?? '';

            $query = "UPDATE attractions 
                     SET name = :name, 
                         description = :description, 
                         location = :location, 
                         category = :category, 
                         ticket_price = :ticket_price, 
                         image_url = :image_url 
                     WHERE attraction_id = :attraction_id";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':name', $attraction->name);
            $stmt->bindParam(':description', $attraction->description);
            $stmt->bindParam(':location', $attraction->location);
            $stmt->bindParam(':category', $attraction->category);
            $stmt->bindParam(':ticket_price', $attraction->ticket_price);
            $stmt->bindParam(':image_url', $attraction->image_url);
            $stmt->bindParam(':attraction_id', $attraction->attraction_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Đã cập nhật địa điểm thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể cập nhật địa điểm']);
            }
            break;

        case 'DELETE':
            // Xóa địa điểm
            if (empty($input['id'])) {
                echo json_encode(['success' => false, 'message' => 'Thiếu ID địa điểm']);
                break;
            }

            $query = "DELETE FROM attractions WHERE attraction_id = :attraction_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':attraction_id', $input['id']);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Đã xóa địa điểm thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể xóa địa điểm']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Method không hợp lệ']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}

// Helper function
function generateAttractionId($name) {
    // Chuyển tên thành ID (loại bỏ dấu, chuyển thành slug)
    $id = strtolower($name);
    $id = preg_replace('/[^a-z0-9]+/', '-', $id);
    $id = trim($id, '-');
    return $id . '-' . time(); // Thêm timestamp để tránh trùng
}
?>
