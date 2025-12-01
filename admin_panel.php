<?php
session_start();

// Validar si es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexión
$conexion = new mysqli("localhost", "root", "", "portal_cautivo");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Contadores
$totalUsuarios = $conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'usuario'")->fetch_assoc()['total'];
$totalAdmins = $conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'administrador'")->fetch_assoc()['total'];

// Consulta principal
$sql = "SELECT id, nombre, apellido, cedula, correo, rol, fecha_registro FROM usuarios ORDER BY fecha_registro DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            padding: 30px;
            background-color: #f0f2f5;
        }

        h1 {
            color: #003366;
            text-align: center;
        }

        .resumen {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
        }

        .card h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #0077cc;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin: 30px 0;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .btn-exportar {
            background-color: #28a745;
        }

        .btn-exportar:hover {
            background-color: #218838;
        }

        .btn-eliminar {
            background-color: crimson;
        }

        .btn-eliminar:hover {
            background-color: #b52b3a;
        }

        .btn-cerrar {
            background-color: #dc3545;
        }

        .btn-cerrar:hover {
            background-color: #b02a37;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin: 10px auto;
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #003366;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .mensaje-exito {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 20px auto;
            border-radius: 5px;
            max-width: 800px;
            text-align: center;
        }
    </style>

    <script>
        function filtrarUsuarios() {
            let input = document.getElementById("busqueda");
            let filter = input.value.toLowerCase();
            let filas = document.getElementsByTagName("tr");

            for (let i = 1; i < filas.length; i++) {
                let fila = filas[i];
                let textoFila = fila.innerText.toLowerCase();
                fila.style.display = textoFila.includes(filter) ? "" : "none";
            }
        }
    </script>
</head>
<body>

<h1>Panel de Administración</h1>

<!-- Estadísticas -->
<div class="resumen">
    <div class="card">
        <h3>Usuarios</h3>
        <p><?= $totalUsuarios ?></p>
    </div>
    <div class="card">
        <h3>Administradores</h3>
        <p><?= $totalAdmins ?></p>
    </div>
</div>

<!-- Acciones -->
<div class="actions">
    <form action="exportar_excel.php" method="post">
        <button type="submit" class="btn btn-exportar">📊 Exportar a Excel</button>
    </form>

    <form action="eliminar_todos_usuarios.php" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar todos los usuarios normales?');">
        <button type="submit" class="btn btn-eliminar">🗑️ Eliminar usuarios</button>
    </form>

    <a href="logout.php" class="btn btn-cerrar">🔒 Cerrar sesión</a>

    <!-- Aquí el botón para historial -->
    <a href="historial_navegacion.php" class="btn btn-exportar" style="margin-left: 10px;">📜 Ver Historial</a>
</div>
<!-- Buscador -->
<input type="text" id="busqueda" onkeyup="filtrarUsuarios()" placeholder="Buscar por nombre, cédula o correo...">

<!-- Tabla -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cédula</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['apellido']) ?></td>
            <td><?= htmlspecialchars($fila['cedula']) ?></td>
            <td><?= htmlspecialchars($fila['correo']) ?></td>
            <td><?= htmlspecialchars($fila['rol']) ?></td>
            <td><?= $fila['fecha_registro'] ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>



<!-- Mensaje de éxito -->
<?php if (isset($_SESSION['mensaje_exito'])): ?>
    <div class="mensaje-exito">
        <?= htmlspecialchars($_SESSION['mensaje_exito']); unset($_SESSION['mensaje_exito']); ?>
    </div>
<?php endif; ?>

</body>
</html>

<?php $conexion->close(); ?>
