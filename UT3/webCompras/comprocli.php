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

        <button type="submit" name="agregar">Agregar al carrito</button>

        <br><br>

        <a href="comconscom.php">Consulta de compras</a>
    </form>

    <br>
    <form method="post">
        <input type="submit" name="comprar" value="comprar">
    </form>
</body>
</html>

<?php 

    // Carrito

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {

        $id_producto = test_input($_POST['id_producto']);
        $cantidad = test_input($_POST['cantidad']);

        agregar_productos_carrito($id_producto, $cantidad);
        mostrar_carrito();
    }

    // Comprar

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comprar'])) {
        
        $nif = $_SESSION['nif'];

        foreach ($_SESSION['productos'] as $id_producto => $cantidad) {

            $hay_stock = buscar_stock($id_producto, $cantidad);

            if ($hay_stock) {
                comprar_producto($nif, $id_producto, $cantidad);
                actualizar_stock($id_producto, $cantidad);

                echo 'Se han comprado ' . $cantidad . ' unidades del producto ' . $id_producto . '<br>';
            }

            else {
                echo '<br>No hay stock del producto ' . $id_producto;
            }

        }
    }

    function agregar_productos_carrito($id_producto, $cantidad) {
        if(!isset($_SESSION['productos'])) {
            $_SESSION['productos'] = [$id_producto => $cantidad];
        }

        elseif (!isset($_SESSION['productos'][$id_producto])){
            $_SESSION['productos'][$id_producto] = $cantidad;
        }

        else {
            $_SESSION['productos'][$id_producto] += $cantidad;
        }
    }

    function mostrar_carrito() {
        echo '<h4> Carrito </h4>';
        try {
            $conn = conexion();
            
            foreach ($_SESSION['productos'] as $key => $value) {

                $stmt = $conn -> prepare(
                "SELECT nombre
                 FROM producto
                 WHERE id_producto = :id_producto"
                );

                $stmt -> bindParam(':id_producto', $key);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $producto_encontrado = $stmt -> fetchAll();

                echo $producto_encontrado[0]['nombre'] . ' x' . $value . '<br>';
            }
            
            // Imprimir
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
    }
?>