<?php
include('db.php');
$query = "SELECT * FROM laboratorios";
$result = $conn->query($query);

echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row['nombre'] . " <a href='editar_laboratorio.php?id=" . $row['id'] . "'>Editar</a> <a href='eliminar_laboratorio.php?id=" . $row['id'] . "'>Eliminar</a></li>";
}
echo "</ul>";
?>
