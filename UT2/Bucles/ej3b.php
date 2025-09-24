<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> EJ3B - Conversor Decimal a base 16</title>
</head>
<body>
    
    <?php
        $num="1515";
        $numInicial = $num;
        $base="16";
        $hexadecimal="0123456789ABCDEF";
        $transformacion = "";
        $noEsCero = true;

        while ($noEsCero) {
            if (floor($num / $base < 1)) {
                $noEsCero = false;
            }

            $transformacion = $transformacion . substr($hexadecimal,($num%$base),1);
            $num /= $base;
        }

        echo "Numero " . $numInicial . " en base " . $base . " = " . strrev($transformacion);
    ?>

</body>
</html>