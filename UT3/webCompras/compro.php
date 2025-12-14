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
        <input type="number" name="cantidad">

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

        // ---------

        $hay_stock = buscar_stock($id_producto, $cantidad);

        if ($hay_stock) {
            comprar_producto($nif, $id_producto, $cantidad);
            actualizar_stock($id_producto, $cantidad);

            echo 'Producto comprado';
        }

        else {
            echo '<br>No hay stock del producto';
        }
    }

    // Buscar stock

    function buscar_stock($id_producto, $cantidad) {
        $hay_stock = false;

        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                "SELECT sum(cantidad)
                        FROM almacena
                        WHERE id_producto = :id_producto"
            );

            $stmt -> bindParam(':id_producto', $id_producto);

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $productos_encontrados = $stmt -> fetchAll();

            if ($productos_encontrados[0]['sum(cantidad)'] >= $cantidad) {
                $hay_stock = true;
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;

        return $hay_stock;
    }

    // Comprar producto

    function comprar_producto($nif, $id_producto, $cantidad) {

        try {
            $conn = conexion();
            $conn -> beginTransaction();

            $stmt = $conn -> prepare(
                "INSERT INTO compra (nif, id_producto, fecha_compra, unidades)
                 VALUES (:nif, :id_producto, curdate(), :unidades)"
            );

            $stmt -> bindParam(':nif', $nif);
            $stmt -> bindParam(':id_producto', $id_producto);
            $stmt -> bindParam(':unidades', $cantidad);

            $stmt -> execute();

            $conn -> commit();
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $conn -> rollBack();
        }

        $conn = null;
    }

    // Actualizar Stock

    function actualizar_stock($id_producto, $cantidad) {
        try {
            $conn = conexion();
            $conn -> beginTransaction();

            while ($cantidad > 0) {

                $stmt = $conn -> prepare(
                    "SELECT num_almacen, cantidad
                            FROM almacena
                            WHERE id_producto = :id_producto AND cantidad = (SELECT max(cantidad) FROM almacena WHERE id_producto = :id_producto)"
                );

                $stmt -> bindParam(':id_producto', $id_producto);
                $stmt -> execute();
                $stmt ->setFetchMode(PDO::FETCH_ASSOC);

                $max_cantidad = $stmt ->fetchAll();   

                $num_almacen = $max_cantidad[0]['num_almacen'];
                $cantidad_almacen = $max_cantidad[0]['cantidad'];
                
                $cantidad_almacen -= $cantidad;
                $cantidad -= $max_cantidad[0]['cantidad'];

                if ($cantidad_almacen < 0) {
                    $cantidad_almacen = 0;
                }

                $stmt = $conn -> prepare("UPDATE almacena SET cantidad = :cantidad_almacen WHERE id_producto = :id_producto AND num_almacen = :num_almacen");
                $stmt -> bindParam(':cantidad_almacen', $cantidad_almacen);
                $stmt -> bindParam(':id_producto', $id_producto);
                $stmt -> bindParam(':num_almacen', $num_almacen);

                $stmt -> execute();
            }

            $conn -> commit();
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $conn -> rollBack();
        }

        $conn = null;
    }
?>