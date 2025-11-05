<?php
    $origen = $destino = $operacion = "";
    
    // Recoger datos

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $origen = test_input($_POST["origen"]);
        $destino = test_input($_POST["destino"]);
        $operacion = test_input($_POST["operaciones"]);
    }

    if (file_exists($origen)) {

        switch ($operacion) {
            case 'copiar':
                crear_carpetas_necesarias($destino);
                copiar_fichero($origen, $destino);
                echo '<br>copiado';
                break;

            case 'renombrar':
                crear_carpetas_necesarias($destino);
                copiar_fichero($origen, $destino);
                unlink($origen);
                echo '<br>renombrado';
                break;

            case 'borrar':
                echo '<br>borrado';
                break;
        }

    }

    else {
        echo 'El fichero origen no existe';
    }

    // --- FUNCIONES ---
    function copiar_fichero($origen, $destino) {
        
        $origen_separado = explode('/',$origen);
        $nombre_fichero = end($origen_separado);

        $destino = $destino. '/' . $nombre_fichero;

        $myfile_origen = fopen($origen, "r");
        $myfile_destino = fopen($destino, "w");

        while (!feof($myfile_origen)) {
            fwrite($myfile_destino, fgets($myfile_origen));
        }

        fclose($myfile_origen);
        fclose($myfile_destino);
    }

    function crear_carpetas_necesarias($destino) {
        $carpetas = explode('/',$destino);
        $string_ruta = '';

        foreach ($carpetas as $key => $carpeta) {
            
            $string_ruta = $string_ruta . $carpeta;

            if (!file_exists($string_ruta)) {
                mkdir($string_ruta);
                echo 'Creando carpeta: ' . $string_ruta . '<br>';
            }

            $string_ruta = $string_ruta . '/';
        }
    }

    //test_input(). Funcion que recibe datos y los limpia
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>