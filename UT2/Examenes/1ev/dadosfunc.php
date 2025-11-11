<?php

    // comprobar_jugadores($jugadores). Función que recibe el array de jugadores y devuelve true si están todos. Si no devuelve false
    function comprobar_jugadores($jugadores) {
        $jugadores_validos = true;
        
        if (in_array('', $jugadores)) {
            $jugadores_validos = false;
        }

        return $jugadores_validos;
    }

    // comprobar_dados($numdados). Función que recibe el número de dados. devuelve true en caso de que [2,10], false si no.

    function comprobar_dados($numdados) {
        $dados_validos = true;

        if ($numdados < 2 || $numdados > 10) {
            $dados_validos = false;
        }

        return $dados_validos;
    }

    // establecer_tiradas_jugadores(&$dadosJugadores, $numdados). Función que recibe el array de los dados de los jugadores, el numero de dados y hace las tiradas.

    function establecer_tiradas_jugadores(&$dadosJugadores, $numdados) {
        
        for ($i=0; $i < 5; $i++) { 
            for ($j=0; $j < $numdados; $j++) { 
                
                $dadosJugadores[$i][$j] = rand(1,6);

            }
        }
    }

    // establecer_valor_tiradas($dadosJugadores, &$valorDadosJugadores). Función que recibe el array con las tiradas de los jugadores, el numero de dados, el array del valor de las tiradas y establece el valor de dichas tiradas.

    function establecer_valor_tiradas($dadosJugadores, $numdados, &$valorDadosJugadores) {

        $suma_tirada = 0;
        $dados_repetidos = true;
        $recorrer_dados = 1;

        // Sumamos el valor de los dados y lo guardamos en la posición correspondiente

        for ($i=0; $i < 5; $i++) { 
            
            $suma_tirada = 0;

            for ($j=0; $j < $numdados; $j++) { 
                $suma_tirada += $dadosJugadores[$i][$j];
            }

            $valorDadosJugadores[$i] = $suma_tirada;
        }

        // Establecemos las bonificaciones de los jugadores en caso de encontrar todos los dados iguales

        for ($i=0; $i < 5; $i++) { 

            $dados_repetidos = true;
            $recorrer_dados = 1;

            while ($dados_repetidos && $recorrer_dados < $numdados) {

                if ($dadosJugadores[$i][0] != $dadosJugadores[$i][$recorrer_dados]) {
                    $dados_repetidos = false;
                }

                $recorrer_dados++;
            }

            // En caso de ser un jugador

            if ($dados_repetidos && $i != 4) {
                $valorDadosJugadores[$i] *= $numdados;
            }

            // En caso de ser la banca

            else if($dados_repetidos) {
                $valorDadosJugadores[$i] = 100;
            }
        }
    }

    // establecer_ganadores($valorDadosJugadores, &$ganadores). Función que recibe el array del valor de los dados de cada jugador, el array de booleanos de los ganadores, la variable del total de ganadores y establece los ganadores.

    function establecer_ganadores($valorDadosJugadores, &$ganadores, &$total_ganadores) {
        $valorGanador = max($valorDadosJugadores);

        for ($i=0; $i < 5; $i++) { 
            
            if ($valorDadosJugadores[$i] == $valorGanador) {
                $ganadores[$i] = true;
                $total_ganadores++;
            }

            else {
                $ganadores[$i] = false;
            }
        }
    }

    // imprimir_por_pantalla($jugadores, $numdados, $dadosJugadores, $valorDadosJugadores, $ganadores, $total_ganadores).
    // Recibe todos los datos necesarios para imprimir por pantalla
    function imprimir_por_pantalla($jugadores, $numdados, $dadosJugadores, $valorDadosJugadores, $ganadores, $total_ganadores) {

        echo '<h2> RESULTADO JUEGO DADOS<h2>';

        // Tabla

        echo '<table>';

        for ($i=0; $i < 5; $i++) { 
            
            echo '<tr>';

            // Nombre

            echo '<td>' . $jugadores[$i] . '<td>';

            // Dados

            for ($j=0; $j < $numdados; $j++) { 
                
                echo '<td> <img src="images/' . $dadosJugadores[$i][$j] . '.PNG"> <td>';
            }
        }

        echo '</table><br><br>';

        // Valor de los dados

        for ($i=0; $i < 5; $i++) { 
            echo $jugadores[$i] . ' = ' . $valorDadosJugadores[$i] . '<br>';
        }

        echo '<br><br>';

        // Ganadores

        for ($i=0; $i < 5; $i++) { 
            if ($ganadores[$i]) {
                echo 'Ganador: ' . $jugadores[$i] . '<br>';
            }
        }

        echo 'Total jugadores ganadores: ' . $total_ganadores;
    }

    // generar_fichero($jugadores, $valorDadosJugadores, $dadosJugadores). Función que recibe el nombre de los jugadores, el valor de los dados, los dados y genera un fichero

    function generar_fichero($jugadores, $valorDadosJugadores, $dadosJugadores, $numdados) {
        
        $cadena = '';
        
        $posicionesOrdenadas = array();
        $valorMaxActual = 0;
        $encontrado = false;
        $recorrerCopiaValores = 0;

        $copiaValores = $valorDadosJugadores;

        // Sacamos la posicion en orden de mayor a menor

        for ($i=0; $i < 5; $i++) { 

            $valorMaxActual = max($copiaValores);
            $encontrado = false;
            $recorrerCopiaValores = 0;

            while(!$encontrado && $recorrerCopiaValores < count($copiaValores)) {

                if ($copiaValores[$recorrerCopiaValores] == $valorMaxActual) {
                    $encontrado = true;
                    $posicionesOrdenadas[] = $recorrerCopiaValores;
                    $copiaValores[$recorrerCopiaValores] = 0;
                }

                else {
                    $recorrerCopiaValores++;
                }
            }
        }

        // Creamos la cadena

        for ($i=0; $i < 5; $i++) { 
            
            $pos = $posicionesOrdenadas[$i];
            // Nombre

            $cadena = $cadena . $jugadores[$pos] . '#';

            // Valor

            $cadena = $cadena . $valorDadosJugadores[$pos] . '#';

            // Dados

            for ($j=0; $j < $numdados; $j++) { 
                
                $cadena = $cadena . $dadosJugadores[$pos][$j] . '#';

            }

            // Enter
            
            $cadena = $cadena . "\n";
        }
        
        // Escribimos

        $myfile = fopen("resultados.txt", "w");

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