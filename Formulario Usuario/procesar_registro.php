<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validar y procesar los datos (puedes agregar más validaciones según tus necesidades)

    // Aquí podrías realizar operaciones de base de datos, enviar correos, etc.

    // Mostrar mensaje de registro exitoso
    echo "<div class='container'><p class='mensaje'>¡Registro exitoso, $nombre! Gracias por unirte.</p></div>";
}
?>
