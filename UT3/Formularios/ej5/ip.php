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