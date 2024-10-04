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

include_once '../config/db.php';

// Ottieni i dati inviati tramite POST
$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';
$user_id = $_POST['user_id'] ?? '';

// Controlla se i dati sono stati inviati
if (!empty($title) && !empty($content) && !empty($user_id)) {
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
            echo json_encode(["success" => false, "message" => "Errore durante l'aggiunta della nota."]);
        }
    } catch (PDOException $e) {
        error_log("Errore durante l'aggiunta della nota: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "Errore durante l'aggiunta della nota."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>
