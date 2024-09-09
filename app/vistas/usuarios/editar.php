<?php
require __DIR__ . '/../../middlewares/autenticacionMiddleware.php';
require __DIR__ . '/../../parciales/barra_lateral.php';
require '../configuracion/base_datos.php';

$id_usuario = $_GET['id'];

// Obtener el usuario actual desde la base de datos
$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// Procesar la actualización del usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $dni = $_POST['dni'];
    $estado = $_POST['estado'];

    $sql = "UPDATE usuarios SET usuario = ?, fk_idrol = ?, fk_dni = ?, fk_id_estado = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisii", $usuario, $rol, $dni, $estado, $id_usuario);
    $stmt->execute();
    header('Location: listado.php'); // Redirigir al listado de usuarios
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Editar Usuario</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario['usuario']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select class="form-control" id="rol" name="rol">
                <option value="1" <?php if ($usuario['fk_idrol'] == 1) echo 'selected'; ?>>Admin</option>
                <option value="2" <?php if ($usuario['fk_idrol'] == 2) echo 'selected'; ?>>Empleado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $usuario['fk_dni']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option value="1" <?php if ($usuario['fk_id_estado'] == 1) echo 'selected'; ?>>Activo</option>
                <option value="2" <?php if ($usuario['fk_id_estado'] == 2) echo 'selected'; ?>>Inactivo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
</body>
</html>
