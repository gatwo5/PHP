<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

        td, tr {
            border: solid;
            text-align: center;
        }

    </style>

</head>
<body>
    <?php
        $array_multiplos_dos = [[],[],[]];
        $multiplos_de_dos = 2;

        $array_suma_filas = [0,0,0];
        $array_suma_columnas = [0,0,0];

        //Creación del array con los múltiplos de 2 
        for ($i=0; $i < 3; $i++) { 
            for ($j=0; $j < 3; $j++) { 
                $array_multiplos_dos[$i][$j] = $multiplos_de_dos;
                $multiplos_de_dos+=2;

                $array_suma_filas[$i] += $array_multiplos_dos[$i][$j];
                $array_suma_columnas[$j] += $array_multiplos_dos[$i][$j];
            }
        }

        echo "Suma por filas: <table>";

        for ($i=0; $i < count($array_suma_filas); $i++) { 
            echo "<tr><td>" . $array_suma_filas[$i] . "</td></tr>";
        }

        echo "</table> Suma por columnas: <table>";

        for ($i=0; $i < count($array_suma_columnas); $i++) { 
            echo "<tr><td>" . $array_suma_columnas[$i] . "</td></tr>";
        }

        echo "</table>";
    ?>
</body>
</html>