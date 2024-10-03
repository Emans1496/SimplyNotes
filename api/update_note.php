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
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);

session_start();

if (isset($_SESSION['user_id'])) {
    include_once '../config/db.php';
    include_once '../config/db_session_handler.php';

    $note_id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (isset($note_id) && isset($title) && isset($content)) {
        $user_id = $_SESSION['user_id'];

        $sql = "UPDATE notes SET title = :title, content = :content WHERE id = :id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':id', $note_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Nota aggiornata con successo."]);
        } else {
            echo json_encode(["success" => false, "message" => "Errore durante l'aggiornamento della nota."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Dati mancanti."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Utente non autenticato."]);
}
?>
