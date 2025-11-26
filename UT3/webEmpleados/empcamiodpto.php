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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <h1>Cambiar departamento</h1>

        <p>DNI:</p>
        <select name="dni">
            <?php mostrar_empleados(); ?>
        </select>

        <p>Nuevo departamento:</p>
        <select name="cod_dpto_nuevo">
            <?php mostrar_departamentos(); ?>
        </select>
        <br><br>

        <button type="submit">Actualizar</button>
        <button type="reset">Borrar</button>

    </form>
</body>
</html>

<?php
    $dni = $cod_dpto_nuevo = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dni = test_input($_POST['dni']);
        $cod_dpto_nuevo = test_input($_POST['cod_dpto_nuevo']);

        cambiar_departamento($dni, $cod_dpto_nuevo);
    }

    function cambiar_departamento($dni, $cod_dpto_nuevo) {

        try {
            $conn = conexion();
            $conn -> beginTransaction();

            // Actualizar fecha_fin del departamento antiguo

            $stmt = $conn -> prepare(
                "UPDATE emple_depart
                        SET fecha_fin = curdate()
                        WHERE fecha_fin is null AND dni = :dni" 
            );

            $stmt->bindParam(':dni', $dni);

            $stmt -> execute();

            // Insertar empleado en el nuevo departamento

            $stmt = $conn -> prepare(
                "INSERT INTO emple_depart (dni, cod_dpto, fecha_ini, fecha_fin)
                    VALUES (:dni, :cod_dpto, curdate(), null)"
            );

            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':cod_dpto', $cod_dpto_nuevo);

            $stmt -> execute();

            $conn -> commit();

            echo 'Empleado cambiado con éxito';
        }

        catch (PDOException $e) {
            $errores = $e -> errorInfo;
            $codigo_error = $errores[1];

            if ($codigo_error == 1062) {
                echo 'Duplicación de primary keys';
            }

            $conn -> rollBack();
        }

        $conn = null;
    }
?>