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
    'domain' => 'simplynotes-backend.onrender.com',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);

include_once '../config/db.php';

// Ottieni i dati inviati tramite POST
$username = $_POST['username'];
$password = $_POST['password'];

// Controlla se i dati sono stati inviati
if (isset($username) && isset($password)) {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Username già esistente."]);
    } else {
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Registrazione avvenuta con successo."]);
        } else {
            echo json_encode(["success" => false, "message" => "Errore durante la registrazione."]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>
