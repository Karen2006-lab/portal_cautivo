<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "portal_cautivo");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener los usuarios
$sql = "SELECT id, nombre, apellido, cedula, correo, rol, fecha_registro FROM usuarios ORDER BY fecha_registro DESC";
$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conexion->error);
}

// Definir encabezados para descargar como Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=usuarios.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Crear la tabla que será exportada
echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Cédula</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Fecha de Registro</th>
      </tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila['id'] . "</td>";
    echo "<td>" . $fila['nombre'] . "</td>";
    echo "<td>" . $fila['apellido'] . "</td>";
    echo "<td>" . $fila['cedula'] . "</td>";
    echo "<td>" . $fila['correo'] . "</td>";
    echo "<td>" . $fila['rol'] . "</td>";
    echo "<td>" . $fila['fecha_registro'] . "</td>";
    echo "</tr>";
}

echo "</table>";
$conexion->close();
?>
