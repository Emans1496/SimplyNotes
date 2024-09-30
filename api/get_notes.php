<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");


// Avvia la sessione
session_start();

// Controlla se l'utente è loggato
if (isset($_SESSION['user_id'])) {
    // Includi il file di configurazione del database
    include_once '../config/db.php';

    $user_id = $_SESSION['user_id'];

    // Ottieni le note dell'utente
    $stmt = $conn->prepare("SELECT * FROM notes WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $notes = [];

    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }

    // Risposta con le note
    echo json_encode(["success" => true, "notes" => $notes]);

    // Chiudi lo statement
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Utente non autenticato."]);
}

// Chiudi la connessione
$conn->close();
?>
