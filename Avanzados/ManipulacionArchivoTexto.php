<?php
$archivo = 'ruta/al/archivo.txt';

// Leer el archivo
$contenido = file_get_contents($archivo);

// Contar palabras y líneas
$palabras = str_word_count($contenido);
$lineas = count(explode("\n", $contenido));

// Mostrar resultados
echo "Palabras: $palabras<br>";
echo "Líneas: $lineas";
?>
