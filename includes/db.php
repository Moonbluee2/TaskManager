<?php
// Habilitar informe de errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Establecer conexión a la base de datos mysqli de manera local
$conn = new mysqli("localhost", "root", "GOmita02", "TaskManager", 3307);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

echo "Conexión exitosa";
?>