<?php 
    include 'fu_globales.php';

    session_start();

    if (isset($_POST['cerrar_sesion'])) {
        cerrar_sesion();
    }

    if (!isset($_SESSION['user'])) {
        header("Location: pe_login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos vendidos entre dos fechas</title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="post">
        <input type="submit" name="cerrar_sesion" value="cerrar sesion">
    </form>

    <h1>Consultar ventas entre dos fechas</h1>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend>Consultar ventas</legend>
            
            <p>
                <label for="fecha_inicio">Fecha inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio">
            </p>

            <p>
                <label for="fecha_fin">Fecha fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin">
            </p>

            <button type="submit">Consultar ventas</button>
        </fieldset>
    </form>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fecha_inicio = test_input($_POST['fecha_inicio']);
        $fecha_fin = test_input($_POST['fecha_fin']);

        consultar_ventas_entre_dos_fechas($fecha_inicio, $fecha_fin);
    }
?>