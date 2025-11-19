<?php include 'funciones.php'; ?>

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
    <h1>Consulta de almacenes</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <select name="num_almacen">

        <?php mostrar_almacenes(); ?>

    </select>

    <br><br>
    <button type="submit">Consultar</button><br><br>

    </form>
</body>
</html>

<?php 
    $num_almacen = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $num_almacen = test_input($_POST['num_almacen']);

        consultar_almacen($num_almacen);
    }

    function consultar_almacen($num_almacen) {
        // Buscar id_productos en el almacen

        try {
            $conn = conexion();
            $stmt = $conn -> prepare("SELECT * FROM producto p, almacena a WHERE a.num_almacen = :num_almacen AND a.id_producto = p.id_producto");
            $stmt -> bindParam(':num_almacen', $num_almacen);
            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $productos = $stmt -> fetchAll();

            if(!$productos) {
                echo 'No se han encontrado productos en el almacén ' . $num_almacen;
            }

            else {

                echo 'Almacen num ' . $num_almacen . '<br>';

                foreach ($productos as $producto) {
                    echo 'id_producto: ' . $producto['ID_PRODUCTO'] . ' | nombre: ' . $producto['NOMBRE'] . ' | precio ' . $producto['PRECIO'] . ' | id_categoria: ' . $producto['ID_CATEGORIA'] . '<br>';
                }
                
            }
        }

        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
        
    }    
?>