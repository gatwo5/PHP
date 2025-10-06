<style>

    table,td,tr {
        border: 1px solid black;
        border-collapse: collapse;
    }

</style>

<?php
    $nombre = $apellido1 = $apellido2 = $email = $sexo = "";
    $datos_obligatorios_vacios;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = test_input($_POST["nombre"]);
        $apellido1 = test_input($_POST["apellido1"]);
        $apellido2 = test_input($_POST["apellido2"]);
        $email = test_input($_POST["email"]);
        $sexo = test_input($_POST["sexo"]);
    }

    $datos_obligatorios_vacios = todos_los_datos_tienen_valor($nombre,$email, $sexo);

    if ($datos_obligatorios_vacios) {
        echo "Faltan datos";
    }

    else {
        imprimir_pantalla($nombre, $apellido1, $apellido2, $email, $sexo);
        guardar_fichero($nombre, $apellido1, $apellido2, $email, $sexo);
    }

    // --- FUNCIONES ---

    // Comprobar que todos los datos tienen valor
    function todos_los_datos_tienen_valor($nombre, $email, $sexo) {
        return (empty($nombre) || empty($email) || empty($sexo));
    }

    // Imprimir por pantalla
    function imprimir_pantalla($nombre, $apellido1, $apellido2, $email, $sexo) {
        echo '<h1>Datos Alumnos<h1>';

        echo 
        '<table>
            <tr>
                <td>Nombre</td>
                <td>Apellidos</td>
                <td>Email</td>
                <td>Sexo</td>
            </tr>
            
            <tr>
                <td>'.$nombre.'</td>'.'
                <td>'.$apellido1.' '.$apellido2.'</td>'.'
                <td>'.$email.'</td>'.'
                <td>'.$sexo.'</td>'.'
            </tr>

         </table>';
    }

    // Guardar en fichero datos.txt
    function guardar_fichero($nombre, $apellido1, $apellido2, $email, $sexo) {
        $fichero = ('C:\wamp64\www\ejercicios\DWES\UT3\Formularios\ej6\datos.txt');
        $actual_estado_fichero = file_get_contents($fichero);
        $actual_estado_fichero .= 'Nombre: ' . $nombre . ' Apellidos: ' . $apellido1 . ' ' . $apellido2 . ' Email: ' . $email . ' Sexo: ' . $sexo . "\n";
        file_put_contents($fichero,$actual_estado_fichero);
    }

    // Validar datos
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>