<?php
    $cadena_numero_base = test_input($_POST['numero']);
    $numero = substr($cadena_numero_base, 0, strpos($cadena_numero_base, "/"));
    $numero_final;
    $antigua_base = substr($cadena_numero_base, strpos($cadena_numero_base, "/") + 1);
    $nueva_base = test_input($_POST['nueva_base']);

    $numero_final = transformar_base($numero, $antigua_base, $nueva_base);

    // --- IMPRIMIR ---

    echo "Numero " . $numero . " en base " . $antigua_base . " = " . $numero_final . " en base " . $nueva_base;

    // --- FUNCIONES ---

    // Transformar de una base a otra
    function transformar_base($numero, $antigua_base, $nueva_base){
        $descoposicion_numeros = str_split(strrev($numero));
        $noEsCero = true;
        $numero_final = 0;
        $numero = 0;

        // Primero se pasa a base 10 en caso de que no lo estuviese ya

        if ($antigua_base != 10) {
            for ($i=0; $i < count($descoposicion_numeros); $i++) { 
                $descoposicion_numeros[$i] = $descoposicion_numeros[$i] * pow($antigua_base, $i);
                $numero += $descoposicion_numeros[$i];
            }
        }

        // Finalmente pasamos de base 10 a la nueva base

        while ($noEsCero) {
            if (floor($numero / $nueva_base) == 0) {
                $noEsCero = false;
            }

            $numero_final = $numero_final . ($numero % $nueva_base);
            $numero/=$nueva_base;
        }

        return $numero_final;
    }

    // Validar datos
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>