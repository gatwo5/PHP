<?php
    // realizar_pago
    function realizar_pago($checkNumber) {

        if (preg_match('/^[A-Z]{2}[0-9]{5}$/',$checkNumber)) {
            
            $valor_total_compra = calcular_compra();

            try {
                $conn = conexion();
                $conn -> beginTransaction();

                $stmt = $conn -> prepare(
                    "INSERT INTO payments (customerNumber, checkNumber, paymentDate, amount)
                            VALUES (:customerNumber, :checkNumber, CURRENT_TIMESTAMP, :amount)");

                $stmt -> bindParam('customerNumber', $_SESSION['user']);
                $stmt -> bindParam('checkNumber', $checkNumber);
                $stmt -> bindParam('amount', $valor_total_compra);
                
                $stmt -> execute();
                $conn -> commit();
            }

            catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                $conn -> rollBack();
            }

            $conn = null;
        }

        else {
            echo 'chechNumber es incorrecto';
        }
    }

    function calcular_compra() {
        $valor_total_compra = 0;

        try {
            $conn = conexion();

            foreach ($_SESSION['productos'] as $productCode => $cantidad) {

                $stmt = $conn -> prepare(
                "SELECT buyPrice
                        FROM products
                        WHERE productCode = :productCode"
                );

                $stmt -> bindParam(':productCode', $productCode);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $producto = $stmt -> fetchAll();

                $valor_total_compra += $producto[0]['buyPrice'] * $cantidad;
            }
        }
        
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;

        return $valor_total_compra;
    }
    
    // realizar_orden
    function realizar_orden($customerNumber, $comments) {

        $orderNumber = buscar_max_orderNumber();
        
        try {
            $conn = conexion();
            $conn -> beginTransaction();

            $stmt = $conn -> prepare(
                "INSERT INTO orders (orderNumber, orderDate, requiredDate, shippedDate, status, comments, customerNumber)
                        VALUES (:orderNumber, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, null, 'Pending', :comments, :customerNumber)");

            $stmt -> bindParam('orderNumber', $orderNumber);
            $stmt -> bindParam("comments", $comments);
            $stmt -> bindParam('customerNumber', $customerNumber);
            
            $stmt -> execute();
            $conn -> commit();
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $conn -> rollBack();
        }

        $conn = null;
    }

    function buscar_max_orderNumber() {
        try {
            $conn = conexion();

            $stmt = $conn -> prepare(
            "SELECT MAX(orderNumber)
                    FROM orders");

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $ultima_orden = $stmt -> fetchAll();      
            
            $ultima_orden = $ultima_orden[0]['MAX(orderNumber)'];

        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
        return ($ultima_orden + 1);
    }

    // mostrar_carrito
    function mostrar_carrito() {
        echo "<h4>Carrito</h4>";

        try {
            $conn = conexion();
            
            foreach ($_SESSION['productos'] as $key => $value) {

                $stmt = $conn -> prepare(
                "SELECT productName
                FROM products
                WHERE productCode = :productCode"
                );

                $stmt -> bindParam(':productCode', $key);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $producto = $stmt -> fetchAll();

                // Imprimir
                echo $producto[0]['productName'] . ' x' . $value . '<br>';
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
    }

    // agregar_producto_carrito
    function agregar_producto_carrito($productCode, $cantidad) {
        if(!isset($_SESSION['productos'])) {
            $_SESSION['productos'] = [$productCode => $cantidad];
        }

        elseif (!isset($_SESSION['productos'][$productCode])){
            $_SESSION['productos'][$productCode] = $cantidad;
        }

        else {
            $_SESSION['productos'][$productCode] += $cantidad;
        }
    }

    // mostrar_productos
    function mostrar_productos() {

        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                "SELECT productCode, productName
                 FROM products
                 WHERE quantityInStock > 0");

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $productos = $stmt -> fetchAll();

            foreach($productos as $producto) {
                echo '<option value ="' . $producto['productCode'] . '">' . $producto['productName'] . '</option>';
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        finally {
            $conn = null;
        }
    }
    
    // comprobar_credenciales
    function comprobar_credenciales($user, $password) {
        $inicia_sesion = false;

        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                "SELECT 1
                        FROM customers
                        WHERE customerNumber = :user AND contactLastName = :pass");

            $stmt -> bindparam(":user", $user);
            $stmt -> bindparam(":pass", $password);

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $usuario_encontrado = $stmt -> fetchAll();

            if (!empty($usuario_encontrado)) {
                $inicia_sesion = true;
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        finally {
            $conn = null;
            return $inicia_sesion;
        }
    }

    // cerrar_sesion
    function cerrar_sesion() {
        session_destroy();
        session_unset();
        setcookie("PHPSESSID", "", time() - 3600, "/");
        header("Location: pe_login.php");
        exit;
    }

    // Conexion a la base de datos
    function conexion() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname="pedidos";

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