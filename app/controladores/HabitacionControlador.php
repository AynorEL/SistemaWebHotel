
<?php
require __DIR__ . '/../../configuracion/base_datos.php';



class HabitacionControlador {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todas las habitaciones junto con tipo y estado
    public function obtenerHabitaciones() {
        $sql = "SELECT habitaciones.*, tipo_habitacion.*, estado_habitacion.*
                FROM habitaciones
                JOIN tipo_habitacion ON habitaciones.fk_id_tipo = tipo_habitacion.id_tipo
                JOIN estado_habitacion ON habitaciones.fk_id_estado_habitacion = estado_habitacion.id_estado_habitacion;";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Añadir nueva habitación
    public function crearHabitacion($numero_habitacion, $descripcion, $fk_id_tipo, $fk_id_estado_habitacion) {
        $sql = "INSERT INTO habitaciones (numero_habitacion, descripcion, fk_id_tipo, fk_id_estado_habitacion) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$numero_habitacion, $descripcion, $fk_id_tipo, $fk_id_estado_habitacion]);
    }

    // Eliminar una habitación
    public function eliminarHabitacion($id_habitacion) {
        $sql = "DELETE FROM habitaciones WHERE id_habitacion = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_habitacion]);
    }

    // Editar una habitación (actualizar datos)
    public function editarHabitacion($id_habitacion, $numero_habitacion, $descripcion, $fk_id_tipo, $fk_id_estado_habitacion) {
        $sql = "UPDATE habitaciones 
                SET numero_habitacion = ?, descripcion = ?, fk_id_tipo = ?, fk_id_estado_habitacion = ? 
                WHERE id_habitacion = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$numero_habitacion, $descripcion, $fk_id_tipo, $fk_id_estado_habitacion, $id_habitacion]);
    }
}
