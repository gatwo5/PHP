<?php

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
function cerrar_sesion() {
    setcookie("PHPSESSID", "", time() - 3600, "/");
    setcookie("user", "", time() - 3600, "/");
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