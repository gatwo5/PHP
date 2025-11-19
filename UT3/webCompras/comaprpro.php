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
    <?php include 'funciones.php' ?>
</head>
<body>
    <h1>Aprovisionar Productos</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <p>Nombre del producto:</p>

    <select name="id_producto">

    <!--Buscar los nombres de los productos-->

        <?php mostrar_productos();?>

    </select>

    <p>Numero de almacen:</p>

    <select name="num_almacen">

    <!--Buscar número de los almacenes-->

        <?php mostrar_almacenes();?>

    </select>

    <p>Cantidad:</p>
    <input type="number" name="cantidad">

    <br><br>
    <button type="submit">Insertar</button>
    <button type="reset">Borrar</button>
    </form>

</body>
</html>

<?php

    $id_producto = $num_almacen = $cantidad = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_producto = test_input($_POST['id_producto']);
        $num_almacen = test_input($_POST['num_almacen']);
        $cantidad = test_input($_POST['cantidad']);

        aprovisionar_productos($id_producto , $num_almacen , $cantidad);
    }

    // aprovisionar_productos()

    function aprovisionar_productos($id_producto , $num_almacen , $cantidad) {

        try {
            $conn = conexion();
            $stmt = $conn -> prepare("SELECT cantidad FROM almacena WHERE id_producto = :id_producto AND num_almacen = :num_almacen");
            $stmt -> bindParam(':id_producto', $id_producto);
            $stmt -> bindParam(':num_almacen', $num_almacen);
            $stmt -> execute();
            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $stock_inicial = $stmt ->fetchAll();   

            // En caso de no existir, insertar nuevo registro

            if(empty($stock_inicial)) {
                $stmt = $conn -> prepare("INSERT INTO almacena (num_almacen, id_producto, cantidad) VALUES(:num_almacen,:id_producto,:cantidad)");
                $stmt -> bindParam(':num_almacen', $num_almacen);
                $stmt -> bindParam(':id_producto', $id_producto);
                $stmt -> bindParam(':cantidad', $cantidad);
            }

            // En caso de existir el registro, actualizar las cantidades
            
            else {
                $cantidad += $stock_inicial[0]['cantidad'];
                $stmt = $conn -> prepare("UPDATE almacena SET cantidad=$cantidad WHERE id_producto = :id_producto AND num_almacen = :num_almacen");
                $stmt -> bindParam(':id_producto', $id_producto);
                $stmt -> bindParam(':num_almacen', $num_almacen);
            }
            

            $stmt -> execute();

            echo '<br>Ahora hay ' . $cantidad . ' producto/s de ID ' . $id_producto . ' en el almacen ' . $num_almacen;
        }

        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>