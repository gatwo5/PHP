<?php
    include 'pokerldv_fun.php';

    $nombres = array(test_input($_POST['nombre1']), test_input($_POST['nombre2']), test_input($_POST['nombre3']), test_input($_POST['nombre4']));
    $bote = test_input($_POST['bote']);
    $baraja = array();
    $mano_jugador = array(array(), array(), array(), array());
    $mano_ganadora = 0;
    $resultado_mano = array();

    // Crear la baraja

    crearBaraja($baraja);

    // Repartir baraja

    repartirBaraja($baraja, $mano_jugador);

    // Asignar jugada

    asignarJugada($mano_jugador, $resultado_mano);

    // Establecer el bote

    establecerBote($resultado_mano, $bote, $mano_ganadora);

    // Imprimir resultado

    imprimir_resultado($nombres, $mano_jugador, $bote, $mano_ganadora, $resultado_mano);
    ?>