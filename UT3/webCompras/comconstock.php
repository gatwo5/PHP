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
    <h1>Consulta de stock</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <select name="id_producto">

        <?php  mostrar_productos(); ?>

    </select>

    <br><br>
    <button type="submit">Consultar</button>
    <br><br>

    </form>
</body>
</html>

<?php 
    $id_producto = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_producto = test_input($_POST['id_producto']);

        consultar_stock($id_producto);
    }

    //consultar_stock()

    function consultar_stock($id_producto) {

        try {
            $conn = conexion();
            $stmt = $conn -> prepare("SELECT num_almacen, cantidad FROM almacena WHERE id_producto = :id_producto ORDER BY num_almacen ASC");
            $stmt -> bindParam(':id_producto', $id_producto);

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $productos = $stmt -> fetchAll();

            // Imprimir resultados

            if(!$productos) {
                echo 'No se ha encontrado stock';
            }

            else {
                echo 'Producto ' . $id_producto . ':<br>';

                foreach ($productos as $producto) {
                    echo 'Almacen num ' . $producto['num_almacen'] . ' | Cantidad: ' . $producto['cantidad'] . '<br>';
                }
            }
        }

        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>