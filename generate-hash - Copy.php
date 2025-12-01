<?php
// Generate hash cho mật khẩu Mi@131204
$password = 'Mi@131204';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Mật khẩu: " . $password . "\n";
echo "Hash: " . $hash . "\n";
?>
