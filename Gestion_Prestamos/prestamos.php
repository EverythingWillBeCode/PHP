<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el nombre del usuario logueado
$usuario_logueado = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];

    if ($accion == 'agregar') {
        $id_herramienta = $_POST['id_herramienta'];
        $profesor = $_POST['profesor_id'];
        $fecha_prestamo = $_POST['fecha_prestamo'];

        // Incluir el usuario que está realizando el préstamo
        $stmt = $conexion->prepare("INSERT INTO prestamos (id_herramienta, profesor_id, fecha_prestamo, usuario_prestamo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_herramienta, $profesor, $fecha_prestamo, $usuario_logueado);
        $stmt->execute();
    } elseif ($accion == 'devolver') {
        $id = $_POST['id'];
        $fecha_actual = date('Y-m-d H:i:s');  // Captura la fecha y hora actual

        // Actualiza la fecha de devolución con la fecha actual
        $stmt = $conexion->prepare("UPDATE prestamos SET fecha_devolucion = ? WHERE id = ?");
        $stmt->bind_param("si", $fecha_actual, $id);
        $stmt->execute();
    }
}

// Obtener la lista de profesores
$profesores = $conexion->query("SELECT * FROM profesores");

// Obtener lista de préstamos con un JOIN a las tablas herramientas, profesores y filtrado por usuario
// Solo mostrar préstamos no devueltos (fecha_devolucion es NULL) y ordenarlos por el más reciente
$prestamos = $conexion->query("
    SELECT prestamos.id, herramientas.nombre, profesores.nombre as profesor_nombre, prestamos.fecha_prestamo, prestamos.fecha_devolucion, prestamos.usuario_prestamo
    FROM prestamos 
    JOIN herramientas ON prestamos.id_herramienta = herramientas.id 
    JOIN profesores ON prestamos.profesor_id = profesores.id
    WHERE prestamos.fecha_devolucion IS NULL
    ORDER BY prestamos.fecha_prestamo DESC
");

$herramientas = $conexion->query("SELECT * FROM herramientas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="loan-management-container">
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
            <select name="profesor_id" required>
                <?php while ($profesor = $profesores->fetch_assoc()) { ?>
                    <option value="<?php echo $profesor['id']; ?>"><?php echo $profesor['nombre']; ?></option>
                <?php } ?>
            </select><br>
            
            <!-- Cambiar a un campo de tipo 'datetime-local' para incluir hora -->
            <label for="fecha_prestamo">Fecha y Hora de Préstamo:</label>
            <input type="datetime-local" name="fecha_prestamo" required><br>

            <button type="submit">Agregar Préstamo</button>
        </form>

        <!-- Enlaces para gestionar herramientas y profesores -->
        <div class="links">
            <a href="herramientas.php">Gestionar Herramientas</a> |
            <a href="seguimiento_herramienta.php">Seguimiento de Herramientas</a> |
            <a href="profesores.php">Gestionar Profesores</a> |
            <a href="logout.php">Cerrar Sesión</a>
        </div>

        <!-- Listado de préstamos -->
        <h3>Lista de Préstamos</h3>
        <table>
            <tr>
                <th>Herramienta</th>
                <th>Profesor</th>
                <th>Fecha y Hora de Préstamo</th>
                <th>Usuario que realizó el préstamo</th>
                <th>Acciones</th>
            </tr>
            <?php while ($prestamo = $prestamos->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $prestamo['nombre']; ?></td>
                    <td><?php echo $prestamo['profesor_nombre']; ?></td>
                    <td><?php echo $prestamo['fecha_prestamo']; ?></td>
                    <td><?php echo $prestamo['usuario_prestamo']; ?></td>
                    <td>
                        <!-- Cambiar el botón de eliminar a devolver -->
                        <form method="POST" action="prestamos.php">
                            <input type="hidden" name="id" value="<?php echo $prestamo['id']; ?>">
                            <input type="hidden" name="accion" value="devolver">
                            <button type="submit">Devolver</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
