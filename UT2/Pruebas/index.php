<?php declare( strict_types = 1 ); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 2</title>
</head>

<body>
    <h1>Ejercicio 2</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
        <label for="numero">Introduce un número entero:</label>
        <input type="number" name="numero" required>
        <input type="hidden" name="numeros" value="<?php echo $numeros; ?>">
        <input type="submit" value="Enviar" name="enviar">
    </form>
</body>

</html>

<?php
    
?>