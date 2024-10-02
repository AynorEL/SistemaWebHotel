<?php
include_once('../../../configuracion/base_datos.php');
include_once '../../controladores/HabitacionControlador.php';

$habitacionControlador = new HabitacionControlador();
$habitaciones = $habitacionControlador->listarHabitaciones();

// Obtener los tipos de habitación y estados para los select
$tipos_habitacion = $habitacionControlador->obtenerTiposHabitacion();
$estados_habitacion = $habitacionControlador->obtenerEstadosHabitacion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Habitaciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Lista de Habitaciones</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCrearHabitacion">
        <i class="fa fa-plus"></i> Agregar Habitación
    </button>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Número</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($habitacion = $habitaciones->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $habitacion['id_habitacion']; ?></td>
                        <td><?php echo $habitacion['numero_habitacion']; ?></td>
                        <td><?php echo $habitacion['descripcion']; ?></td>
                        <td><?php echo $habitacion['tipo_habitacion']; ?></td>
                        <td><?php echo $habitacion['estado_habitacion']; ?></td>
                        <td>
                            <!-- Iconos de acciones sin funcionalidad -->
                            <span class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </span>
                            <span class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear Habitación -->
<div class="modal fade" id="modalCrearHabitacion" tabindex="-1" role="dialog" aria-labelledby="modalCrearHabitacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php include 'crear.php'; ?> <!-- Contenido del modal de creación -->
        </div>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script personalizado para el manejo de habitaciones -->
<script>
$(document).ready(function() {

    // Evento para crear habitación
    $('#formCrearHabitacion').submit(function(e) {
        e.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/SistemaWebHotel/app/controladores/HabitacionControlador.php',
            data: datos + '&accion=crear',
            success: function(response) {
                response = response.trim();
                if (response === 'exito') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Habitación creada correctamente.',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modalCrearHabitacion').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al crear la habitación.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    });

});
</script>

</body>
</html>
