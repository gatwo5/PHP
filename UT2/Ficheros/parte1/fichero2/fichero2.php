<?php
    // Recoger valores

    $nombre = test_input($_POST["nombre"]);
    $apellido1 = test_input($_POST["apellido1"]);
    $apellido2 = test_input($_POST["apellido2"]);
    $fechaNacimiento = test_input($_POST["fechaNacimiento"]);
    $localidad = test_input($_POST["localidad"]);

    // Escribir

    $myfile = fopen("C:/wamp64/www/files/alumnos2.txt","a");

    // Nombre

    fwrite($myfile,$nombre);
    caracteresDelimitadores($myfile);

    // Apellido1

    fwrite($myfile,$apellido1);
    caracteresDelimitadores($myfile);

    // Apellido2

    fwrite($myfile,$apellido2);
    caracteresDelimitadores($myfile);

    // FechaNacimiento

    fwrite($myfile,$fechaNacimiento);
    caracteresDelimitadores($myfile);

    // Localidad

    fwrite($myfile,$localidad);

    // Enter
    fwrite($myfile, "\n");

    // Cerrar
    fclose($myfile);

    // --- Funciones ---

    // caracteresDelimitadores() Recibe fichero para escribir caracteres delimitadores
    function caracteresDelimitadores($myfile) {
        fwrite($myfile,"##");
    }

    // test_input() Recibe los datos para evitar inyección de código y devuelve los datos limpios
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>