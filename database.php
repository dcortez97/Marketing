<?php 

$server = 'localhost';
$username = 'ulises';
$password = 'ulises1996';
$database = 'fit';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
    die('Conexion fallida'. $e->getMessage());
}

?>