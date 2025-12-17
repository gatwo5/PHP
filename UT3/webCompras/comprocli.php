<?php
include 'funciones.php';
session_start();

if (isset($_POST['cerrar_sesion'])) {
    cerrar_sesion();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: comlogincli.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h1>Compra de Productos</h1>

        <h3>Bienvenido <?php echo $_SESSION['usuario'] ?></h3>
        <p>Producto:</p>

        <select name="id_producto">
            <?php mostrar_productos() ?>
        </select>

        <p>Cantidad:</p>
        <input type="number" name="cantidad">

        <br><br>

        <button type="submit" name="comprar">Comprar</button>

        <br><br>

        <a href="comconscom.php">Consulta de compras</a>
    </form>

</body>
</html>

<?php 

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comprar'])) {

        $id_producto = test_input($_POST['id_producto']);
        $cantidad = test_input($_POST['cantidad']);

        if(!isset($_SESSION['productos'])) {
            $_SESSION['productos'] = [$id_producto => $cantidad];
        }

        else {
            $_SESSION['productos'][$id_producto] += $cantidad;
        }

        var_dump($_SESSION['productos']);
    }
?>