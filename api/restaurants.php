<?php
/**
 * API Restaurants - Xử lý các request liên quan đến quán ăn
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../models/Restaurant.php';

// Khởi tạo database và model
$database = new Database();
$db = $database->getConnection();
$restaurant = new Restaurant($db);

// Lấy method và action
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Xử lý các request
switch ($method) {
    case 'GET':
        handleGetRequest($restaurant, $action);
        break;
    
    case 'POST':
        handlePostRequest($restaurant, $action);
        break;
    
    case 'PUT':
        handlePutRequest($restaurant, $action);
        break;
    
    case 'DELETE':
        handleDeleteRequest($restaurant, $action);
        break;
    
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}

/**
 * Xử lý GET request
 */
function handleGetRequest($restaurant, $action) {
    switch ($action) {
        case 'all':
            getAllRestaurants($restaurant);
            break;
        
        case 'by-food-type':
            getRestaurantsByFoodType($restaurant);
            break;
        
        case 'one':
            getOneRestaurant($restaurant);
            break;
        
        case 'search':
            searchRestaurants($restaurant);
            break;
        
        case 'food-types':
            getFoodTypes($restaurant);
            break;
        
        case 'top-rated':
            getTopRated($restaurant);
            break;
        
        case 'count':
            countByFoodType($restaurant);
            break;
        
        default:
            getAllRestaurants($restaurant);
            break;
    }
}

/**
 * Lấy tất cả quán ăn
 */
function getAllRestaurants($restaurant) {
    $stmt = $restaurant->readAll();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $restaurants_arr = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $restaurant_item = [
                'id' => $id,
                'restaurant_id' => $restaurant_id,
                'name' => $name,
                'food_type' => $food_type,
                'address' => $address,
                'phone' => $phone,
                'rating' => floatval($rating),
                'price_range' => $price_range,
                'open_time' => $open_time,
                'specialties' => json_decode($specialties),
                'image_url' => $image_url,
                'coordinates' => [
                    'lat' => floatval($latitude),
                    'lng' => floatval($longitude)
                ],
                'description' => $description,
                'status' => $status
            ];
            
            array_push($restaurants_arr, $restaurant_item);
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'count' => $num,
            'data' => $restaurants_arr
        ]);
    } else {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'count' => 0,
            'data' => [],
            'message' => 'Không tìm thấy quán ăn nào'
        ]);
    }
}

/**
 * Lấy quán ăn theo loại món
 */
function getRestaurantsByFoodType($restaurant) {
    $foodType = isset($_GET['food_type']) ? $_GET['food_type'] : '';
    
    if (empty($foodType)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Thiếu tham số food_type']);
        return;
    }

    $stmt = $restaurant->getByFoodType($foodType);
    $num = $stmt->rowCount();

    if ($num > 0) {
        $restaurants_arr = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $restaurant_item = [
                'id' => $restaurant_id,
                'name' => $name,
                'address' => $address,
                'phone' => $phone,
                'rating' => floatval($rating),
                'price' => $price_range,
                'openTime' => $open_time,
                'specialties' => json_decode($specialties),
                'image' => $image_url,
                'coordinates' => [
                    'lat' => floatval($latitude),
                    'lng' => floatval($longitude)
                ],
                'description' => $description
            ];
            
            array_push($restaurants_arr, $restaurant_item);
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'food_type' => $foodType,
            'count' => $num,
            'data' => $restaurants_arr
        ]);
    } else {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'food_type' => $foodType,
            'count' => 0,
            'data' => [],
            'message' => 'Không tìm thấy quán ăn cho món này'
        ]);
    }
}

/**
 * Lấy một quán ăn
 */
function getOneRestaurant($restaurant) {
    $restaurant->restaurant_id = isset($_GET['id']) ? $_GET['id'] : '';
    
    if (empty($restaurant->restaurant_id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Thiếu tham số id']);
        return;
    }

    if ($restaurant->readOne()) {
        $restaurant_item = [
            'id' => $restaurant->restaurant_id,
            'name' => $restaurant->name,
            'food_type' => $restaurant->food_type,
            'address' => $restaurant->address,
            'phone' => $restaurant->phone,
            'rating' => floatval($restaurant->rating),
            'price' => $restaurant->price_range,
            'openTime' => $restaurant->open_time,
            'specialties' => json_decode($restaurant->specialties),
            'image' => $restaurant->image_url,
            'coordinates' => [
                'lat' => floatval($restaurant->latitude),
                'lng' => floatval($restaurant->longitude)
            ],
            'description' => $restaurant->description
        ];

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data' => $restaurant_item
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy quán ăn']);
    }
}

/**
 * Tìm kiếm quán ăn
 */
function searchRestaurants($restaurant) {
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    
    if (empty($keyword)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Thiếu từ khóa tìm kiếm']);
        return;
    }

    $stmt = $restaurant->search($keyword);
    $num = $stmt->rowCount();

    if ($num > 0) {
        $restaurants_arr = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $restaurant_item = [
                'id' => $restaurant_id,
                'name' => $name,
                'food_type' => $food_type,
                'address' => $address,
                'phone' => $phone,
                'rating' => floatval($rating),
                'price' => $price_range,
                'openTime' => $open_time,
                'specialties' => json_decode($specialties),
                'image' => $image_url,
                'coordinates' => [
                    'lat' => floatval($latitude),
                    'lng' => floatval($longitude)
                ],
                'description' => $description
            ];
            
            array_push($restaurants_arr, $restaurant_item);
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'keyword' => $keyword,
            'count' => $num,
            'data' => $restaurants_arr
        ]);
    } else {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'keyword' => $keyword,
            'count' => 0,
            'data' => [],
            'message' => 'Không tìm thấy kết quả'
        ]);
    }
}

