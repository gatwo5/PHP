<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $array_edad_alumnos = array("Pepito" => 28, "Juanito" => 20, "Manola" => 22, "Verónica" => 18, "Nick" => 30);

        //Apartado a)

        echo "<h2>Apartado a)</h2>";

        foreach ($array_edad_alumnos as $key => $value) {
            echo "Nombre (Key): " . $key . " | Edad (Value): " . $value . "<br><br>";
        }

        //Apartado b)

        echo "<h2>Apartado b)</h2>";
        
        $keys = array_keys($array_edad_alumnos);

        echo "Segunda posición del array: " . $array_edad_alumnos[$keys[1]];

        //Apartado c)

        echo "<h2>Apartado c)</h2>";

        echo "Tercera posición del array: " .  $array_edad_alumnos[$keys[2]];

        //Apartado d)

        echo "<h2>Apartado d)</h2>";

        echo "Última posición del array: " .  $array_edad_alumnos[$keys[count($keys) - 1]];

        //Apartado e)

        echo "<h2>Apartado e)</h2>";

        sort($array_edad_alumnos);
        $keys = array_keys($array_edad_alumnos);

        echo "Primera posición del array: " . $array_edad_alumnos[$keys[0]] . "<br>";
        echo "Última posición del array: " .  $array_edad_alumnos[$keys[count($keys) - 1]];
    ?>
</body>
</html>