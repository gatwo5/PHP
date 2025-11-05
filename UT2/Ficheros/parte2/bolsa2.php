<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">

        <p>Nombre valor bursátil:</p>
        <input type="text" name="nombre">

        <button type="submit">enviar</button>
    </form>
</body>
</html>

<?php
    $nombre = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = test_input($_POST['nombre']);
        $lineas = file('ibex35.txt');

        for ($i=1; $i < count($lineas); $i++) { 
        $dato = preg_split('/\s{2,}/', trim($lineas[$i]));
        
        if ($dato[0] == $nombre) {
            echo '<table><tr>';

            foreach ($dato as $dat) {
                echo '<td>' . $dat . '</td>';
            }

            echo '</tr></table>';
        }
        
    }
    }

    // Funciones

    //test_input(). Funcion que recibe datos y los limpia
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
