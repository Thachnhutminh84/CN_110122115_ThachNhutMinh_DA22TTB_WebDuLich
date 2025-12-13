<?php
/**
 * Model User - Quản lý tài khoản người dùng
 */

class User {
    private $conn;
    private $table = 'app_users';

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Đăng ký tài khoản mới
     */
    public function register($data) {
        try {
            // Kiểm tra username đã tồn tại
            $checkUsername = "SELECT id FROM {$this->table} WHERE username = :username";
            $stmt = $this->conn->prepare($checkUsername);
            $stmt->bindParam(':username', $data['username']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Tên đăng nhập đã tồn tại'];
            }

            // Kiểm tra email đã tồn tại
            $checkEmail = "SELECT id FROM {$this->table} WHERE email = :email";
            $stmt = $this->conn->prepare($checkEmail);
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Email đã được sử dụng'];
            }

            // Mã hóa mật khẩu
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Thêm user mới (không có cột user_id)
            $query = "INSERT INTO {$this->table} 
                     (username, email, password, full_name, phone, role, status) 
                     VALUES 
                     (:username, :email, :password, :full_name, :phone, :role, 'active')";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':full_name', $data['full_name']);
            $stmt->bindParam(':phone', $data['phone']);
            
            // Mặc định role là 'user'
            $role = isset($data['role']) ? $data['role'] : 'user';
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                return [
                    'success' => true, 
                    'message' => 'Đăng ký thành công',
                    'user_id' => $this->conn->lastInsertId()
                ];
            }

