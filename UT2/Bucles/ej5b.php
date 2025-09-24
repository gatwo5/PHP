<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla multiplicar con TD</title>

    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

</head>
<body>
    <?php

        $num = "8";

        echo "<table>";

        for ($i=1; $i <= 10; $i++) { 
            echo "<tr>" . "<td>" . $num . " X " . $i . "</td>" . " <td> " . ($num*$i) . "</td>" .  "</tr>";
        }

        echo "<table>"
    ?>
</body>
</html>