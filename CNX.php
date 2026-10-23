<?php
if (session_status()===PHP_SESSION_NONE){
    session_start();
}
$host = 'localhost';
$port = '3307'; 
$dbname = 'n8n'; 
$username = 'root';
$password = '';

try {
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
?>