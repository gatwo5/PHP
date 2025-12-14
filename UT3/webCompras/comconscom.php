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

        <h1>Consulta de Compras</h1>

        <p>Cliente:</p>

        <select name="nif">
            <?php mostrar_clientes() ?>
        </select>

        <p>Fecha desde:</p>

        <input type="date" name="fecha_desde">

        <p>Fecha hasta:</p>

        <input type="date" name="fecha_hasta">

        <br><br>

        <button type="submit">Consultar</button>
        <button type="reset">Borrar</button>
    </form>

</body>
</html>

<?php 

    $nif = $fecha_desde = $fecha_hasta = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nif = test_input($_POST['nif']);
        $fecha_desde = test_input($_POST['fecha_desde']);
        $fecha_hasta = test_input($_POST['fecha_hasta']);

        mostrar_info_compra($nif , $fecha_desde , $fecha_hasta);
    }

    function mostrar_info_compra($nif , $fecha_desde , $fecha_hasta) {

    }
?>