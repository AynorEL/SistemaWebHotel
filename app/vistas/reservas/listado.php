php
<?php
// Incluir el controlador de reservas
require __DIR__ . '/../../controladores/ReservaControlador.php';

// Incluir la barra lateral (si es necesario)
require __DIR__ . '/../../parciales/barra_lateral.php';

// Obtener la lista de reservas desde el controlador
$reservaControlador = new ReservaControlador($conn);
$reservas = $reservaControlador->obtenerReservas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Reservas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Incluir la barra lateral -->
<div class="container mt-5">
    <h1>Listado de Reservas</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Cliente (DNI)</th>
                <th>Usuario</th>
                <th>Habitación</th>
                <th>Tipo Habitación</th>
                <th>Estado Habitación</th>
                <th>Precio</th>
                <th>Fecha Inicio</th>
                <th>Fecha Salida</th>
                <th>Pago</th>
                <th>Tipo Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?php echo $reserva['id_reserva']; ?></td>
                    <td><?php echo $reserva['fk_dni']; ?></td>
                    <td><?php echo $reserva['usuario']; ?></td>
                    <td><?php echo $reserva['numero_habitacion']; ?></td>
                    <td><?php echo $reserva['nom_tipo']; ?></td>
                    <td><?php echo $reserva['nombre_estado']; ?></td>
                    <td><?php echo $reserva['precio']; ?></td>
                    <td><?php echo $reserva['fecha_inicio']; ?></td>
                    <td><?php echo $reserva['fecha_salida']; ?></td>
                    <td><?php echo $reserva['fecha_pago']; ?></td>
                    <td><?php echo $reserva['nombre_tipo']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $reserva['id_reserva']; ?>" class="btn btn-warning">Editar</a>
                        <a href="eliminar.php?id=<?php echo $reserva['id_reserva']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta reserva?');">Eliminar</a>
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
