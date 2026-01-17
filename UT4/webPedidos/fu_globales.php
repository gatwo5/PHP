<?php
    // consultar_stock
    function consultar_stock($productCode) {

        try {
            $conn = conexion();

            $stmt = $conn -> prepare(
                "SELECT quantityInStock
                        FROM products
                        WHERE productCode = :productCode");

            $stmt -> bindParam('productCode', $productCode);
            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $stock = $stmt -> fetchAll();

            echo '<br><h2>Stock del producto ' . $productCode . ': ' . $stock[0]['quantityInStock'] . '</h2>';
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
    }

    // consultar_pedidos
    function consultar_pedidos($customerNumber) {

        try {
            $conn = conexion();
            
            // Pedido

            $stmt = $conn -> prepare(
                "SELECT orderNumber, orderDate, status
                        FROM orders
                        WHERE customerNumber = :customerNumber");

            $stmt -> bindParam('customerNumber', $customerNumber);
            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $pedidos = $stmt -> fetchAll();

            // Productos del pedido

            foreach ($pedidos as $pedido) {

                $orderNumber = $pedido ['orderNumber'];
                $orderDate = $pedido['orderDate'];
                $status = $pedido['status'];

                // Imprimir pedido
                
                echo '<h2> Pedido número ' . $orderNumber . '</h2>';
                echo 'Fecha: ' . $orderDate . '<br>';
                echo 'Estado: ' . $status . '<br>';

                // Buscar productos del pedido 

                $stmt = $conn -> prepare(
                    "SELECT o.orderLineNumber, p.productName, o.quantityOrdered, o.priceEach
                            FROM products p, orderdetails o
                            WHERE o.orderNumber = :orderNumber AND p.productCode = o.productCode
                            ORDER BY o.orderLineNumber");

                $stmt -> bindParam('orderNumber', $orderNumber);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $productos = $stmt -> fetchAll(); 

                echo '<h4>Productos</h4>';

                foreach ($productos as $producto) {
                    $orderLineNumber = $producto['orderLineNumber'];
                    $productName = $producto['productName'];
                    $quantityOrdered = $producto['quantityOrdered'];
                    $priceEach = $producto['priceEach'];

                    // Imprimir productos pedido

                    echo '<b>' . $orderLineNumber . '</b><br>';
                    echo 'Producto: ' . $productName . '<br>';
                    echo 'Cantidad: ' . $quantityOrdered . '<br>';
                    echo 'Precio unidad: ' . $priceEach . '<br><br>';
                }
            }
        }   

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
    }
    // actualizar_stock
    function actualizar_stock() {
        try {
            $conn = conexion();
            $conn -> beginTransaction();

            foreach ($_SESSION['productos'] as $productCode => $cantidad) {
                $stmt = $conn -> prepare(
                    "UPDATE products
                            SET quantityInStock = quantityInStock - :cantidad
                            WHERE productCode = :productCode");

            }

            $stmt -> bindParam('cantidad', $cantidad);
            $stmt -> bindParam('productCode', $productCode);
                
            $stmt -> execute();
            $conn -> commit();
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $conn -> rollBack();
        }

        $conn = null;
    }
    // detalles_orden
    function detalles_orden() {
        $orderLineNumber = 1;

        try {
            $conn = conexion();
            $conn -> beginTransaction();

            foreach ($_SESSION['productos'] as $productCode => $cantidad) {
                // Buscar precio
                $stmt = $conn -> prepare(
                    "SELECT buyPrice
                     FROM products
                     WHERE productCode = :productCode");
                
                $stmt -> bindParam(':productCode', $productCode);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $producto = $stmt -> fetchAll();
                
                // Insertar orden
                $stmt = $conn -> prepare(
                    "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber)
                            VALUES (:orderNumber, :productCode, :quantityOrdered, :priceEach, :orderLineNumber)");

                $stmt -> bindParam('orderNumber', $_SESSION['orderNumber']);
                $stmt -> bindParam('productCode', $productCode);
                $stmt -> bindParam('quantityOrdered', $cantidad);
                $stmt -> bindParam('priceEach', $producto[0]['buyPrice']);
                $stmt -> bindParam('orderLineNumber', $orderLineNumber);
                
                $stmt -> execute();
                $conn -> commit();

                $orderLineNumber++;
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $conn -> rollBack();
        }

        $conn = null;
    }
    
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
        
        $_SESSION['orderNumber'] = $orderNumber;

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