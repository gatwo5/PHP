<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $array_1 = array("Bases Datos", "Entornos Desarrollo", "Programación");
        $array_2 = array("Sistemas informáticos", "FOL", "Mecanizado");
        $array_3 = array("Desarrollo Web ES", "Desarrollo Web EC", "Despliegue", "Desarrollo Interfaces", "Inglés");
        
        $array_a = array();
        $indice_a = 0;

        $array_b = array();
        $array_c = array();

        //apartado a) y c)

        for ($i=0; $i < count($array_1); $i++) {
            $array_a[$indice_a] = $array_1[$i];
            $indice_a++;

            array_push($array_c,$array_1[$i]);
        }

        for ($i=0; $i < count($array_2); $i++) { 
            $array_a[$indice_a] = $array_2[$i];
            $indice_a++;

            array_push($array_c,$array_2[$i]);
        }

        for ($i=0; $i < count($array_3); $i++) { 
            $array_a[$indice_a] = $array_3[$i];
            $indice_a++;

            array_push($array_c,$array_3[$i]);
        }

        echo "<h2> Apartado a) </h2>";
        var_dump($array_a);

        //apartado b)

        $array_b = array_merge($array_1, $array_2, $array_3);
        echo "<h2> Apartado b) </h2>";
        var_dump($array_b);

        //apartado c) (imprimir)
        
        echo "<h2> Apartado c) </h2>";
        var_dump($array_c);
    ?>
</body>
</html>