<?php
require 'conexion.php';

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $stmt = $connection->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: usuarios.php");
    exit();
}

// Obtener todos los usuarios
$resultado = $connection->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios</title>
</head>
<body>
<h2>Listado de Usuarios</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre de Usuario</th>
        <th>Acciones</th>
    </tr>
    <?php while ($user = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td>
                <a href="editar_usuario.php?id=<?php echo $user['id']; ?>">Editar</a> |
                <a href="usuarios.php?eliminar=<?php echo $user['id']; ?>">Eliminar</a>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
