<?php
require_once __DIR__ . '/../../configuracion/base_datos.php';

class HabitacionControlador {
    private $conexion;

    public function __construct() {
        global $conn;
        $this->conexion = $conn;
    }

    // Función para listar habitaciones con búsqueda, filtro por tipo y estado, y paginación
    public function listarHabitaciones($busqueda = '', $tipo = '', $estado = '', $pagina = 1, $limite = 5) {
        $offset = ($pagina - 1) * $limite;
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
                WHERE 1=1";

        // Filtrar por búsqueda, tipo y estado
        if (!empty($busqueda)) {
            $sql .= " AND (h.numero_habitacion LIKE '%$busqueda%' OR h.descripcion LIKE '%$busqueda%')";
        }
        if (!empty($tipo)) {
            $sql .= " AND h.fk_id_tipo = $tipo";
        }
        if (!empty($estado)) {
            $sql .= " AND h.fk_id_estado_habitacion = $estado";
        }

        $sql .= " LIMIT $limite OFFSET $offset";
        $result = $this->conexion->query($sql);

        return $result;
    }

    // Función para contar habitaciones (para la paginación)
    public function contarHabitaciones($busqueda = '', $tipo = '', $estado = '') {
        $sql = "SELECT COUNT(*) as total
                FROM 
                    habitaciones h
                JOIN 
                    tipo_habitacion t ON h.fk_id_tipo = t.id_tipo
                JOIN 
                    estado_habitacion e ON h.fk_id_estado_habitacion = e.id_estado_habitacion
                WHERE 1=1";

        if (!empty($busqueda)) {
            $sql .= " AND (h.numero_habitacion LIKE '%$busqueda%' OR h.descripcion LIKE '%$busqueda%')";
        }
        if (!empty($tipo)) {
            $sql .= " AND h.fk_id_tipo = $tipo";
        }
        if (!empty($estado)) {
            $sql .= " AND h.fk_id_estado_habitacion = $estado";
        }

        $result = $this->conexion->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Verificar si el número de habitación ya existe
    public function verificarNumeroHabitacion($numero, $id_habitacion = null) {
        $sql = "SELECT COUNT(*) as total FROM habitaciones WHERE numero_habitacion = ?";
        
        // Si es una actualización, excluye la habitación actual
        if ($id_habitacion) {
            $sql .= " AND id_habitacion != ?";
        }

        $stmt = $this->conexion->prepare($sql);

        if ($id_habitacion) {
            $stmt->bind_param("ii", $numero, $id_habitacion);
        } else {
            $stmt->bind_param("i", $numero);
        }

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;  // Devuelve true si ya existe
    }

    // Crear nueva habitación con validación de duplicados
    public function crearHabitacion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numero = $_POST['numero'];
            $descripcion = $_POST['descripcion'];
            $fk_tipo = $_POST['fk_tipo'];
            $fk_estado = $_POST['fk_estado'];

            if (empty($numero) || empty($descripcion) || empty($fk_tipo) || empty($fk_estado)) {
                echo 'error'; // Error por campos vacíos
                return;
            }

            // Verificar si el número de habitación ya existe
            if ($this->verificarNumeroHabitacion($numero)) {
                echo 'error_duplicado'; // Error por número duplicado
                return;
            }

            $stmtHabitacion = $this->conexion->prepare("INSERT INTO habitaciones (numero_habitacion, descripcion, fk_id_tipo, fk_id_estado_habitacion) VALUES (?, ?, ?, ?)");
            $stmtHabitacion->bind_param("isii", $numero, $descripcion, $fk_tipo, $fk_estado);

            if ($stmtHabitacion->execute()) {
                echo 'exito';
            } else {
                echo 'error';
            }
        }
    }

    // Actualizar habitación con validación de duplicados
    public function actualizarHabitacion($id_habitacion) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numero = $_POST['numero'];
            $descripcion = $_POST['descripcion'];
            $fk_tipo = $_POST['fk_tipo'];
            $fk_estado = $_POST['fk_estado'];

            if (empty($numero) || empty($descripcion) || empty($fk_tipo) || empty($fk_estado)) {
                echo 'error'; // Error por campos vacíos
                return;
            }

            // Verificar si el número de habitación ya existe, excluyendo la habitación actual
            if ($this->verificarNumeroHabitacion($numero, $id_habitacion)) {
                echo 'error_duplicado'; // Error por número duplicado
                return;
            }

            $stmtHabitacion = $this->conexion->prepare("
                UPDATE habitaciones 
                SET numero_habitacion = ?, descripcion = ?, fk_id_tipo = ?, fk_id_estado_habitacion = ? 
                WHERE id_habitacion = ?
            ");
            $stmtHabitacion->bind_param("isiii", $numero, $descripcion, $fk_tipo, $fk_estado, $id_habitacion);

            if ($stmtHabitacion->execute()) {
                echo 'exito';
            } else {
                echo 'error';
            }
        }
    }

    // Obtener datos de una habitación específica y cargar la vista de actualización
    public function obtenerHabitacionPorId($id_habitacion) {
        $habitacion = $this->obtenerHabitacion($id_habitacion);
        
        // Verificar si se obtuvieron los datos de la habitación
        if ($habitacion) {
            // Incluir la vista de actualización y pasar los datos de la habitación
            $tipos_habitacion = $this->obtenerTiposHabitacion();
            $estados_habitacion = $this->obtenerEstadosHabitacion();
            include '../vistas/habitaciones/actualizar.php';  // Incluir la vista
        } else {
            echo "Error: No se encontró la habitación.";
        }
    }

    // Obtener habitación por ID (método interno)
    private function obtenerHabitacion($id_habitacion) {
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

    // Eliminar habitación
    public function eliminarHabitacion($id_habitacion) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $stmt = $this->conexion->prepare("DELETE FROM habitaciones WHERE id_habitacion = ?");
            $stmt->bind_param("i", $id_habitacion);

            if ($stmt->execute()) {
                echo 'exito';
            } else {
                echo 'error';
            }
        }
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

    if ($_POST['accion'] == 'crear') {
        $controlador->crearHabitacion();
    }

    if ($_POST['accion'] == 'actualizar') {
        $id_habitacion = $_POST['id_habitacion'];
        $controlador->actualizarHabitacion($id_habitacion);
    }

    if ($_POST['accion'] == 'eliminar') {
        $id_habitacion = $_POST['id_habitacion'];
        $controlador->eliminarHabitacion($id_habitacion);
    }
}

