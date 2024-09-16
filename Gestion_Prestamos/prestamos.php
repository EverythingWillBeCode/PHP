<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    
    if ($accion == 'agregar') {
        $id_herramienta = $_POST['id_herramienta'];
        $profesor = $_POST['profesor'];
        $fecha_prestamo = $_POST['fecha_prestamo'];

        $stmt = $conexion->prepare("INSERT INTO prestamos (id_herramienta, profesor, fecha_prestamo) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_herramienta, $profesor, $fecha_prestamo);
        $stmt->execute();
    } elseif ($accion == 'eliminar') {
        $id = $_POST['id'];
        $stmt = $conexion->prepare("DELETE FROM prestamos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

// Obtener lista de préstamos
$prestamos = $conexion->query("SELECT prestamos.id, herramientas.nombre, prestamos.profesor, prestamos.fecha_prestamo, prestamos.fecha_devolucion FROM prestamos JOIN herramientas ON prestamos.id_herramienta = herramientas.id");
$herramientas = $conexion->query("SELECT * FROM herramientas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Préstamos</title>
</head>
<body>
    <h2>Gestión de Préstamos</h2>

    <!-- Formulario para agregar nuevo préstamo -->
    <form method="POST" action="prestamos.php">
        <input type="hidden" name="accion" value="agregar">

        <label for="id_herramienta">Herramienta:</label>
        <select name="id_herramienta" required>
            <?php while ($herramienta = $herramientas->fetch_assoc()) { ?>
                <option value="<?php echo $herramienta['id']; ?>"><?php echo $herramienta['nombre']; ?></option>
            <?php } ?>
        </select><br>

        <label for="profesor">Profesor:</label>
        <input type="text" name="profesor" required><br>

        <label for="fecha_prestamo">Fecha de Préstamo:</label>
        <input type="date" name="fecha_prestamo" required><br>

        <button type="submit">Agregar Préstamo</button>
    </form>

    <!-- Listado de préstamos -->
    <h3>Lista de Préstamos</h3>
    <table border="1">
        <tr>
            <th>Herramienta</th>
            <th>Profesor</th>
            <th>Fecha de Préstamo</th>
            <th>Fecha de Devolución</th>
            <th>Acciones</th>
        </tr>
        <?php while ($prestamo = $prestamos->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $prestamo['nombre']; ?></td>
                <td><?php echo $prestamo['profesor']; ?></td>
                <td><?php echo $prestamo['fecha_prestamo']; ?></td>
                <td><?php echo $prestamo['fecha_devolucion'] ?: 'No devuelto'; ?></td>
                <td>
                    <form method="POST" action="prestamos.php">
                        <input type="hidden" name="id" value="<?php echo $prestamo['id']; ?>">
                        <input type="hidden" name="accion" value="eliminar">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
