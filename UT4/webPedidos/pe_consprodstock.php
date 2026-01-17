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
    <title>Consultar stock</title>
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

    <h1>Consultar stock</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
         <fieldset>
            <legend>Productos</legend>
            <select name="productCode">
                <?php mostrar_productos() ?>
            </select>

            <button type="submit">Consultar stock</button>
        </fieldset>
    </form>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productCode = test_input($_POST['productCode']);

        consultar_stock($productCode);
    }
?>