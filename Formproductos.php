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

    <title>Productos</title>

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
      <li class="active">Productos</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      
      	<?php

      	$inventario="active";

      	$productos="active";

      	include 'menu.php';

		require_once("clases/clase_producto.php");

		extract($_GET);

		if (isset($accion) && $accion=="editarp") {

		    $id_producto = $id_producto;

		    $usuario=new Producto();

		    $consulta=mysqli_fetch_assoc($producto->consultaidproducto($id_producto));

		    $nombre=$consulta['nombre'];

		    $descripcion=$consulta['descripcion'];

		    $telefono=$consulta['Telefono'];

		    $cargo=$consulta['Cargo'];

		}else{

			$accion="insertarp";

			$id_producto="";

			$codigo="";

			$producto="";

			$descripcion="";

			$stock="";

			$stockm="";

			$precioc="";

			$preciov="";

		}

		?>

		<input type="hidden" name="cod_usuario" form="form" value="<?php echo $_SESSION['codigou'];  ?>">

		<div class="col-md-9">
		    <div class="panel panel-default">
		        <div class="panel-heading color-principal">
		            <h3 class="panel-title">Productos</h3>
		        </div>
		        <div class="panel-body">
		            <div class="row">  
						<form id="form" class="form-horizontal" action="acciones.php?accion=<?php echo $accion; ?>&id_producto=<?php echo $id_producto; ?>" method="post">

							<div class="form-group col-md-12">
			                	<label class="col-md-3 col-md-offset-2 control-label">Código *</label>
			                	<div class="col-md-4">
			                		<input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>" required <?php if ($accion=="editaru") { echo "readonly";} ?> autofocus placeholder="Lea el Codigo de Barras">
								</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Producto *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="producto" value="<?php echo $producto; ?>" required pattern="[A-Za-züÜñÑáéíóú ]{1,60}" title="Solo puedes ingresar letras y el tamaño maximo es de 60" placeholder="Nombre del Producto">
		                		</div>                               
			             	</div>

			             	<div class="form-group col-md-12">					
								<label for="descripcion" class="col-md-3 col-md-offset-2 control-label">Descripción</label>
								<div class="col-md-4">							
									<textarea cols="31" rows="3" name="descripcion" id="descripcion" maxlength="300" placeholder="Opcional, Agregar las caracteristicas del producto"><?php echo $descripcion ?></textarea>
								</div>
							</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Unidad de Medida *</label>
		                		<div class="col-md-4">
		                			<select class="form-control" name="umedida" id="umedida">

									<?php
									
									    $producto = new Producto();

									    $producto->cargaum($accion, $id_producto);

									?>

									</select>
								</div>                               
			             	</div>

			             	<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Stock *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="stock" value="<?php echo $stock; ?>" required pattern="[0-9]{1,20}" title="Solo puedes ingresar Números" placeholder="Cantidad con la que inicia en inventario">
		                		</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Stock Mímino *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="stockm" value="<?php echo $stockm; ?>" required pattern="[0-9]{1,20}" title="Solo puedes ingresar Números" placeholder="Cantidad minima para alertas">
		                		</div>                               
			             	</div>

			             	<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Precio de Costo *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="precioc" value="<?php echo $precioc; ?>" required pattern="[0-9]{1,20}" title="Solo puedes ingresar Números">
		                		</div>                               
			             	</div>

			             	<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Precio de Venta *</label>
		                		<div class="col-md-4">
		                			<input type="text" class="form-control" name="preciov" value="<?php echo $preciov; ?>" required pattern="[0-9]{1,20}" title="Solo puedes ingresar Números">
		                		</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Categoria *</label>
		                		<div class="col-md-4">
		                			<select class="form-control" name="categoria" id="categoria">

									<?php
									
									    $producto = new Producto();

									    $producto->cargacat($accion, $id_producto);

									?>

									</select>
								</div>                               
			             	</div>

							<div class="form-group col-md-12">
		                		<label class="col-md-3 col-md-offset-2 control-label">Estado *</label>
		                		<div class="col-md-4">
		                			<select class="form-control" name="estado" id="opcion">

									<?php
									
					    				$producto = new Producto();

					    				$producto->cargaest($accion, $id_producto);
									
									?>

									</select>
								</div>                               
			             	</div>

							<div class="form-group col-md-10">			
								<div class="col-md-6 col-md-offset-5">  

									<?php 

										if (isset($_GET['accion']) && $_GET['accion'] == "editarp") {

											echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Actualizar Producto</button>";

											echo "<a href='?accion=listarp#listado' class='btn btn-danger' name='cancelar'>Cancelar</a>"; 
											
										}else{
											
											echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Crear Producto</button>";

											echo "<a href='?accion=listarp#listado' class='btn btn-info' name='ver'>Listar Productos</a>"; 
				              				
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

							if (isset($_GET['accion']) == "listarp") {


							    $producto = new Producto();

							    $producto->listarp();

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