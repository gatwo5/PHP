<?php

    $operando1 = $_POST['operando1'];
    $operando2 = $_POST['operando2'];
    $operacion = $_POST['operacion'];
    $resultado = '';

    switch ($operacion) {
        case 'suma':
            $resultado = sumar($operando1,$operando2);
            break;
        
        case 'resta':
            $resultado = restar($operando1,$operando2);
            break;

        case 'producto':
            $resultado = producto($operando1,$operando2);
            break;
        
        case 'division':
            $resultado = division($operando1,$operando2);
            break;
    }

    echo "<h2>Calculadora</h2><br>";
    echo "El resultado de " . $resultado;

    // --- FUNCIONES ---
    function sumar($a,$b) {
        return ($a . " + " . $b . " = " . ($a + $b));
    }
    function restar($a,$b) {
        return ($a . " - " . $b . " = " . ($a - $b));
    }
    function producto($a,$b) {
        return ($a . " * " . $b . " = " . ($a * $b));
    }
    function division($a,$b) {
        return ($a . " / " . $b . " = " . ($a / $b));
    }
?>