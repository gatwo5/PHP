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

        <h1>Consulta de Compras</h1>
        <h3>Bienvenido <?php echo $_SESSION['usuario'] ?></h3>
        
        <p>Fecha desde:</p>

        <input type="date" name="fecha_desde">

        <p>Fecha hasta:</p>

        <input type="date" name="fecha_hasta">

        <br><br>

        <button type="submit" name="consultar">Consultar</button>
        <button type="reset">Borrar</button>

        <br><br>

        <a href="compro.php">Comprar productos</a><br>
    </form>

</body>
</html>

<?php 

    $nif = $_SESSION['nif'];
    $fecha_desde = $fecha_hasta = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar'])) {

        $fecha_desde = test_input($_POST['fecha_desde']);
        $fecha_hasta = test_input($_POST['fecha_hasta']);

        mostrar_info_compra($nif , $fecha_desde , $fecha_hasta);
    }

    function mostrar_info_compra($nif , $fecha_desde , $fecha_hasta) {

        $total_todas_compras = 0;

        try {
            $conn = conexion();

            $stmt = $conn -> prepare(
                "SELECT c.id_producto, sum(c.unidades), p.precio, p.nombre
                        FROM compra c, producto p
                        WHERE c.nif = :nif AND c.fecha_compra > :fecha_desde AND c.fecha_compra < :fecha_hasta AND c.id_producto = p.id_producto
                        GROUP BY c.id_producto"
            );

            $stmt -> bindParam(':nif', $nif);
            $stmt -> bindParam(':fecha_desde', $fecha_desde);
            $stmt -> bindParam(':fecha_hasta', $fecha_hasta);

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $productos_comprados = $stmt -> fetchAll();

            foreach ($productos_comprados as $productos) {
                $id_producto = $productos['id_producto'];
                $unidades = $productos['sum(c.unidades)'];
                $precio = $productos['precio'];
                $nombre = $productos['nombre'];
                $total_compra_actual = $unidades * $precio;
                $total_todas_compras += $total_compra_actual;

                echo '<br>';
                echo 'Producto: ' . $id_producto . '<br>';
                echo 'Nombre: ' . $nombre . '<br>';
                echo 'Unidades: ' . $unidades . '<br>';
                echo 'Precio compra: ' . $total_compra_actual . '<br>';
            }

            echo '<br><br>Total compras: ' . $total_todas_compras;
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
    }
?>