<?php
require __DIR__ . '/../../controladores/UsuarioControlador.php';

if ($_POST) {
    $usuarioControlador = new UsuarioControlador($conn);
    $id_usuario = $_POST['id_usuario'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $rolUsuario = $_POST['rolUsuario'];
    $dniUsuario = $_POST['dniUsuario'];
    $estadoUsuario = $_POST['estadoUsuario'];

    try {
        $usuarioControlador->actualizarUsuario($id_usuario, $nombreUsuario, $rolUsuario, $dniUsuario, $estadoUsuario);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
