<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "portal_cautivo");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $nombre     = trim($_POST['nombre']);
    $apellido   = trim($_POST['apellido']);
    $cedula     = trim($_POST['cedula']);
    $correo     = strtolower(trim($_POST['correo']));
    $contrasena = $_POST['contrasena'];
    $contrasena_confirm = $_POST['contrasena_confirm'];
    $rol        = $_POST['rol'];

    // Validar contraseñas
    if ($contrasena !== $contrasena_confirm) {
        header("Location: registro.php?error=contrasenas_no_coinciden");
        exit;
    }

   // Verificar si ya existe por cédula
$consulta = $conexion->prepare("SELECT id, contrasena FROM usuarios WHERE cedula = ?");
$consulta->bind_param("s", $cedula);
$consulta->execute();
$consulta->store_result();

if ($consulta->num_rows > 0) {
    $consulta->bind_result($id_usuario, $contrasena_bd);
    $consulta->fetch();

    if (!empty($contrasena_bd)) {
        header("Location: login.php?error=ya_registrado");
        exit;
    }

    // Solo actualizamos la contraseña si no tenía
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $update = $conexion->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
    $update->bind_param("si", $contrasena_hash, $id_usuario);
    if ($update->execute()) {
        header("Location: login.php?registro=actualizado");
    } else {
        header("Location: registro.php?error=registro_fallido");
    }
    exit;
}
// Si no existe, se registra normalmente
    // Si ya tiene contraseña, ya está registrado
    if (!empty($usuario['contrasena'])) {
        header("Location: registro.php?error=usuario_ya_registrado");
        exit;
    }

    $stmt->close();

    // Actualizar la contraseña para ese usuario existente
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $update = $conexion->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
    $update->bind_param("si", $contrasena_hash, $usuario['id']);

    if ($update->execute()) {
        header("Location: login.php?registro=exitoso");
        exit;
    } else {
        header("Location: registro.php?error=registro_fallido");
        exit;
    }

    $update->close();
    $conexion->close();

} else {
    header("Location: registro.php");
    exit;
}
?>