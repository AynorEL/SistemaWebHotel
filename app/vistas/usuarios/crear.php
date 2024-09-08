<?php
require '../controladores/UsuarioControlador.php';
require '../configuracion/base_datos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioControlador = new UsuarioControlador($conn);
    $usuarioControlador->crearUsuario($_POST['usuario'], $_POST['password'], $_POST['fk_idrol'], $_POST['fk_dni'], $_POST['fk_id_estado']);
    header('Location: listado.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <!-- Aquí el CSS necesario -->
</head>
<body>
<div class="container">
    <h1>Crear Usuario</h1>
    <form action="crear.php" method="POST">
        <!-- Campos de entrada para usuario, contraseña, rol, dni, etc. -->
        <button type="submit" class="btn btn-success">Crear Usuario</button>
    </form>
</div>
</body>
</html>

