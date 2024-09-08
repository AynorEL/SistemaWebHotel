<?php
// Incluir el controlador de usuarios
require __DIR__ . '/../../controladores/UsuarioControlador.php';

// Incluir la barra lateral
require __DIR__ . '/../../parciales/barra_lateral.php';

// Aquí puedes añadir el código para obtener los usuarios y mostrarlos

// Obtener la lista de usuarios desde el controlador
$usuarioControlador = new UsuarioControlador($conn);
$usuarios = $usuarioControlador->obtenerUsuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Incluir la barra lateral -->
<div class="container mt-5">
    <h1>Listado de Usuarios</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>DNI</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id_usuario']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td><?php echo $usuario['fk_idrol']; ?></td>
                    <td><?php echo $usuario['fk_dni']; ?></td>
                    <td><?php echo $usuario['fk_id_estado']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-warning">Editar</a>
                        <a href="eliminar.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
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
