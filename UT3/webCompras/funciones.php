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

    // comprobar_nif
    function comprobar_nif($nif) {
        $valido = false;

        if (preg_match('/^[0-9]{8}[A-Z]$/',$nif)) {
            $valido = true;
        }

        return $valido;
    }

    // Crear cliente
    function crear_cliente($nif, $nombre, $apellido, $cp, $direccion, $ciudad, $clave) {
        
        try {
            $conn = conexion();
            $conn -> beginTransaction();

            // Insertar cliente

            $stmt = $conn -> prepare(
                "INSERT INTO cliente (nif, nombre, apellido, cp, direccion, ciudad, clave)
                 VALUES (:nif, :nombre, :apellido, :cp, :direccion, :ciudad, :clave)"
            );

            $stmt -> bindParam(':nif', $nif);
            $stmt -> bindParam(':nombre', $nombre);
            $stmt -> bindParam(':apellido', $apellido);
            $stmt -> bindParam(':cp', $cp);
            $stmt -> bindParam(':direccion', $direccion);
            $stmt -> bindParam(':ciudad', $ciudad);
            $stmt -> bindParam(':clave', $clave);

            $stmt -> execute();

            $conn -> commit();

            echo 'Cliente creado con éxito';
        }

        catch (PDOException $e) {
            $errores = $e -> errorInfo;
            $codigo_error = $errores[1];

            if ($codigo_error == 1062) {
                echo 'El NIF ya existe';
            }

            $conn -> rollBack();
        }

        $conn = null;
    }

// test_input()
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>