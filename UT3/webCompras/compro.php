<?php include 'funciones.php' ?>

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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h1>Compra de Productos</h1>

        <p>Cliente:</p>

        <select name="nif">
            <?php mostrar_clientes() ?>
        </select>

        <p>Producto:</p>

        <select name="id_producto">
            <?php mostrar_productos() ?>
        </select>

        <p>Cantidad:</p>
        <input type="number">

        <br><br>

        <button type="submit">Comprar</button>
    </form>

</body>
</html>

<?php 

    $nif = $id_producto = $cantidad = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nif = test_input($_POST['nif']);
        $id_producto = test_input($_POST['id_producto']);
        $cantidad = test_input($_POST['cantidad']);

        
    }

    // Buscar stock

    function buscar_stock($id_producto, $cantidad) {
        $conn = conexion();
        $stmt = $conn -> prepare(
            "SELECT num_almacen, id_producto
                    FROM almacena
                    WHERE cantidad > :cantidad_comprar AND 
                        id_producto = :id_producto"
        );
    }

    // Comprar producto

    function comprar_producto($nif, $id_producto, $cantidad) {

    }
?>