<?php
    $myfile = fopen("C:/wamp64/www/files/alumnos1.txt", "r");
    $linea = "";
    $datos = array();
    $contador_filas = -1;
    $salida = "";

    $salida = $salida . "<table>";

    $salida = $salida . "<tr><th>Nombre</th>";
    $salida = $salida . "<th>Apellido1</th>";
    $salida = $salida . "<th>Apellido2</th>";
    $salida = $salida . "<th>Nacimiento</th></tr>";


    while(!feof($myfile)) {
        $linea = fgets($myfile);

        $datos = preg_split('/\s+/', trim($linea));

        $salida = $salida . "<tr>";

        foreach ($datos as $key => $value) {
            $salida = $salida . "<td>" . $value . "</td>";
        }

        $salida = $salida . "<tr>";

        $contador_filas++;
    }

    $salida = $salida . "</table>";

    $salida = $salida . "<br><br>Se han escrito " . $contador_filas . " filas";

    fclose($myfile);

    echo $salida;
?>