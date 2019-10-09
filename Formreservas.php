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

	<title>Solicitud Reserva</title>

	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />	
	<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">

</head>

<body>
<?php 

	require_once('clases/clase_reserva.php');
	require_once('clases/clase_general.php');

	$accion="";
	
	extract($_GET);

	if ($accion=="editarr") {

		$general=new General();

		$general->session();
		
		$reserva= new Reserva();

		$consulta=mysqli_fetch_assoc($reserva->busquedarid($id_reserva));		

		if ($consulta['imagen']!="") {

			$cancha_nombre=$consulta['nombre']." <img src='".$consulta['imagen']."' width='50' height='28'>";

		}else{

			$cancha_nombre=$consulta['nombre'];

		}

		$hora_inicio=$consulta['hora_inicio'];

		$hora_fin=$consulta['hora_fin'];

		$fecha=$consulta['fecha'];

		$horario_id=$consulta['horario_id'];

		$ndocumento=$consulta['n_documento'];

		$nombre_cliente=$consulta['nombre_cliente'];

		$apellido_cliente=$consulta['apellido_cliente'];

		$telefono_cliente=$consulta['telefono_cliente'];

		$email_cliente=$consulta['email_cliente'];

		$solicitud_adicional=$consulta['solicitud_adicional'];		


	}elseif (isset($_GET['id_cancha']) && isset($_GET['horario_id']) && isset($_GET['hora_inicio']) && isset($_GET['hora_fin']) && isset($_GET['fecha'])) {

		$reserva=new Reserva();

		$consulta=mysqli_fetch_assoc($reserva->consultacanid($id_cancha));

		if ($consulta['imagen']!="") {

			$cancha_nombre=$consulta['nombre']." <img src='".$consulta['imagen']."' width='50' height='28'>";

		}else{

			$cancha_nombre=$consulta['nombre'];

		}

		$ndocumento="";

		$nombre_cliente="";

		$apellido_cliente="";

		$telefono_cliente="";

		$email_cliente="";

		$solicitud_adicional="";		

	}

	$fecha2=date_create($fecha);

		$dias  = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
		$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

		$fecha2 = $dias[date_format($fecha2, "w")] . ", " . date_format($fecha2, 'd') . " de " . $meses[date_format($fecha2, "n") - 1] . " del " . date_format($fecha2, "Y");

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
     <a class="navbar-brand" href="#" style="margin-right: 10px"><img src="imagenes/logosac.png" width="70"></a>
     <a class="navbar-brand" href="#"><b><?php echo $nombre ?></b></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
 
  </div><!-- /.container-fluid -->
</nav>

<header id="header">  
  <div class="container">
    <h1 class="peq">Sistema de Administración de Canchas <img src="<?php if ($consulta['logo']!=NULL) echo $consulta['logo'] ?>" width="120" style="margin-left: 40px; border-radius: 20px "></h1>
  </div>
</header>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Solicitud de Reserva</li>
    </ol>
  </div>
