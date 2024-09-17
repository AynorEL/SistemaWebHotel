<?php
session_start();
require_once __DIR__ . '/../../controladores/UsuarioControlador.php';

// Crear instancia del controlador
$usuarioControlador = new UsuarioControlador($conn);

// Obtener la lista de usuarios y personas
try {
    $usuarios = $usuarioControlador->obtenerUsuarios(); 
    $personas = $usuarioControlador->obtenerPersonas(); 
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// Definir el título de la página
$tituloPagina = "Usuarios";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de <?php echo htmlspecialchars($tituloPagina, ENT_QUOTES, 'UTF-8'); ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/SistemaWebHotel/public/css/estilos.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container mt-5">
    <h1>Lista de <?php echo htmlspecialchars($tituloPagina, ENT_QUOTES, 'UTF-8'); ?></h1>
    
    <!-- Botón para abrir el modal de agregar usuario -->
    <button type="button" class="btn btn-primary add-user-btn" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">
        <i class="fas fa-user-plus"></i> Crear Usuario
    </button>
    
    <!-- Tabla de usuarios con paginación y ordenación -->
    <table id="tablaUsuarios" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>DNI</th>
                <th>Dirección</th>
                <th>Celular</th>
                <th>Acciones</th>
                    <th>celular</th>
                    <th>Direccion</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id_usuario']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td><?php echo $usuario['fk_idrol']; ?></td>
                    <td><?php echo $usuario['fk_dni']; ?></td>
                    <td><?php echo $usuario['fk_id_estado'] == 1 ? 'Activo' : 'Oculto'; ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm editarUsuario" data-id="<?php echo htmlspecialchars($usuario['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm cambiarEstadoUsuario" data-id="<?php echo htmlspecialchars($usuario['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>" data-estado="1">
                            <i class="fas fa-eye-slash"></i> Cambiar Estado
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarUsuario">
          <input type="hidden" id="editarIdUsuario" name="id_usuario">
          <div class="mb-3">
            <label for="editarNombreUsuario" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="editarNombreUsuario" name="nombreUsuario" required>
          </div>
          <div class="mb-3">
            <label for="editarRolUsuario" class="form-label">Rol</label>
            <select class="form-select" id="editarRolUsuario" name="rolUsuario" required>
              <option value="1">Administrador</option>
              <option value="2">Empleado</option>
              <option value="3">Recepcionista</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editarDniUsuario" class="form-label">DNI</label>
            <input type="text" class="form-control" id="editarDniUsuario" name="dniUsuario" required>
          </div>
          <div class="mb-3">
            <label for="editarEstadoUsuario" class="form-label">Estado</label>
            <select class="form-select" id="editarEstadoUsuario" name="estadoUsuario" required>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="actualizarUsuarioBtn" class="btn btn-primary">Actualizar Usuario</button>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/SistemaWebHotel/public/js/scripts.js"></script>

</body>
</html>
