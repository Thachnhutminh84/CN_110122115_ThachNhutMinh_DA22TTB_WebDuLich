<?php
/**
 * Trang Chi Tiết Địa Điểm Du Lịch - Phiên Bản Mới
 */

session_start();

require_once 'config/database.php';
require_once 'models/Attraction.php';

// Lấy ID từ URL
$attractionId = isset($_GET['id']) ? $_GET['id'] :