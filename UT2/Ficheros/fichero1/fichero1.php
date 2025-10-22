<?php

    // Recoger valores

    $nombre = test_input($_POST["nombre"]);
    $apellido1 = test_input($_POST["apellido1"]);
    $apellido2 = test_input($_POST["apellido2"]);
    $fechaNacimiento = test_input($_POST["fechaNacimiento"]);
    $localidad = test_input($_POST["localidad"]);

    // Escribir

    $myfile = fopen("C:/wamp64/www/files/alumnos1.txt","a");

    // Nombre

    fwrite($myfile, $nombre);

    for ($i=strlen($nombre); $i <= 40; $i++) { 
        fwrite($myfile," ");
    }

    // Apellido1

    fwrite($myfile, $apellido1);

    for ($i=(41+strlen($apellido1)); $i <= 81; $i++) { 
        fwrite($myfile, " ");
    }

    // Apellido2

    fwrite($myfile, $apellido2);

    for ($i=(82+strlen($apellido2)); $i <= 123; $i++) { 
        fwrite($myfile, " ");
    }

    // FechaNacimiento

    fwrite($myfile, $fechaNacimiento);

    for ($i=(124+strlen($fechaNacimiento)); $i <= 133; $i++) { 
        fwrite($myfile, " ");
    }

    // Localidad

    fwrite($myfile,$localidad);

    for ($i=(134+strlen($localidad)); $i <= 160; $i++) { 
        fwrite($myfile, " ");
    }

    // Enter al final

    fwrite($myfile, "\n");

    // Cerrar fichero

    fclose($myfile);

    // --- Funciones ---

    // test_input() Recibe los datos para evitar inyección de código y devuelve los datos limpios
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>