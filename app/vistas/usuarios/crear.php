<?php
header('Content-Type: application/json; charset=UTF-8');
require __DIR__ . '/../../controladores/UsuarioControlador.php';
// Verificar conexión a la base de datos
if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Error de conexión a la base de datos.'
    ]));
}

// Crear instancia del controlador
$usuarioControlador = new UsuarioControlador($conn);

// Verificar si el método de solicitud es POST y validar campos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['nombreUsuario'] ?? null;
    $password = $_POST['passwordUsuario'] ?? null;
    $rol = $_POST['rolUsuario'] ?? null;
    $dni = $_POST['dniUsuario'] ?? null;
    $estado = $_POST['estadoUsuario'] ?? null;

    if ($usuario && $password && $rol && $dni && $estado) {
        // Encriptar la contraseña
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
        
        // Intentar crear el usuario
        $resultado = $usuarioControlador->crearUsuario($usuario, $passwordHashed, $rol, $dni, $estado);
        
        // Enviar la respuesta en base al resultado
        echo json_encode([
            'status' => $resultado ? 'success' : 'error',
            'message' => $resultado ? 'Usuario creado correctamente.' : 'Error al crear el usuario.',
            'data' => $resultado ? [
                'id_usuario' => $conn->insert_id,
                'usuario' => $usuario,
                'rol' => $rol,
                'dni' => $dni,
                'estado' => $estado == 1 ? 'Activo' : 'Inactivo'
            ] : null
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Todos los campos son obligatorios.'
        ]);
    }
}
?>
