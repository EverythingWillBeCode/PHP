<?php
include('db.php');

// Consultar todos los laboratorios
$query = "SELECT l.id, l.nombre, a.fecha_inicio, a.fecha_fin, d.nombre AS docente_nombre, d.apellido AS docente_apellido
          FROM laboratorios l
          LEFT JOIN asignaciones a ON l.id = a.laboratorio_id
          LEFT JOIN docentes d ON a.docente_id = d.id
          ORDER BY l.nombre";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Laboratorios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Estado de los Laboratorios</h1>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Laboratorio</th>
                    <th>Disponibilidad</th>
                    <th>Fecha y Hora de Ocupación</th>
                    <th>Docente Asignado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['nombre']; ?></td>
                        <td>
                            <?php if ($row['fecha_inicio'] && (!$row['fecha_fin'] || $row['fecha_fin'] > date("Y-m-d H:i:s"))) { ?>
                                Ocupado
                            <?php } else { ?>
                                Disponible
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($row['fecha_inicio']) { ?>
                                Desde: <?php echo $row['fecha_inicio']; ?><br>
                                <?php if ($row['fecha_fin']) { ?>
                                    Hasta: <?php echo $row['fecha_fin']; ?>
                                <?php } else { ?>
                                    Actualmente en uso
                                <?php } ?>
                            <?php } else { ?>
                                No asignado
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($row['docente_nombre']) { ?>
                                <?php echo $row['docente_nombre'] . ' ' . $row['docente_apellido']; ?>
                            <?php } else { ?>
                                No asignado
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
