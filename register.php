<?php
// Incluir la conexión a la base de datos y funciones necesarias
include 'includes/db.php';
include 'includes/functions.php';

// Iniciar sesión y procesar el formulario
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos enviados desde el formulario
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // Asegúrate de que el name en el formulario sea "confirm_password"

    // Verificar que las contraseñas coincidan
    if ($password === $confirm_password) {
        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Verificar si el correo ya está registrado usando sentencias preparadas
        if ($stmt = $conn->prepare("SELECT * FROM users WHERE email = ?")) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "El correo electrónico ya está registrado.";
            } else {
                // Insertar nuevo usuario con sentencias preparadas
                if ($stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)")) {
                    $stmt->bind_param("sss", $username, $email, $hashed_password);
                    if ($stmt->execute()) {
                        $_SESSION['flash_message'] = "Registro exitoso. Ahora puedes iniciar sesión.";
                        header("Location: Login.php");
                        exit();
                    } else {
                        $error = "Error en el registro: " . $stmt->error;
                    }
                }
            }
            $stmt->close();
        }
    } else {
        $error = "Las contraseñas no coinciden.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - TaskManager</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>TaskManager Register</h2>
            <?php
            if (isset($error)) {
                echo '<p class="error">' . $error . '</p>';
            }
            if (isset($_SESSION['flash_message'])) {
                echo '<p class="success">' . $_SESSION['flash_message'] . '</p>';
                unset($_SESSION['flash_message']);
            }
            ?>
            <form action="#" method="POST">
                <div class="input-group">
                    <label for="username" class="form-label">User</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>
                </div>
                <button type="submit">Register</button>
            </form>
            <div class="login-footer">
                <p>¿Ya tienes una cuenta? <a href="Login.php">Iniciar Sesión</a></p>
            </div>
        </div>
    </div>
</body>
</html>