<?php
// session_start();
header("Access-Control-Allow-Headers: test-custom-header");
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Credentials: true");
print_r($_COOKIE);
?>