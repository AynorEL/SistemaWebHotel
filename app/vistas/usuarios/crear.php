<?php
header('Content-Type: application/json; charset=UTF-8');
require __DIR__ . '/../../controladores/UsuarioControlador.php'; // Asegúrate de que esta ruta sea correcta

// Verificar conexión a la base de datos
if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error
    ]));
}

// Crear instancia del controlador
$usuarioControlador = new UsuarioControlador($conn);

// Verificar si el método de solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['nombreUsuario'] ?? null;
    $password = $_POST['passwordUsuario'] ?? null;
    $rol = $_POST['rolUsuario'] ?? null;
    $dni = $_POST['dniUsuario'] ?? null;
    $estado = $_POST['estadoUsuario'] ?? null;
    // Validar que todos los campos estén presentes
    if ($usuario && $password && $rol && $dni && $estado) {
        // Encriptar la contraseña con password_hash (mejor que MD5)
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
        // Intentar crear el usuario
        $resultado = $usuarioControlador->crearUsuario($usuario, $passwordHashed, $rol, $dni, $estado);
        // Verificar si se creó correctamente
        if ($resultado) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Usuario creado correctamente.',
                'data' => [
                    'id_usuario' => $conn->insert_id, // Obtener el último ID insertado
                    'usuario' => $usuario,
                    'rol' => $rol,
                    'dni' => $dni,
                    'estado' => $estado == 1 ? 'Activo' : 'Inactivo'
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al crear el usuario. ' . $conn->error
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Todos los campos son obligatorios.'
        ]);
    }
}
?>
