<?php
require __DIR__ . '/../../configuracion/base_datos.php';

class UsuarioControlador {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los usuarios activos con dirección
    public function obtenerUsuarios() {
        $sql = "SELECT 
                    usuarios.id_usuario AS 'ID Usuario', 
                    CONCAT(personas.nombres, ' ', personas.apellidos) AS 'Nombre Completo', 
                    usuarios.usuario AS 'Usuario', 
                    personas.dni AS 'DNI', 
                    personas.dirección AS 'Dirección',  -- Corregido: Sin tilde
                    personas.celular AS 'Celular',  -- Añadimos el celular
                    roles.cargo AS 'Rol'
                FROM 
                    usuarios
                INNER JOIN 
                    personas ON usuarios.fk_dni = personas.dni
                INNER JOIN 
                    roles ON usuarios.fk_idrol = roles.id_rol
                WHERE 
                    usuarios.fk_id_estado = 1";  // Filtrando solo los usuarios activos
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Añadir nuevo usuario
    public function crearUsuario($usuario, $password, $fk_idrol, $fk_dni, $fk_id_estado) {
        $hashPassword = md5($password); // Encriptamos la contraseña con MD5
        $sql = "INSERT INTO usuarios (usuario, password, fk_idrol, fk_dni, fk_id_estado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        // Enlazar los parámetros y ejecutar la consulta
        $stmt->bind_param("ssisi", $usuario, $hashPassword, $fk_idrol, $fk_dni, $fk_id_estado);
        
        return $stmt->execute();  // Retornamos el resultado de la ejecución
    }

    // Obtener lista de personas para el combobox de DNI
    public function obtenerPersonas() {
        $sql = "SELECT dni, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM personas";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
