<?php
// Configurazione del database
$servername = "dpg-crtcf252ng1s73bvnngq-a"; // Hostname da Render
$username = "dbsimplynotes_user";            // Username da Render
$password = "relDbjxCEhkxDcUmUAfml4SDkD8HFbFm";        // Password da Render
$dbname = "dbsimplynotes";                   // Nome del database da Render
$port = 5432;                                // Porta predefinita di PostgreSQL

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>

