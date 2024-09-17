<?php
require_once __DIR__ . '/../../controladores/UsuarioControlador.php';

// Verificar si se envía el formulario mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $rolUsuario = $_POST['rolUsuario'];
    $dniUsuario = $_POST['dniUsuario'];
    $estadoUsuario = $_POST['estadoUsuario'];

    try {
        // Crear instancia del controlador
        $usuarioControlador = new UsuarioControlador($conn);
        
        // Actualizar los datos del usuario
        $resultado = $usuarioControlador->actualizarUsuario($id_usuario, $nombreUsuario, $rolUsuario, $dniUsuario, $estadoUsuario);
        
        // Responder con éxito si se actualiza correctamente
        if ($resultado) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario actualizado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el usuario.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
