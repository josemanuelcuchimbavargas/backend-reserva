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

    <title>Empresa</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">

  </head>

<body>

	<?php 

		require_once("clases/clase_general.php");

		$sesion = new General();

		$sesion->sessionsuperad();

		include("header.php");

	?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Empresa</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      
      	<?php

      	$mantenimiento="active";

      	$empressa="active";

      	include 'menu.php';

		require_once("clases/clase_empresa.php");
		require_once("clases/clase_general.php");

		extract($_GET);

		if (isset($accion) && $accion=="editare") {

		    $id = $id;

		    $general=new General();

		    $empresa=new Empresa();

		    $consulta=mysqli_fetch_assoc($empresa->consultaid($id));

		    $nit=$consulta['nit'];

		    $nombre=$consulta['nombre'];

		    $direccion=$consulta['direccion'];

		    $telefono1=$consulta['telefono1'];

		    $telefono2=$consulta['telefono2'];

		    $telefono3=$consulta['telefono3'];

		    $logo=$consulta['logo'];
		 
		}else{

			$accion="insertare";

			$id="";

			$nit="";

			$nombre="";

			$direccion="";

			$telefono1="";

			$telefono2="";

			$telefono3="";

			$logo="";	

		}

		?>

		<div class="col-md-9">
		    <div class="panel panel-default">
		        <div class="panel-heading color-principal">
		            <h3 class="panel-title">Empresa</h3>
		        </div>
		        <div class="panel-body">
		            <div class="row">  
						<form id="form" class="form-horizontal" action="acciones.php?accion=<?php echo $accion; ?>&id=<?php echo $id; ?>&logoa=<?php echo $logo; ?>" method="post" enctype="multipart/form-data">

							<div class="form-group col-md-12">
			                	<label class="col-md-3 col-md-offset-2 control-label">Nit *</label>
			                	<div class="col-md-4">
			                		<input type="text" class="form-control" name="nit" value="<?php echo $nit; ?>" required <?php if ($accion=="editare") { echo "readonly";} ?>>
								</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Nombre *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" required>
		                		</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Dirección *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="direccion" value="<?php echo $direccion; ?>" required>
		                		</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Télefono 1 *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="telefono1" value="<?php echo $telefono1; ?>" required>
		                		</div>                               
			             	</div>

			             	<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Télefono 2</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="telefono2" value="<?php echo $telefono2; ?>">
		                		</div>                               
			             	</div>

			             	<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Télefono 3</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="telefono3" value="<?php echo $telefono3; ?>">
		                		</div>                               
			             	</div>

			             	<div class="form-group col-md-12">
				                <label class="col-md-2 col-md-offset-3 control-label">Logo</label>
				                <div class="col-md-4">
				                	<input class="form-control" type="file" name="logo">
				                </div>              
				                <h5><small><?php echo "$logo"; ?></small></h5>
				            </div>

				            <div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Estado *</label>
		                		<div class="col-md-4">
		                			<select class="form-control" name="estado" id="opcion" required>

									<?php

									if ($accion == "insertare") {  ?>

										<option value="Activo">Activo</option>
										<option value="Inactivo">Inactivo</option>

									<?php

									} elseif ($accion== "editare") {

					    				$empresa = new Empresa();

					    				$empresa->cargae($id);

									}

									?>

									</select>
								</div>                               
			             	</div>

							<div class="form-group col-md-10">			
								
									<?php 

										if (isset($_GET['accion']) && $_GET['accion'] == "editare") {

											echo "<div class='col-md-offset-5 col-xs-offset-1'>";

											echo "<button class='btn btn-primary' type='submit' name='actualizar' style='margin-right:20px'>Actualizar Empresa</button>";

											echo "<a href='?accion=listare#listado' class='btn btn-danger' name='cancelar'>Cancelar</a>"; 
											
										}else{

											$empresa=new Empresa();

											$cantidade=mysqli_num_rows($empresa->consultae());
											
											if ($cantidade==0) {

												echo "<div class='col-md-offset-6 col-xs-offset-4'>";
												
												echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Crear Empresa</button>";
												
											}else{

												echo "<div class='col-md-offset-4'>";

												echo "<a href='?accion=listare#listado' class='btn btn-info col-xs-offset-4' name='listare'>Ver Empresa</a>";
											}										
				              				
										}

									?> 				     
		              		
								</div>
					  		</div>
							<a name="listado"></a>
						</form>
					</div>

					<div class="row">
						
						<?php

							require_once 'clases/clase_empresa.php';

							if (isset($_GET['accion']) == "listare") {

							    $empresa = new Empresa();

							    $empresa->listare();

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