$(document).ready(function() {
    // Evento para crear usuario
    $('#formCrearUsuario').submit(function(e) {
        e.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '../../app/controladores/UsuarioControlador.php',
            data: datos + '&accion=crear',
            success: function(response) {
                if(response.trim() == 'exito') {
                    alert('Usuario creado correctamente');
                    $('#modalCrearUsuario').modal('hide');
                    location.reload();
                } else {
                    alert('Error al crear usuario');
                }
            }
        });
    });

    // Evento para abrir modal de actualización
    $('.editarUsuario').click(function(e) {
        e.preventDefault();
        var id_usuario = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '../../controladores/UsuarioControlador.php',
            data: { id_usuario: id_usuario, accion: 'obtener' },
            success: function(response) {
                $('#modalActualizarUsuario .modal-body').html(response);
                $('#modalActualizarUsuario').modal('show');
            },
            error: function() {
                alert('Error al cargar los datos del usuario.');
            }
        });
    });

    // Evento para actualizar usuario
    $(document).on('submit', '#formActualizarUsuario', function(e) {
        e.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '../../controladores/UsuarioControlador.php',
            data: datos + '&accion=actualizar',
            success: function(response) {
                if(response.trim() == 'exito') {
                    alert('Usuario actualizado correctamente');
                    location.reload();
                } else {
                    alert('Error al actualizar usuario');
                }
            },
            error: function() {
                alert('Error al enviar los datos.');
            }
        });
    });

    // Evento para cambiar estado del usuario
    $('.cambiarEstado').click(function() {
        var id_usuario = $(this).data('id');
        var estado = $(this).data('estado');
        if(confirm('¿Está seguro de cambiar el estado de este usuario?')) {
            $.ajax({
                type: 'POST',
                url: '../../controladores/UsuarioControlador.php',
                data: { id_usuario: id_usuario, estado: estado, accion: 'cambiarEstado' },
                success: function(response) {
                    if(response.trim() == 'exito') {
                        alert('Estado del usuario actualizado');
                        location.reload();
                    } else {
                        alert('Error al cambiar el estado');
                    }
                }
            });
        }
    });
});
