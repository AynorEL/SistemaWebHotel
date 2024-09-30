<?php
include_once('../../../configuracion/base_datos.php');
include_once '../../controladores/UsuarioControlador.php';

$usuarioControlador = new UsuarioControlador();
$usuarios = $usuarioControlador->listarUsuarios();
$roles = $usuarioControlador->obtenerRoles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Lista de Usuarios</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCrearUsuario">
        <i class="fa fa-user-plus"></i> Agregar Usuario
    </button>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th>Celular</th>
                    <th>Cargo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($usuario = $usuarios->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $usuario['id_usuario']; ?></td>
                        <td><?php echo $usuario['nombres']; ?></td>
                        <td><?php echo $usuario['direccion']; ?></td>
                        <td><?php echo $usuario['correo']; ?></td>
                        <td><?php echo $usuario['usuario']; ?></td>
                        <td><?php echo $usuario['celular']; ?></td>
                        <td><?php echo $usuario['cargo']; ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning editarUsuario" data-id="<?php echo $usuario['id_usuario']; ?>">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger cambiarEstado" data-id="<?php echo $usuario['id_usuario']; ?>" data-estado="1">
                                <i class="fa fa-toggle-on"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" role="dialog" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formCrearUsuario">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearUsuarioLabel">Crear Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario -->
                    <?php include 'crear.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Actualizar Usuario -->
<div class="modal fade" id="modalActualizarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalActualizarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- El formulario se cargará dinámicamente mediante AJAX -->
        </div>
    </div>
</div>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script personalizado incluido directamente -->
<script>
$(document).ready(function() {
    // Función para validar el formulario de creación de usuario
    function validarFormularioCrear() {
        var dni = $('#formCrearUsuario input[name="dni"]').val().trim();
        var nombres = $('#formCrearUsuario input[name="nombres"]').val().trim();
        var apellidos = $('#formCrearUsuario input[name="apellidos"]').val().trim();
        var direccion = $('#formCrearUsuario input[name="direccion"]').val().trim();
        var celular = $('#formCrearUsuario input[name="celular"]').val().trim();
        var correo = $('#formCrearUsuario input[name="correo"]').val().trim();
        var usuario = $('#formCrearUsuario input[name="usuario"]').val().trim();
        var password = $('#formCrearUsuario input[name="password"]').val();
        var fk_idrol = $('#formCrearUsuario select[name="fk_idrol"]').val();

        // Validaciones
        if (dni === '' || !/^\d{8}$/.test(dni)) {
            Swal.fire('Error', 'Ingrese un DNI válido de 8 dígitos.', 'error');
            return false;
        }
        if (nombres === '') {
            Swal.fire('Error', 'Ingrese los nombres.', 'error');
            return false;
        }
        if (apellidos === '') {
            Swal.fire('Error', 'Ingrese los apellidos.', 'error');
            return false;
        }
        if (direccion === '') {
            Swal.fire('Error', 'Ingrese la dirección.', 'error');
            return false;
        }
        if (celular === '' || !/^\d{9}$/.test(celular)) {
            Swal.fire('Error', 'Ingrese un número de celular válido de 9 dígitos.', 'error');
            return false;
        }
        if (correo === '' || !/^\S+@\S+\.\S+$/.test(correo)) {
            Swal.fire('Error', 'Ingrese un correo electrónico válido.', 'error');
            return false;
        }
        if (usuario === '') {
            Swal.fire('Error', 'Ingrese un nombre de usuario.', 'error');
            return false;
        }
        if (password === '' || password.length < 6) {
            Swal.fire('Error', 'La contraseña debe tener al menos 6 caracteres.', 'error');
            return false;
        }
        if (fk_idrol === null || fk_idrol === '') {
            Swal.fire('Error', 'Seleccione un cargo.', 'error');
            return false;
        }
        return true;
    }

    // Evento para crear usuario con validaciones y manejo de DNI duplicado
    $('#formCrearUsuario').submit(function(e) {
        e.preventDefault();
        if (validarFormularioCrear()) {
            var datos = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '/SistemaWebHotel/app/controladores/UsuarioControlador.php',
                data: datos + '&accion=crear',
                success: function(response) {
                    response = response.trim();
                    if(response === 'exito') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Usuario creado correctamente.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            $('#modalCrearUsuario').modal('hide');
                            location.reload();
                        });
                    } else if(response === 'dni_duplicado') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'DNI Duplicado',
                            text: 'El DNI ingresado ya está registrado.',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al crear usuario.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error en la solicitud.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });

    // Función para validar el formulario de actualización de usuario
    function validarFormularioActualizar() {
        var nombres = $('#formActualizarUsuario input[name="nombres"]').val().trim();
        var apellidos = $('#formActualizarUsuario input[name="apellidos"]').val().trim();
        var direccion = $('#formActualizarUsuario input[name="direccion"]').val().trim();
        var celular = $('#formActualizarUsuario input[name="celular"]').val().trim();
        var correo = $('#formActualizarUsuario input[name="correo"]').val().trim();
        var usuario = $('#formActualizarUsuario input[name="usuario"]').val().trim();
        var password = $('#formActualizarUsuario input[name="password"]').val();
        var fk_idrol = $('#formActualizarUsuario select[name="fk_idrol"]').val();

        // Validaciones
        if (nombres === '') {
            Swal.fire('Error', 'Ingrese los nombres.', 'error');
            return false;
        }
        if (apellidos === '') {
            Swal.fire('Error', 'Ingrese los apellidos.', 'error');
            return false;
        }
        if (direccion === '') {
            Swal.fire('Error', 'Ingrese la dirección.', 'error');
            return false;
        }
        if (celular === '' || !/^\d{9}$/.test(celular)) {
            Swal.fire('Error', 'Ingrese un número de celular válido de 9 dígitos.', 'error');
            return false;
        }
        if (correo === '' || !/^\S+@\S+\.\S+$/.test(correo)) {
            Swal.fire('Error', 'Ingrese un correo electrónico válido.', 'error');
            return false;
        }
        if (usuario === '') {
            Swal.fire('Error', 'Ingrese un nombre de usuario.', 'error');
            return false;
        }
        if (password !== '' && password.length < 6) {
            Swal.fire('Error', 'La nueva contraseña debe tener al menos 6 caracteres.', 'error');
            return false;
        }
        if (fk_idrol === null || fk_idrol === '') {
            Swal.fire('Error', 'Seleccione un cargo.', 'error');
            return false;
        }
        return true;
    }

    // Evento para actualizar usuario con validaciones
    $(document).on('submit', '#formActualizarUsuario', function(e) {
        e.preventDefault();
        if (validarFormularioActualizar()) {
            var datos = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '/SistemaWebHotel/app/controladores/UsuarioControlador.php',
                data: datos + '&accion=actualizar',
                success: function(response) {
                    response = response.trim();
                    if(response === 'exito') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Usuario actualizado correctamente.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            $('#modalActualizarUsuario').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al actualizar usuario.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al enviar los datos.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });

    // Evento para abrir modal de actualización
    $(document).on('click', '.editarUsuario', function(e) {
        e.preventDefault();
        var id_usuario = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '/SistemaWebHotel/app/controladores/UsuarioControlador.php',
            data: { id_usuario: id_usuario, accion: 'obtener' },
            success: function(response) {
                $('#modalActualizarUsuario .modal-content').html(response);
                $('#modalActualizarUsuario').modal('show');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar los datos del usuario.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });

    // Evento para cambiar estado del usuario
    $(document).on('click', '.cambiarEstado', function(e) {
        e.preventDefault();
        var id_usuario = $(this).data('id');
        var estado = $(this).data('estado');
        Swal.fire({
            title: '¿Está seguro?',
            text: '¿Desea cambiar el estado de este usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/SistemaWebHotel/app/controladores/UsuarioControlador.php',
                    data: { id_usuario: id_usuario, estado: estado, accion: 'cambiarEstado' },
                    success: function(response) {
                        response = response.trim();
                        if(response === 'exito') {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: 'Estado del usuario actualizado.',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al cambiar el estado.',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error en la solicitud.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>
