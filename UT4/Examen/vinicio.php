<?php
include 'funciones.php';

    session_start();

    if (isset($_POST['salir'])) {
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
		<div class="card-header">Menú Usuario </div>
		<div class="card-body">

		<B>Email Cliente:</B>  <?php echo $_SESSION['email']; ?>  <BR>
		<B>Nombre Cliente:</B>  <?php echo $_SESSION['nombre']; ?>  <BR>
		<B>Fecha:</B>   <?php echo $_SESSION['fecha']; ?>  <BR><BR>
	  
		<!--Formulario con enlaces -->
		<div>
			<a href="vreservas.php">RESERVAR VUELOS</a><BR>

			<a href="vconsultas.php">CONSULTAR RESERVA</a>

			<form method="post">
				<input type="submit" value="Salir" name="salir" class="btn btn-warning disabled">
			</form>
		</div>	
	</div>  
   </body>
   
</html>


