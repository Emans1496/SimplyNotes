<?php
header("Access-Control-Allow-Origin: https://simplynotes-static.onrender.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

session_set_cookie_params([
    'lifetime' => 0,
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);

session_start();

include_once '../config/db.php';

// Ottieni i dati inviati tramite POST
$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';
$user_id = $_POST['user_id'] ?? ''; // Usa user_id dal POST, che viene dal localStorage

// Controlla se i dati sono stati inviati
if (empty($title) || empty($content) || empty($user_id)) {
    error_log("Dati mancanti: title = $title, content = $content, user_id = $user_id");
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
    exit();
}

try {
    // Inserisci la nota nel database
    $sql = "INSERT INTO notes (user_id, title, content) VALUES (:user_id, :title, :content)";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Nota aggiunta con successo."]);
    } else {
        error_log("Errore durante l'esecuzione dello statement SQL.");
        echo json_encode(["success" => false, "message" => "Errore durante l'aggiunta della nota."]);
    }
} catch (PDOException $e) {
    error_log("Errore durante l'aggiunta della nota: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "Errore durante l'aggiunta della nota."]);
}
?>
