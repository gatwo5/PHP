<?php
    
    // crearBaraja($baraja). Función que recibe la baraja, la crea y la barajea.
    function crearBaraja(&$baraja) {
        $valor = array('1', 'J', 'K', 'Q');
        $palo = array('C', 'D', 'P', 'T');
        
        for ($i=0; $i < 4; $i++) { 
            
            for ($j=0; $j < 4; $j++) { 
                
                for ($k=1; $k <= 2; $k++) { 
                    $baraja[] = $valor[$i] . $palo[$j] . $k;
                }
            }
        }

        shuffle($baraja);
    }

    // repartirBaraja($baraja, $mano_jugador). Función que recibe la baraja y la mano de los jugadores para repartirla
    function repartirBaraja($baraja, &$mano_jugador) {
        $recorrer_baraja = 0;

        for ($i=0; $i < 4; $i++) { 
            for ($j=0; $j < 4; $j++) { 
                $mano_jugador[$i][$j] = $baraja[$recorrer_baraja];

                $recorrer_baraja++;
            }
        }
    }

    // asignarJugada($mano_jugador, $resultado_mano). Función que recibe la mano de cada jugador y el resultado de la mano donde se guardará el resultado obtenido por cada jugador

    function asignarJugada($mano_jugador, &$resultado_mano) {
        // Nada = 0 | Pareja = 1 | Doble Pareja = 2 | Trio = 3 | Poker = 4

        $pareja = $doblepareja = $trio = $poker = false;
        $posicionCoincidencia = 0;
        $contadorPoker = 0;

        // Recorrer cada jugador
        for ($i=0; $i < 4; $i++) { 

            $pareja = $doblepareja = $trio = $poker = false;

            // Selector inicial
            for ($j=0; $j < 3; $j++) { 
                $contadorPoker = 0;
                // Selector secundario
                for ($k=(1+$j); $k < 4; $k++) { 
                    
                    if ($mano_jugador[$i][$j][0] == $mano_jugador[$i][$k][0]) {
                        $contadorPoker++;

                        if (!$pareja) {
                            $pareja = true;
                            $posicionCoincidencia = $j;
                        }

                        else if(!$trio && $pareja && ($mano_jugador[$i][$k][0] == $mano_jugador[$i][$posicionCoincidencia][0])) {
                            $trio = true;
                        }

                        else if(!$trio && $pareja) {
                            $doblepareja = true;
                        }

                        else if ($contadorPoker == 3) {
                            $poker = true;
                        }

                    }

                    else {
                        $contadorPoker = 0;
                    }
                }
            }

            // Establecer resultado

            if ($poker) {
                $resultado_mano[$i] = 4;
            }

            elseif ($trio) {
                $resultado_mano[$i] = 3;
            }

            elseif ($doblepareja) {
                $resultado_mano[$i] = 2;
            }

            elseif ($pareja) {
                $resultado_mano[$i] = 1;
            }

            elseif (!$pareja) {
                $resultado_mano[$i] = 0;
            }
        }
    }

    // establecerBote($resultado_mano, $bote). Función que recibe el resultado de la mano de cada jugador y el bote para establecerlo
    function establecerBote($resultado_mano, &$bote, &$mano_ganadora) {
        
        $mano_ganadora = max($resultado_mano);

        switch ($mano_ganadora) {
            case 2:
                $bote *= 0.5;
                break;
            case 3:
                $bote *= 0.7;
                break;
            case 4:
                break;
            default:
                $bote = 0;
                break;
        }
    }

    function imprimir_resultado($nombres, $mano_jugador, $bote, $mano_ganadora, $resultado_mano) {
        
        // Imprimir mano

        echo '<table>';

        for ($i=0; $i < 4; $i++) { 

            echo '<tr>';
            echo '<td>' . $nombres[$i] . '</td>';

            for ($j=0; $j < 4; $j++) { 
                echo '<td> <img src="images/' . $mano_jugador[$i][$j] . '"> </td>'; 
            }

            echo '<td>';
                
                switch ($resultado_mano[$i]) {
                    case '0':
                        echo 'nada';
                        break;
                    
                    case '1':
                        echo 'pareja';
                        break;
                    
                    case '2':
                        echo 'doble pareja';
                        break;

                    case '3':
                        echo 'trio';
                        break;

                    case '4':
                        echo 'poker';
                        break;
                }

            echo '</td>';

            
                if ($resultado_mano[$i] == $mano_ganadora) {
                    echo '<td> Gana y recibe ' . $bote . '$';
                }

            echo '</tr>';
        }

        echo '</table>';
    }
    
    // test_input($data). Función que redibe datos, los limpia y los devuelve.
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>