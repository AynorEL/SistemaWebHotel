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
    <title>Dashboard - Sistema Hotelero</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        
        /* Sidebar */
        .sidebar {
            background-color: #007bff;
            color: white;
            border-radius: 20px;
            height: 100vh;
            position: fixed;
            margin: 4px;
            top: 0;
            left: 0;
            width: 180px; /* Sidebar más estrecho */
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar h2 {
            font-size: 1.2em; /* Tamaño de texto reducido */
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px; /* Espaciado más compacto */
            font-size: 1em; /* Texto más pequeño */
            margin-bottom: 10px;
            border-radius: 28px; /* Bordes redondeados */
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .sidebar a:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra elegante */
        }

        .sidebar i {
            margin-right: 10px;
        }

        /* Main content */
        .main-content {
            margin-left: 190px; /* Ajustar margen para acomodar el sidebar */
            padding: 20px;
        }

        .header {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo ligeramente opaco */
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header .user-info {
            display: flex;
            align-items: center;
        }

        .header .user-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        /* Tarjetas */
        .card {
            border-radius: 12px; /* Bordes más redondeados */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px); /* Sutil efecto de levantamiento */
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .card h5 {
            font-size: 1.1em;
            margin-bottom: 8px;
        }

        .card p {
            font-size: 1em;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Sistema Hotelero</h2>
    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="#habitacionesSubmenu" data-bs-toggle="collapse"><i class="fas fa-bed"></i> Habitaciones</a>
    <div id="habitacionesSubmenu" class="collapse">
        <a href="../habitaciones/listado.php" class="ps-4">Listado de Habitaciones</a>
        <a href="../habitaciones/nueva.php" class="ps-4">Añadir Habitación</a>
    </div>
    <a href="#reservasSubmenu" data-bs-toggle="collapse"><i class="fas fa-calendar-alt"></i> Reservas</a>
    <div id="reservasSubmenu" class="collapse">
        <a href="../reservas/listado.php" class="ps-4">Todas las Reservas</a>
        <a href="../reservas/nueva.php" class="ps-4">Crear Reserva</a>
    </div>
    <a href="#pagosSubmenu" data-bs-toggle="collapse"><i class="fas fa-money-check-alt"></i> Pagos</a>
    <div id="pagosSubmenu" class="collapse">
        <a href="../pagos/listado.php" class="ps-4">Listado de Pagos</a>
        <a href="../pagos/nuevo.php" class="ps-4">Añadir Pago</a>
    </div>
    <a href="#usuariosSubmenu" data-bs-toggle="collapse"><i class="fas fa-users"></i> Usuarios</a>
    <div id="usuariosSubmenu" class="collapse">
        <a href="../usuarios/listado.php" class="ps-4">Usuarios</a>
        <a href="../usuarios/nuevo.php" class="ps-4">Añadir Usuario</a>
    </div>
    <a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
</div>

<!-- Main content -->
<div class="main-content">
    <!-- Header con información del usuario -->
    <div class="header">
        <h4>Bienvenido, <?php echo $_SESSION['usuario']; ?></h4>
        <div class="user-info">
            <img src="https://via.placeholder.com/50" alt="Usuario">
            <span><?php echo $_SESSION['usuario']; ?></span> <!-- Mostrar el nombre real del usuario -->
        </div>
    </div>

    <!-- Contenido dinámico -->
    <div class="container">
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
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
