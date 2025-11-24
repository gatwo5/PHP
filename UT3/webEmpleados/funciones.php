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

// mostrar_departamentos()

function mostrar_departamentos() {
    try {
        $conn = conexion();
        $stmt = $conn -> prepare("SELECT cod_dpto, nombre_dpto FROM departamento");
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);

        $departamentos = $stmt -> fetchAll();

        // Imprimir valores

        foreach ($departamentos as $departamento) {
            echo '<option value ="' . $departamento['cod_dpto'] . '">' . $departamento['nombre_dpto'] . '</option>';
        }
    }
    
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// test_input()
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>