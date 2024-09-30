<?php

class DashboardControlador {
    private $db;  // Variable para la conexión a la base de datos

    // Constructor para recibir la conexión de base de datos
    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // Método para obtener el número de habitaciones ocupadas
    public function obtenerHabitacionesOcupadas() {
        $sql = "SELECT COUNT(*) AS ocupadas FROM habitaciones WHERE fk_id_estado_habitacion = 2"; // Cambiado a 'Ocupada' (suponiendo que 2 es el estado ocupado)
        $result = $this->db->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['ocupadas'] ?? 0; // Devuelve 0 si no hay resultados
        }
        return 0;
    }

    // Método para obtener los ingresos del día
    public function obtenerIngresosHoy() {
        $sql = "SELECT SUM(monto) AS ingresos FROM detalle_pago WHERE DATE(fecha_pago) = CURDATE()";
        $result = $this->db->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['ingresos'] ?? 0; // Devuelve 0 si no hay ingresos
        }
        return 0;
    }

    // Método para obtener las reservas pendientes
    public function obtenerReservasPendientes() {
        $sql = "SELECT COUNT(*) AS pendientes FROM reservas WHERE fecha_salida >= CURDATE() AND fk_id_estados_reserva = 1"; // Filtra por estado pendiente
        $result = $this->db->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['pendientes'] ?? 0; // Devuelve 0 si no hay reservas
        }
        return 0;
    }
}
?>
