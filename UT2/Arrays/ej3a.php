<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
    </style>
</head>
<body>

    <?php
        $array_binarios = array();

        echo "<table> <tr> <td> Indice </td> <td> Binario </td> <td> Octal </td>";
        
        for ($i=0; $i <= 20; $i++) { 
            $array_binarios[$i] = decbin($i);

            echo "<tr>";

            echo "<td> " . $i . " </td> <td> " . $array_binarios[$i] . " </td> <td> " . decoct($i) . " </td>";

            echo "</tr>";
        }

        echo "</table>";
    ?>

</body>
</html>