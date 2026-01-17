<?php 
    include 'fu_globales.php';
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
    <h1>Consultar productos</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend>Consultar productos</legend>

            <p>
                <label for="customerNumber">Número de cliente:</label>
                <input type="number" name="customerNumber" id="customerNumber">
            </p>

            <button type="submit">Consultar</button>
        </fieldset>
    </form>
</body>
</html>

<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customerNumber = test_input($_POST['customerNumber']);

        consultar_pedidos($customerNumber);
    } 
?>