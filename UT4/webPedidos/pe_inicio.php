<?php

    include 'fu_globales.php';

    session_start();

    if (isset($_POST['cerrar_sesion'])) {
        cerrar_sesion();
    }

    if (!isset($_SESSION['user'])) {
        header("Location: pe_login.php");
    }

    // ------------------------

    echo "Bienvendio " . $_SESSION['user'];
    
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

    <a href="pe_altaped.php">Realizar pedidos</a><br>
    <a href="pe_consped.php">Consultar pedidos</a><br>
    <a href="pe_consprodstock.php">Consultar pedidos</a><br>
    <a href="pe_constock.php">Consultar pedidos de una línea de pedidos</a><br>
    <a href="pe_topprod.php">Productos vendidos entre dos fechas</a><br>
</body>
</html>