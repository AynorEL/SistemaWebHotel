<?php
include_once(__DIR__ . '/../../../configuracion/base_datos.php');
include_once(__DIR__ . '/../../controladores/HabitacionControlador.php');

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
    <!-- Estilos personalizados -->
    <style>
        .sortable:hover {
            cursor: pointer;
            text-decoration: underline;
        }
        .modal-body {
    max-height: 500px;
    overflow-y: auto;
}
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Lista de Habitaciones</h2>

    <!-- Barra de búsqueda y filtros -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="buscarHabitacion" class="form-control" placeholder="Buscar habitación...">
        </div>
        <div class="col-md-4">
            <select id="filtroTipo" class="form-control">
                <option value="">Filtrar por Tipo</option>
                <?php foreach ($tipos_habitacion as $tipo): ?>
                    <option value="<?= $tipo['id_tipo'] ?>"><?= $tipo['nom_tipo'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <select id="filtroEstado" class="form-control">
                <option value="">Filtrar por Estado</option>
                <?php foreach ($estados_habitacion as $estado): ?>
                    <option value="<?= $estado['id_estado_habitacion'] ?>"><?= $estado['nombre_estado'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Botón para agregar nueva habitación -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCrearHabitacion">
        <i class="fa fa-plus"></i> Agregar Habitación
    </button>

    <!-- Tabla de habitaciones -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th id="sortID" class="sortable">ID</th>
                    <th id="sortNumero" class="sortable">Número</th>
                    <th>Descripción</th>
                    <th id="sortTipo" class="sortable">Tipo</th>
                    <th id="sortEstado" class="sortable">Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="listaHabitaciones">
                <!-- Aquí se cargarán dinámicamente las habitaciones -->
                <?php while($habitacion = $habitaciones->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $habitacion['id_habitacion'] ?></td>
                        <td><?= $habitacion['numero_habitacion'] ?></td>
                        <td><?= $habitacion['descripcion'] ?></td>
                        <td><?= $habitacion['tipo_habitacion'] ?></td>
                        <td><?= $habitacion['estado_habitacion'] ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning editarHabitacion" data-id="<?= $habitacion['id_habitacion'] ?>">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger eliminarHabitacion" data-id="<?= $habitacion['id_habitacion'] ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <nav>
        <ul class="pagination justify-content-center" id="paginacionHabitaciones">
            <!-- Paginación generada dinámicamente -->
        </ul>
    </nav>
</div>

<!-- Modal Crear Habitación -->
<div class="modal fade" id="modalCrearHabitacion" tabindex="-1" role="dialog" aria-labelledby="modalCrearHabitacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php include 'crear.php'; ?> <!-- Contenido del modal de creación -->
        </div>
    </div>
</div>

<!-- Modal Actualizar Habitación -->
<div class="modal fade" id="modalActualizarHabitacion" tabindex="-1" role="dialog" aria-labelledby="modalActualizarHabitacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Aquí el contenido se cargará dinámicamente con AJAX -->
        </div>
    </div>
</div>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/SistemaWebHotel/public/js/habitacion.js"></script>
</body>
</html>
