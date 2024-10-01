<?php
header("Access-Control-Allow-Origin: https://simplynotes-oktn.onrender.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

session_start();

include_once '../config/db.php';

// Ottieni i dati inviati tramite POST
$username = $_POST['username'];
$password = $_POST['password'];

// Controlla se i dati sono stati inviati
if (isset($username) && isset($password)) {
    // Preparazione dello statement per prevenire SQL injection
    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se l'utente esiste
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(["success" => true, "message" => "Login effettuato con successo."]);
    } else {
        echo json_encode(["success" => false, "message" => "Username o password errati."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>
