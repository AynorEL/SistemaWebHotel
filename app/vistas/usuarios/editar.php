<?php
require '../controladores/UsuarioControlador.php';
require '../configuracion/base_datos.php';

$id_usuario = $_GET['id']; // Obtener el ID del usuario desde la URL
$usuarioControlador = new UsuarioControlador($conn);
$usuario = $usuarioControlador->obtenerUsuarioPorId($id_usuario); // Crear método para obtener el usuario por ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioControlador->editarUsuario($id_usuario, $_POST['usuario'], $_POST['password'], $_POST['fk_idrol'], $_POST['fk_dni'], $_POST['fk_id_estado']);
    header('Location: listado.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
<div class="container">
    <h1>Editar Usuario</h1>
    <form action="editar.php?id=<?php echo $id_usuario; ?>" method="POST">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario['usuario']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="fk_idrol" class="form-label">Rol</label>
            <input type="text" class="form-control" id="fk_idrol" name="fk_idrol" value="<?php echo $usuario['fk_idrol']; ?>" required>
        </div>
        <!-- Otros campos como DNI, Estado, etc. -->
        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
    </form>
</div>
</body>
</html>
