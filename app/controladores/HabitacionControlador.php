<?php
require_once __DIR__ . '/../../configuracion/base_datos.php';

class HabitacionControlador {
    private $conexion;

    public function __construct() {
        global $conn;
        $this->conexion = $conn;
    }

    // Listar habitaciones con tipo y estado
    public function listarHabitaciones() {
        $sql = "SELECT 
                    h.id_habitacion, 
                    h.numero_habitacion, 
                    h.descripcion, 
                    t.nom_tipo AS tipo_habitacion, 
                    e.nombre_estado AS estado_habitacion
                FROM 
                    habitaciones h
                JOIN 
                    tipo_habitacion t ON h.fk_id_tipo = t.id_tipo
                JOIN 
                    estado_habitacion e ON h.fk_id_estado_habitacion = e.id_estado_habitacion
                WHERE e.nombre_estado != 'Inactivo'"; 
        $result = $this->conexion->query($sql);
        return $result;
    }

    // Crear nueva habitación con tipo y estado
    public function crearHabitacion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numero = $_POST['numero'];
            $descripcion = $_POST['descripcion'];
            $fk_tipo = $_POST['fk_tipo'];
            $fk_estado = $_POST['fk_estado'];

            $stmtHabitacion = $this->conexion->prepare("INSERT INTO habitaciones (numero_habitacion, descripcion, fk_id_tipo, fk_id_estado_habitacion) VALUES (?, ?, ?, ?)");
            $stmtHabitacion->bind_param("isii", $numero, $descripcion, $fk_tipo, $fk_estado);

            if ($stmtHabitacion->execute()) {
                echo 'exito';
            } else {
                echo 'error';
            }
        }
    }

    // Obtener datos de una habitación específica
    public function obtenerHabitacionPorId($id_habitacion) {
        $sql = "SELECT 
                    h.id_habitacion, 
                    h.numero_habitacion, 
                    h.descripcion, 
                    h.fk_id_tipo, 
                    h.fk_id_estado_habitacion 
                FROM habitaciones h
                WHERE h.id_habitacion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_habitacion);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Obtener tipos de habitación para los select
    public function obtenerTiposHabitacion() {
        $sql = "SELECT id_tipo, nom_tipo FROM tipo_habitacion";
        return $this->conexion->query($sql);
    }

    // Obtener estados de habitación para los select
    public function obtenerEstadosHabitacion() {
        $sql = "SELECT id_estado_habitacion, nombre_estado FROM estado_habitacion";
        return $this->conexion->query($sql);
    }
}

// Manejo de las acciones de los formularios
if (isset($_POST['accion'])) {
    $controlador = new HabitacionControlador();

    // Acción para crear habitación
    if ($_POST['accion'] == 'crear') {
        $controlador->crearHabitacion();
    }
}

// Manejo de la acción para obtener los datos de la habitación
if (isset($_GET['accion']) && $_GET['accion'] == 'obtener') {
    $id_habitacion = $_GET['id_habitacion'];
    $controlador = new HabitacionControlador();
    $habitacion = $controlador->obtenerHabitacionPorId($id_habitacion);
    $tipos_habitacion = $controlador->obtenerTiposHabitacion();
    $estados_habitacion = $controlador->obtenerEstadosHabitacion();

    // Incluir el archivo de actualización desde la ruta correcta
    include '../vistas/habitaciones/actualizar.php';
}
?>
