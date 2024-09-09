<?php
require __DIR__ . '/../../configuracion/base_datos.php';

class UsuarioControlador {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Añadir nuevo usuario
    public function crearUsuario($usuario, $password, $fk_idrol, $fk_dni, $fk_id_estado) {
        $hashPassword = md5($password); // Cambia a MD5 si prefieres
        $sql = "INSERT INTO usuarios (usuario, password, fk_idrol, fk_dni, fk_id_estado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        // Enlazar los parámetros y ejecutar
        $stmt->bind_param("ssisi", $usuario, $hashPassword, $fk_idrol, $fk_dni, $fk_id_estado);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Obtener lista de personas para el combobox de DNI
    public function obtenerPersonas() {
        $sql = "SELECT dni, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM personas";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
