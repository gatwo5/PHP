<?php
    include 'fichero5fun.php';
    
    $nombreFichero = test_input($_POST['fichero']);
    $operacion = test_input($_POST['operaciones']);

    switch ($operacion) {
        case 'mostrarFichero':

            mostrarFichero($nombreFichero);

            break;
        
        case 'mostrarLineaEspecifica':

            $numLineaEspecifica = test_input($_POST['numLineaEspecifica']);
            mostrarLineaEspecifica($nombreFichero, $numLineaEspecifica);

            break;

        case 'mostrarLineas':

            $numLineas = test_input($_POST['numLineas']);
            mostrarLineas($nombreFichero, $numLineas);

            break;
    }
?>