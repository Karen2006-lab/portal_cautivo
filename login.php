<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $conexion = new mysqli("localhost", "root", "", "portal_cautivo");
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT id, nombre, contrasena, rol FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nombre, $contrasena_hash, $rol);
        $stmt->fetch();

        if (password_verify($contrasena, $contrasena_hash)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['rol'] = $rol;

            if ($rol === 'administrador' || $rol === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: usuario_panel.php");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Correo no encontrado.";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <style>
        body {
            background: url('imagen/imagen 1.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #cce7ff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #0e08be;
        }
        form label {
            display: block;
            margin-top: 15px;
            color: #333;
        }
        form input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn-login {
            background-color: #0e08be;
            color: white;
            border: none;
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #0904a0;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Iniciar Sesión</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>

        <button class="btn-login" type="submit">Ingresar</button>

       <div style="text-align: center; margin-top: 20px;">
  <a href="registro.html" style="color: #0e08be; text-decoration: none; font-weight: 600;">
    ¿No tienes cuenta? Regístrate aquí
  </a>
    </form>
</div>
</body>
</html>