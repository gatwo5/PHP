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
    <title>Consultar pedidos</title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <a href="pe_inicio.php">Inicio</a><br><br>

    <form method="post">
        <input type="submit" name="cerrar_sesion" value="cerrar sesion">
    </form>

    <h1>Consultar productos</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend>Consultar productos</legend>

            <button type="submit">Consultar</button>
        </fieldset>
    </form>
</body>
</html>

<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customerNumber = $_SESSION['user'];

        consultar_pedidos($customerNumber);
    } 
?>