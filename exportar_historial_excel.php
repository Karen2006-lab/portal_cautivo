<?php
session_start();

// Validar si es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "portal_cautivo");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Configurar encabezados para descargar como Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=historial_navegacion.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Crear tabla HTML para Excel
echo "<table border='1'>";
echo "<tr><th>ID</th><th>IP</th><th>Usuario</th><th>Fecha</th><th>URL</th></tr>";

$sql = "SELECT h.id, h.ip, h.fecha, h.url, u.nombre, u.apellido 
        FROM historial_navegacion h 
        LEFT JOIN usuarios u ON h.usuario_id = u.id 
        ORDER BY h.fecha DESC";
$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {
    $usuario = $fila['nombre'] ? $fila['nombre'] . ' ' . $fila['apellido'] : 'No registrado';
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['ip']}</td>
            <td>{$usuario}</td>
            <td>{$fila['fecha']}</td>
            <td>{$fila['url']}</td>
          </tr>";
}

echo "</table>";

$conexion->close();
?>