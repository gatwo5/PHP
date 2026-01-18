<?php

    include 'fu_globales.php';

    session_start();

    if (isset($_POST['cerrar_sesion'])) {
        cerrar_sesion();
    }

    if (!isset($_COOKIE['user'])) {
        header("Location: pe_login.php");
    }

    // ------------------------
    $user = unserialize($_COOKIE['user']);
    echo "Bienvendio " . $user[1];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inicio</title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="post">
        <input type="submit" name="cerrar_sesion" value="cerrar sesion">
    </form>
</body>
</html>