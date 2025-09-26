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
        $num_mayor = 0;
        $pos_i = 0;
        $pos_j = 0;

        for ($i=0; $i < count($array); $i++) { 
            for ($j=0; $j < count($array[0]); $j++) {

                if ($array[$i][$j] > $num_mayor) {
                    $num_mayor = $array[$i][$j];
                    $pos_i = $i;
                    $pos_j = $j;
                }

            }
        }

        echo "Elemento mayor " . $num_mayor . " - fila " . ($pos_i + 1) . " columna " . ($pos_j + 1);
    ?>
</body>
</html>