<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $array = [[2,4,6,9,7],[8,10,12,1,12],[14,16,88,3,15]];

        echo "<h2>Elementos por fila</h2>";

        for ($i=0; $i < count($array); $i++) { 
            for ($j=0; $j < count($array[0]); $j++) { 
                echo $array[$i][$j] . " ";
            }
        }

        echo "<h2>Elementos por columna</h2>";

        for ($i=0; $i < count($array[0]); $i++) { 
            for ($j=0; $j < count($array); $j++) { 
                echo $array[$j][$i] . " ";
            }
        }
    ?>
</body>
</html>