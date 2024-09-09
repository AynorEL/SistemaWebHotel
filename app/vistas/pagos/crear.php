// Vista para crear pagos 
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $monto = $_POST['monto'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO detalle_pago (usuario, monto, estado, fecha) VALUES ('$usuario', '$monto', '$estado', NOW())";
    if (mysqli_query($conexion, $sql)) {
        echo "Pago creado exitosamente";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Pago</title>
</head>
<body>
    <h1>Crear Pago</h1>
    <form method="POST" action="">
        Usuario: <input type="text" name="usuario" required><br>
        Monto: <input type="number" name="monto" required><br>
        Estado: 
        <select name="estado">
            <option value="pendiente">Pendiente</option>
            <option value="pagado">Pagado</option>
        </select><br>
        <button type="submit">Crear</button>
    </form>
</body>
</html>
