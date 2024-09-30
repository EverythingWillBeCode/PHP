<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener la lista de herramientas para seleccionar
$herramientas = $conexion->query("SELECT * FROM herramientas");

// Si se ha seleccionado una herramienta, obtener los préstamos asociados
$prestamos_herramienta = null; // Inicializo como null para que no dé error si no se selecciona herramienta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_herramienta'])) {
    $id_herramienta = $_POST['id_herramienta'];

    // Consulta para obtener los préstamos de la herramienta seleccionada, incluyendo el usuario que realizó el préstamo
    $prestamos_herramienta = $conexion->query("
        SELECT prestamos.id, herramientas.nombre AS herramienta_nombre, profesores.nombre AS profesor_nombre, prestamos.fecha_prestamo, prestamos.fecha_devolucion, prestamos.usuario_prestamo
        FROM prestamos
        JOIN herramientas ON prestamos.id_herramienta = herramientas.id
        JOIN profesores ON prestamos.profesor_id = profesores.id
        WHERE prestamos.id_herramienta = $id_herramienta
    ");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Herramientas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="loan-management-container">
        <h2>Seguimiento de Préstamos por Herramienta</h2>

        <!-- Formulario para seleccionar la herramienta -->
        <form method="POST" action="seguimiento_herramienta.php">
            <label for="id_herramienta">Selecciona una herramienta:</label>
            <select name="id_herramienta" required>
                <?php while ($herramienta = $herramientas->fetch_assoc()) { ?>
                    <option value="<?php echo $herramienta['id']; ?>"><?php echo $herramienta['nombre']; ?></option>
                <?php } ?>
            </select>
            <button type="submit">Ver Préstamos</button>
        </form>

        <!-- Si se ha seleccionado una herramienta, mostrar sus préstamos -->
        <?php if ($prestamos_herramienta && $prestamos_herramienta->num_rows > 0) { ?>
            <h3>Préstamos de la herramienta seleccionada:</h3>
            <table border="1">
                <tr>
                    <th>Herramienta</th>
                    <th>Profesor</th>
                    <th>Fecha y hora de Préstamo</th>
                    <th>Fecha y hora de Devolución</th>
                    <th>Usuario que realizó el préstamo</th> <!-- Nueva columna para mostrar el usuario -->
                </tr>
                <?php while ($prestamo = $prestamos_herramienta->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $prestamo['herramienta_nombre']; ?></td>
                        <td><?php echo $prestamo['profesor_nombre']; ?></td>
                        <td><?php echo $prestamo['fecha_prestamo']; ?></td>
                        <td><?php echo $prestamo['fecha_devolucion'] ?: 'No devuelto'; ?></td>
                        <td><?php echo $prestamo['usuario_prestamo']; ?></td> <!-- Mostrar el usuario que realizó el préstamo -->
                    </tr>
                <?php } ?>
            </table>
        <?php } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <p>No se encontraron préstamos para la herramienta seleccionada.</p>
        <?php } ?>

        <div class="links">
            <a href="prestamos.php">Volver a la gestión de préstamos</a>
        </div>
    </div>
</body>
</html>
