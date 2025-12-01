<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // Cambia "login.php" por tu página de inicio de sesión si es otro nombre
exit;
?>

