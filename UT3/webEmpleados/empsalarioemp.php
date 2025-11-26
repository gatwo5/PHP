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

        <h1>Modificar salario</h1>

        <p>DNI:</p>
        <select name="dni">
            <?php mostrar_empleados(); ?>
        </select>

        <p>Porcentaje (+/-)</p>
        <input type="number" name="porcentaje_modificacion_salario">
        <br><br>

        <button type="submit">Actualizar</button>
        <button type="reset">Borrar</button>

    </form>
</body>
</html>

<?php
    $dni = $porcentaje_modificacion_salario = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dni = test_input($_POST['dni']);
        $porcentaje_modificacion_salario = test_input($_POST['porcentaje_modificacion_salario']);

        modificar_salario($dni, $porcentaje_modificacion_salario);
    }

    function modificar_salario($dni, $porcentaje_modificacion_salario) {

        $porcentaje_modificacion_salario /= 100;

        try {
            $conn = conexion();
            $conn -> beginTransaction();

            // Actualizar salario

            $stmt = $conn -> prepare(
        "UPDATE empleado
                SET salario = salario + salario * :porcentaje
                WHERE dni = :dni"
            );

            $stmt -> bindParam('porcentaje', $porcentaje_modificacion_salario);
            $stmt -> bindParam('dni', $dni);

            $stmt -> execute();

            $conn -> commit();
            echo 'Salario actualizado con éxito';
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            echo "Código de error: " . $e->getCode() . "<br>";
            $conn -> rollBack();
        }
    }
?>