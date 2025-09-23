<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $num="2";
        $numInicial = $num;
        $numBinario = "";

        while ($num / 2 > 0.4 ) {
            $numBinario = $numBinario.($num%2);
            $num/=2;
        }

        echo "Numero ".$numInicial. " en binario = ".strrev($numBinario);
    ?>
</body>
</html>