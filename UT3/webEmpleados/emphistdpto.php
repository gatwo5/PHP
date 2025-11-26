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

        <h1>Histórico empleados</h1>

        <p>Departamento:</p>
        <select name="cod_dpto">
            <?php mostrar_departamentos(); ?>
        </select>
        <br><br>

        <button type="submit">Mostrar</button>
        <button type="reset">Borrar</button>

        <br><br>
    </form>
</body>
</html>

<?php

    $cod_dpto = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cod_dpto = test_input($_POST['cod_dpto']);

        mostrar_historico_empleados_departamento($cod_dpto);
    }

    function mostrar_historico_empleados_departamento($cod_dpto) {
        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                'SELECT *
                        FROM emple_depart
                        WHERE cod_dpto = :cod_dpto AND fecha_fin IS NOT null
                        ORDER BY dni, fecha_ini, fecha_fin'
            );

            $stmt -> bindParam(':cod_dpto', $cod_dpto);

            $stmt -> execute();
            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $empleados= $stmt ->fetchAll();


            // Imprimir

            foreach ($empleados as $empleado) {
                echo 'DNI: '. $empleado['dni'] .
                ' | cod_dpto: ' . $empleado['cod_dpto'] .
                ' | fecha_ini: ' . $empleado['fecha_ini'] .
                ' | fecha_fin: ' . $empleado['fecha_fin'] . '<br><br>';
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            echo "Código de error: " . $e->getCode() . "<br>";
            $conn -> rollBack();
        }
    }
?>