<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $matriz = array([],[],[]);

        echo "<table>";

        for ($i=0; $i < 3; $i++) { 
            echo "<tr>";

            for ($j=0; $j < 5; $j++) { 
                $matriz[$i][$j] = $i + $j;

                echo "<td>" . $matriz[$i][$j] . "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    ?>
</body>
</html>