<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['accion'] == 'editar') {
    $id = $_POST['id'];
    $resultado = $conexion->query("SELECT * FROM herramientas WHERE id = $id");
    $herramienta = $resultado->fetch_assoc();
}


// Manejar las acciones CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];

    if ($accion == 'agregar') {
        // Agregar nueva herramienta
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $stmt = $conexion->prepare("INSERT INTO herramientas (nombre, descripcion) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $descripcion);
        $stmt->execute();
    } elseif ($accion == 'actualizar') {
        // Actualizar herramienta existente
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $stmt = $conexion->prepare("UPDATE herramientas SET nombre = ?, descripcion = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre, $descripcion, $id);
        $stmt->execute();
    } elseif ($accion == 'eliminar') {
        // Eliminar herramienta
        $id = $_POST['id'];

        $stmt = $conexion->prepare("DELETE FROM herramientas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

// Obtener la lista de herramientas
$herramientas = $conexion->query("SELECT * FROM herramientas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Herramientas</title>
</head>
<body>
    <h2>Gestión de Herramientas</h2>

    <!-- Formulario para agregar/editar herramienta -->
    <form method="POST" action="herramientas.php">
        <input type="hidden" name="id" value="<?php echo isset($herramienta) ? $herramienta['id'] : ''; ?>">
        <input type="hidden" name="accion" value="<?php echo isset($herramienta) ? 'actualizar' : 'agregar'; ?>">

        <label for="nombre">Nombre de la herramienta:</label>
        <input type="text" name="nombre" value="<?php echo isset($herramienta) ? $herramienta['nombre'] : ''; ?>" required><br>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" value="<?php echo isset($herramienta) ? $herramienta['descripcion'] : ''; ?>" required><br>

        <button type="submit">
            <?php echo isset($herramienta) ? 'Actualizar Herramienta' : 'Agregar Herramienta'; ?>
        </button>
    </form>

    <!-- Listado de herramientas -->
    <h3>Lista de Herramientas</h3>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php while ($herramienta = $herramientas->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $herramienta['nombre']; ?></td>
                <td><?php echo $herramienta['descripcion']; ?></td>
                <td>
                    <form method="POST" action="herramientas.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $herramienta['id']; ?>">
                        <input type="hidden" name="accion" value="editar">
                        <button type="submit">Editar</button>
                    </form>
                    <form method="POST" action="herramientas.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $herramienta['id']; ?>">
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
