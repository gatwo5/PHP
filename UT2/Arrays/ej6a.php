<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $array_1 = array("Bases Datos", "Entornos Desarrollo", "Programación");
        $array_2 = array("Sistemas informáticos", "FOL", "Mecanizado");
        $array_3 = array("Desarrollo Web ES", "Desarrollo Web EC", "Despliegue", "Desarrollo Interfaces", "Inglés");
        $array_unido = array_merge($array_1,$array_2,$array_3);

        $array_unido = array_reverse($array_unido);

        unset($array_unido[array_search("Mecanizado",$array_unido)]);
        var_dump($array_unido);
    ?>
</body>
</html>