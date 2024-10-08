<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contrasena) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre_usuario, $contrasena);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <img src="img/logoCFP.png" alt="Logo de CFP-401" class="login-logo">
        <h2>Registro de Usuario</h2>

        <form method="POST" action="registro_usuario.php">
            <label for="nombre_usuario">Nombre de usuario:</label>
            <input type="text" name="nombre_usuario" required><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required><br>

            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
