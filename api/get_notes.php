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

// Imposta i parametri dei cookie di sessione senza specificare il dominio
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);

session_start();

include_once '../config/db.php';
include_once '../config/db_session_handler.php';

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non autenticato.']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Recupera le note dell'utente
    $stmt = $conn->prepare("SELECT * FROM notes WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'notes' => $notes]);
} catch (PDOException $e) {
    error_log("Errore durante il recupero delle note: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Errore durante il recupero delle note.']);
}
?>
