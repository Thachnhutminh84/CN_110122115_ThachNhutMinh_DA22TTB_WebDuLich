<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Model Contact - Quản lý liên hệ
 */
class Contact {
    private $conn;
    private $table_name = "contacts";

    public $id;
    public $contact_id;
    public $full_name;
    public $email;
    public $phone;
    public $subject;
    public $message;
    public $status;
    public $ip_address;
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
     * Tạo liên hệ mới
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET full_name = :full_name,
                    email = :email,
                    phone = :phone,
                    subject = :subject,
                    message = :message,
                    status = 'new'";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->subject = htmlspecialchars(strip_tags($this->subject));
        $this->message = htmlspecialchars(strip_tags($this->message));

        // Bind dữ liệu
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':subject', $this->subject);
        $stmt->bindParam(':message', $this->message);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Lấy tất cả liên hệ
     */
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy liên hệ theo trạng thái
     */
    public function readByStatus($status) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE status = :status 
                 ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Lấy một liên hệ theo ID
     */
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE contact_id = :contact_id 
                 LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':contact_id', $this->contact_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->full_name = $row['full_name'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->subject = $row['subject'];
            $this->message = $row['message'];
            $this->status = $row['status'];
            $this->created_at = $row['created_at'];
            return true;
        }

        return false;
    }

    /**
     * Cập nhật trạng thái
     */
    public function updateStatus($contact_id, $new_status) {
        $query = "UPDATE " . $this->table_name . "
                SET status = :status
                WHERE contact_id = :contact_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':contact_id', $contact_id);

        return $stmt->execute();
    }

    /**
     * Đếm số liên hệ theo trạng thái
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
     * Xóa liên hệ
     */
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->contact_id);

        return $stmt->execute();
    }

    /**
     * Tạo contact_id tự động
     */
    public function generateContactId() {
        return 'CT' . date('YmdHis') . rand(100, 999);
    }
}
?>
