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
    <h1>Insertar empleados</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <p>Departamento:</p>

    <select name="cod_dpto">
        <?php mostrar_departamentos(); ?>
    </select>
    
    <p>DNI:</p>
    <input type="text" name="dni">

    <p>Nombre:</p>
    <input type="text" name="nombre">

    <p>Apellidos:</p>
    <input type="text" name="apellidos">

    <p>Fecha de nacimiento:</p>
    <input type="date" name="fecha_nac">

    <p>Salario:</p>
    <input type="number" name="salario">
    
    <br><br>

    <button type="submit">Agregar</button>
    <button type="reset">Borrar</button>

    </form>
</body>
</html>

<?php 

    $dni = $nombre = $apellidos = $fecha_nac = $salario = $cod_dpto = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dni = test_input($_POST['dni']);
        $nombre = test_input($_POST['nombre']);
        $apellidos = test_input($_POST['apellidos']);
        $fecha_nac = test_input($_POST['fecha_nac']);
        $salario = test_input($_POST['salario']);
        $cod_dpto = test_input($_POST['cod_dpto']);

        if(crear_empleado($dni, $nombre, $apellidos, $fecha_nac, $salario))
            insertar_emple_dpto($dni, $cod_dpto);

    }


    // crear_empleado($dni, $nombre, $apellidos, $fecha_nac, $salario)
    function crear_empleado($dni, $nombre, $apellidos, $fecha_nac, $salario) {
        $empleado_insertado = false;

        try {

            $conn = conexion();

            $conn -> beginTransaction();

            // Preparar insert
            $stmt = $conn -> prepare(
                "INSERT INTO empleado (dni, nombre, apellidos, fecha_nac, salario)
                VALUES (:dni, :nombre, :apellidos, :fecha_nac, :salario)"
            );

            // bindParam

            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':fecha_nac', $fecha_nac);
            $stmt->bindParam(':salario', $salario);

            $stmt -> execute();

            $conn -> commit();

            $empleado_insertado = true;
            echo '<br> EMPLEADO INSERTADO';
        }

        catch (PDOException $e) {
            $errores = $e -> errorInfo;
            $codigo_error = $errores[1];

            if ($codigo_error == 1062) {
                echo 'Tabla Empleados: El DNI ya existe';
            }

            $conn -> rollBack();
        }

        $conn = null;

        return $empleado_insertado;
    }

    // insertar_emple_dpto($dni, $cod_dpto)
    function insertar_emple_dpto($dni, $cod_dpto) {
        
        $fecha_ini = date('Y-m-d');
        $fecha_fin = null;

        try {
            $conn = conexion();

            $conn -> beginTransaction();

            // Preparar insert
            $stmt = $conn -> prepare(
                "INSERT INTO emple_depart (dni, cod_dpto, fecha_ini, fecha_fin)
                    VALUES (:dni, :cod_dpto, :fecha_ini, :fecha_fin)"
            );

            // Bindparam

            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':cod_dpto', $cod_dpto);
            $stmt->bindParam(':fecha_ini', $fecha_ini);
            $stmt->bindParam(':fecha_fin', $fecha_fin);

            $stmt -> execute();

            $conn -> commit();
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            echo "Código de error: " . $e->getCode() . "<br>";
            $conn -> rollBack();
        }

        $conn = null;
    }
?>