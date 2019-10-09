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

    <title>Listado Reservas</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="calendario/tcal.css" />  
  <script type="text/javascript" src="calendario/tcal.js"></script> 

  </head>

<body>

<?php 

    require_once "clases/clase_general.php";

    $sesion = new General();

    $sesion->session();

    include("header.php");

     date_default_timezone_set('America/Bogota');

      $hoy=date('Y/m/d');
      $fechai=$hoy;
      $fechaf=$hoy;

  ?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Total Horas Por Cliente</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      
      <?php 

      $reservas="active";

      $creservas="active";

      include('menu.php'); ?>

      <input type="hidden" name="cod_usuario" form="form" value="<?php echo $_SESSION['codigou'];  ?>">
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading color-principal">
            <h3 class="panel-title">Total Horas Por Cliente</h3>
          </div>
          <div class="panel-body">
            <div class="row">            
            <form id="form" action="?accion=busqueda#listado" method="post" class="col-md-6 col-md-offset-3">
              <div class="form-group col-md-6">
                <label>Desde</label>
                <input class="form-control tcal" type="text" name="fechai" value="<?php echo $fechai ?>">                
              </div>
              <div class="form-group col-md-6">
                <label>Hasta</label>
                <input class="form-control tcal" type="text" name="fechaf" value="<?php echo $fechaf ?>">                
              </div>
              <button class="btn btn-primary col-md-offset-5 col-xs-offset-4" type="submit" name="reserva">Buscar</button>              
            </form> 
            <a name="listado"></a>
            </div>

           
            <?php

            require_once 'clases/clase_reserva.php';

            if (isset($_GET['accion']) == "busqueda") {

              extract($_POST);

              $limit="";

              $busqueda = new Reserva();

              $busqueda->cantidadres($fechai, $fechaf, $limit, $_GET['accion']);

            } 

            ?>

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
