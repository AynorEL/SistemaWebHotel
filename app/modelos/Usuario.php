<?php
class Usuario {
    private $conn;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    // Función para obtener usuarios activos
    public function obtenerUsuarios() {
        $sql = "SELECT u.id_usuario, CONCAT_WS(' ', p.nombres, p.apellidos) AS NOMBRES, p.direccion, p.correo, u.usuario, p.celular, r.cargo 
                FROM usuarios u 
                INNER JOIN personas p ON u.fk_dni = p.dni
                INNER JOIN roles r ON u.fk_idrol = r.id_rol
                WHERE u.fk_id_estado = 1
                ORDER BY u.id_usuario ASC"; // Agregamos ORDER BY
        $result = $this->conn->query($sql);
    
        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
    
        return $usuarios;
    }
    
    // Función para crear un usuario
    public function crear($dni, $nombres, $apellidos, $direccion, $celular, $correo, $usuario, $password, $rol) {
        $sql_persona = "INSERT INTO personas (dni, nombres, apellidos, direccion, celular, correo) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_persona = $this->conn->prepare($sql_persona);
        $stmt_persona->bind_param("ssssss", $dni, $nombres, $apellidos, $direccion, $celular, $correo);
        $stmt_persona->execute();

        $password_encrypted = md5($password);
        $sql_usuario = "INSERT INTO usuarios (usuario, password, fk_idrol, fk_dni, fk_id_estado) 
                        VALUES (?, ?, ?, ?, 1)";
        $stmt_usuario = $this->conn->prepare($sql_usuario);
        $stmt_usuario->bind_param("ssis", $usuario, $password_encrypted, $rol, $dni);
        return $stmt_usuario->execute();
    }

    // Función para actualizar un usuario
    public function actualizar($id_usuario, $nombres, $apellidos, $direccion, $celular, $correo, $usuario, $password, $rol) {
        $sql_persona = "UPDATE personas 
                        SET nombres = ?, apellidos = ?, direccion = ?, celular = ?, correo = ? 
                        WHERE dni = (SELECT fk_dni FROM usuarios WHERE id_usuario = ?)";
        $stmt_persona = $this->conn->prepare($sql_persona);
        $stmt_persona->bind_param("sssssi", $nombres, $apellidos, $direccion, $celular, $correo, $id_usuario);
        $stmt_persona->execute();

        $password_encrypted = md5($password);
        $sql_usuario = "UPDATE usuarios 
                        SET usuario = ?, password = ?, fk_idrol = ? 
                        WHERE id_usuario = ?";
        $stmt_usuario = $this->conn->prepare($sql_usuario);
        $stmt_usuario->bind_param("ssii", $usuario, $password_encrypted, $rol, $id_usuario);
        return $stmt_usuario->execute();
    }
}
