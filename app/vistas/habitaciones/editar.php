<?php
require '../controladores/HabitacionesControlador.php';
require '../configuracion/base_datos.php';

$id_habitacion = $_GET['id']; // Obtener el ID de la habitación desde la URL
$habitacionesControlador = new HabitacionesControlador($conn);
$habitacion = $habitacionesControlador->obtenerHabitacionPorId($id_habitacion); // Crear método para obtener la habitación por ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $habitacionesControlador->editarHabitacion($id_habitacion, $_POST['numero_habitacion'], $_POST['descripcion'], $_POST['fk_id_tipo'], $_POST['fk_id_estado']);
    header('Location: listado.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Habitación</title>
    <!-- Agregar el CSS de Bootstrap para diseño -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Editar Habitación</h1>
    <form action="editar.php?id=<?php echo $id_habitacion; ?>" method="POST">
        <div class="mb-3">
            <label for="numero_habitacion" class="form-label">Número de Habitación</label>
            <input type="text" class="form-control" id="numero_habitacion" name="numero_habitacion" value="<?php echo $habitacion['numero_habitacion']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $habitacion['descripcion']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="fk_id_tipo" class="form-label">Tipo de Habitación</label>
            <input type="text" class="form-control" id="fk_id_tipo" name="fk_id_tipo" value="<?php echo $habitacion['fk_id_tipo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="fk_id_estado" class="form-label">Estado de Habitación</label>
            <input type="text" class="form-control" id="fk_id_estado" name="fk_id_estado" value="<?php echo $habitacion['fk_id_estado']; ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
    </form>
</div>

<!-- Agregar el JS de Bootstrap para funcionalidad -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