</section>

 <div class="container">

	<div class="panel panel-primary">

		<div class="panel-heading color-principal">

			<h2 class="centrar">SOLICITUD DE RESERVA</h2>			

		</div>

		<div class="panel-body">	

	      	<h4 class='centrar'><b>Reserva Para: </b><?php echo "$cancha_nombre"; ?></h4>	
	      	<h4 class='centrar'><b>Fecha:</b> <?php echo "$fecha2"; ?></h4>	
	      	<h4 class='centrar'><b>Hora de Inicio:</b> <?php echo "$hora_inicio"; ?></h4>	
	      	<h4 class='centrar'><b>Hora de Fin:</b> <?php echo "$hora_fin"; ?></h4><br>

	      	<?php 

	      		if ($accion=="editarr") {

	      			echo "<input type='hidden' name='cod_usuario' form='form' value='".$_SESSION['codigou']."'>";

	      			echo "<form id='form' class='form-horizontal' action='acciones.php?accion=editarr&id_reserva=".$id_reserva."&fechai=".$fechai."&fechaf=".$fechaf."&id_cancha=".$id_cancha."&estado=".$estado."' method='post'>";
	      			
	      		}else{

	      			echo "<form class='form-horizontal' action='acciones.php?accion=insertarr&id_cancha=".$id_cancha."&horario_id=".$horario_id."&fecha=".$fecha."' method='post'>";

	      		}

	      	 ?>			
					
					<div class="form-group">
	                	<label class="control-label col-md-2 col-md-offset-3">No. Documento *</label>
	                	<div class="col-md-3">
	                		<input type="text" class="form-control" name="ndocumento" value="<?php echo $ndocumento ?>" required autofocus placeholder="Sin punto, coma o Espacio" pattern="[0-9]{1,20}" title="Por Favor Ingresa un Número de Documento Valido, Solo debe tener números">
						</div>                               
	             	</div>

					<div class="form-group">					
						<label for="nombres" class="control-label col-md-2 col-md-offset-3">Nombres *</label>
						<div class="col-md-3">							
							<input type="text" class="form-control" name="nombres" id="nombress" pattern="[A-Za-zñÑáéíóú ]{1,60}" title="Solo puedes ingresar letras y el tamaño maximo es de 60" required value="<?php echo $nombre_cliente ?>">
						</div>
					</div>
					<div class="form-group">					
						<label for="apellidos" class="control-label col-md-2 col-md-offset-3">Apellidos *</label>
						<div class="col-md-3">							
							<input type="text" class="form-control" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóú ]{1,60}" title="Solo puedes ingresar letras y el tamaño maximo es de 60" required value="<?php echo $apellido_cliente ?>">
						</div>
					</div>
					<div class="form-group">					
						<label for="telefono" class="control-label col-md-2 col-md-offset-3" >Número de Télefono *</label>
						<div class="col-md-3">							
							<input type="text" class="form-control" name="telefono" id="telefono" pattern="[0-9]{1,10}" title="Solo se aceptan numeros y maximo 10 caracteres" required value="<?php echo $telefono_cliente ?>">
						</div>
					</div>
					<div class="form-group">					
						<label for="email" class="control-label col-md-2 col-md-offset-3">Email *</label>
						<div class="col-md-3">							
							<input type="email" class="form-control" name="email" id="email" required value="<?php echo $email_cliente ?>">
						</div>
					</div>

					<?php if ($accion==""){ ?>

						<div class="form-group">					
							<label for="hadicional" class="control-label col-md-2 col-md-offset-3">Horas a Reservar</label>						
							<div class="col-md-3">							
								<select class="form-control" name="horas" id="horas">

									<?php 
										$i=1;									
										while ($i <= 10) {
											echo "<option value='$i'>$i</option>";
											$i++;
										}
									 ?>              				                  
	                  		                
	                			</select>  
							</div>												
						</div>
					<?php } ?>
					<div class="form-group">					
						<label for="solicitud" class="control-label col-md-2 col-md-offset-3">Solicitud Adicional</label>
						<div class="col-md-3">							
							<textarea cols="33" rows="3" name="solicitud" id="solicitud" maxlength="300"><?php echo $solicitud_adicional ?></textarea>
						</div>
					</div>

					<div class="form-group">

						<?php 

							if ($accion=="editarr") {

								echo "<a href='Admreservas.php?fechai=".$fechai."&fechaf=".$fechaf."&id_cancha=".$id_cancha."&estado=".$estado."' class='btn btn-default col-md-offset-4 col-xs-offset-1'> Regresar al Panel</a>
									<button type='submit' class='btn btn-primary'> Actualizar Solicitud</button>";
								# code...
							}else{

								echo "<a href='Formcalendario.php?fecha=".$fecha."' class='btn btn-default col-md-offset-4 col-xs-offset-1'> Regresar al Calendario</a>
									<button type='submit' class='btn btn-primary'> Enviar Solicitud</button>";

							}

						?>
						
					</div>
					
			</form>

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