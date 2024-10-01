<?php
header("Access-Control-Allow-Origin: https://simplynotes-oktn.onrender.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Il resto del tuo codice PHP...


// Avvia la sessione
session_start();

// Distruggi la sessione
session_unset();
session_destroy();

// Risposta di successo
echo json_encode(["success" => true, "message" => "Logout effettuato con successo."]);
?>