// Manejo de la acción para listar habitaciones y obtener una para actualizar
if (isset($_GET['accion'])) {
    $controlador = new HabitacionControlador();

    if ($_GET['accion'] == 'listar') {
        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
        $estado = isset($_GET['estado']) ? $_GET['estado'] : '';

        $habitaciones = $controlador->listarHabitaciones($busqueda, $tipo, $estado, $pagina);
        $totalHabitaciones = $controlador->contarHabitaciones($busqueda, $tipo, $estado);
        $totalPaginas = ceil($totalHabitaciones / 5); // Paginación de 5 elementos por página

        $html = '';
        while ($habitacion = $habitaciones->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $habitacion['id_habitacion'] . '</td>';
            $html .= '<td>' . $habitacion['numero_habitacion'] . '</td>';
            $html .= '<td>' . $habitacion['descripcion'] . '</td>';
            $html .= '<td>' . $habitacion['tipo_habitacion'] . '</td>';
            $html .= '<td>' . $habitacion['estado_habitacion'] . '</td>';
            $html .= '<td>';
            $html .= '<a href="#" class="btn btn-sm btn-warning editarHabitacion" data-id="' . $habitacion['id_habitacion'] . '">';
            $html .= '<i class="fa fa-edit"></i></a>';
            $html .= '<a href="#" class="btn btn-sm btn-danger eliminarHabitacion" data-id="' . $habitacion['id_habitacion'] . '">';
            $html .= '<i class="fa fa-trash"></i></a>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        // Enviar respuesta con HTML y paginación
        echo json_encode([
            'html' => $html,
            'paginacion' => generarPaginacion($pagina, $totalPaginas)
        ]);
    }

    if ($_GET['accion'] == 'obtener') {
        $id_habitacion = $_GET['id_habitacion'];
        $controlador->obtenerHabitacionPorId($id_habitacion);
    }
}

// Función para generar los enlaces de paginación
function generarPaginacion($paginaActual, $totalPaginas) {
    $html = '<nav><ul class="pagination justify-content-center">';
    for ($i = 1; $i <= $totalPaginas; $i++) {
        $activeClass = $i == $paginaActual ? 'active' : '';
        $html .= '<li class="page-item ' . $activeClass . '">';
        $html .= '<a class="page-link" href="#" data-pagina="' . $i . '">' . $i . '</a>';
        $html .= '</li>';
    }
    $html .= '</ul></nav>';
    return $html;
}
