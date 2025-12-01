<?php
// verificar_usuario_por_cedula.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "portal_cautivo");
    if ($conexion->connect_error) {
        die(json_encode(["error" => "Error de conexión"]));
    }

    $cedula = trim($_POST['cedula']);
    $stmt = $conexion->prepare("SELECT nombre, apellido, correo, rol, contrasena FROM usuarios WHERE cedula = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($nombre, $apellido, $correo, $rol, $contrasena);
        $stmt->fetch();

        echo json_encode([
            "existe" => true,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "correo" => $correo,
            "rol" => $rol,
            "tiene_contrasena" => !empty($contrasena)
        ]);
    } else {
        echo json_encode(["existe" => false]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
