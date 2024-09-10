<?php
$host = 'localhost';
$db = 'app_users';
$user = 'root'; // Cambia esto si tienes un usuario diferente
$pass = ''; // Cambia esto si tienes una contraseña diferente

$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Conexión fallida: " . $connection->connect_error);
}
?>
