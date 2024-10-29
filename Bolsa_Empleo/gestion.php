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
    <link rel="stylesheet" href="css/estilos.css"> <!-- Ruta a estilos.css -->
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
        <p>Seleccione una de las opciones para gestionar:</p>

        <!-- Menú de gestión en Flexbox -->
        <ul class="menu">
            <li class="menu-item">
                <a href="crud_estudiantes.php">
                    <img src="images/estudiantes.png" alt="Gestión de Estudiantes">
                    <p>Estudiantes</p>
                </a>
            </li>
            <li class="menu-item">
                <a href="crud_cursos.php">
                    <img src="images/cursos.png" alt="Gestión de Cursos">
                    <p>Cursos</p>
                </a>
            </li>
            <li class="menu-item">
                <a href="crud_instructores.php">
                    <img src="images/instructores.png" alt="Gestión de Instructores">
                    <p>Instructores</p>
                </a>
            </li>
            <li class="menu-item">
                <a href="crud_empresas.php">
                    <img src="images/empresas.png" alt="Gestión de Empresas">
                    <p>Empresas</p>
                </a>
            </li>
        </ul>

        <p><a href="logout.php" class="logout">Cerrar Sesión</a></p>
    </div>
</body>
</html>

