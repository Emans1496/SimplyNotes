<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

session_start();

if (isset($_SESSION['user_id'])) {
    echo json_encode(['isAuthenticated' => true]);
} else {
    echo json_encode(['isAuthenticated' => false]);
}
?>
