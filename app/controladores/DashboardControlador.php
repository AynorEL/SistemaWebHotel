<?php

class DashboardControlador {
    private $db;  // Variable para la conexión a la base de datos

    // Constructor para recibir la conexión de base de datos
    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // Método para obtener el número de habitaciones ocupadas
    public function obtenerHabitacionesOcupadas() {
        $sql = "SELECT COUNT(*) as ocupadas FROM habitaciones WHERE fk_id_estado_habitacion = 3";
        $result = $this->db->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['ocupadas'];
        }
        return 0;
    }

    // Método para obtener los ingresos del día
    public function obtenerIngresosHoy() {
        $sql = "SELECT SUM(monto) as ingresos FROM detalle_pago WHERE DATE(fecha_pago) = CURDATE()";
        $result = $this->db->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['ingresos'] ?? 0;
        }
        return 0;
    }

    // Método para obtener las reservas pendientes
    public function obtenerReservasPendientes() {
        $sql = "SELECT COUNT(*) as pendientes FROM reservas WHERE fecha_salida >= CURDATE()";
        $result = $this->db->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['pendientes'];
        }
        return 0;
    }
}
?>
