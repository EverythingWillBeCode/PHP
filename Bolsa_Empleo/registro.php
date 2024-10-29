<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registrar Nuevo Usuario</h2>
    
    <!-- Formulario para registrar un nuevo usuario -->
    <form action="" method="POST">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required>
        <br><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Registrar Usuario</button>
    </form>

    <!-- Código PHP para registrar al usuario -->
    <?php
    include 'conexion.php'; // Conexión a la base de datos

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña

        $sql = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Usuario registrado exitosamente</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
    ?>
</body>
</html>
