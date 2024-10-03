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
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
]);

session_start();

include_once '../config/db.php';

// Ottieni i dati inviati tramite POST
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Controlla se i dati sono stati inviati
if (!empty($username) && !empty($password)) {
    try {
        // Preparazione dello statement per prevenire SQL injection
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se l'utente esiste
        if ($user) {
            // Verifica la password
            if (password_verify($password, $user['password'])) {
                // Password corretta, avvia la sessione
                $_SESSION['user_id'] = $user['id'];
                echo json_encode(["success" => true, "message" => "Login effettuato con successo."]);
            } else {
                // Password errata
                echo json_encode(["success" => false, "message" => "Username o password errati."]);
            }
        } else {
            // Utente non trovato
            echo json_encode(["success" => false, "message" => "Username o password errati."]);
        }
    } catch (PDOException $e) {
        error_log("Errore durante il login: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "Errore durante il login."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>
