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

        <h1>Mostrar empleados</h1>

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

        mostrar_empleados_departamento($cod_dpto);
    }

    function mostrar_empleados_departamento($cod_dpto) {

        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                'SELECT e.dni, e.nombre, e.apellidos, e.fecha_nac, e.salario
                        FROM empleado e, emple_depart d
                        WHERE d.cod_dpto = :cod_dpto AND fecha_fin IS null AND d.dni = e.dni'
            );

            $stmt -> bindParam(':cod_dpto', $cod_dpto);

            $stmt -> execute();
            $stmt ->setFetchMode(PDO::FETCH_ASSOC);
            $empleados= $stmt ->fetchAll();


            // Imprimir

            foreach ($empleados as $empleado) {
                echo 'DNI: ' . $empleado['dni'] .
                    ' | Nombre: ' . $empleado['nombre'] .
                    ' | Apellidos: ' . $empleado['apellidos'] .
                    ' | Fecha_nac: ' . $empleado['fecha_nac'] .
                    ' | Salario: ' . $empleado['salario'] . '<br><br>';
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            echo "Código de error: " . $e->getCode() . "<br>";
            $conn -> rollBack();
        }
    }
?>