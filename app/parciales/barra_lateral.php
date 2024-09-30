<div class="sidebar bg-primary vh-100">
    <h2 class="text-white">Menu</h2>
    <a href="dashboard.php" class="text-white d-block py-2 ajax-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

    <!-- Submenú de Habitaciones -->
    <a href="#habitacionesSubmenu" data-bs-toggle="collapse" class="text-white d-block py-2">
        <i class="fas fa-bed"></i> Habitaciones
    </a>
    <div id="habitacionesSubmenu" class="collapse ps-3">
        <a href="/SistemaWebHotel/app/vistas/habitaciones/listado.php" class="text-white d-block py-2 ajax-link">Listado de Habitaciones</a>
        <a href="../habitaciones/nueva.php" class="text-white d-block py-2 ajax-link">Añadir Habitación</a>
    </div>

    <!-- Submenú de Reservas -->
    <a href="#reservasSubmenu" data-bs-toggle="collapse" class="text-white d-block py-2">
        <i class="fas fa-calendar-alt"></i> Reservas
    </a>
    <div id="reservasSubmenu" class="collapse ps-3">
        <a href="/SistemaWebHotel/app/vistas/reservas/listado.php" class="text-white d-block py-2 ajax-link">Todas las Reservas</a>
        <a href="../reservas/nueva.php" class="text-white d-block py-2 ajax-link">Crear Reserva</a>
    </div>

    <!-- Submenú de Pagos -->
    <a href="#pagosSubmenu" data-bs-toggle="collapse" class="text-white d-block py-2">
        <i class="fas fa-money-check-alt"></i> Pagos
    </a>
    <div id="pagosSubmenu" class="collapse ps-3">
        <a href="/SistemaWebHotel/app/vistas/pagos/index.php" class="text-white d-block py-2 ajax-link">Listado de Pagos</a>
        <a href="/SistemaWebHotel/app/vistas/pagos/crearpago.php" class="text-white d-block py-2 ajax-link">Añadir Pago</a>
    </div>

    <!-- Submenú de Usuarios -->
    <a href="#usuariosSubmenu" data-bs-toggle="collapse" class="text-white d-block py-2">
        <i class="fas fa-users"></i> Usuarios
    </a>
    <div id="usuariosSubmenu" class="collapse ps-3">
    <a href="/SistemaWebHotel/app/vistas/usuarios/index.php" class="text-white d-block py-2 ajax-link">Usuarios</a>
        <a href="../usuarios/nuevo.php" class="text-white d-block py-2 ajax-link">Añadir Usuario</a>
    </div>

    <!-- Opción de Cerrar Sesión -->
    <a href="../auth/logout.php" class="text-white d-block py-2 ajax-link">
        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
    </a>
</div>
