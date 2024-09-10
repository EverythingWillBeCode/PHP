<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Cursos</title>
</head>
<body>

<h2>CRUD de Cursos</h2>

<!-- Formulario para crear o actualizar curso -->
<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo isset($curso['id']) ? $curso['id'] : ''; ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo isset($curso['nombre']) ? $curso['nombre'] : ''; ?>" required><br>

    <label for="descripcion">Descripción:</label>
    <input type="text" name="descripcion" value="<?php echo isset($curso['descripcion']) ? $curso['descripcion'] : ''; ?>" required><br>

    <label for="creditos">Créditos:</label>
    <input type="number" name="creditos" value="<?php echo isset($curso['creditos']) ? $curso['creditos'] : ''; ?>" required><br>

    <button type="submit" name="accion" value="crear">Crear Curso</button>
    <button type="submit" name="accion" value="actualizar">Actualizar Curso</button>
</form>

<!-- Listado de cursos -->
<h3>Lista de Cursos</h3>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Créditos</th>
        <th>Acciones</th>
    </tr>
    <?php
    // Obtener todos los cursos
    $resultado = $connection->query("SELECT * FROM cursos");
    while ($curso = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $curso['nombre'] . "</td>";
        echo "<td>" . $curso['descripcion'] . "</td>";
        echo "<td>" . $curso['creditos'] . "</td>";
        echo "<td>
                <form method='POST' action=''>
                    <input type='hidden' name='id' value='" . $curso['id'] . "'>
                    <button type='submit' name='accion' value='editar'>Editar</button>
                    <button type='submit' name='accion' value='eliminar'>Eliminar</button>
                </form>
            </td>";
        echo "</tr>";
    }
    ?>
</table>

<?php
// Acciones CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];

    if ($accion == 'crear') {
        // Crear un nuevo curso
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $creditos = $_POST['creditos'];

        $stmt = $connection->prepare("INSERT INTO cursos (nombre, descripcion, creditos) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nombre, $descripcion, $creditos);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($accion == 'actualizar') {
        // Actualizar un curso
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $creditos = $_POST['creditos'];

        $stmt = $connection->prepare("UPDATE cursos SET nombre = ?, descripcion = ?, creditos = ? WHERE id = ?");
        $stmt->bind_param("ssii", $nombre, $descripcion, $creditos, $id);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($accion == 'eliminar') {
        // Eliminar un curso
        $id = $_POST['id'];

        $stmt = $connection->prepare("DELETE FROM cursos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($accion == 'editar') {
        // Seleccionar un curso para edición
        $id = $_POST['id'];

        $resultado = $connection->query("SELECT * FROM cursos WHERE id = $id");
        $curso = $resultado->fetch_assoc();
    }
}
?>

</body>
</html>
