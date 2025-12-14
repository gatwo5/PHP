<?php include 'funciones.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        body {
            text-align: center;
        }

    </style>
</head>
<body>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <h1>Login de Clientes</h1>

        <p>Usuario:</p>
        <input type="text" name="usuario">

        <p>Clave:</p>
        <input type="text" name="clave">

        <br><br>

        <button type="submit">Iniciar sesión</button>
        <button type="reset">Borrar</button>

        
    </form>
</body>
</html>

<?php 

    $usuario = $clave = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = test_input($_POST['usuario']);
        $clave = test_input($_POST['clave']);

        $login = comprobar_usuario($usuario, $clave);

        list($login_existoso, $nif) = $login;

        if ($login_existoso) {
            session_start();
            $_SESSION['nif'] = $nif;
            $_SESSION['usuario'] = $usuario;

            echo '<a href="compro.php">Comprar productos</a><br>';
            echo '<a href="comconscom.php">Consulta de compras</a>';
        }

        else {
            echo 'Error al iniciar sesión';
        }
    }

    function comprobar_usuario($usuario, $clave) {

        $login_exitoso = false;
        $nif = '';

        try {
            $conn = conexion();
            $stmt = $conn -> prepare(
                "SELECT nif
                        FROM cliente
                        WHERE nombre = :usuario AND clave = :clave"
            );

            $stmt -> bindParam(':usuario', $usuario);
            $stmt -> bindParam(':clave', $clave);

            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $cliente = $stmt -> fetchAll();

            if(empty($cliente)) {
                $login_exitoso = false;
                $nif = '';
            }

            else {
                $login_exitoso = true;
                $nif = $cliente[0]['nif'];
            }
        }

        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;

        return [$login_exitoso, $nif];
    }

?>