<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    $ip="192.168.16.100/16";
    $ipSinMascara = substr($ip,0,strpos($ip,"/"));
    $mascara = substr($ip, strpos($ip, "/") + 1);
    $ipBinarioDividida = (explode('.',$ipSinMascara));
    $ipBinarioJunta = "";
    $ipHost="";
    $ipRed="";
    $ipBroadcast="";
    $ipRedJunta = "";
    $ipBroadcastJunta ="";
    $numerosRed;
    $numerosBroadcast;

    echo "IP ".$ip."<br>";
    echo "Mascara ".$mascara."<br>";

    //Transformar en binario y juntar la cadena completa
    for ($i=0; $i < count($ipBinarioDividida); $i++) { 
        $ipBinarioDividida[$i] = sprintf("%08b",$ipBinarioDividida[$i]);
        $ipBinarioJunta = $ipBinarioJunta.$ipBinarioDividida[$i];
    }


    //Dividir la parte de Host y la de red e igualar red a 0 y broadcast a 1

    $ipHost = substr($ipBinarioJunta,0,(32-(32-$mascara)));
    $ipRed = substr($ipBinarioJunta,(32-(32-$mascara)));
    $ipRed = str_replace("1","0",$ipRed);
    $ipBroadcast = str_replace("0","1",$ipRed);

    //Volver a colocarlos

    $ipRedJunta = $ipHost.$ipRed;
    $ipBroadcastJunta = $ipHost.$ipBroadcast;

    for ($i=0; $i <= 3; $i++) { 
        $numerosRed[$i] = bindec(substr($ipRedJunta,$i*8,8));
        $numerosBroadcast[$i] = bindec(substr($ipBroadcastJunta,$i*8,8));
    }

    //Escribir red y broadcast

    echo "Dirección Red: ";

    for ($i=0; $i <= 3; $i++) { 
        echo $numerosRed[$i].".";
    }

    echo "<br>";
    echo "Dirección Broadcast: ";

    for ($i=0; $i <= 3; $i++) { 
        echo $numerosBroadcast[$i].".";
    }

    echo "<br>";

    //Escribir rango

    echo "Rango: ";

    for ($i=0; $i <= 2; $i++) { 
        echo $numerosRed[$i].".";
    }

    echo ($numerosRed[3] + 1). " a ";

    

    for ($i=0; $i <= 2; $i++) { 
        echo $numerosBroadcast[$i].".";
    }

    echo $numerosBroadcast[3] - 1;
    ?>
    
</body>
</html>

