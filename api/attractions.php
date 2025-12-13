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

// Nhận dữ liệu từ cả JSON và FormData
if ($method === 'POST' || $method === 'PUT') {
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
    
    if (strpos($contentType, 'application/json') !== false) {
        // Dữ liệu JSON
        $input = json_decode(file_get_contents('php://input'), true);
    } else {
        // Dữ liệu FormData
        $input = $_POST;
    }
} else {
    $input = json_decode(file_get_contents('php://input'), true);
}

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
            $name = isset($input['name']) ? trim($input['name']) : '';
            $description = isset($input['description']) ? trim($input['description']) : '';
            $address = isset($input['address']) ? trim($input['address']) : '';
            
            if (empty($name) || empty($description)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu thông tin bắt buộc (tên và mô tả)']);
                break;
            }

            // Tạo attraction_id từ tên
            $attraction->attraction_id = isset($input['attraction_id']) && !empty($input['attraction_id'])
                ? $input['attraction_id'] 
                : generateAttractionId($name);
            
            $attraction->name = $name;
            $attraction->description = $description;
            $attraction->location = !empty($address) ? $address : '';
            $attraction->category = isset($input['category']) ? $input['category'] : '';
            $attraction->ticket_price = isset($input['entrance_fee']) ? $input['entrance_fee'] : 'Miễn phí';
            $attraction->image_url = isset($input['image_url']) && !empty($input['image_url']) 
                ? $input['image_url'] 
                : 'hinhanh/DulichtpTV/aobaom-02-1024x686.jpg';
            
            $opening_hours = isset($input['opening_hours']) ? $input['opening_hours'] : '6:00 - 18:00';
            $latitude = isset($input['latitude']) ? $input['latitude'] : null;
            $longitude = isset($input['longitude']) ? $input['longitude'] : null;
            $highlights = isset($input['highlights']) ? $input['highlights'] : '';
            $facilities = isset($input['facilities']) ? $input['facilities'] : '';
            $best_time = isset($input['best_time']) ? $input['best_time'] : '';
            $contact = isset($input['contact']) ? $input['contact'] : '';
            $status = isset($input['status']) ? $input['status'] : 'active';

            // Thêm vào database với đầy đủ trường
            $query = "INSERT INTO attractions 
                     (attraction_id, name, description, location, category, ticket_price, image_url, 
                      opening_hours, highlights, facilities, best_time, contact, status) 
                     VALUES 
                     (:attraction_id, :name, :description, :location, :category, :ticket_price, :image_url,
                      :opening_hours, :highlights, :facilities, :best_time, :contact, :status)";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':attraction_id', $attraction->attraction_id);
            $stmt->bindParam(':name', $attraction->name);
            $stmt->bindParam(':description', $attraction->description);
            $stmt->bindParam(':location', $attraction->location);
            $stmt->bindParam(':category', $attraction->category);
            $stmt->bindParam(':ticket_price', $attraction->ticket_price);
            $stmt->bindParam(':image_url', $attraction->image_url);
            $stmt->bindParam(':opening_hours', $opening_hours);
            $stmt->bindParam(':highlights', $highlights);
            $stmt->bindParam(':facilities', $facilities);
            $stmt->bindParam(':best_time', $best_time);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':status', $status);

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
            if (empty($input['attraction_id'])) {
                echo json_encode(['success' => false, 'message' => 'Thiếu ID địa điểm']);
                break;
            }

            $attraction->attraction_id = $input['attraction_id'];
            $attraction->name = $input['name'];
            $attraction->description = $input['description'];
            $attraction->location = $input['location'] ?? '';
            $attraction->category = $input['category'] ?? '';
            $attraction->ticket_price = $input['ticket_price'] ?? '';
            $attraction->image_url = $input['image_url'] ?? '';
            $opening_hours = $input['opening_hours'] ?? '';
            $highlights = $input['highlights'] ?? '';
            $facilities = $input['facilities'] ?? '';
            $best_time = $input['best_time'] ?? '';
            $contact = $input['contact'] ?? '';
            $status = $input['status'] ?? 'active';

            $query = "UPDATE attractions 
                     SET name = :name, 
                         description = :description, 
                         location = :location, 
                         category = :category, 
                         ticket_price = :ticket_price, 
                         image_url = :image_url,
                         opening_hours = :opening_hours,
                         highlights = :highlights,
                         facilities = :facilities,
                         best_time = :best_time,
                         contact = :contact,
                         status = :status,
                         updated_at = CURRENT_TIMESTAMP
                     WHERE attraction_id = :attraction_id";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':name', $attraction->name);
            $stmt->bindParam(':description', $attraction->description);
            $stmt->bindParam(':location', $attraction->location);
            $stmt->bindParam(':category', $attraction->category);
            $stmt->bindParam(':ticket_price', $attraction->ticket_price);
            $stmt->bindParam(':image_url', $attraction->image_url);
            $stmt->bindParam(':opening_hours', $opening_hours);
            $stmt->bindParam(':highlights', $highlights);
            $stmt->bindParam(':facilities', $facilities);
            $stmt->bindParam(':best_time', $best_time);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':attraction_id', $attraction->attraction_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Đã cập nhật địa điểm thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể cập nhật địa điểm']);
            }
            break;

        case 'DELETE':
            // Xóa địa điểm
            $attraction_id = $input['attraction_id'] ?? $_GET['id'] ?? null;
            
            if (empty($attraction_id)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu ID địa điểm']);
                break;
            }

            $query = "DELETE FROM attractions WHERE attraction_id = :attraction_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':attraction_id', $attraction_id);

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
