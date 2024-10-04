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

include_once '../config/db.php';
include_once '../config/db_session_handler.php';

// Ottieni i dati inviati tramite POST
$user_id = $_POST['user_id'] ?? '';
$note_id = $_POST['id'] ?? '';

// Verifica se l'utente è autenticato
if (empty($user_id)) {
    echo json_encode(['success' => false, 'message' => 'Non autenticato.']);
    exit();
}

// Controlla se l'ID della nota è stato inviato
if (empty($note_id)) {
    echo json_encode(['success' => false, 'message' => 'ID della nota mancante.']);
    exit();
}

try {
    // Cancella la nota dal database
    $sql = "DELETE FROM notes WHERE id = :id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $note_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Nota eliminata con successo.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore durante l\'eliminazione della nota.']);
    }
} catch (PDOException $e) {
    error_log("Errore durante l'eliminazione della nota: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Errore durante l\'eliminazione della nota.']);
}
?>
