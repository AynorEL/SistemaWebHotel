<?php
session_start();
require '../configuracion/base_datos.php';  // Conexión a la base de datos

$error = '';  // Inicializamos la variable error vacía para evitar que se muestre al cargar la página.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = md5($_POST['password']);  // Usamos md5 para encriptar la contraseña (puedes usar otro método más seguro como bcrypt o password_hash)

    // Consulta para verificar el usuario y contraseña
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password' AND fk_id_estado = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si existe el usuario, autenticación correcta
        $_SESSION['usuario'] = $usuario;
        header('Location: dashboard.php');  // Redirigir al dashboard de inmediato
        exit;  // Detenemos la ejecución del script para evitar que continúe
    } else {
        // Usuario o contraseña incorrectos
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Sistema Hotelero</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Imagen de fondo */
        body {
            background: url('img/login.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        /* Caja de login */
        .login-container {
            background-color: rgba(255, 255, 255, 0.1); /* Caja blanca translúcida */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 350px;
            transition: all 0.3s ease-in-out;
        }
        .login-container:hover {
            background-color: rgba(255, 255, 255, 0.8); /* Más opaco al pasar el mouse */
            backdrop-filter: blur(5px); /* Efecto blur al pasar el mouse */
        }
        /* Estilo del título */
        .login-title {
            font-size: 1.8em;
            font-weight: bold;
            color: #333; /* Título en negro */
        }
        /* Campos del formulario */
        .form-control {
            background-color: rgba(255, 255, 255, 0.2); /* Fondo blanco translúcido */
            border: none;
            border-bottom: 2px solid #6c63ff; /* Línea inferior púrpura */
            color: #333; /* Texto en negro */
            border-radius: 0;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2); /* Fondo más sólido al enfocar */
            border-color: #6c63ff; /* Borde púrpura al enfocar */
            box-shadow: none;
            color: #333; /* Mantener el texto en negro */
        }
        .form-control::placeholder {
            color: #666; /* Placeholder gris oscuro */
        }
        /* Estilo del botón */
        .btn-custom {
            background-color: #6c63ff;
            color: white;
            border-radius: 30px;
            padding: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #554ab0;
        }
        /* Mensajes de error */
        .alert-danger {
            background-color: rgba(255, 0, 0, 0.7); /* Fondo rojo translúcido para el error */
            color: white;
            border-radius: 10px;
            padding: 10px;
            font-size: 0.9em;
            margin-bottom: 20px;
        }
        /* Alineación y tamaño */
        .container-fluid {
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="login-container text-center">
            <h2 class="login-title mb-4">BIENVENIDO</h2>
            <?php if (!empty($error)): ?>  <!-- Verificamos si hay un error antes de mostrar el mensaje -->
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
                    <label for="usuario">Usuario</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    <label for="password">Contraseña</label>
                </div>
                <button type="submit" class="btn btn-custom w-100 mb-3">Iniciar sesión</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
