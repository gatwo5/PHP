<?php
    $salida = "";
    $datos = array();
    $linea = "";
    $contador_filas = -1;

    $myfile = fopen("C:/wamp64/www/files/alumnos2.txt", "r");

    $salida = $salida . "<table>";

    while(!feof($myfile)) {
        $linea = fgets($myfile);

        $datos = explode("##",$linea);

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