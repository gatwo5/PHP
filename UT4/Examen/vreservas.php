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
		<div class="card-header">Reservar Vuelos</div>
		<div class="card-body">
	  	  

	<!-- INICIO DEL FORMULARIO -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
		<B>Email Cliente:</B>  <?php echo $_SESSION['email']; ?>  <BR>
		<B>Nombre Cliente:</B>  <?php echo $_SESSION['nombre']; ?>  <BR>
		<B>Fecha:</B>   <?php echo $_SESSION['fecha']; ?>  <BR><BR>
		
		<B>Vuelos</B>

		<select name="vuelos" class="form-control">
			<?php mostrar_vuelos(); ?>
		</select>	

		<BR> 
		<B>Número Asientos</B><input type="number" name="asientos" size="3" min="1" max="100" value="1" class="form-control">
		<BR><BR><BR><BR><BR>
		<button type="submit" name="agregar">Agregar al carrito</button>
			
	</form>
	
	<form method="post">
		<button type="submit" name="comprar" value="comprar">Comprar</button>
	</form>

	<form method="post">
        <button type="submit" name="vaciar" value="vaciar">Vaciar carrito</button>
    </form>	

	<a href="vinicio.php">Volver</a>

	<form method="post">
		<input type="submit" value="Cerrar sesion" name="cerrar_sesion" class="btn btn-warning disabled">
	</form>
  </body>
   
</html>

<?php
 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {

	$id_vuelo = test_input($_POST['vuelos']);
	$num_asientos = test_input($_POST['asientos']);

	agregar_vuelo_carrito($id_vuelo, $num_asientos);
	mostrar_carrito();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comprar'])) {

	$hay_asientos = comprobar_asientos_suficientes();

	if($hay_asientos) {
		$id_reserva = calcular_id_reserva();
		actualizar_asientos();
		comprar_vuelos($id_reserva);
		echo 'Vuelos reservados';
	} else {
		echo 'No hay asientos disponibles';
	}

	vaciar_carrito();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vaciar'])) {

	vaciar_carrito();
	echo '';
}
?>

