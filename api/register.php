<?php
header("Access-Control-Allow-Origin: https://simplynotes-oktn.onrender.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/db.php';

// Ottieni i dati inviati tramite POST
$username = $_POST['username'];
$password = $_POST['password'];

// Controlla se i dati sono stati inviati
if (isset($username) && isset($password)) {
    // Controlla se l'username esiste già
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username già esistente
        echo json_encode(["success" => false, "message" => "Username già esistente."]);
    } else {
        // Inserisci il nuovo utente nel database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Registrazione avvenuta con successo."]);
        } else {
            echo json_encode(["success" => false, "message" => "Errore durante la registrazione."]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}

// Chiudi la connessione
$conn->close();
?>
