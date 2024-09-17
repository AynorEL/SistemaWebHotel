$(document).ready(function() {
    // Inicializar DataTables
    var tablaUsuarios = $('#tablaUsuarios').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "pageLength": 5,
        "deferRender": true,
        "order": [[0, "asc"]],
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

    // Función para crear el usuario usando AJAX sin recargar la página
    $('#crearUsuarioBtn').click(function(e) {
        e.preventDefault();
        var formData = $('#formAgregarUsuario').serialize(); 

        $.ajax({
            url: 'http://localhost/SistemaWebHotel/app/vistas/usuarios/crear.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Usuario Creado',
                        text: 'El usuario ha sido creado exitosamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        $('#modalAgregarUsuario').modal('hide');
                        // Añadir la nueva fila a la tabla sin recargar la página
                        tablaUsuarios.row.add([
                            response.data.id_usuario,
                            response.data.nombre_completo,
                            response.data.usuario,
                            response.data.rol,
                            response.data.dni,
                            response.data.direccion,
                            response.data.celular,
                            `<a href="javascript:void(0);" class="btn btn-warning btn-sm editarUsuario" data-id="${response.data.id_usuario}"><i class="fas fa-edit"></i> Editar</a>
                             <a href="javascript:void(0);" class="btn btn-secondary btn-sm cambiarEstadoUsuario" data-id="${response.data.id_usuario}" data-estado="1"><i class="fas fa-eye-slash"></i> Cambiar Estado</a>`
                        ]).draw(false);
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Hubo un problema al crear el usuario.', 'error');
            }
        });
    });

    // Función para abrir el modal de edición y cargar los datos del usuario
    $(document).on('click', '.editarUsuario', function() {
        var idUsuario = $(this).data('id');
        if (!idUsuario) {
            Swal.fire('Error', 'No se pudo obtener el ID del usuario.', 'error');
            return;
        }

        $.ajax({
            url: 'http://localhost/SistemaWebHotel/app/vistas/usuarios/editar.php',
            type: 'GET',
            data: { id_usuario: idUsuario },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var usuario = response.data;
                    $('#editarIdUsuario').val(usuario['ID Usuario']);
                    $('#editarNombreUsuario').val(usuario.Usuario);
                    $('#editarRolUsuario').val(usuario.Rol);
                    $('#editarDniUsuario').val(usuario.DNI);
                    $('#editarEstadoUsuario').val(usuario.Estado);
                    $('#modalEditarUsuario').modal('show'); // Mostrar modal de edición
                } else {
                    Swal.fire('Error', 'No se pudo cargar el usuario.', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Hubo un problema al obtener el usuario.', 'error');
            }
        });
    });

    // Función para cambiar el estado del usuario sin recargar la página
    $(document).on('click', '.cambiarEstadoUsuario', function() {
        var idUsuario = $(this).data('id');
        var nuevoEstado = $(this).data('estado') == 1 ? 2 : 1;

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Estás a punto de cambiar el estado del usuario.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cambiar estado',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'http://localhost/SistemaWebHotel/app/vistas/usuarios/cambiar_estado.php',
                    type: 'POST',
                    data: { id_usuario: idUsuario, nuevo_estado: nuevoEstado },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Estado cambiado', 'El estado del usuario ha sido actualizado.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'No se pudo cambiar el estado.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Error al cambiar el estado.', 'error');
                    }
                });
            }
        });
    });
});
