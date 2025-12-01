<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Model Attraction - Quản lý địa điểm du lịch
 */
class Attraction {
    private $conn;
    private $table_name = "attractions";

    public $id;
    public $attraction_id;
    public $name;
    public $description;
    public $ticket_price;
    public $location;
    public $image_url;
    public $category;
    public $status;
    
    // Thông tin chi tiết
    public $year_built;
    public $cultural_significance;
    public $historical_value;
    public $architecture_style;
    public $notable_features;
    public $religious_significance;
    public $opening_hours;
    public $best_time;
    public $contact;
    public $highlights;
    public $facilities;
    public $latitude;
    public $longitude;

    public function __construct($db = null) {
        if ($db) {
            $this->conn = $db;
        } else {
            $database = new Database();
            $this->conn = $database->getConnection();
        }
    }

    /**
     * Lấy tất cả attractions
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
     * Lấy attraction theo ID
     */
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE attraction_id = :attraction_id 
                 LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':attraction_id', $this->attraction_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->ticket_price = $row['ticket_price'];
            $this->location = $row['location'];
            $this->image_url = $row['image_url'];
            $this->category = $row['category'];
            $this->status = $row['status'];
            
            // Thông tin chi tiết
            $this->year_built = $row['year_built'] ?? null;
            $this->cultural_significance = $row['cultural_significance'] ?? null;
            $this->historical_value = $row['historical_value'] ?? null;
            $this->architecture_style = $row['architecture_style'] ?? null;
            $this->notable_features = $row['notable_features'] ?? null;
            $this->religious_significance = $row['religious_significance'] ?? null;
            $this->opening_hours = $row['opening_hours'] ?? null;
            $this->best_time = $row['best_time'] ?? null;
            $this->contact = $row['contact'] ?? null;
            $this->highlights = $row['highlights'] ?? null;
            $this->facilities = $row['facilities'] ?? null;
            $this->latitude = $row['latitude'] ?? null;
            $this->longitude = $row['longitude'] ?? null;
            
            return true;
        }

        return false;
    }

    /**
     * Lấy attraction theo category
     */
    public function readByCategory($category) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE category = :category AND status = 'active' 
                 ORDER BY name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Tìm kiếm attractions - Cải tiến
     */
    public function search($keyword) {
        // Loại bỏ khoảng trắng thừa và chuyển về lowercase để tìm kiếm tốt hơn
        $keyword = trim($keyword);
        
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE (
                     LOWER(name) LIKE LOWER(:keyword1) OR 
                     LOWER(description) LIKE LOWER(:keyword2) OR 
                     LOWER(location) LIKE LOWER(:keyword3) OR
                     LOWER(category) LIKE LOWER(:keyword4)
                 ) 
                 AND status = 'active' 
                 ORDER BY 
                     CASE 
                         WHEN LOWER(name) LIKE LOWER(:keyword5) THEN 1
                         WHEN LOWER(location) LIKE LOWER(:keyword6) THEN 2
                         ELSE 3
                     END,
                     name ASC";

        $stmt = $this->conn->prepare($query);
        $searchTerm = '%' . $keyword . '%';
        
        // Bind tất cả các tham số
        $stmt->bindParam(':keyword1', $searchTerm);
        $stmt->bindParam(':keyword2', $searchTerm);
        $stmt->bindParam(':keyword3', $searchTerm);
        $stmt->bindParam(':keyword4', $searchTerm);
        $stmt->bindParam(':keyword5', $searchTerm);
        $stmt->bindParam(':keyword6', $searchTerm);
        
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
     * Đếm số lượng bookings cho attraction
     */
    public function getBookingCount() {
        $query = "SELECT COUNT(*) as booking_count 
                 FROM bookings 
                 WHERE attraction_id = :attraction_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':attraction_id', $this->attraction_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['booking_count'];
    }

    /**
     * Lấy attractions phổ biến (nhiều booking nhất)
     */
    public function getPopularAttractions($limit = 5) {
        $query = "SELECT a.*, COUNT(b.id) as booking_count 
                 FROM " . $this->table_name . " a 
                 LEFT JOIN bookings b ON a.attraction_id = b.attraction_id 
                 WHERE a.status = 'active' 
                 GROUP BY a.id 
                 ORDER BY booking_count DESC, a.name ASC 
                 LIMIT :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
}
?>