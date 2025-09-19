<?php

    $decimal = 50;
    $numInicial = $decimal;
    $resto = "";

    while ($decimal <= 0) {

        $resto = $resto.($decimal % 2);
        $decimal = $decimal / 2;

    }

    print ("Número ". $numInicial . " en binario = " . strrev($resto));
?>