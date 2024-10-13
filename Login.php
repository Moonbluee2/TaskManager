<?php
// Iniciar la sesión al inicio del script
session_start();

// Incluir el archivo de conexión a la base de datos
require_once 'db.php';

// Inicializar variable de error
$error = "";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y sanitizar los datos del formulario
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        $error = "Por favor, complete ambos campos.";
    } else {
        // Preparar la consulta para buscar al usuario en la base de datos
        $stmt = $conn->prepare("SELECT id, username, password FROM usuarios WHERE username = ?");
        
        if ($stmt) {
            // Vincular el parámetro
            $stmt->bind_param("s", $username);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el resultado
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                // Obtener los datos del usuario
                $user = $result->fetch_assoc();
                
                // Verificar la contraseña
                if (password_verify($password, $user['password'])) {
                    // Regenerar el ID de sesión para prevenir secuestro de sesiones
                    session_regenerate_id(true);
                    
                    // Contraseña correcta, establecer variables de sesión
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    
                    // Redirigir al administrador de tareas
                    header("Location: task_manager.php");
                    exit();
                } else {
                    // Contraseña incorrecta
                    $error = "Credenciales incorrectas.";
                }
            } else {
                // Usuario no encontrado
                $error = "Credenciales incorrectas.";
            }
            
            // Cerrar la declaración
            $stmt->close();
        } else {
            // Error en la preparación de la consulta
            // Para seguridad, no se muestra el error específico al usuario
            $error = "Ocurrió un error. Por favor, inténtalo de nuevo más tarde.";
            // Opcional: Registrar el error en un log para desarrolladores
            error_log("Error en la preparación de la consulta: " . $conn->error);
        }
    }
    
    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - TaskManager</title>
    <link rel="stylesheet" href="Style.css">
    <!-- Uso de Bootstrap 5.3.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionales para mejorar la apariencia */
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }
        .login-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .login-footer {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>

            <!-- Mostrar el mensaje de error si existe -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" id="username" name="username" class="form-control" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                </div>
                <div class="input-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="login-footer">
                <p>¿No tienes una cuenta? <a href="Register.html">Regístrate</a></p>
            </div>
        </div>
    </div>
</body>
</html>