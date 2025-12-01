<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "portal_cautivo");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $correo = strtolower(trim($_POST['correo']));
    $contrasena = $_POST['contrasena'];

    // Buscar usuario por correo
    $stmt = $conexion->prepare("SELECT id, nombre, apellido, contrasena, rol FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
        // Verificar contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Contraseña correcta: iniciar sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellido'] = $usuario['apellido'];
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: registro.html"); // Cambia por tu página principal
            exit;
        } else {
            // Contraseña incorrecta
            header("Location: login.php?error=usuario_incorrecto");
            exit;
        }
    } else {
        // Usuario no encontrado
        header("Location: login.php?error=usuario_incorrecto");
        exit;
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: login.php");
    exit;
}
?>
