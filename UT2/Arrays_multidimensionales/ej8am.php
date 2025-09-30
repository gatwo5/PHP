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
        $matriz_b;

        //Matriz A
        echo "<h2>Matriz a)</h2><table>";

        for ($i=0; $i < 3; $i++) { 
            echo "<tr>";
            for ($j=0; $j < 3; $j++) { 
                $matriz_a[$i][$j] = rand(0,10);
                echo "<td>" . $matriz_a[$i][$j] . "</td>";
            }
            echo "</tr>";
        }

        //Matriz B
        echo "</table><h2>Matriz b)</h2><table>";

        for ($i=0; $i < 3; $i++) { 
            echo "<tr>";
            for ($j=0; $j < 3; $j++) { 
                $matriz_b[$i][$j] = rand(0,10);
                echo "<td>" . $matriz_b[$i][$j] . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

        //Suma de A y B
        echo "<h2>Suma de A y B</h2><table>";

        for ($i=0; $i < 3; $i++) { 
            echo "<tr>";
            for ($j=0; $j < 3; $j++) { 
                echo "<td>" . ($matriz_a[$i][$j] + $matriz_b[$i][$j]) . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

        //Producto de A y B
        $suma = 0;

        echo "<h2>Producto de A y B</h2><table>";

        for ($i=0; $i < 3; $i++) { 
            echo "<tr>";
            for ($j=0; $j < 3; $j++) { 
                $suma = 0;

                for ($k=0; $k < 3; $k++) { 
                    $suma += ($matriz_a[$i][$k] * $matriz_b[$k][$j]);
                }

                echo "<td>" . $suma . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    ?>
</body>
</html>