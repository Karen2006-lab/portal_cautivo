<?php
$host = "localhost";      // Servidor
$usuario = "root";        // Usuario de MySQL
$contrasena = "";         // Contraseña (por defecto en XAMPP suele estar vacía)
$base_datos = "portal_cautivo";   // Nombre de tu base de datos

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    // echo "Conexión exitosa"; // Puedes descomentar esto para pruebas
}
?>
