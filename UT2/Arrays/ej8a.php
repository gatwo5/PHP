<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $array_edad_alumnos = array("Pepito" => 10, "Juanito" => 4, "Manola" => 7, "Verónica" => 9, "Nick" => 3);
        
        $mayor_nota = 0;
        $nombre_alumno_mayor_nota;

        $menor_nota = 10;
        $nombre_alumno_menor_nota;

        $media_nota = 0;

        foreach ($array_edad_alumnos as $key => $value) {

            //Establecer Mayor y Menor nota

            if ($value > $mayor_nota) {
                $mayor_nota = $value;
                $nombre_alumno_mayor_nota = $key;
            }

            else if ($value < $menor_nota) {
                $menor_nota = $value;
                $nombre_alumno_menor_nota = $key;
            }

            //Calcular la media

            $media_nota += $value;
        }

        echo "a. Mostrar el alumno con mayor nota: " . $nombre_alumno_mayor_nota . " con un " . $mayor_nota . " de nota <br>";
        echo "b. Mostrar el alumno con menor nota: " . $nombre_alumno_menor_nota . " con un " . $menor_nota . " de nota <br>";
        echo "c. Media notas obtenidas por alumnos: " . ($media_nota/count($array_edad_alumnos));
    ?>
</body>
</html>