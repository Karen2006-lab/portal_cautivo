<?php
session_start();

// Validación de sesión y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido - Desarrollo de Software</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --color-primario: #003366;
            --color-secundario: #0077cc;
            --color-blanco: #ffffff;
            --sombra: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('img/fondo_instituto.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .header {
            background: rgba(0, 51, 102, 0.9);
            color: var(--color-blanco);
            width: 100%;
            padding: 25px;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            box-shadow: var(--sombra);
        }

        .card {
            background: rgba(255, 255, 255, 0.96);
            margin-top: 50px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--sombra);
            max-width: 960px;
            width: 90%;
            animation: fadeIn 1s ease-in-out;
        }

        .card h2 {
            text-align: center;
            color: var(--color-primario);
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card p {
            margin-bottom: 20px;
            font-size: 1.1em;
            color: #222;
            line-height: 1.8;
            text-align: justify;
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .btn i {
            font-size: 1.2em;
        }

        .btn-facebook {
            background: #3b5998;
            color: white;
        }

        .btn-facebook:hover {
            background: #2d4373;
        }

        .btn-delete {
            background: #e53935;
            color: white;
        }

        .btn-delete:hover {
            background: #b71c1c;
        }

        .btn-logout {
            background: var(--color-secundario);
            color: white;
        }

        .btn-logout:hover {
            background: #005fa3;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: var(--sombra);
            font-weight: bold;
            z-index: 1000;
            animation: fadeOut 5s forwards;
        }

        @keyframes fadeOut {
            0% {opacity: 1;}
            80% {opacity: 1;}
            100% {opacity: 0;}
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }

        @media (max-width: 768px) {
            .card {
                margin: 20px 10px;
                padding: 20px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="alert">
        ✅ Te conectaste correctamente a internet.
    </div>

    <div class="header">
        Bienvenido <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?>
    </div>

    <div class="card">
        <h2>Carrera de Desarrollo de Software</h2>
        <p>
            La carrera de Desarrollo de Software del Instituto Superior Tecnológico Riobamba forma profesionales
            capacitados para diseñar, desarrollar, implementar y mantener soluciones tecnológicas de vanguardia.
        </p>
        <p>
            Los estudiantes adquieren conocimientos sólidos en programación, bases de datos, diseño web, desarrollo móvil
            y metodologías ágiles. Se fomenta el pensamiento crítico, el trabajo colaborativo y el desarrollo de proyectos reales.
        </p>

        <div class="buttons-container">
            <form action="eliminar_cuenta.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                <button type="submit" class="btn btn-delete"><i class="fas fa-user-times"></i> Eliminar cuenta</button>
            </form>

            <a href="https://www.facebook.com/profile.php?id=100092577182098&locale=es_LA" target="_blank" class="btn btn-facebook">
                <i class="fab fa-facebook-f"></i> Ver página Facebook
            </a>

            <a href="logout.php" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
        </div>
    </div>
</body>
</html>