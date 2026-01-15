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
    <title>Realizar pedidos</title>
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

    <h1>Realizar pedidos</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        
        <fieldset>
            <legend>Productos</legend>
            <select name="productCode">
                <?php mostrar_productos() ?>
            </select>

            <p>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad">
            </p>

            <button type="submit" name="agregar">Agregar al carrito</button>
        </fieldset>
    </form>

    <form method="post">
        <fieldset>
            <legend>Comprar</legend>
            <p>
                <label for="checkNumber">Número de pago:</label>
                <input type="text" name="checkNumber" id="checkNumber">
            </p>

            <p>
                <label for="comments">Comentarios:</label>
                <input type="text" name="comments" id="comments">
            </p>

            <button type="submit" name="comprar" value="comprar">Comprar</button>
            <button type="reset">Limpiar</button>
        </fieldset>
    </form>
    
</body>
</html>

<?php 
    // Agregar producto al carrito

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {

        $productCode = test_input($_POST['productCode']);
        $cantidad = test_input($_POST['cantidad']);

        agregar_producto_carrito($productCode, $cantidad);
        mostrar_carrito();
    }

    // Mostrar carrito

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comprar'])) {
        
        $comments = test_input($_POST['comments']);

        realizar_orden($_SESSION['user'], $comments);
    }
?>