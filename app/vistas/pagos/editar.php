// Vista para editar pagos 
<?php
include('conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pagos WHERE id = $id";
    $result = mysqli_query($conexion, $sql);
    $pago = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $monto = $_POST['monto'];
    $estado = $_POST['estado'];

    $sql = "UPDATE pagos SET usuario = '$usuario', monto = '$monto', estado = '$estado' WHERE id = $id";
    if (mysqli_query($conexion, $sql)) {
        echo "Pago actualizado exitosamente";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Pago</title>
</head>
<body>
    <h1>Editar Pago</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $pago['id']; ?>">
        Usuario: <input type="text" name="usuario" value="<?php echo $pago['usuario']; ?>" required><br>
        Monto: <input type="number" name="monto" value="<?php echo $pago['monto']; ?>" required><br>
        Estado: 
        <select name="estado">
            <option value="pendiente" <?php echo ($pago['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
            <option value="pagado" <?php echo ($pago['estado'] == 'pagado') ? 'selected' : ''; ?>>Pagado</option>
        </select><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
