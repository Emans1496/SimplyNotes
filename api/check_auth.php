<?php
header("Access-Control-Allow-Origin: https://simplynotes-static.onrender.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Rispondi con 200 OK per le richieste preflight
    header("HTTP/1.1 200 OK");
    exit();
}

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);

include_once '../config/db.php';
include_once '../config/db_session_handler.php';

$sessionHandler = new DBSessionHandler($conn);
session_set_save_handler($sessionHandler, true);

session_start();

if (isset($_SESSION['user_id'])) {
    echo json_encode(['isAuthenticated' => true]);
} else {
    echo json_encode(['isAuthenticated' => false]);
}
?>
