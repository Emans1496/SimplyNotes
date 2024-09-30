<?php
// Configurazione del database
$servername = "localhost";
$username = "root"; // Nome utente di default per XAMPP
$password = "";     // Password di default è vuota
$dbname = "notesapp_db";

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>
