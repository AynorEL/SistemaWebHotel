<?php
require_once __DIR__ . '/../../configuracion/base_datos.php';

class UsuarioControlador {
    private $conexion;

    public function __construct() {
        global $conn;
        $this->conexion = $conn;
    }

    // Listar usuarios activos
    public function listarUsuarios() {
        $sql = "SELECT u.id_usuario, CONCAT_WS(' ', p.nombres, p.apellidos) AS nombres, p.direccion, p.correo, u.usuario, p.celular, r.cargo 
                FROM usuarios u 
                INNER JOIN personas p ON u.fk_dni = p.dni
                INNER JOIN roles r ON u.fk_idrol = r.id_rol
                WHERE u.fk_id_estado = 1";
        $result = $this->conexion->query($sql);
        return $result;
    }

    // Crear nuevo usuario con verificación de DNI duplicado
    public function crearUsuario($datosPersona, $datosUsuario) {
        // Verificar si el DNI ya existe
        $stmtVerificarDNI = $this->conexion->prepare("SELECT dni FROM personas WHERE dni = ?");
        $stmtVerificarDNI->bind_param("s", $datosPersona['dni']);
        $stmtVerificarDNI->execute();
        $resultadoVerificacion = $stmtVerificarDNI->get_result();

        if ($resultadoVerificacion->num_rows > 0) {
            // El DNI ya existe
            return 'dni_duplicado';
        }

        // Iniciar transacción
        $this->conexion->begin_transaction();

        try {
            // Insertar en personas
            $stmtPersona = $this->conexion->prepare("INSERT INTO personas (dni, nombres, apellidos, direccion, celular, correo) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtPersona->bind_param("ssssss", $datosPersona['dni'], $datosPersona['nombres'], $datosPersona['apellidos'], $datosPersona['direccion'], $datosPersona['celular'], $datosPersona['correo']);
            $stmtPersona->execute();

            // Insertar en usuarios
            $stmtUsuario = $this->conexion->prepare("INSERT INTO usuarios (usuario, password, fk_idrol, fk_dni, fk_id_estado) VALUES (?, ?, ?, ?, 1)");
            $passwordHash = md5($datosUsuario['password']); // Se recomienda usar password_hash() en producción
            $stmtUsuario->bind_param("ssis", $datosUsuario['usuario'], $passwordHash, $datosUsuario['fk_idrol'], $datosPersona['dni']);
            $stmtUsuario->execute();

            // Confirmar transacción
            $this->conexion->commit();
            return 'exito';
        } catch (Exception $e) {
            // Revertir transacción
            $this->conexion->rollback();
            return 'error';
        }
    }

    // Actualizar usuario (sin cambios)
    public function actualizarUsuario($id_usuario, $datosPersona, $datosUsuario) {
        // Iniciar transacción
        $this->conexion->begin_transaction();

        try {
            // Actualizar personas
            $stmtPersona = $this->conexion->prepare("UPDATE personas SET nombres = ?, apellidos = ?, direccion = ?, celular = ?, correo = ? WHERE dni = ?");
            $stmtPersona->bind_param("ssssss", $datosPersona['nombres'], $datosPersona['apellidos'], $datosPersona['direccion'], $datosPersona['celular'], $datosPersona['correo'], $datosPersona['dni']);
            $stmtPersona->execute();

            // Actualizar usuarios
            if (!empty($datosUsuario['password'])) {
                // Si se proporciona una nueva contraseña
                $stmtUsuario = $this->conexion->prepare("UPDATE usuarios SET usuario = ?, fk_idrol = ?, password = ? WHERE id_usuario = ?");
                $passwordHash = md5($datosUsuario['password']); // Se recomienda usar password_hash() en producción
                $stmtUsuario->bind_param("sisi", $datosUsuario['usuario'], $datosUsuario['fk_idrol'], $passwordHash, $id_usuario);
            } else {
                // Si no se cambia la contraseña
                $stmtUsuario = $this->conexion->prepare("UPDATE usuarios SET usuario = ?, fk_idrol = ? WHERE id_usuario = ?");
                $stmtUsuario->bind_param("sii", $datosUsuario['usuario'], $datosUsuario['fk_idrol'], $id_usuario);
            }
            $stmtUsuario->execute();

            // Confirmar transacción
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            // Revertir transacción
            $this->conexion->rollback();
            return false;
        }
    }

    // Cambiar estado del usuario (activar/inactivar) (sin cambios)
    public function cambiarEstadoUsuario($id_usuario, $estado) {
        $nuevoEstado = ($estado == 1) ? 2 : 1; // 1 = Activo, 2 = Inactivo
        $stmt = $this->conexion->prepare("UPDATE usuarios SET fk_id_estado = ? WHERE id_usuario = ?");
        $stmt->bind_param("ii", $nuevoEstado, $id_usuario);
        return $stmt->execute();
    }

    // Obtener roles (sin cambios)
    public function obtenerRoles() {
        $sql = "SELECT id_rol, cargo FROM roles";
        $result = $this->conexion->query($sql);
        return $result;
    }

    // Obtener datos de un usuario específico (sin cambios)
    public function obtenerUsuarioPorId($id_usuario) {
        $sql = "SELECT u.id_usuario, u.usuario, u.fk_idrol, p.dni, p.nombres, p.apellidos, p.direccion, p.celular, p.correo 
                FROM usuarios u 
                INNER JOIN personas p ON u.fk_dni = p.dni
                WHERE u.id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

// Manejo de acciones AJAX
if (isset($_POST['accion'])) {
    $controlador = new UsuarioControlador();

    if ($_POST['accion'] == 'crear') {
        $datosPersona = [
            'dni' => $_POST['dni'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'direccion' => $_POST['direccion'],
            'celular' => $_POST['celular'],
            'correo' => $_POST['correo']
        ];

        $datosUsuario = [
            'usuario' => $_POST['usuario'],
            'password' => $_POST['password'],
            'fk_idrol' => $_POST['fk_idrol']
        ];

        $resultado = $controlador->crearUsuario($datosPersona, $datosUsuario);

        if ($resultado == 'exito') {
            echo 'exito';
        } elseif ($resultado == 'dni_duplicado') {
            echo 'dni_duplicado';
        } else {
            echo 'error';
        }
    }

    if ($_POST['accion'] == 'actualizar') {
        $id_usuario = $_POST['id_usuario'];

        $datosPersona = [
            'dni' => $_POST['dni'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'direccion' => $_POST['direccion'],
            'celular' => $_POST['celular'],
            'correo' => $_POST['correo']
        ];

        $datosUsuario = [
            'usuario' => $_POST['usuario'],
            'password' => $_POST['password'],
            'fk_idrol' => $_POST['fk_idrol']
        ];

        if ($controlador->actualizarUsuario($id_usuario, $datosPersona, $datosUsuario)) {
            echo 'exito';
        } else {
            echo 'error';
        }
    }

    if ($_POST['accion'] == 'cambiarEstado') {
        $id_usuario = $_POST['id_usuario'];
        $estado = $_POST['estado'];

        if ($controlador->cambiarEstadoUsuario($id_usuario, $estado)) {
            echo 'exito';
        } else {
            echo 'error';
        }
    }
}

if (isset($_GET['accion']) && $_GET['accion'] == 'obtener') {
    $controlador = new UsuarioControlador();
    $id_usuario = $_GET['id_usuario'];
    $usuarioData = $controlador->obtenerUsuarioPorId($id_usuario);
    $roles = $controlador->obtenerRoles();

    // Incluir el formulario de actualización con los datos cargados
    include '../vistas/usuarios/actualizar.php';
}
?>
