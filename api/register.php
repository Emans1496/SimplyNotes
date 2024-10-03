<?php
require_once '../config/db.php';

header("Access-Control-Allow-Origin: https://simplynotes-static.onrender.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);
// Avvia la sessione
session_start();

// Ottieni i dati dal frontend
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Verifica che tutti i campi siano stati compilati
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Compila tutti i campi.']);
    exit();
}

// Hash della password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Verifica se l'username o l'email esistono già
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Username o email già in uso.']);
        exit();
    }

    // Inserisci il nuovo utente nel database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword]);

    echo json_encode(['success' => true, 'message' => 'Registrazione avvenuta con successo.']);
} catch (PDOException $e) {
    error_log("Errore durante la registrazione: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Errore durante la registrazione.']);
}
?>
