<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar el usuario por su ID
    $query = "DELETE FROM usuarios WHERE id=$id";
    
    if ($conn->query($query) === TRUE) {
        header('Location: listar_usuarios.php');
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }
}
?>
