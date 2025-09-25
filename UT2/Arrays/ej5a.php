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
        $union = array($array_1,$array_2,$array_3);
        
        $array_a = array();
        $i_array_a = 0;

        $array_b = array();
        $array_c = array();

        //apartado a)

        for ($i=0; $i < 3; $i++) { 
            for ($j=0; $j < count($union[$i]); $j++) { 
                $array_a[$i_array_a] = $union[$i][$j];
                $i_array_a++;
            }
        }

        echo "<h2> Apartado a) </h2>";
        var_dump($array_a);

        //apartado b)

        $array_b = array_merge($array_1, $array_2, $array_3);
        echo "<h2> Apartado b) </h2>";
        var_dump($array_b);

        //apartado c)
        for ($i=0; $i < 3; $i++) { 
            for ($j=0; $j < count($union[$i]); $j++) { 
                array_push($array_c, $union[$i][$j]);
            }
        }

        echo "<h2> Apartado c) </h2>";
        var_dump($array_c);
    ?>
</body>
</html>