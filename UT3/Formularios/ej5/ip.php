<?php

    $ip = test_input($_POST['ip']);
    $ip_dividida = explode(".",$ip);
    $ipvalida = comprobar_ip($ip, $ip_dividida);

    if ($ipvalida) {
        # code...
    }

    else {
        echo "La ip introducida no es válida";
    }

    // --- FUNCIONES ---

    // Comprobar si la ip es válida
    function comprobar_ip($ip,$ip_dividida){
        $ipvalida = true;
        $ocurrencias_caracter = count_chars($ip,1);

        //con count_chars se crea un array con key equivalente al numero ASCI del caracter con su value en funcion de las veces que aparece
        
        if ($ocurrencias_caracter['46'] == 3) {
            
        }

        else {
            
        }
        return $ipvalida;
    }

    // Transformar la IP a binario
    function transformar_ip_a_binario($ip) {
        $ip_binario = '';

        return $ip_binario;
    }

    // Validar datos
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>