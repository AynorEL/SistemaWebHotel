<?php
require_once __DIR__ . '/../../configuracion/base_datos.php';

class UsuarioControlador {
    private $db;

    // Constructor para recibir la conexión a la base de datos
    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los usuarios activos con dirección
    public function obtenerUsuarios() {
        $sql = "SELECT u.id_usuario,concat_ws(' ',p.nombres,p.apellidos) as NOMBRES, p.dirección,
        p.correo,u.usuario,p.celular,r.cargo FROM usuarios u 
INNER JOIN personas p ON u.fk_dni=p.dni
INNER JOIN roles r ON u.fk_idrol=r.id_rol
WHERE u.fk_id_estado=1";  // Solo usuarios activos
        $result = $this->db->query($sql);

        if (!$result) {
            throw new Exception("Error al obtener usuarios activos: " . $this->db->error);
        }

        // Devolver los resultados como un array asociativo
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Crear nuevo usuario
    public function crearUsuario($usuario, $password, $fk_idrol, $fk_dni, $fk_id_estado) {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT); // Encriptamos la contraseña

        $sql = "INSERT INTO usuarios (usuario, password, fk_idrol, fk_dni, fk_id_estado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->db->error);
        }

        $stmt->bind_param("ssisi", $usuario, $hashPassword, $fk_idrol, $fk_dni, $fk_id_estado);

        if (!$stmt->execute()) {
            throw new Exception("Error al crear usuario: " . $stmt->error);
        }

        return true;
    }

    // Obtener usuario por ID para editar
    public function obtenerUsuarioPorId($id_usuario) {
        $sql = "SELECT 
                    u.id_usuario, 
                    u.usuario, 
                    p.dni, 
                    CONCAT_WS(' ', p.nombres, p.apellidos) AS NOMBRES, 
                    p.dirección, 
                    p.celular, 
                    p.correo, 
                    r.cargo, 
                    u.fk_id_estado AS estado
                FROM usuarios u
                INNER JOIN personas p ON u.fk_dni = p.dni
                INNER JOIN roles r ON u.fk_idrol = r.id_rol
                WHERE u.id_usuario = ?";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->db->error);
        }

        $stmt->bind_param("i", $id_usuario);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener usuario: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Error al obtener resultado: " . $stmt->error);
        }

        return $result->fetch_assoc(); // Devolver el resultado como un array asociativo
    }

    // Actualizar usuario
    public function actualizarUsuario($id_usuario, $usuario, $fk_idrol, $fk_dni, $fk_id_estado) {
        $sql = "UPDATE usuarios SET usuario = ?, fk_idrol = ?, fk_dni = ?, fk_id_estado = ? WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->db->error);
        }

        $stmt->bind_param("sisii", $usuario, $fk_idrol, $fk_dni, $fk_id_estado, $id_usuario);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar usuario: " . $stmt->error);
        }

        return true;
    }

    // Cambiar estado del usuario (activar o desactivar)
    public function cambiarEstadoUsuario($id_usuario, $nuevo_estado) {
        $sql = "UPDATE usuarios SET fk_id_estado = ? WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->db->error);
        }

        $stmt->bind_param("ii", $nuevo_estado, $id_usuario);

        if (!$stmt->execute()) {
            throw new Exception("Error al cambiar el estado del usuario: " . $stmt->error);
        }

        return true;
    }

    // Obtener lista de personas para el combobox de DNI
    public function obtenerPersonas() {
        $sql = "SELECT dni, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM personas";
        $result = $this->db->query($sql);

        if (!$result) {
            throw new Exception("Error al obtener personas: " . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
