<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        td {
            text-align: center;
        }

    </style>
</head>
<body>
    <?php
        $matriz_a;

        //Matriz A
        echo "<h2>Matriz A</h2><table>";

        for ($i=0; $i < 3; $i++) { 
            echo "<tr>";
            for ($j=0; $j < 4; $j++) { 
                $matriz_a[$i][$j] = rand(0,10);
                echo "<td>" . $matriz_a[$i][$j] . "</td>";
            }
            echo "</tr>";
        }

        //Matriz traspuesta
        echo "</table><h2>Traspuesta de A</h2><table>";

        for ($i=0; $i < 4; $i++) { 
            echo "<tr>";
            for ($j=0; $j < 3; $j++) { 
                echo "<td>" . $matriz_a[$j][$i] . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>"
    ?>
</body>
</html>