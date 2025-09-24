<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> EJ6B - Factorial</title>
</head>
<body>
    <?php
        $num = "123123123";
        $total = 1;
        
        for ($i=1; $i <= $num; $i++) { 
            $total *= $i;
        }

        echo $num . "! = " . $total;

    ?>
</body>
</html>