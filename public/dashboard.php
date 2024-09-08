<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no ha iniciado sesión, redirigir al login
    header('Location: login.php');
    exit();
}

// Incluir el archivo de configuración de base de datos y el controlador necesario
require '../configuracion/base_datos.php';
require '../app/controladores/DashboardControlador.php';

// Instanciar el controlador del dashboard para obtener los datos
$dashboardControlador = new DashboardControlador($conn);

// Obtener los datos que necesitas mostrar en el dashboard
$habitacionesOcupadas = $dashboardControlador->obtenerHabitacionesOcupadas();
$ingresosHoy = $dashboardControlador->obtenerIngresosHoy();
$reservasPendientes = $dashboardControlador->obtenerReservasPendientes();

// Incluir la vista del dashboard desde app/vistas/dashboard/index.php
require '../app/vistas/dashboard/index.php';
