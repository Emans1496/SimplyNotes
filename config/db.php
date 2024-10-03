<?php
$servername = "dpg-crtcf252ng1s73bvnngq-a"; 
$username = "dbsimplynotes_user";            
$password = "relDbjxCEhkxDcUmUAfml4SDkD8HFbFm";        
$dbname = "dbsimplynotes";                   
$port = 5432;                                

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
     $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     error_log('Connessione fallita: ' . $e->getMessage());
     exit('Connessione fallita: ' . $e->getMessage());
}
?>
