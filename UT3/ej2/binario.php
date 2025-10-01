<?php

    $numero_decimal = $_POST['decimal'];
    $numero_binario = decbin($numero_decimal);

    echo "<h1>CONVERSOR BINARIO</h1>";
    echo "Número decimal: " . $numero_decimal . "<br>";    
    echo "Número binario: " . $numero_binario;

?>