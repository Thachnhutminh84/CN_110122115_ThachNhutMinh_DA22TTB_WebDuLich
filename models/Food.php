<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Model Food - Quản lý món ăn đặc sản
 */
class Food {
    private $conn;
    private $table_name = "foods";

    public $id;
    public $food_id;
    public $name;
    public $name_khmer;
    public $category;
    public $description;
    public $ingredients;
    public $price_range;
    public $image_url;
    public $origin;
    public $best_time;
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
     * Lấy tất cả món ăn
     */
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE status = 'active' 
                 ORDER BY name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy món ăn theo category
     */
    public function getByCategory($category) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE category = :category AND status = 'active' 
                 ORDER BY name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy món ăn theo ID
     */
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE food_id = :food_id 
                 LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':food_id', $this->food_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->name_khmer = $row['name_khmer'];
            $this->category = $row['category'];
            $this->description = $row['description'];
            $this->ingredients = $row['ingredients'];
            $this->price_range = $row['price_range'];
            $this->image_url = $row['image_url'];
            $this->origin = $row['origin'];
            $this->best_time = $row['best_time'];
            $this->status = $row['status'];
            return true;
        }

        return false;
    }

    /**
     * Tìm kiếm món ăn
     */
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE (name LIKE :keyword OR description LIKE :keyword OR ingredients LIKE :keyword) 
                 AND status = 'active' 
                 ORDER BY name ASC";

        $stmt = $this->conn->prepare($query);
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy danh sách categories
     */
    public function getCategories() {
        $query = "SELECT DISTINCT category FROM " . $this->table_name . " 
                 WHERE status = 'active' AND category IS NOT NULL 
                 ORDER BY category ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Thêm món ăn mới
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    food_id = :food_id,
                    name = :name,
                    name_khmer = :name_khmer,
                    category = :category,
                    description = :description,
                    ingredients = :ingredients,
                    price_range = :price_range,
                    image_url = :image_url,
                    origin = :origin,
                    best_time = :best_time,
                    status = :status";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->food_id = htmlspecialchars(strip_tags($this->food_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind dữ liệu
        $stmt->bindParam(':food_id', $this->food_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':name_khmer', $this->name_khmer);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':ingredients', $this->ingredients);
        $stmt->bindParam(':price_range', $this->price_range);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':origin', $this->origin);
        $stmt->bindParam(':best_time', $this->best_time);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Cập nhật món ăn
     */
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    name = :name,
                    name_khmer = :name_khmer,
                    category = :category,
                    description = :description,
                    ingredients = :ingredients,
                    price_range = :price_range,
                    image_url = :image_url,
                    origin = :origin,
                    best_time = :best_time,
                    status = :status
                WHERE
                    food_id = :food_id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind dữ liệu
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':name_khmer', $this->name_khmer);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':ingredients', $this->ingredients);
        $stmt->bindParam(':price_range', $this->price_range);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':origin', $this->origin);
        $stmt->bindParam(':best_time', $this->best_time);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':food_id', $this->food_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Xóa món ăn (soft delete)
     */
    public function delete() {
        $query = "UPDATE " . $this->table_name . "
                SET status = 'inactive'
                WHERE food_id = :food_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':food_id', $this->food_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Lấy món ăn nổi bật
     */
    public function getFeatured($limit = 6) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE status = 'active' 
                 ORDER BY RAND()
                 LIMIT :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
}
?>
