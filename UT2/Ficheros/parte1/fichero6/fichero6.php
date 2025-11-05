<?php

    $nombreFichero = test_input($_POST['nombreFichero']);

    if (file_exists($nombreFichero)) {
        echo '<b>Nombre del fichero:</b> ' . $nombreFichero . '<br>';
        echo '<b>Directorio:</b> ' . realpath($nombreFichero) . '<br>';
        echo '<b>Tamaño del fichero:</b> ' . filesize($nombreFichero) . 'Kb<br>';
        echo '<b>Fecha última modificación fichero:</b> ' . date('d/m/Y H:i:s',fileatime($nombreFichero));
    }

    else {
        echo 'No existe el fichero';
    }

    // --- FUNCIONES ---
    
    //test_input(). Funcion que recibe datos y los limpia
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>