<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Manejar las acciones CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];

    if ($accion == 'agregar') {
        // Agregar nuevo profesor
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];

        $stmt = $conexion->prepare("INSERT INTO profesores (nombre, email, telefono) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $telefono);
        $stmt->execute();
    } elseif ($accion == 'actualizar') {
        // Actualizar profesor existente
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];

        $stmt = $conexion->prepare("UPDATE profesores SET nombre = ?, email = ?, telefono = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nombre, $email, $telefono, $id);
        $stmt->execute();
    } elseif ($accion == 'eliminar') {
        // Eliminar profesor
        $id = $_POST['id'];

        $stmt = $conexion->prepare("DELETE FROM profesores WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

// Obtener la lista de profesores
$profesores = $conexion->query("SELECT * FROM profesores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Profesores</title>
</head>
<body>
    <h2>Gestión de Profesores</h2>

    <!-- Formulario para agregar/editar profesor -->
    <form method="POST" action="profesores.php">
        <input type="hidden" name="id" value="<?php echo isset($profesor) ? $profesor['id'] : ''; ?>">
        <input type="hidden" name="accion" value="<?php echo isset($profesor) ? 'actualizar' : 'agregar'; ?>">

        <label for="nombre">Nombre del Profesor:</label>
        <input type="text" name="nombre" value="<?php echo isset($profesor) ? $profesor['nombre'] : ''; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo isset($profesor) ? $profesor['email'] : ''; ?>" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo isset($profesor) ? $profesor['telefono'] : ''; ?>"><br>

        <button type="submit">
            <?php echo isset($profesor) ? 'Actualizar Profesor' : 'Agregar Profesor'; ?>
        </button>
    </form>

    <!-- Listado de profesores -->
    <h3>Lista de Profesores</h3>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php while ($profesor = $profesores->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $profesor['nombre']; ?></td>
                <td><?php echo $profesor['email']; ?></td>
                <td><?php echo $profesor['telefono']; ?></td>
                <td>
                    <form method="POST" action="profesores.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $profesor['id']; ?>">
                        <input type="hidden" name="accion" value="editar">
                        <button type="submit">Editar</button>
                    </form>
                    <form method="POST" action="profesores.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $profesor['id']; ?>">
                        <input type="hidden" name="accion" value="eliminar">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="prestamos.php">Volver a Préstamos</a> | <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
