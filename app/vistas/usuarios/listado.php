<?php
require __DIR__ . '/../../controladores/UsuarioControlador.php'; // Asegúrate de que esta ruta sea correcta

// Crear instancia del controlador
$usuarioControlador = new UsuarioControlador($conn);

// Obtener la lista de usuarios y personas para el combobox de DNI
$usuarios = $usuarioControlador->obtenerUsuarios();
$personas = $usuarioControlador->obtenerPersonas(); // Para el combobox de DNI

// Definir el título de la página
$tituloPagina = "Usuarios";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de <?php echo $tituloPagina; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" async>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" defer>
    <!-- FontAwesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" defer>
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .container {
            margin-top: 10px;
            max-width: 90%;
        }
        h1 {
            font-size: 2.3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007bff;
        }
        .add-user-btn {
            margin-bottom: 20px;
        }
        table.dataTable thead {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1>Lista de <?php echo $tituloPagina; ?></h1>
    
    <!-- Botón para abrir el modal de agregar usuario -->
    <button type="button" class="btn btn-primary add-user-btn" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">
        <i class="fas fa-user-plus"></i> Crear Usuario
    </button>
    
    <!-- Tabla de usuarios con paginación y ordenación -->
    <table id="tablaUsuarios" class="table table-bordered table-hover">
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
                    <td><?php echo $usuario['fk_id_estado'] == 1 ? 'Activo' : 'Oculto'; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                        <a href="estado.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-secondary btn-sm" onclick="return confirmarEstado();"><i class="fas fa-eye-slash"></i> Cambiar Estado</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal de Bootstrap para agregar usuario -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="modalAgregarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarUsuarioLabel">Crear Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <!-- Formulario para agregar un nuevo usuario -->
        <form id="formAgregarUsuario">
          <div class="mb-3">
            <label for="nombreUsuario" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
          </div>
          <div class="mb-3">
            <label for="rolUsuario" class="form-label">Rol</label>
            <select class="form-select" id="rolUsuario" name="rolUsuario" required>
              <option value="1">Administrador</option>
              <option value="2">Empleado</option>
              <option value="3">Recepcionista</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="dniUsuario" class="form-label">DNI</label>
            <select class="form-select" id="dniUsuario" name="dniUsuario" required>
                <?php foreach ($personas as $persona): ?>
                    <option value="<?php echo $persona['dni']; ?>"><?php echo $persona['dni'] . ' - ' . $persona['nombre_completo']; ?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="passwordUsuario" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" required>
          </div>
          <div class="mb-3">
            <label for="estadoUsuario" class="form-label">Estado</label>
            <select class="form-select" id="estadoUsuario" name="estadoUsuario" required>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="crearUsuarioBtn" class="btn btn-primary">Crear Usuario</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" async></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" defer></script>
<!-- FontAwesome para los iconos -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" defer></script>

<!-- Script para activar DataTables -->
<script>
$(document).ready(function() {
    $('#tablaUsuarios').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "pageLength": 5,
        "deferRender": true, // Optimiza el renderizado para cuando es necesario
        "order": [[ 0, "asc" ]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ usuarios por página",
            "zeroRecords": "No se encontraron usuarios",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay usuarios disponibles",
            "infoFiltered": "(filtrado de _MAX_ usuarios totales)",
            "search": "Buscar:",
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente"
            }
        }
    });

    // Función para enviar el formulario usando AJAX
    $('#crearUsuarioBtn').click(function(e) {
        e.preventDefault();
        var formData = $('#formAgregarUsuario').serialize(); // Recopila los datos del formulario

        $.ajax({
            url: 'http://localhost/SistemaWebHotel/app/vistas/usuarios/crear.php', // Ruta correcta
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log(response); // Verifica en consola la respuesta
                if (response.status === 'success') {
                    alert(response.message);
                    $('#modalAgregarUsuario').modal('hide');
                    var nuevoUsuario = `
                        <tr>
                            <td>${response.data.id_usuario}</td>
                            <td>${response.data.usuario}</td>
                            <td>${response.data.rol}</td>
                            <td>${response.data.dni}</td>
                            <td>${response.data.estado == 1 ? 'Activo' : 'Oculto'}</td>
                            <td>
                                <a href="editar.php?id=${response.data.id_usuario}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                <a href="estado.php?id=${response.data.id_usuario}" class="btn btn-secondary btn-sm"><i class="fas fa-eye-slash"></i> Cambiar Estado</a>
                            </td>
                        </tr>
                    `;
                    $('#tablaUsuarios tbody').append(nuevoUsuario);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al crear el usuario:', error); // Verifica detalles del error
                alert('Error al crear el usuario listado.');
            }
        });
    });
});

// Confirmación personalizada para cambiar el estado
function confirmarEstado() {
    return confirm('¿Estás seguro de cambiar el estado?');
}
</script>

</body>
</html>
