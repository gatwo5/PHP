<?php
    include 'media7fun.php';

    // Recibir valores desde el formulario

    $nombres = [test_input($_POST['nombre1']) , test_input($_POST['nombre2']), test_input($_POST['nombre3']), test_input($_POST['nombre4'])];
    $numcartas =test_input($_POST['numcartas']);
    $apuesta =test_input($_POST['apuesta']);

    $baraja = array(); //Baraja
    $mano_jugadores = array(array(), array(), array(), array()); //Mano de cada jugador
    $valor_mano = array(0,0,0,0); //Valor de la mano de cada jugador
    $ganadores = array(); // Array en el que se guarda la posición de cada ganador

    // Crear la baraja
    crearBaraja($baraja);

    // Repartir las cartas a cada jugador y establecer el valor de su mano

    repartirCartas($baraja, $numcartas, $mano_jugadores, $valor_mano);

    // Obtener ganadores

    obtenerGanadores($valor_mano, $ganadores);

    // Imprimir por pantalla

    imprimir($nombres, $numcartas, $apuesta, $mano_jugadores, $valor_mano, $ganadores);

    // Generar fichero

    generarFichero($nombres, $apuesta, $valor_mano, $ganadores);
?>