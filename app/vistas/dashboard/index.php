<?php
// Incluir middleware de autenticación
require __DIR__ . '/../../middlewares/autenticacionMiddleware.php';
// Incluir la barra lateral
require __DIR__ . '/../../parciales/barra_lateral.php';
// Incluir la conexión a la base de datos
 require '../configuracion/base_datos.php';


// Obtener el número de habitaciones ocupadas
$sqlHabitacionesOcupadas = "SELECT COUNT(*) as ocupadas FROM habitaciones WHERE fk_id_estado_habitacion = 3";
$resultHabitacionesOcupadas = $conn->query($sqlHabitacionesOcupadas);
$habitacionesOcupadas = $resultHabitacionesOcupadas->fetch_assoc()['ocupadas'];

// Obtener los ingresos del día
$sqlIngresosHoy = "SELECT SUM(monto) as ingresos FROM detalle_pago WHERE DATE(fecha_pago) = CURDATE()";
$resultIngresosHoy = $conn->query($sqlIngresosHoy);
$ingresosHoy = $resultIngresosHoy->fetch_assoc()['ingresos'] ?? 0;

// Obtener el número de reservas pendientes
$sqlReservasPendientes = "SELECT COUNT(*) as pendientes FROM reservas WHERE fecha_salida >= CURDATE()";
$resultReservasPendientes = $conn->query($sqlReservasPendientes);
$reservasPendientes = $resultReservasPendientes->fetch_assoc()['pendientes'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Hotelero - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Referencia al archivo CSS del dashboard -->
    <link href="/SistemaWebHotel/app/vistas/dashboard/styles.css" rel="stylesheet">
    <!-- jQuery para manejar AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="header">
        <h4>Bienvenido, <?php echo $_SESSION['usuario']; ?></h4>
        <div class="user-info">
            <img src="https://via.placeholder.com/50" alt="Usuario">
            <span><?php echo $_SESSION['usuario']; ?></span> <!-- Mostrar el nombre real del usuario -->
        </div>
    </div>
<!-- Sidebar (Solo uno) -->
<?php require __DIR__ . '/../../parciales/barra_lateral.php'; ?>


<!-- Contenedor dinámico -->
<div id="content" class="main-content">
    <!-- Aquí se cargará el contenido dinámico (por defecto muestra el dashboard) -->
    <h1>Bienvenido al Dashboard</h1>
    <p>Tu última sesión fue hace 21 horas desde Perú.</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Habitaciones Ocupadas</h5>
                    <p class="card-text">3</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Ingresos Hoy</h5>
                    <p class="card-text">S/ 0.00</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Reservas Pendientes</h5>
                    <p class="card-text">0</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar AJAX -->
<script>
    // Función para cargar contenido dinámicamente
    function loadContent(page) {
        $.ajax({
            url: page,
            type: 'GET',
            success: function(response) {
                $('#content').html(response);  // Reemplaza el contenido del contenedor
            },
            error: function() {
                alert('Error al cargar el contenido.');
            }
        });
    }

    // Capturar clics en los enlaces con clase .ajax-link
    $(document).on('click', '.ajax-link', function(event) {
        event.preventDefault();  // Evitar que el enlace haga la navegación predeterminada
        var page = $(this).attr('href');  // Obtener la URL del enlace
        loadContent(page);  // Cargar el contenido de la URL en el contenedor #content
    });
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>