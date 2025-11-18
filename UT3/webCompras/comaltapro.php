<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="./comaltapro2.php" method="post">
        
        <p>Nombre del producto: </p>
        <input type="text" name="nombre_producto">

        <p>Precio del producto:</p>
        <input type="number" name="precio_producto">

        <p>Categoría del producto:</p>
        
        <select name = 'categoria_producto'>

        <!-- Introducir las opciones de nombre categoria-->

        <?php 
            $servername = "localhost";
            $username = "root";
            $password = "rootroot";
            $dbname="comprasWeb";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

