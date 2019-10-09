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

    <title>Unidades de Medida</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">

  </head>

<body>

<?php 

	require_once "clases/clase_general.php";

	$sesion = new General();

	$sesion->sessionad();

	include("header.php")

?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Unidades de Medida</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">

      <?php 

        $inventario="active";

        $unimedida="active";

        include 'menu.php';

      	require_once('clases/clase_producto.php');

      	if (isset($_GET['accion']) && ($_GET['accion'])=="editarum") {

        	$id_umedida=$_GET['id_umedida'];

        	$accion=$_GET['accion'];

        	$producto=new Producto();

        	$consulta=mysqli_fetch_assoc($producto->consultaumid($id_umedida));

        	$umedida=$consulta['unidad'];

        	$abreviacionum=$consulta['abreviacion'];    

        }else{

        	if (isset($_GET['accion'])) {

        	    $accion=$_GET['accion'];

        	}
        	
        	$umedida="";
        	$id_umedida="";
        	$abreviacionum="";
        	$accion="insertarum";

        }

       ?>
		
	<input type="hidden" name="cod_usuario" form="form" value="<?php echo $_SESSION['codigou']; ?>">
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading color-principal">
            <h3 class="panel-title">Unidades de Medida</h3>
          </div>
          <div class="panel-body">
            <div class="row">            
            <form id="form" action="acciones.php?accion=<?php echo $accion ?>&umedida=<?php echo $umedida; ?>&id_umedida=<?php echo $id_umedida; ?>" method="post" class="form-horizontal">
              <div class="form-group col-md-12">
                <label class="col-md-2 col-md-offset-3 control-label">Unidad *</label>
                <div class="col-md-4">
                	<input class="form-control" type="text" name="unidadm" value="<?php echo $umedida; ?>" required autofocus> 
                </div>                               
              </div>
              <div class="form-group col-md-12">
                <label class="col-md-2 col-md-offset-3 control-label">Abreviación *</label>
                <div class="col-md-4">
                	<input class="form-control" type="text" name="abreviacion" value="<?php echo $abreviacionum; ?>" required="">  
                </div>               
              </div>
              

              <div class="form-group col-md-10">	

				        <div class="col-md-6 col-md-offset-5">  

					<?php 

						if (isset($_GET['accion']) && $_GET['accion'] == "editarum") {

							echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Actualizar Unidad</button>";

							echo "<a href='?accion=listarum#listado' class='btn btn-danger' name='ver'>Cancelar</a>";
							
						}else{
							
							echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Crear Unidad</button>";

							echo "<a href='?accion=listarum#listado' class='btn btn-info' name='ver'>Listar Unidad</a>";
              				
						}

					?>     
              		
				</div>
			  </div>		
            </form> 
            <a name="listado"></a>
            </div>

            <div class="row">

            <?php

            require_once 'clases/clase_producto.php';

            if (isset($_GET['accion']) == "listarum") {
          
              $listar = new Producto();

              $listar->listarum();

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
