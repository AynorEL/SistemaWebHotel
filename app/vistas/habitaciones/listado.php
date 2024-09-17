<?php
// Incluir el controlador de habitaciones
require __DIR__ . '/../../controladores/HabitacionControlador.php';

// Incluir la barra lateral
require __DIR__ . '/../../parciales/barra_lateral.php';

// Obtener la lista de habitaciones desde el controlador
$habitacionControlador = new HabitacionControlador($conn);
$habitaciones = $habitacionControlador->obtenerHabitaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Habitaciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Incluir la barra lateral -->
<div class="container mt-5">
    <h1>Listado de Habitaciones</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de Habitación</th>
                <th>Descripción</th>
                <th>Tipo de Habitación</th>
                <th>Estado de Habitación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($habitaciones as $habitacion): ?>
                <tr>
                    <td><?php echo $habitacion['id_habitacion']; ?></td>
                    <td><?php echo $habitacion['numero_habitacion']; ?></td>
                    <td><?php echo $habitacion['descripcion']; ?></td>
                    <td><?php echo $habitacion['nom_tipo']; ?></td>
                    <td><?php echo $habitacion['nombre_estado']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $habitacion['id_habitacion']; ?>" class="btn btn-warning">Editar</a>
                        <a href="eliminar.php?id=<?php echo $habitacion['id_habitacion']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta habitación?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
