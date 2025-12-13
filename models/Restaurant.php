<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Model Restaurant - Quản lý thông tin quán ăn
 */
class Restaurant {
    private $conn;
    private $table_name = "quanans";

    public $id;
    public $restaurant_id;
    public $name;
    public $food_type;
    public $address;
    public $phone;
    public $rating;
    public $price_range;
    public $open_time;
    public $specialties;
    public $image_url;
    public $latitude;
    public $longitude;
    public $description;
    public $status;

    public function __construct($db = null) {
        if ($db) {
            $this->conn = $db;
        } else {
            $database = new Database();
            $this->conn = $database->getConnection();
        }
    }

    /**
     * Lấy tất cả quán ăn
     */
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE status = 'active' 
                 ORDER BY rating DESC, name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy quán ăn theo loại món
     */
    public function getByFoodType($foodType) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE food_type = :food_type AND status = 'active' 
                 ORDER BY rating DESC, name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':food_type', $foodType);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy quán ăn theo ID
     */
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE restaurant_id = :restaurant_id 
                 LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':restaurant_id', $this->restaurant_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->food_type = $row['food_type'];
            $this->address = $row['address'];
            $this->phone = $row['phone'];
            $this->rating = $row['rating'];
            $this->price_range = $row['price_range'];
            $this->open_time = $row['open_time'];
            $this->specialties = $row['specialties'];
            $this->image_url = $row['image_url'];
            $this->latitude = $row['latitude'];
            $this->longitude = $row['longitude'];
            $this->description = $row['description'];
            $this->status = $row['status'];
            return true;
        }

        return false;
    }

    /**
     * Tìm kiếm quán ăn
     */
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE (name LIKE :keyword OR address LIKE :keyword OR specialties LIKE :keyword OR description LIKE :keyword) 
                 AND status = 'active' 
                 ORDER BY rating DESC, name ASC";

        $stmt = $this->conn->prepare($query);
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Thêm quán ăn mới
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    restaurant_id = :restaurant_id,
                    name = :name,
                    food_type = :food_type,
                    address = :address,
                    phone = :phone,
                    rating = :rating,
                    price_range = :price_range,
                    open_time = :open_time,
                    specialties = :specialties,
                    image_url = :image_url,
                    latitude = :latitude,
                    longitude = :longitude,
                    description = :description,
                    status = :status";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->restaurant_id = htmlspecialchars(strip_tags($this->restaurant_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->food_type = htmlspecialchars(strip_tags($this->food_type));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind dữ liệu
        $stmt->bindParam(':restaurant_id', $this->restaurant_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':food_type', $this->food_type);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':rating', $this->rating);
        $stmt->bindParam(':price_range', $this->price_range);
        $stmt->bindParam(':open_time', $this->open_time);
        $stmt->bindParam(':specialties', $this->specialties);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':latitude', $this->latitude);
        $stmt->bindParam(':longitude', $this->longitude);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Cập nhật quán ăn
     */
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    name = :name,
                    food_type = :food_type,
                    address = :address,
                    phone = :phone,
                    rating = :rating,
                    price_range = :price_range,
                    open_time = :open_time,
                    specialties = :specialties,
                    image_url = :image_url,
                    latitude = :latitude,
                    longitude = :longitude,
                    description = :description,
                    status = :status
                WHERE
                    restaurant_id = :restaurant_id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->food_type = htmlspecialchars(strip_tags($this->food_type));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind dữ liệu
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':food_type', $this->food_type);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':rating', $this->rating);
        $stmt->bindParam(':price_range', $this->price_range);
        $stmt->bindParam(':open_time', $this->open_time);
        $stmt->bindParam(':specialties', $this->specialties);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':latitude', $this->latitude);
        $stmt->bindParam(':longitude', $this->longitude);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':restaurant_id', $this->restaurant_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Xóa quán ăn (soft delete)
     */
    public function delete() {
        $query = "UPDATE " . $this->table_name . "
                SET status = 'inactive'
                WHERE restaurant_id = :restaurant_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':restaurant_id', $this->restaurant_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Lấy danh sách loại món ăn
     */
    public function getFoodTypes() {
        $query = "SELECT DISTINCT food_type FROM " . $this->table_name . " 
                 WHERE status = 'active' AND food_type IS NOT NULL 
                 ORDER BY food_type ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Đếm số lượng quán theo loại món
     */
    public function countByFoodType($foodType) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                 WHERE food_type = :food_type AND status = 'active'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':food_type', $foodType);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    /**
     * Lấy quán ăn được đánh giá cao nhất
     */
    public function getTopRated($limit = 5) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE status = 'active' 
                 ORDER BY rating DESC, name ASC 
                 LIMIT :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
}
?>
