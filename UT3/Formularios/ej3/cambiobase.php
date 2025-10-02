<style>
    table,td,tr {
        text-align: center;
        border: solid;
    }
</style>

<?php
    $numero_decimal = $_POST['decimal'];
    $eleccion = $_POST['eleccion'];

    echo "<h1>CAMBIO BASE</h1>";

    echo "Número decimal: " . $numero_decimal;

    echo "<table>";

    switch ($eleccion) {
        case 'binario':
            tabla_binario($numero_decimal);
            break;
        
        case 'octal':
            tabla_octal($numero_decimal);
            break;

        case 'hexadecimal':
            tabla_hexadecimal($numero_decimal);
            break;

        case 'todos sistemas':
            tabla_binario($numero_decimal);
            tabla_octal($numero_decimal);
            tabla_hexadecimal($numero_decimal);
            break;
    }

    echo "</table>";

    function tabla_binario($numero_decimal) {
        echo "<tr><td>Binario</td><td>" . decbin($numero_decimal) .  "</td>";
    }

    function tabla_octal($numero_decimal) {
        echo "<tr><td>Octal</td><td>" . decoct($numero_decimal) .  "</td>";
    }

    function tabla_hexadecimal($numero_decimal) {
        echo "<tr><td>Hexadecimal</td><td>" . dechex($numero_decimal) .  "</td>";
    }
?>