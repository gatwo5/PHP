<?php
    function mostrar_datos_reserva($id_reserva) {
        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                "SELECT a.nombre_aerolinea, v.origen, v.destino, v.fechahorasalida, v.fechahorallegada, r.num_asientos
                        FROM aerolineas a, vuelos v, reservas r
                        WHERE  r.id_reserva = :id_reserva AND r.id_vuelo = v.id_vuelo AND v.id_aerolinea = a.id_aerolinea
                        ORDER BY v.fechahorasalida");

            $stmt -> bindParam(':id_reserva', $id_reserva);
            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $vuelos = $stmt -> fetchAll();

            echo '<table><tr><th>Aerolinea</th><th>Origen</th><th>Destino</th><th>Salida</th><th>Llegada</th><th>Asientos</th></tr>';
            foreach($vuelos as $vuelo) {
                echo '<tr><td> ' . $vuelo['nombre_aerolinea'] . '</td><td>' . $vuelo['origen']. '</td><td>' . $vuelo['destino'] . '</td><td>' . $vuelo['fechahorasalida'] .'</td><td>' . $vuelo['fechahorallegada'] . '</td><td>' . $vuelo['num_asientos']. '</td></tr>';
            }
            echo '</table>';
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        finally {
            $conn = null;
        }
    }
    //mostrar_reservas()
    function mostrar_reservas() {
        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                "SELECT id_reserva
                        FROM reservas
                        WHERE dni_cliente = :dni
                        GROUP BY id_reserva");

            $stmt -> bindParam(':dni', $_SESSION['dni']);
            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $reservas = $stmt -> fetchAll();

            foreach($reservas as $reserva) {
                echo '<option value ="' . $reserva['id_reserva'] . '"> RESERVA ' . $reserva['id_reserva'].'</option>';
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        finally {
            $conn = null;
        }
    }
    function comprar_vuelos($id_reserva) {
        try {
            $conn = conexion();
            $conn -> beginTransaction();

            //Buscamos el precio total establecido en la base de datos
            //En vez de guardarlo en una session/cookie por si se modifica el precio del vuelo

            foreach ($_SESSION['carrito'] as $key => $value) {
                $stmt = $conn -> prepare(
                "SELECT precio_asiento
                        FROM vuelos
                        WHERE id_vuelo = :id_vuelo"
                );

                $stmt -> bindParam(':id_vuelo', $key);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $precio_asiento = $stmt -> fetchAll();

                $total_compra = $precio_asiento[0]['precio_asiento']*$value;

                $stmt = $conn -> prepare(
                    "INSERT INTO reservas (id_reserva, id_vuelo, dni_cliente, fecha_reserva, num_asientos, preciototal)
                     VALUES (:id_reserva, :id_vuelo, :dni_cliente, :fecha_reserva, :num_asientos, :preciototal)");

                $stmt -> bindParam('id_reserva', $id_reserva);
                $stmt -> bindParam('id_vuelo', $key);
                $stmt -> bindParam('dni_cliente', $_SESSION['dni']);
                $stmt -> bindParam('fecha_reserva', $_SESSION['fecha']);
                $stmt -> bindParam('num_asientos', $value);
                $stmt -> bindParam('preciototal', $total_compra);
                
                $stmt -> execute();
            }

            $conn -> commit();
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $conn -> rollBack();
        }

        finally {
            $conn = null;
        }

    }
    function actualizar_asientos() {
        try {
            $conn = conexion();
            $conn -> beginTransaction();

            foreach ($_SESSION['carrito'] as $key => $value) {
                $stmt = $conn -> prepare(
                    "UPDATE vuelos
                            SET asientos_disponibles = asientos_disponibles - :num_asientos
                            WHERE id_vuelo = :id_vuelo");

            }

            $stmt -> bindParam('num_asientos', $value);
            $stmt -> bindParam('id_vuelo', $key);
                
            $stmt -> execute();
            $conn -> commit();
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $conn -> rollBack();
        }

        finally {
            $conn = null;
        }
    }
    function calcular_id_reserva() {
        try {
            $conn = conexion();

            $stmt = $conn -> prepare(
            "SELECT MAX(id_reserva)
                    FROM reservas"
            );
            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $ultimo_id_reserva = $stmt -> fetchAll();

            $id_reserva = $ultimo_id_reserva[0]['MAX(id_reserva)'];
            $id_reserva++;
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $conn -> rollBack();
        }

        finally {
            $conn = null;
            return $id_reserva;
        }
    }
    function calcular_total_compra() {
        
    }
    function comprobar_asientos_suficientes() {
        $hay_asientos = true;

        try {
            $conn = conexion();
            
            foreach ($_SESSION['carrito'] as $key => $value) {

                $stmt = $conn -> prepare(
                "SELECT asientos_disponibles
                        FROM vuelos
                        WHERE id_vuelo = :id_vuelo"
                );

                $stmt -> bindParam(':id_vuelo', $key);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $numero_asientos = $stmt -> fetchAll();
                
                if ($numero_asientos[0]['asientos_disponibles'] < $value) {
                    $hay_asientos = false;
                    break;
                } else {
                    $hay_asientos = true;
                }
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        finally {
            $conn = null;
            return $hay_asientos;
        }
    }
    // mostrar_carrito
    function mostrar_carrito() {
        echo "<h4>Carrito</h4>";

        try {
            $conn = conexion();
            
            foreach ($_SESSION['carrito'] as $key => $value) {

                $stmt = $conn -> prepare(
                "SELECT v.origen, v.destino, v.fechahorasalida, v.fechahorallegada, a.nombre_aerolinea, v.precio_asiento
                        FROM vuelos v, aerolineas a
                        WHERE v.id_vuelo = :id_vuelo AND a.id_aerolinea = v.id_aerolinea"
                );

                $stmt -> bindParam(':id_vuelo', $key);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $vuelo = $stmt -> fetchAll();

                // Imprimir
                echo $vuelo[0]['origen'] . " -> " . $vuelo[0]['destino'] . "| SALIDA: " . $vuelo[0]['fechahorasalida'] . "| LLEGADA: " . $vuelo[0]['fechahorallegada']. "| AEROLINEA: " . $vuelo[0]['nombre_aerolinea'] . " | NUMERO ASIENTOS: " . $value . " | PRECIO TOTAL ASIENTOS: " . $value*$vuelo[0]['precio_asiento'] . '$<br><br>';
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
    }
    //vaciar_carrito
    function vaciar_carrito() {
        $_SESSION['carrito'] = null;
    }

    //agregar_vuelo_carrito()
    function agregar_vuelo_carrito($id_vuelo, $num_asientos) {
        if(!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [$id_vuelo => $num_asientos];
        }

        elseif (!isset($_SESSION['carrito'][$id_vuelo])){
            $_SESSION['carrito'][$id_vuelo] = $num_asientos;
        }

        else {
            $_SESSION['carrito'][$id_vuelo] += $num_asientos;
        }
    }
    // mostrar_vuelos()

    function mostrar_vuelos() {
        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                "SELECT v.id_vuelo, v.origen, v.destino, v.fechahorasalida, v.fechahorallegada, a.nombre_aerolinea, v.precio_asiento
                        FROM vuelos v, aerolineas a
                        WHERE v.asientos_disponibles > 0 AND a.id_aerolinea = v.id_aerolinea");

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $vuelos = $stmt -> fetchAll();

            foreach($vuelos as $vuelo) {
                echo '<option value ="' . $vuelo['id_vuelo'] . '">' . $vuelo['origen'] . " -> " . $vuelo['destino'] . "| SALIDA: " . $vuelo['fechahorasalida'] . "| LLEGADA: " . $vuelo['fechahorallegada']. "| AEROLINEA: " . $vuelo['nombre_aerolinea'] . " | PRECIO ASIENTO: " . $vuelo['precio_asiento'].'</option>';
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        finally {
            $conn = null;
        }
    }

    //comprobar_credenciales()
    function comprobar_credenciales($usuario, $password) {
        $inicia_sesion = false;

        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                "SELECT dni, nombre
                        FROM clientes
                        WHERE email = :email");

            $stmt -> bindparam(":email", $usuario);

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $usuario_encontrado = $stmt -> fetchAll();

            if (empty($usuario_encontrado)) {
                echo 'Email incorrecto';
            } else if ($password != substr($usuario_encontrado[0]['dni'],0,4)){
                echo 'Contraseña incorrecta';
            } else {
                $inicia_sesion = true;

                session_start();
                $_SESSION['email'] = $usuario;
                $_SESSION['nombre'] = $usuario_encontrado[0]['nombre'];
                $_SESSION['fecha'] = date("Y/m/d H:i:s");
                $_SESSION['dni'] = $usuario_encontrado[0]['dni'];
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
        header("Location: index.php");
        exit;
    }

    // Conexion a la base de datos
    function conexion() {
        $servername = "localhost";
        $username = "root";
        $password = "rootroot";
        $dbname="reservas";

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