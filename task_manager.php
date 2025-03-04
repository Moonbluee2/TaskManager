<?php
session_start();
include 'config.php'; // Incluye el archivo de configuración de la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];

// Obtener las tareas del usuario
$stmt = $conn->prepare("SELECT id, titulo, descripcion, estado FROM tareas WHERE usuario_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager</title>
    <link rel="stylesheet" href="Style.css"> 
</head>
<body>
    <h1>Mis Tareas</h1>
    <a href="add_task.php">Agregar Nueva Tarea</a> <!-- Enlace para agregar una nueva tarea -->
    <a href="logout.php">Cerrar Sesión</a> <!-- Enlace de cerrar sesión -->
    
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Modificar Estado</th>
                <th>Acciones</th> <!-- Nueva columna para editar y eliminar -->
            </tr>
        </thead>
        <tbody>
            <?php while ($task = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($task['descripcion']); ?></td>
                    <td>
                        <?php
                        // Mostrar el estado de la tarea de manera legible
                        if ($task['estado'] == 0) {
                            echo 'Por Hacer';
                        } elseif ($task['estado'] == 1) {
                            echo 'En Progreso';
                        } else {
                            echo 'Terminada';
                        }
                        ?>
                    </td>
                    <td>
                        <!-- Formulario para modificar el estado de la tarea -->
                        <form action="update_task.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            <select name="estado">
                                <option value="0" <?php if ($task['estado'] == 0) echo 'selected'; ?>>Por Hacer</option>
                                <option value="1" <?php if ($task['estado'] == 1) echo 'selected'; ?>>En Progreso</option>
                                <option value="2" <?php if ($task['estado'] == 2) echo 'selected'; ?>>Terminada</option>
                            </select>
                            <input type="submit" value="Actualizar">
                        </form>
                    </td>
                    <td>
                        <!-- Botones para editar y eliminar -->
                        <a href="edit_task.php?id=<?php echo $task['id']; ?>">Editar</a> | 
                        <a href="delete_task.php?id=<?php echo $task['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta tarea?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>