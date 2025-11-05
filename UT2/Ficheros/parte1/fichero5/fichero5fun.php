<?php

    //mostrarFichero()
    function mostrarFichero($nombreFichero) {
        $myfile = fopen($nombreFichero, 'r') or die('No existe el fichero');

        while(!feof($myfile)) {
            echo fgets($myfile) . '<br>';
        }

        fclose($myfile);
    }

    //mostrarLineaEspecifica()
    function mostrarLineaEspecifica($nombreFichero, $numLineaEspecifica) {
        $myfile = fopen($nombreFichero, 'r') or die('No existe el fichero');

        $contadorLinea = 1;

        while(!feof($myfile) && $contadorLinea <= $numLineaEspecifica) {
            
            if ($contadorLinea != $numLineaEspecifica) {
                fgets($myfile);
            }
            
            else {
                echo fgets($myfile) . '<br>';
            }
            
            $contadorLinea++;
        }

        fclose($myfile); 
    }   

    // mostrarLineas()
    function mostrarLineas($nombreFichero, $numLineas) {
        $myfile = fopen($nombreFichero, 'r') or die('No existe el fichero');

        $contadorLinea = 1;

        while(!feof($myfile) && $contadorLinea <= $numLineas) {
            echo fgets($myfile) . '<br>';
            $contadorLinea++;
        }
        
        fclose($myfile);
    }

    // test_input(). Función que recibe dato y lo limpia
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>