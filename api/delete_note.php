<?php
header("Access-Control-Allow-Origin: https://simplynotes-oktn.onrender.com"); 
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

session_start();

if (isset($_SESSION['user_id'])) {
    include_once '../config/db.php';

    $note_id = $_POST['id'];

    if (isset($note_id)) {
        $stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $note_id, $_SESSION['user_id']);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Nota eliminata con successo."]);
        } else {
            echo json_encode(["success" => false, "message" => "Errore durante l'eliminazione della nota."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "ID della nota mancante."]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Utente non autenticato."]);
}
?>
