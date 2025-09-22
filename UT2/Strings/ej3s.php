<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    $ip="192.168.16.100/21";
    $ipSinMascara = substr($ip,0,strpos($ip,"/"));
    $mascara = substr($ip, strpos($ip, "/") + 1);

    $ipBinarioDividida = (explode('.',$ipSinMascara));
    $ipBinarioJunta = "";
    $ipHost="";
    $ipRed="";
    $ipBroadcast="";

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

    echo $ipHost."<br>";
    echo $ipRed."<br>";
    echo $ipBroadcast;

    ?>
    
</body>
</html>

