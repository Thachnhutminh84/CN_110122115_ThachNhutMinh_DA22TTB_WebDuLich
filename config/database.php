<?php
/**
 * Cấu hình kết nối Database cho hệ thống đặt tour
 * Sử dụng với XAMPP MySQL
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'travinh_tourism';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    public $conn;

    /**
     * Kết nối database
     */
    public function getConnection() {
        $this->conn = null;
        
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ];
            
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            throw new Exception("Không thể kết nối database: " . $exception->getMessage());
        }
        
        return $this->conn;
    }

    /**
     * Kiểm tra kết nối database
     */
    public function testConnection() {
        try {
            $conn = $this->getConnection();
            if ($conn) {
                return [
                    'success' => true,
                    'message' => 'Kết nối database thành công',
                    'server_info' => $conn->getAttribute(PDO::ATTR_SERVER_VERSION)
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi kết nối: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Đóng kết nối
     */
    public function closeConnection() {
        $this->conn = null;
    }
}

/**
 * Hàm helper để lấy kết nối database
 */
if (!function_exists('getDBConnection')) {
    function getDBConnection() {
        $database = new Database();
        return $database->getConnection();
    }
}

/**
 * Hàm helper để test kết nối
 */
if (!function_exists('testDBConnection')) {
    function testDBConnection() {
        $database = new Database();
        return $database->testConnection();
    }
}
?>