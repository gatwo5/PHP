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

        $matriz_aleatoria = array();
        $valores_maximos_filas = array();
        $promedio_filas = array();
        
        echo "<h2> Tabla aleatoria </h2>" . "<table>";

        for ($i=0; $i < 3; $i++) { 
            echo "<tr>";

            for ($j=0; $j < 3; $j++) { 
                $matriz_aleatoria[$i][$j] = rand(0,100);

                echo "<td>" . $matriz_aleatoria[$i][$j] . "</td>";
            }

            $valores_maximos_filas[$i] = max($matriz_aleatoria[$i]);
            $promedio_filas[$i] = array_sum($matriz_aleatoria[$i]) / count($matriz_aleatoria[$i]);

            echo "</tr>";
        }
        
        echo "</table>";

        echo "<h2>Valores máximos por fila</h2>" . "<table>";

        for ($i=0; $i < count($valores_maximos_filas); $i++) { 
            echo "<tr><td>" . $valores_maximos_filas[$i] . "</td></tr>";
        }

        echo "</table>";

        echo "<h2>Promedio por fila</h2><table>";

        for ($i=0; $i < count($promedio_filas); $i++) { 
            echo "<tr><td>" . round($promedio_filas[$i]) . "</td></tr>";
        }

        echo "</table>";
    ?>
</body>
</html>