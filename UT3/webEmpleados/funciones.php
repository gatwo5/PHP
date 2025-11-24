<?php

// Conexion a la base de datos
function conexion() {
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname="empleados";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}

// test_input()
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>