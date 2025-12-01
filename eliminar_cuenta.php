<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir la conexión a la base de datos
require 'conexion.php';  // Ajusta la ruta si es necesario

$usuario_id = $_SESSION['usuario_id'];

// Preparar la consulta para eliminar el usuario
$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $usuario_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Usuario eliminado, cerrar sesión
    session_destroy();

    // Redirigir con mensaje de éxito a login.php
    header("Location: login.php?mensaje=Cuenta eliminada correctamente");
    exit();
} else {
    // No se pudo eliminar, mostrar error
    echo "Error: No se pudo eliminar la cuenta.";
}

$stmt->close();
$conexion->close();
?>