            return ['success' => false, 'message' => 'Đăng ký thất bại'];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }

    /**
     * Đăng nhập
     */
    public function login($username, $password) {
        try {
            $query = "SELECT * FROM {$this->table} 
                     WHERE (username = :username OR email = :email) 
                     AND status = 'active'";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Kiểm tra mật khẩu
                if (password_verify($password, $user['password'])) {
                    // Xóa password khỏi dữ liệu trả về
                    unset($user['password']);

                    return [
                        'success' => true,
                        'message' => 'Đăng nhập thành công',
                        'user' => $user
                    ];
                }
            }

            return ['success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng'];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }

    /**
     * Tự động đăng ký tài khoản khi đăng nhập lần đầu
     */
    private function autoRegisterAndLogin($username, $password) {
        try {
            // Tạo user_id tự động
            $user_id = $this->generateUserId();

            // Mã hóa mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Xác định email và username
            $email = '';
            $actualUsername = '';
            
            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                // Nếu nhập email
                $email = $username;
                $actualUsername = explode('@', $username)[0]; // Lấy phần trước @ làm username
            } else {
                // Nếu nhập username
                $actualUsername = $username;
                $email = $username . '@travinh.local'; // Tạo email giả
            }

            // Tạo full_name từ username
            $full_name = ucwords(str_replace(['_', '.', '-'], ' ', $actualUsername));

            // Thêm user mới
            $query = "INSERT INTO {$this->table} 
                     (user_id, username, email, password, full_name, role, status, login_count) 
                     VALUES 
                     (:user_id, :username, :email, :password, :full_name, 'user', 'active', 1)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':username', $actualUsername);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':full_name', $full_name);

            if ($stmt->execute()) {
                // Lấy ID vừa tạo
                $newUserId = $this->conn->lastInsertId();
                
                // Cập nhật last_login
                $this->updateLoginInfo($newUserId);
                
                // Lấy thông tin user vừa tạo
                $user = $this->getUserById($newUserId);

                return [
                    'success' => true,
                    'message' => 'Chào mừng! Tài khoản của bạn đã được tạo tự động',
                    'user' => $user,
                    'is_new' => true
                ];
            }

            return ['success' => false, 'message' => 'Không thể tạo tài khoản'];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }

    /**
     * Cập nhật thông tin đăng nhập
     */
    private function updateLoginInfo($userId) {
        $query = "UPDATE {$this->table} 
                 SET last_login = NOW(), 
                     login_count = login_count + 1 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }

    /**
     * Lấy thông tin user theo ID
     */
    public function getUserById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            unset($user['password']);
            return $user;
        }

        return null;
    }

    /**
     * Lấy tất cả users
     */
    public function getAllUsers() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo user_id tự động
     */
    private function generateUserId() {
        $query = "SELECT user_id FROM {$this->table} ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->query($query);
        
        if ($stmt->rowCount() > 0) {
            $lastUser = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastId = intval(substr($lastUser['user_id'], 3));
            $newId = $lastId + 1;
        } else {
            $newId = 1;
        }

        return 'USR' . str_pad($newId, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Cập nhật trạng thái user
     */
    public function updateStatus($userId, $status) {
        $query = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $userId);
        
        return $stmt->execute();
    }

    /**
     * Cập nhật thông tin user
     */
    public function updateUser($userId, $data) {
        try {
            // Kiểm tra username đã tồn tại (ngoại trừ user hiện tại)
            if (isset($data['username'])) {
                $checkUsername = "SELECT id FROM {$this->table} WHERE username = :username AND id != :id";
                $stmt = $this->conn->prepare($checkUsername);
                $stmt->bindParam(':username', $data['username']);
                $stmt->bindParam(':id', $userId);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    return ['success' => false, 'message' => 'Tên đăng nhập đã tồn tại'];
                }
            }

            // Kiểm tra email đã tồn tại (ngoại trừ user hiện tại)
            if (isset($data['email'])) {
                $checkEmail = "SELECT id FROM {$this->table} WHERE email = :email AND id != :id";
                $stmt = $this->conn->prepare($checkEmail);
                $stmt->bindParam(':email', $data['email']);
                $stmt->bindParam(':id', $userId);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    return ['success' => false, 'message' => 'Email đã được sử dụng'];
                }
            }

            // Xây dựng câu query động
            $fields = [];
            $params = [':id' => $userId];

            if (isset($data['username'])) {
                $fields[] = "username = :username";
                $params[':username'] = $data['username'];
            }
            if (isset($data['email'])) {
                $fields[] = "email = :email";
                $params[':email'] = $data['email'];
            }
            if (isset($data['full_name'])) {
                $fields[] = "full_name = :full_name";
                $params[':full_name'] = $data['full_name'];
            }
            if (isset($data['phone'])) {
                $fields[] = "phone = :phone";
                $params[':phone'] = $data['phone'];
            }
            if (isset($data['role'])) {
                $fields[] = "role = :role";
                $params[':role'] = $data['role'];
            }
            if (isset($data['status'])) {
                $fields[] = "status = :status";
                $params[':status'] = $data['status'];
            }
            if (isset($data['password']) && !empty($data['password'])) {
                $fields[] = "password = :password";
                $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            if (empty($fields)) {
                return ['success' => false, 'message' => 'Không có dữ liệu để cập nhật'];
            }

            $query = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Cập nhật thành công'];
            }

            return ['success' => false, 'message' => 'Cập nhật thất bại'];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }

    /**
     * Xóa user
     */
    public function deleteUser($userId) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $userId);
        
        return $stmt->execute();
    }

    /**
     * Tìm user theo email
     */
    public function findByEmail($email) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }

    /**
     * Tìm user theo Google ID
     */
    public function findByGoogleId($googleId) {
        $query = "SELECT * FROM {$this->table} WHERE google_id = :google_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':google_id', $googleId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }

    /**
     * Tìm user theo Facebook ID
     */
    public function findByFacebookId($facebookId) {
        $query = "SELECT * FROM {$this->table} WHERE facebook_id = :facebook_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':facebook_id', $facebookId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }

    /**
     * Tạo user từ OAuth (Google/Facebook)
     */
    public function createFromOAuth($data) {
        try {
            $user_id = $this->generateUserId();

            $query = "INSERT INTO {$this->table} 
                     (user_id, username, email, full_name, google_id, facebook_id, avatar_url, role, status) 
                     VALUES 
                     (:user_id, :username, :email, :full_name, :google_id, :facebook_id, :avatar_url, 'user', 'active')";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':full_name', $data['full_name']);
            $stmt->bindParam(':google_id', $data['google_id']);
            $stmt->bindParam(':facebook_id', $data['facebook_id']);
            $stmt->bindParam(':avatar_url', $data['avatar_url']);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'user_id' => $this->conn->lastInsertId()
                ];
            }

            return ['success' => false, 'message' => 'Không thể tạo tài khoản'];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }

    /**
     * Cập nhật OAuth ID cho user
     */
    public function updateOAuthId($userId, $provider, $providerId, $avatarUrl = null) {
        $column = ($provider === 'google') ? 'google_id' : 'facebook_id';
        
        $query = "UPDATE {$this->table} SET {$column} = :provider_id";
        if ($avatarUrl) {
            $query .= ", avatar_url = COALESCE(avatar_url, :avatar_url)";
        }
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':provider_id', $providerId);
        $stmt->bindParam(':id', $userId);
        if ($avatarUrl) {
            $stmt->bindParam(':avatar_url', $avatarUrl);
        }

        return $stmt->execute();
    }
}
