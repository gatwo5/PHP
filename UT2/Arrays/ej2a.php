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

<!-- Métodos importantes para arrays:
    implode
    explode
    printr
    var_dump
-->
    <?php

        $num = 1;
        $suma = 1;
        $contador_impares = 0;
        $media_posiciones_pares = 0;
        $media_posiciones_impares = 0;
        $tabla_impares = array(array("Indice"), array("Valor"), array("Suma"));

        while ($contador_impares < 20) {
            //Indice
            $tabla_impares[0][$contador_impares + 1] = $contador_impares;

            //Valor
            $tabla_impares[1][$contador_impares + 1] = $num;
            
            if ($tabla_impares[0][$contador_impares + 1] % 2 == 0) {
                $media_posiciones_pares += $num;
            }

            else {
                $media_posiciones_impares += $num;
            }

            //Suma
            $tabla_impares[2][$contador_impares + 1] = $suma;

            $num += 2;
            $suma += $num;
            $contador_impares++;
        }

        echo "<table>";

        for ($i=0; $i < count($tabla_impares[0]); $i++) { 
            echo "<tr>";

            for ($j=0; $j < count($tabla_impares); $j++) { 
                echo "<td>" . $tabla_impares[$j][$i] . "</td>";
            }

            echo "</tr>";
        }

        echo "</table>" . "<br>";

        echo "Media posiciones pares: " . ($media_posiciones_pares/10) . "<br>";
        echo "Media posiciones impares: " . ($media_posiciones_impares/10);
    ?>
</body>
</html>