<?php
class Tour {
    private $conn;
    private $table = 'tours';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả tours
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tours active
    public function getActive() {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tour theo ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE tour_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo tour mới
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (tour_name, description, duration_days, base_price, max_participants, itinerary, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['tour_name'],
            $data['description'],
            $data['duration_days'],
            $data['base_price'],
            $data['max_participants'],
            $data['itinerary'],
            $data['status'] ?? 'active'
        ]);
    }

    // Cập nhật tour
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET tour_name = ?, description = ?, duration_days = ?, 
                      base_price = ?, max_participants = ?, itinerary = ?, status = ?
                  WHERE tour_id = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['tour_name'],
            $data['description'],
            $data['duration_days'],
            $data['base_price'],
            $data['max_participants'],
            $data['itinerary'],
            $data['status'],
            $id
        ]);
    }

    // Xóa tour
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE tour_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Lấy lịch trình của tour
    public function getSchedules($tourId) {
        $query = "SELECT * FROM tour_schedules WHERE tour_id = ? ORDER BY departure_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy địa điểm của tour
    public function getAttractions($tourId) {
        $query = "SELECT ta.*, a.name, a.location, a.image_url 
                  FROM tour_attractions ta
                  JOIN attractions a ON ta.attraction_id = a.attraction_id
                  WHERE ta.tour_id = ?
                  ORDER BY ta.visit_order ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm địa điểm vào tour
    public function addAttraction($tourId, $attractionId, $visitOrder, $visitDuration) {
        $query = "INSERT INTO tour_attractions (tour_id, attraction_id, visit_order, visit_duration) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$tourId, $attractionId, $visitOrder, $visitDuration]);
    }

    // Xóa địa điểm khỏi tour
    public function removeAttraction($tourId, $attractionId) {
        $query = "DELETE FROM tour_attractions WHERE tour_id = ? AND attraction_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$tourId, $attractionId]);
    }

    // Lấy giá tour theo mùa
    public function getPricing($tourId) {
        $query = "SELECT * FROM tour_pricing WHERE tour_id = ? AND is_active = 1 ORDER BY start_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm giá theo mùa
    public function addPricing($data) {
        $query = "INSERT INTO tour_pricing 
                  (tour_id, season_name, start_date, end_date, adult_price, child_price, infant_price, is_active) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['tour_id'],
            $data['season_name'],
            $data['start_date'],
            $data['end_date'],
            $data['adult_price'],
            $data['child_price'],
            $data['infant_price'],
            $data['is_active'] ?? 1
        ]);
    }

    // Lấy giá hiện tại theo ngày
    public function getCurrentPrice($tourId, $date = null) {
        $date = $date ?? date('Y-m-d');
        $query = "SELECT * FROM tour_pricing 
                  WHERE tour_id = ? AND is_active = 1 
                  AND ? BETWEEN start_date AND end_date
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tourId, $date]);
        $pricing = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$pricing) {
            // Nếu không có giá theo mùa, lấy giá cơ bản
            $tour = $this->getById($tourId);
            return [
                'adult_price' => $tour['base_price'],
                'child_price' => $tour['base_price'] * 0.7,
                'infant_price' => 0
            ];
        }
        
        return $pricing;
    }
}
