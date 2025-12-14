<?php

// Conexion a la base de datos
function conexion() {
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname="comprasWeb";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}

// mostrar_productos()
function mostrar_productos() {
    try {
        $conn = conexion();
        $stmt = $conn -> prepare("SELECT id_producto, nombre FROM producto");
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);

        $productos = $stmt -> fetchAll();

        // Imprimir valores

        foreach ($productos as $producto) {
            echo '<option value ="' . $producto['id_producto'] . '">' . $producto['nombre'] . '</option>';
        }
    }
    
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// mostrar_almacenes()

function mostrar_almacenes() {

    try {
        $conn = conexion();
        $stmt = $conn -> prepare("SELECT num_almacen FROM almacen");
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);

        $almacenes = $stmt -> fetchAll();

        // Imprimir valores
        
        foreach($almacenes as $almacen) {
            echo '<option value ="' . $almacen['num_almacen'] . '">' . $almacen['num_almacen'] . '</option>';
        }
    }
    
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// mostrar_clientes()

function mostrar_clientes() {

    try {
        $conn = conexion();
        $stmt = $conn -> prepare("SELECT nif FROM cliente");
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);

        $clientes = $stmt -> fetchAll();

        // Imprimir valores
        
        foreach($clientes as $cliente) {
            echo '<option value ="' . $cliente['nif'] . '">' . $cliente['nif'] . '</option>';
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