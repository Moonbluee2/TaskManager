<?php
session_start();
include 'config.php'; // Incluye el archivo de configuración de la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Login.php");
    exit();
}

// Verifica si se ha pasado un id por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar la tarea
    $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Si la eliminación fue exitosa, redirige a la página principal de gestión de tareas
        header("Location: task_manager.php");
        exit();
    } else {
        echo "Error al eliminar la tarea.";
    }
} else {
    // Si no se recibe un id válido, redirige de nuevo a la página principal
    header("Location: task_manager.php");
    exit();
}
?>


