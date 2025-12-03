<?php
/**
 * Facebook Login Redirect
 * Du Lịch Trà Vinh
 */
session_start();
require_once '../config/oauth.php';

// Redirect to Facebook OAuth
header('Location: ' . getFacebookAuthUrl());
exit;
?>
