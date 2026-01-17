<?php 
    include 'fu_globales.php';

    session_start();

    if (isset($_POST['cerrar_sesion'])) {
        cerrar_sesion();
    }

    if (!isset($_SESSION['user'])) {
        header("Location: pe_login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock total de todos los productos de una determinada linea de producto</title>
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

    <h1>Consultar línea según stock</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend>Linea productos</legend>
            <select name="productLine">
                <?php mostrar_linea_productos() ?>
            </select>

            <button type="submit">Consultar stock</button>
        </fieldset>
    </form>
</body>
</html>

<?php
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productLine = test_input($_POST['productLine']);

        mostrar_productos_segun_linea($productLine);
    }
?>