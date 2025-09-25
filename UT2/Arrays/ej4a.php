<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $array_binarios = array();
        $array_binarios_inverso = array();

        for ($i=0; $i < 20; $i++) { 
            $array_binarios[$i] = decbin($i);
            $array_binarios_inverso[19 - $i] = $array_binarios[$i];
        }

        for ($i=0; $i < count($array_binarios_inverso); $i++) { 
            echo $array_binarios_inverso[$i] . " ";
        }
    ?>
</body>
</html>