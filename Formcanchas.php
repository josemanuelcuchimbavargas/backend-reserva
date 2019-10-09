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

    <title>Canchas</title>

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
      <li class="active">Canchas</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">

      <?php 

        $mantenimiento="active";

        $canchas="active";

        include 'menu.php';

      	require_once('clases/clase_reserva.php');

      	if (isset($_GET['accion']) && ($_GET['accion'])=="editarc") {

        	$id_cancha=$_GET['id_cancha'];

        	$accion=$_GET['accion'];

        	$reserva=new Reserva();

        	$consulta=mysqli_fetch_assoc($reserva->consultacanid($id_cancha));

        	$nombrecan=$consulta['nombre'];

        	$precioc=$consulta['precio_hora'];    

        	$imagenc=$consulta['imagen'];        	

        }else{

        	if (isset($_GET['accion'])) {

        	    $accion=$_GET['accion'];

        	}
        	
        	$nombrecan="";
        	$id_cancha="";
        	$precioc="";
        	$imagenc="";
        	$accion="insertarc";

        }

       ?>
		
      <input type="hidden" name="cod_usuario" form="form" value="<?php echo $_SESSION['codigou']; ?>">
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading color-principal">
            <h3 class="panel-title">Canchas</h3>
          </div>
          <div class="panel-body">
            <div class="row">            
              <form id="form" action="acciones.php?accion=<?php echo $accion ?>&nombrecan=<?php echo $nombrecan; ?>&id_cancha=<?php echo $id_cancha; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group col-md-12">
                  <label class="col-md-2 col-md-offset-3 control-label">Nombre *</label>
                  <div class="col-md-4">
                  	<input class="form-control" type="text" name="nombrec" value="<?php echo $nombrecan; ?>" required> 
                  </div>                               
                </div>
                <div class="form-group col-md-12">
                  <label class="col-md-2 col-md-offset-3 control-label">Precio *</label>
                  <div class="col-md-4">
                  	<input class="form-control" type="text" name="precioc" value="<?php echo $precioc; ?>" required="">  
                  </div>               
                </div>
                <div class="form-group col-md-12">
                  <label class="col-md-2 col-md-offset-3 control-label">Imagen</label>
                  <div class="col-md-4">
                  	<input class="form-control" type="file" name="imagenc">
                  </div>              
                  <h5><small><?php echo "$imagenc"; ?></small></h5>
                </div>
                <div class="form-group col-md-12">
                  <label class="col-md-2 col-md-offset-3 control-label">Estado *</label>
                  <div class="col-md-4">
                    <select class="form-control" name="estadoc">

                    <?php

                    	if ($_GET['accion']=="editarc") {

                    		$id_cancha=$_GET['id_cancha'];

                       		$reserva->cargaest($id_cancha);

                    	}else{

                    		echo "<option value='Activa'>Activa</option>";
                      		echo "<option value='Inactiva'>Inactiva</option>";
                    	}

                    ?>	     

                    </select>  
                  </div>              
                </div>

                <div class="form-group col-md-10">			
          				<div class="col-md-6 col-md-offset-5">  

          					<?php 

          						if (isset($_GET['accion']) && $_GET['accion'] == "editarc") {

          							echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Actualizar Cancha</button>";

          							echo "<a href='?accion=listarc#listado' class='btn btn-danger' name='ver'>Cancelar</a>";
          							
          						}else{
          							
          							echo "<button class='btn btn-primary' type='submit' name='crear' style='margin-right:20px'>Crear Cancha</button>";

          							echo "<a href='?accion=listarc#listado' class='btn btn-info' name='ver'>Listar Canchas</a>";
                        				
          						}

          					?>     
                        		
          				</div>
                </div>		
              </form> 
              <a name="listado"></a>
            </div>

            <div class="row">

              <?php

              require_once 'clases/clase_reserva.php';

              if (isset($_GET['accion']) == "listarc") {
            
                $listar = new Reserva();

                $listar->listarcan();

              } 

              if (isset($_GET['fechai']) && isset($_GET['fechaf']) && isset($_GET['id_cancha']) && isset($_GET['estado'])) {

                extract($_GET);

                $busqueda = new Reserva();

                $busqueda->busquedares($id_cancha, $fechai, $fechaf, $estado);
           
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
