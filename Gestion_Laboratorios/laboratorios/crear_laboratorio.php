<form action="crear_laboratorio.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre del Laboratorio" required>
    <button type="submit">Crear Laboratorio</button>
</form>

<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $query = "INSERT INTO laboratorios (nombre) VALUES ('$nombre')";
    
    if ($conn->query($query) === TRUE) {
        echo "Laboratorio creado exitosamente";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
