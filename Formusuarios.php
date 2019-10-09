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

    <title>Usuarios</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">

  </head>

<body>

	<?php 

		require_once "clases/clase_general.php";

		$sesion = new General();

		$sesion->sessionad();

		include("header.php");

	?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Usuarios</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      
      	<?php

      	$mantenimiento="active";

      	$usuarios="active";

      	include 'menu.php';

		require_once("clases/clase_usuario.php");
		require_once("clases/clase_general.php");

		extract($_GET);

		if (isset($accion) && $accion=="editaru") {

		    $ndocumento = $ndocumento;

		    $general=new General();

		    $usuario=new Usuario();

		    $consulta=mysqli_fetch_assoc($usuario->consultadoc($ndocumento));

		    $nombre=$consulta['Nombre'];

		    $direccion=$consulta['Direccion'];

		    $telefono=$consulta['Telefono'];

		    $cargo=$consulta['Cargo'];

		    $password=$general->desencriptar($consulta['Password']);

		}else{

			$accion="insertaru";

			$ndocumento="";

			$nombre="";

			$direccion="";

			$telefono="";

			$cargo="";

			$password="";

		}

		?>

		<input type="hidden" name="cod_usuario" form="form" value="<?php echo $_SESSION['codigou'];  ?>">

		<div class="col-md-9">
		    <div class="panel panel-default">
		        <div class="panel-heading color-principal">
		            <h3 class="panel-title">Usuarios</h3>
		        </div>
		        <div class="panel-body">
		            <div class="row">  
						<form id="form" class="form-horizontal" action="acciones.php?accion=<?php echo $accion; ?>&id=<?php echo $ndocumento; ?>" method="post">

							<div class="form-group col-md-12">
			                	<label class="col-md-3 col-md-offset-2 control-label">No. Documento *</label>
			                	<div class="col-md-4">
			                		<input type="text" class="form-control" name="ndocumento" value="<?php echo $ndocumento; ?>" required placeholder="Sin punto, coma o Espacio" pattern="[0-9]{1,20}" title="Por Favor Ingresa un Número de Documento Valido, Solo debe tener números" <?php if ($accion=="editaru") { echo "readonly";} ?>>
								</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Nombre *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" required pattern="[A-Za-züÜñÑáéíóú ]{1,60}" title="Solo puedes ingresar letras y el tamaño maximo es de 60">
		                		</div>                               
			             	</div>

			             	<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Dirección *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="direccion" value="<?php echo $direccion; ?>" required>
		                		</div>                               
			             	</div>

			             	<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Télefono *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="telefono" value="<?php echo $telefono	; ?>" required pattern="[0-9]{1,20}" title="Solo puedes ingresar Números">
		                		</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Cargo *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="cargo" value="<?php echo $cargo; ?>" required pattern="[A-Za-z0-9üÜñÑáéíóú ]{1,60}" title="No puedes Ingresar Caracteres especiales">
		                		</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Perfil *</label>
		                		<div class="col-md-4">
		                			<select class="form-control" name="perfil" id="opcion">

									<?php
									if ($accion == "insertaru") {
									    ?>

											<option value="Usuario">Usuario</option>
											<option value="Administrador" <?php if ($_SESSION['perfil']=="Administrador"){echo "disabled";} ?>>Administrador</option>
											<option value="SuperAdministrador" <?php if ($_SESSION['perfil']=="Administrador"){echo "disabled";} ?>>SuperAdministrador</option>

										<?php

									} elseif ($accion == "editaru") {

									    $usuario = new Usuario();

									    $usuario->cargap($ndocumento);

									}

									?>

									</select>
								</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Contraseña *</label>
		                		<div class="col-md-4">
		                			<input type="password" class="form-control" name="password" value="<?php echo $password; ?>" required>
		                		</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Estado *</label>
		                		<div class="col-md-4">
		                			<select class="form-control" name="estado" id="opcion">

									<?php

									if ($accion == "insertaru") {  ?>

										<option value="Activo">Activo</option>
										<option value="Inactivo">Inactivo</option>

									<?php

									} elseif ($accion== "editaru") {

					    				$usuario = new Usuario();

					    				$usuario->cargae($ndocumento);

									}

									?>

									</select>
								</div>                               
			             	</div>

							<div class="form-group col-md-10">			
								<div class="col-md-6 col-md-offset-5">  

									<?php 

										if (isset($_GET['accion']) && $_GET['accion'] == "editaru") {

											echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Actualizar Usuario</button>";

											echo "<a href='?accion=listaru#listado' class='btn btn-danger' name='cancelar'>Cancelar</a>"; 
											
										}else{
											
											echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Crear Usuario</button>";

											echo "<a href='?accion=listaru#listado' class='btn btn-info' name='ver'>Listar Usuarios</a>"; 
				              				
										}

									?> 				     
		              		
								</div>
					  		</div>
							<a name="listado"></a>
						</form>
					</div>

					<div class="row">
						
						<?php

							require_once 'clases/clase_usuario.php';

							if (isset($_GET['accion']) == "listaru") {


							    $usuario = new Usuario();

							    $usuario->listar();

							} 
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</section>

<?php

include("footer.php") 

?>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
 
</body>
</html>