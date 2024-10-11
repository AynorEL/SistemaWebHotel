$(document).ready(function () {

    // Función para mostrar alerta de éxito
    function mostrarAlertaExito(mensaje) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: mensaje,
            timer: 3000,
            showConfirmButton: false
        });
    }

    // Función para mostrar alerta de error
    function mostrarAlertaError(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje,
            timer: 3000,
            showConfirmButton: false
        });
    }

    // Función para validar formularios antes de enviar
    function validarFormulario(formulario) {
        var camposValidos = true;
        var mensajeError = '';

        $(formulario).find('input, textarea, select').each(function () {
            var valor = $(this).val().trim();
            var nombreCampo = $(this).attr('name');

            if (valor === '') {
                mensajeError = 'El campo ' + nombreCampo + ' es obligatorio.';
                camposValidos = false;
                return false;
            }

            if ($(this).attr('type') === 'number') {
                if (isNaN(valor) || valor <= 0) {
                    mensajeError = 'El campo ' + nombreCampo + ' debe ser un número mayor a cero.';
                    camposValidos = false;
                    return false;
                }
            }

            if ($(this).attr('type') === 'text') {
                if (valor.length > 100) {
                    mensajeError = 'El campo ' + nombreCampo + ' no puede tener más de 100 caracteres.';
                    camposValidos = false;
                    return false;
                }
            }
        });

        if (!camposValidos) {
            mostrarAlertaError(mensajeError);
        }

        return camposValidos;
    }

    // Función para cargar habitaciones con filtros y paginación
    function cargarHabitaciones(pagina = 1, busqueda = '', tipo = '', estado = '') {
        $.ajax({
            url: '/SistemaWebHotel/app/controladores/HabitacionControlador.php',
            type: 'GET',
            data: {
                accion: 'listar',
                pagina: pagina,
                busqueda: busqueda,
                tipo: tipo,
                estado: estado
            },
            success: function (response) {
                let data = JSON.parse(response);
                $('#listaHabitaciones').html(data.html);
                $('#paginacionHabitaciones').html(data.paginacion);
            },
            error: function () {
                mostrarAlertaError('Error al cargar las habitaciones.');
            }
        });
    }

    // Función para recargar la tabla sin filtros ni búsqueda
    function recargarTablaHabitaciones() {
        cargarHabitaciones();
    }

    // Cargar la tabla al iniciar
    cargarHabitaciones();

    // Evento para la búsqueda
    $('#buscarHabitacion').on('input', function () {
        var busqueda = $(this).val();
        var tipo = $('#filtroTipo').val();
        var estado = $('#filtroEstado').val();
        cargarHabitaciones(1, busqueda, tipo, estado);
    });

    // Evento para filtrar por tipo
    $('#filtroTipo').on('change', function () {
        var tipo = $(this).val();
        var busqueda = $('#buscarHabitacion').val();
        var estado = $('#filtroEstado').val();
        cargarHabitaciones(1, busqueda, tipo, estado);
    });

    // Evento para filtrar por estado
    $('#filtroEstado').on('change', function () {
        var estado = $(this).val();
        var busqueda = $('#buscarHabitacion').val();
        var tipo = $('#filtroTipo').val();
        cargarHabitaciones(1, busqueda, tipo, estado);
    });

    // Evento de paginación
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        var pagina = $(this).data('pagina');
        var busqueda = $('#buscarHabitacion').val();
        var tipo = $('#filtroTipo').val();
        var estado = $('#filtroEstado').val();
        cargarHabitaciones(pagina, busqueda, tipo, estado);
    });

    // Evento para crear habitación
    $('#formCrearHabitacion').submit(function (e) {
        e.preventDefault();
        if (!validarFormulario(this)) return;

        var datos = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/SistemaWebHotel/app/controladores/HabitacionControlador.php',
            data: datos + '&accion=crear',
            success: function (response) {
                if (response.trim() === 'exito') {
                    mostrarAlertaExito('Habitación creada correctamente.');
                    $('#modalCrearHabitacion').modal('hide');
                    recargarTablaHabitaciones(); // Recargar solo la tabla
                } else if (response.trim() === 'error_duplicado') {
                    mostrarAlertaError('Error: El número de habitación ya existe.'); // Mensaje de error para duplicados
                } else {
                    mostrarAlertaError('Error al crear la habitación.');
                }
            },
            error: function () {
                mostrarAlertaError('Error en la solicitud.');
            }
        });
    });

    // Evento para abrir el modal de actualización y cargar datos de habitación
    $(document).on('click', '.editarHabitacion', function (e) {
        e.preventDefault();
        var id_habitacion = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: '/SistemaWebHotel/app/controladores/HabitacionControlador.php',
            data: { id_habitacion: id_habitacion, accion: 'obtener' },
            success: function (response) {
                $('#modalActualizarHabitacion .modal-content').html(response);
                $('#modalActualizarHabitacion').modal('show');
            },
            error: function () {
                mostrarAlertaError('Error al cargar los datos de la habitación.');
            }
        });
    });

    // Evento para actualizar habitación
    $(document).on('submit', '#formActualizarHabitacion', function (e) {
        e.preventDefault();
        if (!validarFormulario(this)) return;

        var datos = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/SistemaWebHotel/app/controladores/HabitacionControlador.php',
            data: datos + '&accion=actualizar',
            success: function (response) {
                if (response.trim() === 'exito') {
                    mostrarAlertaExito('Habitación actualizada correctamente.');
                    $('#modalActualizarHabitacion').modal('hide');
                    recargarTablaHabitaciones(); // Recargar solo la tabla
                } else if (response.trim() === 'error_duplicado') {
                    mostrarAlertaError('Error: El número de habitación ya existe.'); // Mensaje de error para duplicados
                } else {
                    mostrarAlertaError('Error al actualizar la habitación.');
                }
            },
            error: function () {
                mostrarAlertaError('Error en la solicitud.');
            }
        });
    });

    // Evento para eliminar habitación
    $(document).on('click', '.eliminarHabitacion', function (e) {
        e.preventDefault();
        var id_habitacion = $(this).data('id');

        Swal.fire({
            title: '¿Está seguro?',
            text: '¿Desea eliminar esta habitación de forma permanente?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/SistemaWebHotel/app/controladores/HabitacionControlador.php',
                    data: { id_habitacion: id_habitacion, accion: 'eliminar' },
                    success: function (response) {
                        if (response.trim() === 'exito') {
                            mostrarAlertaExito('Habitación eliminada correctamente.');
                            recargarTablaHabitaciones(); // Recargar solo la tabla
                        } else {
                            mostrarAlertaError('No se pudo eliminar la habitación.');
                        }
                    },
                    error: function (xhr) {
                        mostrarAlertaError('Error en la solicitud. ' + xhr.responseText);
                    }
                });
            }
        });
    });
});
