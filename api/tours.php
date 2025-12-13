<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';
require_once '../models/Tour.php';

$database = new Database();
$db = $database->connect();
$tour = new Tour($db);

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                // Lấy tour theo ID với đầy đủ thông tin
                $tourData = $tour->getById($_GET['id']);
                if ($tourData) {
                    $tourData['schedules'] = $tour->getSchedules($_GET['id']);
                    $tourData['attractions'] = $tour->getAttractions($_GET['id']);
                    $tourData['pricing'] = $tour->getPricing($_GET['id']);
                    echo json_encode(['success' => true, 'data' => $tourData]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Tour không tồn tại']);
                }
            } elseif (isset($_GET['action']) && $_GET['action'] === 'active') {
                // Lấy tours active
                $tours = $tour->getActive();
                echo json_encode(['success' => true, 'data' => $tours]);
            } elseif (isset($_GET['action']) && $_GET['action'] === 'price') {
                // Lấy giá tour theo ngày
                $tourId = $_GET['tour_id'] ?? null;
                $date = $_GET['date'] ?? null;
                if ($tourId) {
                    $price = $tour->getCurrentPrice($tourId, $date);
                    echo json_encode(['success' => true, 'data' => $price]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Thiếu tour_id']);
                }
            } else {
                // Lấy tất cả tours
                $tours = $tour->getAll();
                echo json_encode(['success' => true, 'data' => $tours]);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (isset($data['action'])) {
                switch($data['action']) {
                    case 'add_attraction':
                        // Thêm địa điểm vào tour
                        $result = $tour->addAttraction(
                            $data['tour_id'],
                            $data['attraction_id'],
                            $data['visit_order'],
                            $data['visit_duration']
                        );
                        echo json_encode([
                            'success' => $result,
                            'message' => $result ? 'Đã thêm địa điểm vào tour' : 'Thêm thất bại'
                        ]);
                        break;
                    
                    case 'add_pricing':
                        // Thêm giá theo mùa
                        $result = $tour->addPricing($data);
                        echo json_encode([
                            'success' => $result,
                            'message' => $result ? 'Đã thêm giá theo mùa' : 'Thêm thất bại'
                        ]);
                        break;
                    
                    default:
                        // Tạo tour mới
                        $result = $tour->create($data);
                        echo json_encode([
                            'success' => $result,
                            'message' => $result ? 'Tạo tour thành công' : 'Tạo tour thất bại'
                        ]);
                }
            } else {
                // Tạo tour mới
                $result = $tour->create($data);
                echo json_encode([
                    'success' => $result,
                    'message' => $result ? 'Tạo tour thành công' : 'Tạo tour thất bại'
                ]);
            }
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['tour_id'] ?? null;
            
            if ($id) {
                $result = $tour->update($id, $data);
                echo json_encode([
                    'success' => $result,
                    'message' => $result ? 'Cập nhật tour thành công' : 'Cập nhật thất bại'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Thiếu tour_id']);
            }
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (isset($data['action']) && $data['action'] === 'remove_attraction') {
                // Xóa địa điểm khỏi tour
                $result = $tour->removeAttraction($data['tour_id'], $data['attraction_id']);
                echo json_encode([
                    'success' => $result,
                    'message' => $result ? 'Đã xóa địa điểm khỏi tour' : 'Xóa thất bại'
                ]);
            } else {
                // Xóa tour
                $id = $data['tour_id'] ?? null;
                if ($id) {
                    $result = $tour->delete($id);
                    echo json_encode([
                        'success' => $result,
                        'message' => $result ? 'Xóa tour thành công' : 'Xóa thất bại'
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Thiếu tour_id']);
                }
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Method không hợp lệ']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
