<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Login Web Pedidos</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <p>
                <label for="user">Usuario:</label>
                <input type="text" name="user" id="user">
            </p>

            <p>
                <label for="password">Password:</label>
                <input type="text" name="password" id="password">
            </p>

            <button type="submit">Iniciar sesión</button>
            <button type="reset">Limpiar</button>
        </fieldset>
    </form>
</body>
</html>

<?php

include 'fu_globales.php';
    
$user = $password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = test_input($_POST['user']);
    $password = test_input($_POST['password']);

    // Comprobar credenciales

    $inicia_sesion = comprobar_credenciales($user, $password);

    if ($inicia_sesion) {
        setcookie("user", serialize(array($user,$password)), time() + 3600, '/');
        header("Location: pe_inicio.php");
    } else {
        echo "Usuario o contraseña incorrectos";
    }
}