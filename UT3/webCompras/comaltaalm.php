<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        
        <p>Localidad almacén: </p>
        <input type="text" name="localidad">

        <br>
        <button type="submit">Agregar</button>
        <button type="reset">Borrar</button>
    </form>
</body>
</html>

<?php 
    include 'funciones.php';

    $localidad = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $localidad = test_input($_POST['localidad']);

        insertar_almacen($localidad);
    }

    // insertar_almacen($localidad). Recibe la localidad e inserta el almacen, calculando su ID correspondiente

    function insertar_almacen($localidad) {
        try {
            // Buscar el último ID

            $conn = conexion();
            $stmt = $conn -> prepare("SELECT max(num_almacen) FROM almacen");
            $stmt -> execute();
            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $max_id_almacen = $stmt ->fetchAll();

            $max_id_almacen = $max_id_almacen[0]['max(num_almacen)'];
            $max_id_almacen++;

            // Preparar para insertar

            $stmt = $conn -> prepare("INSERT INTO almacen (num_almacen, localidad) VALUES (:num_almacen,:localidad)");
            $stmt -> bindParam(':num_almacen', $max_id_almacen);
            $stmt -> bindParam(':localidad', $localidad);

            // Insertar

            $stmt -> execute();

            echo 'Almacen número ' . $max_id_almacen . ' creado en ' . $localidad;
        }

        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>