<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'app_school';

// Crear una conexión a la base de datos
$connection = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($connection->connect_error) {
    die("Conexión fallida: " . $connection->connect_error);
}
?>
