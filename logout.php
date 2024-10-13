<?php
session_start(); // Iniciar la sesión

// Limpiar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Redirigir al login
header("Location: Login.php");
exit();
?>