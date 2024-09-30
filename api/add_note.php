<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Il resto del tuo codice PHP...


// Avvia la sessione
session_start();

// Controlla se l'utente è loggato
if (isset($_SESSION['user_id'])) {
    // Includi il file di configurazione del database
    include_once '../config/db.php';

    // Ottieni i dati inviati tramite POST
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Controlla se i dati sono stati inviati
    if (isset($title) && isset($content)) {
        $user_id = $_SESSION['user_id'];

        // Inserisci la nota nel database
        $stmt = $conn->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $content);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Nota aggiunta con successo."]);
        } else {
            echo json_encode(["success" => false, "message" => "Errore durante l'aggiunta della nota."]);
        }

        // Chiudi lo statement
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Dati mancanti."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Utente non autenticato."]);
}

// Chiudi la connessione
$conn->close();
?>
