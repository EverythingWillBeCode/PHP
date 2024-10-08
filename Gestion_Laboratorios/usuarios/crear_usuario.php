<form action="crear_usuario.php" method="POST">
    <label for="nombre_usuario">Nombre de Usuario:</label>
    <input type="text" name="nombre_usuario" required>
    
    <label for="contraseña">Contraseña:</label>
    <input type="password" name="contraseña" required>
    
    <button type="submit">Crear Usuario</button>
</form>

<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);  // Encriptar la contraseña

    // Verificar si el nombre de usuario ya existe
    $check_query = "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "El nombre de usuario ya está en uso. Elige otro.";
    } else {
        // Insertar el nuevo usuario
        $query = "INSERT INTO usuarios (nombre_usuario, contraseña) VALUES ('$nombre_usuario', '$contraseña')";
        
        if ($conn->query($query) === TRUE) {
            echo "Usuario creado exitosamente";
        } else {
            echo "Error al crear el usuario: " . $conn->error;
        }
    }
}
?>
