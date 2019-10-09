<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="imagenes/favicon.ico">


	<title>Calendario de Reservas</title>

	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="calendario/tcal.css" />  
  	<script type="text/javascript" src="calendario/tcal.js"></script> 

</head>

<body>

<?php 

date_default_timezone_set('America/Bogota');

$hoy=date('Y/m/d');

if (isset($_GET['accion'])) {

	$accion=$_GET['accion'];
	
}else{

$accion="";

}

if ($accion=="busqueda" && isset($_POST['bbuscar'])) {

	$fecha=$_POST['fecha'];

}else{

	$fecha=$hoy;
}

if (isset($_GET['fecha'])) {

	$fecha=$_GET['fecha'];
}

?>

<?php 

	require_once("clases/clase_empresa.php");

	$empresa=new Empresa();

	$consulta=mysqli_fetch_assoc($empresa->consultae());

	$nombre=$consulta['nombre'];

?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
     <a class="navbar-brand" href="Administrador.php" style="margin-right: 10px"><img src="imagenes/logosac.png" width="60"></a>
      <?php if ($consulta['nombre']!=""): ?>
        <a class="navbar-brand" href="Administrador.php"><b><?php echo $nombre ?></b></a>
      <?php endif ?>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
 
  </div><!-- /.container-fluid -->
</nav>

<header id="header">  
  <div class="container">
    <h1 class="peq">Sistema de Administración de Canchas <?php if ($consulta['logo']!="") echo '<img src="'.$consulta['logo'].'" class="logo">'?></h1>
  </div>
</header>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Calendario de Reservas</li>
    </ol>
  </div>
</section>

 <div class="container">

	<div class="panel panel-primary">

		<div class="panel-heading color-principal">

			<h2 class="centrar peq">CALENDARIO DE RESERVAS</h2>			

		</div>

		<div class="panel-body">	

			<form class="form-inline centrar" action="?accion=busqueda" method="post">

				<div class="input-group col-sm-1 col-md-3">

					<div class="input-group-addon">Fecha</div>

					<input type="text" name="fecha" class="form-control tcal" value="<?php echo $fecha; ?>" required>

					<span class="input-group-btn">

						<button type="submit" name="bbuscar" class="btn btn-primary">Busqueda</button>

					</span>	
					
				</div>	

				<br>			
				
			</form>

			<?php 

			$fecha2=date_create($fecha);

			$dias  = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
			$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

			$fecha2 = $dias[date_format($fecha2, "w")] . ", " . date_format($fecha2, 'd') . " de " . $meses[date_format($fecha2, "n") - 1] . " del " . date_format($fecha2, "Y");

			 ?>

			<h4 class="centrar"><?php echo "$fecha2"; ?></h4>

			<?php 

				require_once('clases/clase_reserva.php');

				if ($fecha<$hoy) {

					echo "<h3 align='center'><span class='glyphicon glyphicon-alert'></span> Lo Sentimos No Podemos Mostrar El Calendario Con Fechas Del Pasado...<hr>Por Favor Selecciona Otra Fecha</h3>";
				}else{

				$reserva=new Reserva();

				$reserva->listarcal($fecha, $hoy);

				}

			 ?>			

		</div>

	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h1 class="modal-title centrar" id="myModalLabel">LO SENTIMOS</h1>
      </div>
      <div class="modal-body">
        
        <h3 class="centrar">Ya No Se Puede Reservar Este Horario, No Se Puede Jugar En El Pasado...</h3>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php 

include("footer.php") 

?>

<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
	
</body>
</html>