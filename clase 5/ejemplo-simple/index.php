<?php
    // Aquí va la sintaxis php
    echo 'Método: '.$_SERVER['REQUEST_METHOD'];

    // Preguntamos si es la primera carga del archivo o ya estamos enviando el formulario
    $error = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $email = "brian@mail.com";
        $password = '12345678';

        if ($_POST['email'] == $email && $_POST['password'] == $password) {
            header("Location: panel.php");
        } else {
            $error = 'Usuario/Contraseña incorrectos';
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio simple</title>

        <style>
            input {
                font-size: 16px;
                padding: 5px 10px;
            }
            button {
                font-size: 16px;
                padding: 5px 10px;
                background-color: #017f9e;
                color: white
            }
        </style>
    </head>
    <body>
        <h1>Envío de formulario normal/fetch</h1>

        <br>
        <h2>Inicio de sesión</h2>
        <hr>
        <?php
            // $error != ''
            if (!empty($error)) {
                echo "<b style='color: red'>$error</b>";
            }
        ?>
        <form action="" method="post">
            <div>
                <label for="">Email</label> <br>
                <input type="email" name="email">
            </div>
            <div>
                <label for="">Contraseña</label> <br>
                <input type="password" name="password">
            </div>
            <div>
                <br>
                <button type="submit">Iniciar sesión</button>
            </div>
        </form>
    </body>
</html>