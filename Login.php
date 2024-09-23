<?php
    //Creamos una nueva sesión o reanudamos una existente mediante un ID de sesión proporcionado en una solicitud get o post.
    session_start(); 

    //VERIFICA SI EL FORMULARIO FUE ENVIADO MEDIANTE EL METODO POST
    if($_SERVER["REQUEST_METHOD"]==="POST"){ 
        //Declarar las variables del Login, previamente definido.
        $user = $_POST[User];        
        $password = $_POST[Password];
        
        //Se valida el usuario existente.
        if($user === "nombre@cesun.edu.mx" && $password === "12345") {
            //Almacernar una variable de que el usuario inicio se sion de forma correcta
        $_SESSION["loggedin"] = true; 
        header("Location:TaskManager.html"); //Dirigirlo a la locacion 
        exit; //Asegurarnos de que los scripts se terminan 
        } else { 
            $error ="Usuario o contraseña inválidos";} 
    } else {
        $error="No se obtuvieron datos"; //Si no cumple la condicion de usuario existente, aparece:

    }

?>

<html lang="es"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaskManager</title>
    <link rel="stylesheet" href="Style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-box">

            <h2>Login</h2>

            <!-- Mostrar el mensaje de error si existe -->
            <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

            <form action="#" method="POST">
                <div class="input-group">
                    <label for="username">User</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="login-footer">
                <p>Don't have an account? <a href="Register.html">Register</a></p>
            </div>
        </div>
    </div>
</body>
</html>