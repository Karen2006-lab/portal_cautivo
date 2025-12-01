<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = new mysqli("localhost", "root", "", "portal_cautivo");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Eliminar solo usuarios con rol 'usuario', dejando a los administradores
    $sql = "DELETE FROM usuarios WHERE rol = 'usuario'";

    if ($conexion->query($sql) === TRUE) {
        $_SESSION['mensaje_exito'] = "¡Todos los usuarios normales han sido eliminados correctamente!";
    } else {
        $_SESSION['mensaje_exito'] = "Error al eliminar usuarios: " . $conexion->error;
    }

    $conexion->close();

    header("Location: admin_panel.php");
    exit;
} else {
    header("Location: admin_panel.php");
    exit;
}
?>
