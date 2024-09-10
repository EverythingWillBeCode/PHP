<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            echo "Inicio de sesión exitoso. ¡Bienvenido, " . $user['username'] . "!";
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No existe una cuenta con ese nombre de usuario.";
    }

    $stmt->close();
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
<h2>Inicio de Sesión</h2>
<form method="POST" action="">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" name="username" required><br>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Iniciar Sesión</button>
</form>
</body>
</html>
