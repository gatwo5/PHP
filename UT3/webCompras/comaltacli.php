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

        <h1>Alta de clientes</h1>

        <p>NIF:</p>
        <input type="text" name="nif">

        <p>Nombre:</p>
        <input type="text" name="nombre">

        <p>Apellido:</p>
        <input type="text" name="apellido">

        <p>CP:</p>
        <input type="number" name="cp">

        <p>Direccion:</p>
        <input type="text" name="direccion">

        <p>Ciudad:</p>
        <input type="text" name="ciudad">

        <br><br>

        <button type="submit">Crear</button>
        <button type="reset">Borrar</button>

        <br><br>
    </form>

</body>
</html>

<?php

    $nif = $nombre = $apellido = $cp = $direccion = $ciudad = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $nif = test_input($_POST['nif']);
        $nombre = test_input($_POST['nombre']);
        $apellido = test_input($_POST['apellido']);
        $cp = test_input($_POST['cp']);
        $direccion = test_input($_POST['direccion']);
        $ciudad = test_input($_POST['ciudad']);

        if (comprobar_nif($nif)) {
            crear_cliente($nif, $nombre, $apellido, $cp, $direccion, $ciudad);
        }

        else {
            echo 'Formato del NIF no válido';
        }
    }

    // comprobar_nif
    function comprobar_nif($nif) {
        $valido = false;

        if (preg_match('/^[0-9]{8}[A-Z]$/',$nif)) {
            $valido = true;
        }

        return $valido;
    }

    // Crear cliente
    function crear_cliente($nif, $nombre, $apellido, $cp, $direccion, $ciudad) {
        
        try {
            $conn = conexion();
            $conn -> beginTransaction();

            // Insertar cliente

            $stmt = $conn -> prepare(
                "INSERT INTO cliente (nif, nombre, apellido, cp, direccion, ciudad)
                 VALUES (:nif, :nombre, :apellido, :cp, :direccion, :ciudad)"
            );

            $stmt -> bindParam(':nif', $nif);
            $stmt -> bindParam(':nombre', $nombre);
            $stmt -> bindParam(':apellido', $apellido);
            $stmt -> bindParam(':cp', $cp);
            $stmt -> bindParam(':direccion', $direccion);
            $stmt -> bindParam(':ciudad', $ciudad);

            $stmt -> execute();

            $conn -> commit();

            echo 'Cliente creado con éxito';
        }

        catch (PDOException $e) {
            $errores = $e -> errorInfo;
            $codigo_error = $errores[1];

            if ($codigo_error == 1062) {
                echo 'El NIF ya existe';
            }

            $conn -> rollBack();
        }

        $conn = null;
    }
?>