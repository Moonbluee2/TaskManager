<?php
session_start();
include 'config.php'; // Incluye el archivo de configuración de la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $usuario_id = $_SESSION['usuario_id'];

    // Insertar tarea en la base de datos
    $stmt = $conn->prepare("INSERT INTO tareas (titulo, descripcion, usuario_id, estado) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("ssi", $titulo, $descripcion, $usuario_id);
    $stmt->execute();

    // Redirigir a task_manager.php
    header("Location: task_manager.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Tarea</title>
</head>
<body>
    <h1>Agregar Nueva Tarea</h1>
    <form action="add_task.php" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        <br>
        <input type="submit" value="Agregar Tarea">
    </form>
    <a href="task_manager.php">Regresar a Mis Tareas</a>
</body>
</html>