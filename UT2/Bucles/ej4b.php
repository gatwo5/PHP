<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJ4B - Tabla Multiplicar</title>
</head>
<body>
    
    <?php
        $num = "8";

        for ($i=1; $i <= 10; $i++) { 
            echo $num . " X " . $i . " = " . ($num*$i) . "<br>";
        }
    ?>
</body>
</html>