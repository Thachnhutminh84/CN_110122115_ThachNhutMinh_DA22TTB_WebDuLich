<?php
/**
 * Google Login Redirect
 * Du Lịch Trà Vinh
 */
session_start();
require_once '../config/oauth.php';

// Redirect to Google OAuth
header('Location: ' . getGoogleAuthUrl());
exit;
?>
