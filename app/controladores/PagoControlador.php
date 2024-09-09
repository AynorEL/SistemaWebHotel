<?php
require __DIR__ . '/../../configuracion/base_datos.php';

class PagoControlador {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los pagos
    public function obtenerPagos() {
        $sql = "SELECT * FROM detalle_pago";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Aquí puedes añadir otros métodos para crear, editar o eliminar pagos si lo necesitas
}
?>
