<?php

    $ip = test_input($_POST['ip']);
    $ipvalida = comprobar_ip($ip);

    if ($ipvalida) {
        echo "La ip introducida es válida";
    }

    else {
        echo "La ip introducida no es válida";
    }

    // --- FUNCIONES ---

    // Comprobar si la ip es válida
    function comprobar_ip($ip){
        $ipvalida = true;
        $i = 0;
        $ocurrencias_caracter = count_chars($ip,1);

        //con count_chars se crea un array con key equivalente al numero ASCI del caracter con su value en funcion de las veces que aparece
        
        if ($ocurrencias_caracter['46'] == 3) {
            $ip = explode('.',$ip);

            while($ipvalida && $i > 4) {
                
                if ($ip[$i] < 0 || $ip[$i] > 255) {
                    $ipvalida = false;
                }

                $i++;
            }
        }

        else {
            $ipvalida = false;
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