<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Model Booking - Quản lý đặt tour
 */
class Booking {
    private $conn;
    private $table_name = "bookings";

    public $id;
    public $booking_id;
    public $attraction_id;
    public $customer_name;
    public $customer_email;
    public $customer_phone;
    public $booking_date;
    public $number_of_people;
    public $total_price;
    public $special_requests;
    public $status;
    public $created_at;

    public function __construct($db = null) {
        if ($db) {
            $this->conn = $db;
        } else {
            $database = new Database();
            $this->conn = $database->getConnection();
        }
    }

    /**
     * Tạo booking mới
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET booking_id = :booking_id,
                    attraction_id = :attraction_id,
                    customer_name = :customer_name,
                    customer_email = :customer_email,
                    customer_phone = :customer_phone,
                    booking_date = :booking_date,
                    number_of_people = :number_of_people,
                    total_price = :total_price,
                    special_requests = :special_requests,
                    status = 'pending'";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->booking_id = htmlspecialchars(strip_tags($this->booking_id));
        $this->attraction_id = htmlspecialchars(strip_tags($this->attraction_id));
        $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
        $this->customer_email = htmlspecialchars(strip_tags($this->customer_email));
        $this->customer_phone = htmlspecialchars(strip_tags($this->customer_phone));
        $this->booking_date = htmlspecialchars(strip_tags($this->booking_date));
        $this->number_of_people = htmlspecialchars(strip_tags($this->number_of_people));
        $this->total_price = htmlspecialchars(strip_tags($this->total_price));
        $this->special_requests = htmlspecialchars(strip_tags($this->special_requests));

        // Bind dữ liệu
        $stmt->bindParam(':booking_id', $this->booking_id);
        $stmt->bindParam(':attraction_id', $this->attraction_id);
        $stmt->bindParam(':customer_name', $this->customer_name);
        $stmt->bindParam(':customer_email', $this->customer_email);
        $stmt->bindParam(':customer_phone', $this->customer_phone);
        $stmt->bindParam(':booking_date', $this->booking_date);
        $stmt->bindParam(':number_of_people', $this->number_of_people);
        $stmt->bindParam(':total_price', $this->total_price);
        $stmt->bindParam(':special_requests', $this->special_requests);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Lấy tất cả bookings
     */
    public function readAll() {
        $query = "SELECT b.*, a.name as attraction_name, a.location as attraction_location
                 FROM " . $this->table_name . " b
                 LEFT JOIN attractions a ON b.attraction_id = a.attraction_id
                 ORDER BY b.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy booking theo trạng thái
     */
    public function readByStatus($status) {
        $query = "SELECT b.*, a.name as attraction_name, a.location as attraction_location
                 FROM " . $this->table_name . " b
                 LEFT JOIN attractions a ON b.attraction_id = a.attraction_id
                 WHERE b.status = :status
                 ORDER BY b.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy một booking theo ID
     */
    public function readOne() {
        $query = "SELECT b.*, a.name as attraction_name, a.location as attraction_location
                 FROM " . $this->table_name . " b
                 LEFT JOIN attractions a ON b.attraction_id = a.attraction_id
                 WHERE b.booking_id = :booking_id
                 LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $this->booking_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->attraction_id = $row['attraction_id'];
            $this->customer_name = $row['customer_name'];
            $this->customer_email = $row['customer_email'];
            $this->customer_phone = $row['customer_phone'];
            $this->booking_date = $row['booking_date'];
            $this->number_of_people = $row['number_of_people'];
            $this->total_price = $row['total_price'];
            $this->special_requests = $row['special_requests'];
            $this->status = $row['status'];
            $this->created_at = $row['created_at'];
            return true;
        }

        return false;
    }

    /**
     * Cập nhật trạng thái booking
     */
    public function updateStatus($booking_id, $new_status) {
        $query = "UPDATE " . $this->table_name . "
                SET status = :status,
                    updated_at = CURRENT_TIMESTAMP
                WHERE booking_id = :booking_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':booking_id', $booking_id);

        return $stmt->execute();
    }

    /**
     * Đếm số booking theo trạng thái
     */
    public function countByStatus() {
        $query = "SELECT status, COUNT(*) as total 
                 FROM " . $this->table_name . " 
                 GROUP BY status";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy bookings theo attraction_id
     */
    public function readByAttraction($attraction_id) {
        $query = "SELECT * FROM " . $this->table_name . "
                 WHERE attraction_id = :attraction_id
                 ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':attraction_id', $attraction_id);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Tạo booking_id tự động
     */
    public function generateBookingId() {
        return 'BK' . date('YmdHis') . rand(100, 999);
    }

    /**
     * Xóa booking
     */
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE booking_id = :booking_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $this->booking_id);

        return $stmt->execute();
    }

    /**
     * Lấy thống kê tổng quan
     */
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_bookings,
                    SUM(number_of_people) as total_people,
                    SUM(total_price) as total_revenue,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
                    COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as confirmed_count,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_count,
                    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_count
                 FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
