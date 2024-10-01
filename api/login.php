<?php
header("Access-Control-Allow-Origin: https://simplynotes-oktn.onrender.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Il resto del tuo codice PHP...


// Avvia la sessione
session_start();

// Includi il file di configurazione del database
include_once '../config/db.php';

// Ottieni i dati inviati tramite POST
$username = $_POST['username'];
$password = $_POST['password'];

// Controlla se i dati sono stati inviati
if (isset($username) && isset($password)) {
    // Preparazione dello statement per prevenire SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se l'utente esiste
    if ($result->num_rows > 0) {
        // Utente trovato
        $user = $result->fetch_assoc();

        // Salva l'ID utente nella sessione
        $_SESSION['user_id'] = $user['id'];

        // Risposta di successo
        echo json_encode(["success" => true, "message" => "Login effettuato con successo."]);
    } else {
        // Credenziali errate
        echo json_encode(["success" => false, "message" => "Username o password errati."]);
    }

    // Chiudi lo statement
    $stmt->close();
} else {
    // Dati mancanti
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}

// Chiudi la connessione al database
$conn->close();
?>
