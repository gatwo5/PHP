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
    
    <h1>Insertar departamento</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <p>Nombre del departamento:</p>
    <input type="text" name="nombre_dpto"> <br><br>

    <button type="submit">Agregar</button>
    <button type="reset">Borrar</button>
    </form>
</body>
</html>

<?php

    include 'funciones.php';

    $nombre_dpto = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre_dpto = test_input($_POST['nombre_dpto']);

        crearDepartamento($nombre_dpto);
    }

    // Crear departamento

    function crearDepartamento($nombre_dpto) {

        try {

            // Extraer el último ID
            
            $conn = conexion();
            $stmt = $conn -> prepare("SELECT max(cod_dpto) FROM departamento");
            $stmt -> execute();
            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $max_cod_dpto = $stmt ->fetchAll();

            var_dump($max_cod_dpto);

            if ($max_cod_dpto[0]['max(cod_dpto)'] == null) {
                $cod_dpto = 'D001';
                echo 'vacio';
            }

            else {
                $cod_dpto =  $max_cod_dpto[0]['max(cod_dpto)'];
                $cod_dpto++;
                
                echo 'no vacio';
            }

            // Preparar el insert

            $conn -> beginTransaction();

            $stmt = $conn -> prepare(
        "INSERT INTO departamento (cod_dpto, nombre_dpto) 
                VALUES (:cod_dpto, :nombre_dpto)"
            );

            $stmt -> bindParam(':cod_dpto', $cod_dpto);
            $stmt -> bindParam(':nombre_dpto', $nombre_dpto);

            $stmt -> execute();

            $conn ->commit();

            echo "<br>Departamento " . $nombre_dpto . " con código " . $cod_dpto . " insertado correctamente";
        }

        catch (PDOException $e) {

            echo "Error: " . $e->getMessage() . "<br>";
            echo "Código de error: " . $e->getCode() . "<br>";
            $conn -> rollBack();
        }

        $conn = null;
    }
?>