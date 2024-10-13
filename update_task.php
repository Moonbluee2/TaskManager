<?php
session_start();
include 'config.php'; // Incluye el archivo de configuración de la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    // Actualizar el estado de la tarea
    $stmt = $conn->prepare("UPDATE tareas SET estado = ? WHERE id = ?");
    $stmt->bind_param("ii", $estado, $id);
    $stmt->execute();

    // Redirigir a task_manager.php
    header("Location: task_manager.php");
    exit();
}
?>