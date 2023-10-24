<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $edad = $_POST["edad"];

    // Validar datos
    if (empty($nombre) || empty($email) || empty($edad)) {
        echo "Por favor, completa todos los campos.";
    } else {
        echo "¡Bienvenido, $nombre! Tu correo es $email y tienes $edad años.";
    }
}
?>

<!-- Formulario HTML -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Nombre: <input type="text" name="nombre"><br>
    Correo electrónico: <input type="text" name="email"><br>
    Edad: <input type="text" name="edad"><br>
    <input type="submit" value="Enviar">
</form>
