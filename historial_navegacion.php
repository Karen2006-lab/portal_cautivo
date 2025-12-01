<?php
session_start();

// Verificar rol administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "portal_cautivo");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener el historial con datos de usuario
$sql = "SELECT h.id, u.nombre, u.apellido, h.ip, h.fecha, h.url 
        FROM historial_navegacion h 
        JOIN usuarios u ON h.usuario_id = u.id 
        ORDER BY h.fecha DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Historial de Navegación</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
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
        a.btn-volver {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        a.btn-volver:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Historial de Navegación</h1>
  <div style="text-align: center; margin-bottom: 20px;">
    <input 
        type="text" 
        id="busquedaHistorial" 
        onkeyup="filtrarHistorial()" 
        placeholder="Buscar en historial (IP, URL, fecha)..." 
        style="padding: 10px; width: 320px; border-radius: 6px; border: 1px solid #ccc;"
    >
</div>

    

</form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>URL Visitada</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['nombre'] . ' ' . $fila['apellido']) ?></td>
                    <td><a href="<?= htmlspecialchars($fila['url']) ?>" target="_blank"><?= htmlspecialchars($fila['url_visitada']) ?></a></td>
                    <td><?= $fila['fecha'] ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">No hay registros de historial.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div style="display: flex; justify-content: center; gap: 15px; margin-top: 30px;">
    <form action="exportar_historial_excel.php" method="post">
        <button type="submit" class="btn btn-exportar">📊 Exportar a Excel</button>
    </form>

    <a href="admin_panel.php" class="btn btn-cerrar">⬅️ Volver al Panel</a>
</div>
<script>
function filtrarHistorial() {
    let input = document.getElementById("busquedaHistorial");
    let filter = input.value.toLowerCase();
    let filas = document.querySelectorAll("tbody tr");

    filas.forEach(fila => {
        let textoFila = fila.innerText.toLowerCase();
        fila.style.display = textoFila.includes(filter) ? "" : "none";
    });
}
</script>
</body>
</html>

<?php
$conexion->close();
?>