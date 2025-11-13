<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        
        <p>Nombre de la categoria: </p>
        <input type="text" name="nombre_categoria">

        <br>
        <button type="submit">Agregar</button><bsr>
        <button type="reset">Borrar</button>
    </form>
</body>
</html>

<?php 
    $nombre_categoria = "";

    //Servidor

    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname="comprasWeb";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_categoria = test_input($_POST['nombre_categoria']);

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn -> prepare("SELECT ID_CATEGORIA FROM categoria");
            $stmt -> execute();

            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $resultado = $stmt ->fetchAll();

            // Preparar para insertar

            $stmt = $conn -> prepare("INSERT INTO categoria (id_categoria, nombre) VALUES (:id_categoria,:nombre)");
            $stmt -> bindParam(':id_categoria', $id_categoria);
            $stmt -> bindParam(':nombre', $nombre_categoria);

                        

            if (empty($resultado)) {
                $id_categoria = 'C-001';
            }

            // Buscar Ultimo_ID

            else {
                $ultimo_id = substr(end($resultado[array_key_last($resultado)]),2);
                $ultimo_id += 1;
                $ultimo_id = sprintf('%03d',$ultimo_id);


                $id_categoria = 'C-' . $ultimo_id;
            }

            $stmt -> execute();

            echo 'Categoria ' . $nombre_categoria . ' insertada';
        }

        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // test_input()
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>