php
<?php
require __DIR__ . '/../../configuracion/base_datos.php';

class ReservaControlador {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todas las reservas junto con sus relaciones (clientes, usuarios, habitaciones, etc.)
    public function obtenerReservas() {
        $sql = "SELECT 
                    reservas.id_reserva,
                    clientes.id_cliente,
                    clientes.fk_dni,
                    usuarios.id_usuario,
                    usuarios.usuario,
                    usuarios.password,
                    habitaciones.id_habitacion,
                    habitaciones.numero_habitacion,
                    tipo_habitacion.nom_tipo,
                    estado_habitacion.nombre_estado,
                    reservas.precio,
                    reservas.fecha_inicio,
                    reservas.fecha_salida,
                    detalle_pago.fecha_pago,
                    tipos_pago.nombre_tipo
                FROM reservas
                INNER JOIN clientes ON reservas.fk_id_cliente = clientes.id_cliente
                INNER JOIN usuarios ON reservas.fk_id_usuario = usuarios.id_usuario
                INNER JOIN habitaciones ON reservas.fk_id_habitacion = habitaciones.id_habitacion
                INNER JOIN tipo_habitacion ON habitaciones.fk_id_tipo = tipo_habitacion.id_tipo
                INNER JOIN estado_habitacion ON habitaciones.fk_id_estado_habitacion = estado_habitacion.id_estado_habitacion
                INNER JOIN detalle_pago ON reservas.id_reserva = detalle_pago.fk_id_reserva
                INNER JOIN tipos_pago ON detalle_pago.fk_id_tipo_pago = tipos_pago.id_tipo_pago;";
                
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Crear una nueva reserva
    public function crearReserva($id_cliente, $id_usuario, $id_habitacion, $precio, $fecha_inicio, $fecha_salida) {
        $sql = "INSERT INTO reservas (fk_id_cliente, fk_id_usuario, fk_id_habitacion, precio, fecha_inicio, fecha_salida) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_cliente, $id_usuario, $id_habitacion, $precio, $fecha_inicio, $fecha_salida]);
    }

    // Eliminar una reserva
    public function eliminarReserva($id_reserva) {
        $sql = "DELETE FROM reservas WHERE id_reserva = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_reserva]);
    }

    // Editar una reserva (actualizar datos)
    public function editarReserva($id_reserva, $id_cliente, $id_usuario, $id_habitacion, $precio, $fecha_inicio, $fecha_salida) {
        $sql = "UPDATE reservas 
                SET fk_id_cliente = ?, fk_id_usuario = ?, fk_id_habitacion = ?, precio = ?, fecha_inicio = ?, fecha_salida = ?
                WHERE id_reserva = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_cliente, $id_usuario, $id_habitacion, $precio, $fecha_inicio, $fecha_salida, $id_reserva]);
    }
}

