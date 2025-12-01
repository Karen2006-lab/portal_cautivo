<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro de usuario</title>
    <style>
        /* Estilos para alertas */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px 20px;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px 20px;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
// Mostrar mensajes según parámetros GET
if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso') {
    echo '<div class="alert-success">✅ ¡Registro exitoso! Ahora puedes iniciar sesión.</div>';
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    $mensaje = "";
    switch ($error) {
        case "contrasenas_no_coinciden":
            $mensaje = "❌ Las contraseñas no coinciden.";
            break;
        case "correo_registrado":
            $mensaje = "❌ El correo ya está registrado.";
            break;
        case "cedula_registrada":
            $mensaje = "❌ La cédula ya está registrada.";
            break;
        case "usuario_no_encontrado":
            $mensaje = "❌ Usuario no encontrado. No puede registrarse.";
            break;
        case "registro_fallido":
            $mensaje = "❌ Error al registrar. Intenta de nuevo.";
            break;
        default:
            $mensaje = "❌ Error desconocido.";
    }
    echo '<div class="alert-error">' . htmlspecialchars($mensaje) . '</div>';
}
?>

<div id="verificacionNombre" class="alert-error" style="display:none;"></div>

<!-- Formulario -->
<form action="registro_procesar.php" method="POST" id="registroForm">
    Nombre: <input type="text" name="nombre" required><br><br>
    Apellido: <input type="text" name="apellido" required><br><br>
    Cédula: <input type="text" name="cedula" required><br><br>
    Correo: <input type="email" name="correo" required><br><br>
    Contraseña: <input type="password" name="contrasena" required><br><br>
    Confirmar contraseña: <input type="password" name="contrasena_confirm" required><br><br>
    Rol: <select name="rol" required>
        <option value="usuario">Usuario</option>
        <option value="administrador">Administrador</option>
    </select><br><br>
    <input type="submit" value="Registrar">
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nombreInput = document.querySelector('input[name="nombre"]');
    const apellidoInput = document.querySelector('input[name="apellido"]');
    const mensajeDiv = document.getElementById('verificacionNombre');
    const botonRegistrar = document.querySelector('input[type="submit"]');

    function verificarUsuario() {
        const nombre = nombreInput.value.trim();
        const apellido = apellidoInput.value.trim();

        if (nombre !== "" && apellido !== "") {
            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('apellido', apellido);

            fetch('verificar_usuario.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === "existe") {
                    mensajeDiv.style.display = "block";
                    mensajeDiv.style.backgroundColor = "#fff3cd";
                    mensajeDiv.style.color = "#856404";
                    mensajeDiv.textContent = "⚠️ Usuario ya registrado. Puedes iniciar sesión.";
                    botonRegistrar.disabled = true;
                } else {
                    mensajeDiv.style.display = "none";
                    botonRegistrar.disabled = false;
                }
            })
            .catch(error => {
                console.error("Error al verificar usuario:", error);
            });
        } else {
            mensajeDiv.style.display = "none";
            botonRegistrar.disabled = false;
        }
    }

    nombreInput.addEventListener('input', verificarUsuario);
    apellidoInput.addEventListener('input', verificarUsuario);
});
</script>

</body>
</html>