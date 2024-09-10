<?php
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $connection->prepare("UPDATE usuarios SET username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $password, $id);
        $stmt->execute();
        header("Location: usuarios.php");
        exit();
    }

    $stmt = $connection->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    header("Location: usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
<h2>Editar Usuario</h2>
<form method="POST" action="">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Actualizar Usuario</button>
</form>
</body>
</html>
