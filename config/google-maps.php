<?php
/**
 * Cấu hình Google Maps API
 * 
 * Để lấy API key:
 * 1. Truy cập: https://console.cloud.google.com/
 * 2. Tạo project mới
 * 3. Bật APIs: Maps JavaScript API, Maps Embed API
 * 4. Tạo API key từ "Credentials"
 * 5. Thay thế GOOGLE_MAPS_API_KEY bằng key của bạn
 */

// Thay thế bằng API key thực của bạn
define('GOOGLE_MAPS_API_KEY', 'AIzaSyDummyKeyForDevelopment');

// Tọa độ mặc định (Trà Vinh)
define('DEFAULT_LAT', 9.9347);
define('DEFAULT_LNG', 106.3428);

// Hàm lấy Google Maps API key
function getGoogleMapsApiKey() {
    return GOOGLE_MAPS_API_KEY;
}

// Hàm tạo URL embed Google Maps (không cần API key)
function getGoogleMapsEmbedUrl($location, $apiKey = null) {
    // Dùng link search thay vì embed để không cần API key
    return "https://www.google.com/maps/search/" . urlencode($location);
}

// Hàm tạo URL search Google Maps
function getGoogleMapsSearchUrl($location) {
    return "https://www.google.com/maps/search/" . urlencode($location);
}
?>
