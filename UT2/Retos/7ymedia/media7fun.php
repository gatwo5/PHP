<?php
    
    // --- Funciones ---

    // crearBaraja(). Función que recibe la baraja vacía, la llena con cartas y la barajea.
    function crearBaraja(&$baraja) {

        $posicion_baraja = 0;
        $figuras = ['J','Q','K'];

        //Meter números

        for ($i=0; $i < 7; $i++) { 
            
            $baraja[$posicion_baraja++] = ($i + 1) . 'C';
            $baraja[$posicion_baraja++] = ($i + 1) . 'D';
            $baraja[$posicion_baraja++] = ($i + 1) . 'P';
            $baraja[$posicion_baraja++] = ($i + 1) . 'T';

        }

        //Meter figuras

        for ($i=0; $i < 3; $i++) { 
            
            $baraja[$posicion_baraja++] = $figuras[$i] . 'C';
            $baraja[$posicion_baraja++] = $figuras[$i] . 'D';
            $baraja[$posicion_baraja++] = $figuras[$i] . 'P';
            $baraja[$posicion_baraja++] = $figuras[$i] . 'T';

        }

        //Barajear

        shuffle($baraja);
    }

    // repartirCartas(). Función que recibe la baraja, el numero de cartas a repartir, la mano de los jugadores y el valor de la mano de los jugadores. Reparte las cartas y modifica el array mano_jugador y valor_jugador

    function repartirCartas($baraja, $numcartas, &$mano_jugadores, &$valor_mano) {
        
        $recorrer_baraja = 0;

        // Repartir las cartas a cada jugador e ir sumando el valor

        for ($i=0; $i < 4; $i++) { 
            for ($j=0; $j < $numcartas; $j++) { 
                
            // Repartir carta

                $mano_jugadores[$i][$j] = $baraja[$recorrer_baraja];

                $recorrer_baraja++;

            // Sumarle el valor

                // Si es una carta normal

                if (is_numeric($mano_jugadores[$i][$j][0])) {
                    $valor_mano[$i] += $mano_jugadores[$i][$j][0];
                }

                // Si no, si es una carta de figura

                else {
                    $valor_mano[$i] += 0.5;
                }
            }
        }
    }

    // obtenerGanadores(). Función que recibe el valor de la mano de cada jugador y a partir de ahí marca quienes han ganado.

    function obtenerGanadores($valor_mano, &$ganadores) {
        
        $mayor_puntuacion = 0;

        // Buscamos la mayor puntuación por debajo del 7.5
        
        for ($i=0; $i < 4; $i++) { 

            if ($valor_mano[$i] > $mayor_puntuacion && $valor_mano[$i] <= 7.5) {
                $mayor_puntuacion = $valor_mano[$i];
            }

        }

        // Buscamos a todos los ganadores que tengan ese valor en caso de que lo haya

        if ($mayor_puntuacion != 0) {

            for ($i=0; $i < 4; $i++) { 

                if ($valor_mano[$i] == $mayor_puntuacion) {
                    $ganadores[] = $i;
                }
            }
        }
    }

    //obtenerPremio(). Función que recibe el por referencia el premio y el booleano hay_75. También recibe por valor el valor de la mano y el la posición de los ganadores.
    //Esta función establece el premio y el booleano hay_75

    function obtenerPremio(&$premio, $apuesta, $valor_mano, $ganadores) {

        $hay_75 = false;

        for ($i=0; $i < count($ganadores); $i++) {

            if ($valor_mano[$ganadores[$i]] == 7.5) {
                    $hay_75 = true;
            }

        }

        if ($hay_75) {
            $premio = $apuesta * 0.80;
        }

        else {
            $premio = $apuesta * 0.50;
        }
        
    }

    // imprimir(). Función que recibe los nombres, apuesta, mano de los jugadores, el valor de sus manos y la posición de cada ganador para imprimir el resultado.

    function imprimir($nombres, $numcartas, $apuesta, $mano_jugadores, $valor_mano, $ganadores, $premio) {

        if (!isset($ganadores[0])) {
            echo 'NO hay ganadores el bote acumulado es de '. $apuesta . '<br>';
        }

        else {

            for ($i=0; $i < count($ganadores); $i++) { 
                
                echo $nombres[$ganadores[$i]] . ' ha ganado la partida con una puntuación de ' . $valor_mano[$ganadores[$i]] . '<br>';
                
            }

            echo 'Los ganadores han obtenido ' . $premio . ' de premio' . '<br>';

        }

        // Imprimir la mano

        echo '<table>';

        for ($i=0; $i < 4; $i++) { 

            echo '<tr>';
            echo '<td>' . $nombres[$i] . '</td>';

            for ($j=0; $j < $numcartas; $j++) { 
                echo '<td> <img src="images/' . $mano_jugadores[$i][$j] . '"> <td>'; 
            }

            echo '</tr>';
        }

        echo '</table>';
    }

    // generarFichero()

    function generarFichero($nombres, $premio, $valor_mano, $ganadores) {

        $es_ganador = false;
        $recorrer_ganadores = 0;

        $cadena = '';

        $myfile = fopen("resultado.txt", "w");

        for ($i=0; $i < 4; $i++) { 

            $es_ganador = false;
            $recorrer_ganadores = 0;
            
            // Iniciales
            
            $cadena = $cadena . $nombres[$i][0] . $nombres[$i][strpos($nombres[$i], ' ') + 1] . '##';

            //Valor de su mano

            $cadena = $cadena . $valor_mano[$i] . '##';

            // Recompensa obtenida

            if (isset($ganadores)) {

                while (!$es_ganador && $recorrer_ganadores < count($ganadores)) {
                    
                    if ($i == $ganadores[$recorrer_ganadores]) {
                        $es_ganador = true;
                    }

                    else {
                        $recorrer_ganadores++;
                    }

                }

                if ($es_ganador) {
                    $cadena = $cadena . ($premio/count($ganadores));
                }

                else {
                    $cadena = $cadena . 0;
                }
            }

            else {
                $cadena = $cadena . 0;
            }

            // Enter

            $cadena = $cadena . "\n";
        }

        // Total Premios

        $cadena =  $cadena . 'TOTALPREMIOS#' . count($ganadores) . '#' . $premio;

        fwrite($myfile, $cadena);

        fclose($myfile);
    }

    // test_input($data). Función que redibe datos, los limpia y los devuelve.
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>