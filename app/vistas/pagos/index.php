<?php
require __DIR__ . '/../../controladores/PagoControlador.php';
$pagoControlador = new PagoControlador($conn);
$pagos = $pagoControlador->obtenerPagos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 d-flex justify-content-center">
<div class="text-center">
    <h1>Listado de Pagos</h1>   
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Tipo de Pago</th>
                <th>Fecha de Pago</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagos as $pago): ?>
                <tr>
                    <td><?php echo $pago['fk_id_reserva']; ?></td>
                    <td><?php echo $pago['fk_id_tipo_pago']; ?></td>
                    <td><?php echo $pago['fecha_pago']; ?></td>
                    <td><?php echo $pago['monto']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>