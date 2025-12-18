<?php 

include 'funciones.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        
        <p>Nombre del producto: </p>
        <input type="text" name="nombre_producto">

        <p>Precio del producto:</p>
        <input type="number" name="precio_producto">

        <p>Categoría del producto:</p>
        
        <select name = 'categoria_producto'>

        <!-- Introducir las opciones de nombre categoria-->

        <?php 
            
            $conn = conexion();
            $stmt = $conn -> prepare("SELECT nombre FROM categoria");
            $stmt -> execute();

            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $resultado = $stmt ->fetchAll();      
            
            
            foreach ($resultado as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    echo '<option value = "' . $value2 . '">' . $value2 . '</option>';
                }
            }

        ?>

        </select>

        <br><br>
        <button type="submit">Agregar</button><bsr>
        <button type="reset">Borrar</button>
    </form>
</body>
</html>

<?php 

    $nombre_producto = $precio_producto = $categoria_producto = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre_producto = test_input($_POST['nombre_producto']);
        $precio_producto = test_input($_POST['precio_producto']);
        $categoria_producto = test_input($_POST['categoria_producto']);

        try {

            // Buscar la ID de la categoria segun el nombre

            $stmt = $conn -> prepare("SELECT id_categoria FROM categoria WHERE nombre = '$categoria_producto'");
            $stmt -> execute();
            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $id_categoria = $stmt ->fetchAll(); 

            $id_categoria = $id_categoria[0]['id_categoria'];

            // Buscar la ID de los productos 

            $stmt = $conn -> prepare("SELECT id_producto FROM producto");
            $stmt -> execute();
            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $id_productos = $stmt ->fetchAll(); 

            // Preparar para insertar

            $stmt = $conn -> prepare("INSERT INTO producto (id_producto, nombre, precio, id_categoria) VALUES (:id_producto,:nombre,:precio,:id_categoria)");
            $stmt -> bindParam(':id_producto', $id_producto);
            $stmt -> bindParam(':nombre', $nombre_producto);
            $stmt -> bindParam(':precio', $precio_producto);
            $stmt -> bindParam(':id_categoria', $id_categoria);

            // Si está vacío

            if (empty($id_productos)) {
                $id_producto = 'P0001';
            }

            // Buscar el últim ID en caso contrario

            else {
                $id_producto = substr(end($id_productos[array_key_last($id_productos)]),1);
                $id_producto++;
                $id_producto =  sprintf('%04d',$id_producto);

                $id_producto = 'P' . $id_producto;
            }

            $stmt -> execute();

            echo 'Producto ' . $nombre_producto . ' insertado';
        }

        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
