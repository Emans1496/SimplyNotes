<?php
header("Access-Control-Allow-Origin: https://simplynotes-oktn.onrender.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'simplynotes-backend.onrender.com',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);


session_start();

// Distruggi la sessione
session_unset();
session_destroy();

// Risposta di successo
echo json_encode(["success" => true, "message" => "Logout effettuato con successo."]);
?>
