<?php
    $lineas = file('ibex35.txt');
    $cabeceras = preg_split('/\s{2,}/', trim($lineas[0]));
    array_pop($cabeceras);

    // Tabla

    // Cabecera

    echo '<table> <tr>';

    foreach ($cabeceras as $col) {
        echo '<td>' . $col . '</td>';
    }

    echo '</tr>';

    // Datos

    for ($i=1; $i < count($lineas); $i++) { 
        $dato = preg_split('/\s{2,}/', trim($lineas[$i]));
        array_pop($dato);

        echo '<tr>';

        foreach ($dato as $dat) {
            echo '<td>' . $dat . '</td>';
        }

        echo '</tr>';
    }
?>