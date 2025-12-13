<?php
/**
 * File test kết nối database cho thanh toán dịch vụ
 * Xóa file này sau khi test xong
 */

session_start();
require_once 'config/database.php';

echo "<h1>Test Kết Nối Database</h1>";

// Test 1: Khởi tạo Database
echo "<h2>Test 1: Khởi tạo Database</h2>";
try {
    $database = new Database();
    echo "✓ Database object created<br>";
} catch (Exception $e) {
    echo "✗ Lỗi: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Lấy connection
echo "<h2>Test 2: Lấy Connection</h2>";
$conn = $database->getConnection();
if ($conn) {
    echo "✓ Connection successful<br>";
} else {
    echo "✗ Connection failed<br>";
    exit;
}

// Test 3: Kiểm tra bảng service_bookings
echo "<h2>Test 3: Kiểm tra bảng service_bookings</h2>";
$query = "SELECT COUNT(*) as count FROM service_bookings";
$result = $conn->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    echo "✓ Bảng service_bookings tồn tại, có " . $row['count'] . " bản ghi<br>";
} else {
    echo "✗ Lỗi: " . $conn->error . "<br>";
}

// Test 4: Kiểm tra bảng payment_confirmations
echo "<h2>Test 4: Kiểm tra bảng payment_confirmations</h2>";
$query = "SELECT COUNT(*) as count FROM payment_confirmations";
$result = $conn->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    echo "✓ Bảng payment_confirmations tồn tại, có " . $row['count'] . " bản ghi<br>";
} else {
    echo "✗ Lỗi: " . $conn->error . "<br>";
    echo "<p>Bảng payment_confirmations chưa tồn tại. Vui lòng chạy file SQL: database/create-payment-confirmations-service.sql</p>";
}

// Test 5: Kiểm tra cấu trúc bảng payment_confirmations
echo "<h2>Test 5: Kiểm tra cấu trúc bảng payment_confirmations</h2>";
$query = "DESCRIBE payment_confirmations";
$result = $conn->query($query);
if ($result) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "✗ Lỗi: " . $conn->error . "<br>";
}

// Test 6: Test INSERT
echo "<h2>Test 6: Test INSERT vào payment_confirmations</h2>";
$test_booking_code = "TEST_" . time();
$query = "INSERT INTO payment_confirmations 
          (booking_code, bank_name, account_number, account_name, amount, status) 
          VALUES (?, ?, ?, ?, ?, 'pending')";

if ($stmt = $conn->prepare($query)) {
    $bank = "Vietcombank";
    $account = "1234567890";
    $name = "TEST USER";
    $amount = 100000;
    
    $stmt->bind_param("ssssi", $test_booking_code, $bank, $account, $name, $amount);
    
    if ($stmt->execute()) {
        echo "✓ INSERT thành công<br>";
        echo "Booking code: " . $test_booking_code . "<br>";
        
        // Xóa test data
        $delete_query = "DELETE FROM payment_confirmations WHERE booking_code = ?";
        if ($delete_stmt = $conn->prepare($delete_query)) {
            $delete_stmt->bind_param("s", $test_booking_code);
            $delete_stmt->execute();
            echo "✓ Test data đã được xóa<br>";
            $delete_stmt->close();
        }
    } else {
        echo "✗ Lỗi INSERT: " . $stmt->error . "<br>";
    }
    $stmt->close();
} else {
    echo "✗ Lỗi prepare: " . $conn->error . "<br>";
}

echo "<h2>Kết Luận</h2>";
echo "<p>Nếu tất cả các test đều ✓ thì hệ thống thanh toán dịch vụ sẽ hoạt động bình thường.</p>";
echo "<p><a href='javascript:history.back()'>Quay lại</a></p>";
?>
