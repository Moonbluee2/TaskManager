<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

// Incluir la conexión a la base de datos
require_once 'db.php';

// Verificar si el ID de la tarea está presente en la URL
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Obtener la tarea desde la base de datos
    $result = $conn->query("SELECT * FROM tasks WHERE id = $task_id AND user_id = " . $_SESSION['user_id']);
    $task = $result->fetch_assoc();

    // Verificar si la tarea existe
    if (!$task) {
        echo "Tarea no encontrada.";
        exit();
    }
} else {
    echo "ID de tarea no proporcionado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="task-container">
        <h2>Editar Tarea</h2>
        <form method="POST" action="edit_task.php?id=<?php echo $task['id']; ?>">
            <div class="input-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($task['name']); ?>" required>
            </div>
            <div class="input-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($task['description']); ?></textarea>
            </div>
            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</body>
</html>

