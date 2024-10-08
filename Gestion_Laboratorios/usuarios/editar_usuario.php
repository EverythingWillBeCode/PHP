<?php
include('db.php');

// Obtener los datos del usuario por ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM usuarios WHERE id=$id";
    $result = $conn->query($query);
    $usuario = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $contraseña = $_POST['contraseña'];

    // Actualizar el nombre de usuario
    $update_query = "UPDATE usuarios SET nombre_usuario='$nombre_usuario'";

    // Si la contraseña no está vacía, actualizarla también
    if (!empty($contraseña)) {
        $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);
        $update_query .= ", contraseña='$contraseña_encriptada'";
    }

    $update_query .= " WHERE id=$id";

    if ($conn->query($update_query) === TRUE) {
        echo "Usuario actualizado exitosamente";
        header('Location: listar_usuarios.php');
    } else {
        echo "Error al actualizar el usuario: " . $conn->error;
    }
}
?>

<form action="editar_usuario.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
    
    <label for="nombre_usuario">Nombre de Usuario:</label>
    <input type="text" name="nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>" required>
    
    <label for="contraseña">Contraseña (déjalo en blanco para no cambiarla):</label>
    <input type="password" name="contraseña">
    
    <button type="submit">Actualizar Usuario</button>
</form>
