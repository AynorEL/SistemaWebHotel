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
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (usuario, password, fk_idrol, fk_dni, fk_id_estado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$usuario, $hashPassword, $fk_idrol, $fk_dni, $fk_id_estado]);
    }

    // Eliminar un usuario
    public function eliminarUsuario($id_usuario) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_usuario]);
    }

    // Editar un usuario (actualizar datos)
    public function editarUsuario($id_usuario, $usuario, $password, $fk_idrol, $fk_dni, $fk_id_estado) {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios SET usuario = ?, password = ?, fk_idrol = ?, fk_dni = ?, fk_id_estado = ? WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$usuario, $hashPassword, $fk_idrol, $fk_dni, $fk_id_estado, $id_usuario]);
    }
}
