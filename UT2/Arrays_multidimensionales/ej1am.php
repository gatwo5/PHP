<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

        td, tr {
            border: solid;
            text-align: center;
        }

    </style>
</head>
<body>
    <?php
        $array_multiplos_dos = [[],[],[]];
        $multiplos_de_dos = 2;

        echo "<table>" ;

        for ($i=0; $i < 3; $i++) { 
            echo "<tr>";

            for ($j=0; $j < 3; $j++) { 
                $array_multiplos_dos[$i][$j] = $multiplos_de_dos;
                $multiplos_de_dos+=2;

                echo "<td> " . $array_multiplos_dos[$i][$j] . " </td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    ?>
</body>
</html>