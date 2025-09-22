<?php

    $ip="192.18.16.204";
    echo "IP ".$ip." en binario es ";

    $ips = (explode('.',$ip));
    

    for ($i=0; $i < count($ips); $i++) { 
        
        echo decbin($ips[$i])," ";
    }

?>