/**
 * Lấy danh sách loại món ăn
 */
function getFoodTypes($restaurant) {
    $stmt = $restaurant->getFoodTypes();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $food_types = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($food_types, $row['food_type']);
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'count' => $num,
            'data' => $food_types
        ]);
    } else {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'count' => 0,
            'data' => []
        ]);
    }
}

/**
 * Lấy quán ăn được đánh giá cao nhất
 */
function getTopRated($restaurant) {
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
    
    $stmt = $restaurant->getTopRated($limit);
    $num = $stmt->rowCount();

    if ($num > 0) {
        $restaurants_arr = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $restaurant_item = [
                'id' => $restaurant_id,
                'name' => $name,
                'food_type' => $food_type,
                'address' => $address,
                'rating' => floatval($rating),
                'price' => $price_range,
                'image' => $image_url
            ];
            
            array_push($restaurants_arr, $restaurant_item);
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'count' => $num,
            'data' => $restaurants_arr
        ]);
    } else {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'count' => 0,
            'data' => []
        ]);
    }
}

/**
 * Đếm số lượng quán theo loại món
 */
function countByFoodType($restaurant) {
    $foodType = isset($_GET['food_type']) ? $_GET['food_type'] : '';
    
    if (empty($foodType)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Thiếu tham số food_type']);
        return;
    }

    $count = $restaurant->countByFoodType($foodType);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'food_type' => $foodType,
        'count' => $count
    ]);
}

/**
 * Xử lý POST request (Thêm quán ăn mới)
 */
function handlePostRequest($restaurant, $action) {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->restaurant_id) && !empty($data->name) && !empty($data->food_type)) {
        $restaurant->restaurant_id = $data->restaurant_id;
        $restaurant->name = $data->name;
        $restaurant->food_type = $data->food_type;
        $restaurant->address = $data->address ?? '';
        $restaurant->phone = $data->phone ?? '';
        $restaurant->rating = $data->rating ?? 0;
        $restaurant->price_range = $data->price_range ?? '';
        $restaurant->open_time = $data->open_time ?? '';
        $restaurant->specialties = json_encode($data->specialties ?? []);
        $restaurant->image_url = $data->image_url ?? '';
        $restaurant->latitude = $data->latitude ?? 0;
        $restaurant->longitude = $data->longitude ?? 0;
        $restaurant->description = $data->description ?? '';
        $restaurant->status = $data->status ?? 'active';

        if ($restaurant->create()) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Thêm quán ăn thành công'
            ]);
        } else {
            http_response_code(503);
            echo json_encode([
                'success' => false,
                'message' => 'Không thể thêm quán ăn'
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu không đầy đủ'
        ]);
    }
}

/**
 * Xử lý PUT request (Cập nhật quán ăn)
 */
function handlePutRequest($restaurant, $action) {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->restaurant_id)) {
        $restaurant->restaurant_id = $data->restaurant_id;
        $restaurant->name = $data->name;
        $restaurant->food_type = $data->food_type;
        $restaurant->address = $data->address;
        $restaurant->phone = $data->phone;
        $restaurant->rating = $data->rating;
        $restaurant->price_range = $data->price_range;
        $restaurant->open_time = $data->open_time;
        $restaurant->specialties = json_encode($data->specialties);
        $restaurant->image_url = $data->image_url;
        $restaurant->latitude = $data->latitude;
        $restaurant->longitude = $data->longitude;
        $restaurant->description = $data->description;
        $restaurant->status = $data->status;

        if ($restaurant->update()) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Cập nhật quán ăn thành công'
            ]);
        } else {
            http_response_code(503);
            echo json_encode([
                'success' => false,
                'message' => 'Không thể cập nhật quán ăn'
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Thiếu ID quán ăn'
        ]);
    }
}

/**
 * Xử lý DELETE request (Xóa quán ăn)
 */
function handleDeleteRequest($restaurant, $action) {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->restaurant_id)) {
        $restaurant->restaurant_id = $data->restaurant_id;

        if ($restaurant->delete()) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Xóa quán ăn thành công'
            ]);
        } else {
            http_response_code(503);
            echo json_encode([
                'success' => false,
                'message' => 'Không thể xóa quán ăn'
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Thiếu ID quán ăn'
        ]);
    }
}
?>
