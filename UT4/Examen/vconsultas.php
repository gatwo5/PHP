<?php

    include 'funciones.php';

    session_start();

    if (isset($_POST['cerrar_sesion'])) {
        cerrar_sesion();
    }

    if (!isset($_SESSION['dni'])) {
        header("Location: index.php");
    }

    
?>

<html>
   
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>RESERVAS VUELOS</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
 </head>
   
 <body>
   

    <div class="container ">
        <!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
		<div class="card-header">Consultar Reservas</div>
		<div class="card-body">
	  	  

	<!-- INICIO DEL FORMULARIO -->
	<form action="" method="post">
	
		<B>Email Cliente:</B>  <?php echo $_SESSION['email']; ?>  <BR>
		<B>Nombre Cliente:</B>  <?php echo $_SESSION['nombre']; ?>  <BR>
		<B>Fecha:</B>   <?php echo $_SESSION['fecha']; ?>  <BR><BR>
		
		<B>Numero Reserva</B><select name="reserva" class="form-control">
				<?php mostrar_reservas() ?>
			</select>	
		<BR><BR><BR><BR><BR><BR><BR>
			<button type="submit" value="Consultar Reserva" name="consultar">CONSULTAR RESERVA</button>
	</form>
	
    <a href="vinicio.php">Volver</a>
	<!-- FIN DEL FORMULARIO -->
    <form method="post">
		<input type="submit" value="Cerrar sesion" name="cerrar_sesion" class="btn btn-warning disabled">
	</form>
  </body>
   
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar'])) {
        $id_reserva = test_input($_POST['reserva']);

        mostrar_datos_reserva($id_reserva);
    }
?>

