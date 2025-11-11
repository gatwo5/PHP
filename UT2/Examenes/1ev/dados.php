<?php
    include 'dadosfunc.php';

    // Recibir los valores desde el formulario

    $jugadores = array(test_input($_POST['jug1']), test_input($_POST['jug2']), test_input($_POST['jug3']), test_input($_POST['jug4']), 'BANCA');
    $numdados = test_input($_POST['numdados']);
    $dadosJugadores = array(array(), array(), array(), array(), array());
    $valorDadosJugadores = array();
    $ganadores = array();
    $total_ganadores = 0;

    // Comprobar jugadores y dados

    if (comprobar_jugadores($jugadores) && comprobar_dados($numdados)) {
        // Se tiran los dados

        establecer_tiradas_jugadores($dadosJugadores, $numdados);

        // Se establece el valor de los dados

        establecer_valor_tiradas($dadosJugadores, $numdados, $valorDadosJugadores);

        // Se establece los ganadores

        establecer_ganadores($valorDadosJugadores, $ganadores, $total_ganadores);

        // Se imprime por pantalla

        imprimir_por_pantalla($jugadores, $numdados, $dadosJugadores, $valorDadosJugadores, $ganadores, $total_ganadores);

        // Se genera el fichero

        generar_fichero($jugadores, $valorDadosJugadores, $dadosJugadores, $numdados);
    }

    else {
        echo 'Error';
    }
    
?>