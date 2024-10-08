<form action="crear_asignacion.php" method="POST">
    <label for="laboratorio_id">Laboratorio:</label>
    <select name="laboratorio_id">
        <?php
        // Obtener laboratorios
        $query_labs = "SELECT * FROM laboratorios";
        $result_labs = $conn->query($query_labs);
        while ($lab = $result_labs->fetch_assoc()) {
            echo "<option value='" . $lab['id'] . "'>" . $lab['nombre'] . "</option>";
        }
        ?>
    </select>

    <label for="docente_id">Docente:</label>
    <select name="docente_id">
        <?php
        // Obtener docentes
        $query_docentes = "SELECT * FROM docentes";
        $result_docentes = $conn->query($query_docentes);
        while ($docente = $result_docentes->fetch_assoc()) {
            echo "<option value='" . $docente['id'] . "'>" . $docente['nombre'] . " " . $docente['apellido'] . "</option>";
        }
        ?>
    </select>

    <label for="fecha_inicio">Fecha y Hora de Inicio:</label>
    <input type="datetime-local" name="fecha_inicio" required>

    <label for="fecha_fin">Fecha y Hora de Fin (opcional):</label>
    <input type="datetime-local" name="fecha_fin">

    <button type="submit">Asignar Laboratorio</button>
</form>
