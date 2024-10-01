<?php
// Configurazione del database
$servername = "dpg-crtcf252ng1s73bvnngq-a"; 
$username = "dbsimplynotes_user";            
$password = "relDbjxCEhkxDcUmUAfml4SDkD8HFbFm";        
$dbname = "dbsimplynotes";                   
$port = 5432;                                

try {
    $conn = new PDO("pgsql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connessione fallita: " . $e->getMessage());
}
?>
