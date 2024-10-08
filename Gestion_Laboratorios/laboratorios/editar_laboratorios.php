<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM laboratorios WHERE id=$id";
    $result = $conn->query($query);
    $laboratorio = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $query = "UPDATE laboratorios SET nombre='$nombre' WHERE id=$id";

    if ($conn->query($query) === TRUE) {
        header('Location: listar_laboratorios.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form action="editar_laboratorio.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $laboratorio['id']; ?>">
    <input type="text" name="nombre" value="<?php echo $laboratorio['nombre']; ?>" required>
    <button type="submit">Actualizar Laboratorio</button>
</form>
