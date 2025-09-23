<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>> EJ2B – Conversor Decimal a base n</title>
</head>
<body>
    <?php
        $num="48";
        $numInicial = $num;
        $base="2";
        $transformacion = "";
        $noEsCero = true;

        while ($noEsCero) {
            if (floor($num / $base) == 0) {
                $noEsCero = false;
            }

            $transformacion = $transformacion . ($num % $base);
            $num/=$base;
        }

        echo "Número " . $numInicial . " en base " . $base . " = " . strrev($transformacion);
    ?>
</body>
</html>