<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirige si no ha iniciado sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de CRUDs</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
    <p>Seleccione una de las opciones para gestionar:</p>
    <ul>
        <li><a href="crud_estudiantes.php">Gestión de Estudiantes</a></li>
        <li><a href="crud_cursos.php">Gestión de Cursos</a></li>
        <li><a href="crud_instructores.php">Gestión de Instructores</a></li>
        <li><a href="crud_empresas.php">Gestión de Empresas</a></li>
    </ul>
    <p><a href="logout.php">Cerrar Sesión</a></p>
</body>
</html>
