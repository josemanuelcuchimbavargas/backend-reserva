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

    <title>Administrador</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="calendario/tcal.css" />
    <script type="text/javascript" src="calendario/tcal.js"></script> 

  </head>

<body>

<?php 

    require_once "clases/clase_general.php";
    require_once "clases/clase_reserva.php";

    $sesion = new General();

    $sesion->session();

    $home="active";

    include("header.php");

    $reserva=new Reserva();

    date_default_timezone_set('America/Bogota');

    $hoy=date('Y/m/d');
    
    if (isset($_POST['bbuscar'])) {

      $fecha=$_POST['fecha'];

      $cantidadr=mysqli_num_rows($reserva->cantidadr("Reservada", $fecha));

      $cantidadc=mysqli_num_rows($reserva->cantidadr("Confirmada", $fecha));

    }else{

      $fecha=$hoy;

      $cantidadr=mysqli_num_rows($reserva->cantidadr("Reservada", $fecha));

      $cantidadc=mysqli_num_rows($reserva->cantidadr("Confirmada", $fecha));

    }

?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Home</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">      
      
      <?php 

      include('menu.php');

      $cod_usuario=$_SESSION['codigou'];  

      ?>
      
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading color-principal">
            <h3 class="panel-title">Vistas Rapidas</h3>
          </div>
          <div class="panel-body">

            <form id="form" class="form-inline centrar" action="" method="post">
              <div class="input-group col-sm-1 col-md-4">
                <div class="input-group-addon">Fecha</div>
                <input type="text" name="fecha" class="form-control tcal" value="<?php echo $fecha; ?>" required>
                <span class="input-group-btn">
                  <button type="submit" name="bbuscar" class="btn btn-primary">Busqueda</button>
                </span>                
              </div>         
            </form>
            <br>

            <div class="col-md-3">
              <div class="well dash-box">
                <h2><span class="glyphicon glyphicon-calendar"></span> 

                <?php if ($cantidadr==0) {

                  echo $cantidadr;

                }else{

                  echo "<a href='Admreservas.php?fechai=$fecha&fechaf=$fecha&id_cancha=Todo&estado=Reservada&cod_usuario=$cod_usuario#listado'>".$cantidadr."</a>";

                } ?></h2>
                <h4>C. Reservadas</h4>
              </div>
            </div>
            <div class="col-md-3">
              <div class="well dash-box">
                <h2><span class="glyphicon glyphicon-phone-alt"></span> <?php if ($cantidadc==0) {

                  echo $cantidadc;

                }else{

                  echo "<a href='Admreservas.php?fechai=$fecha&fechaf=$fecha&id_cancha=Todo&estado=Confirmada&cod_usuario=$cod_usuario#listado'>".$cantidadc."</a>";

                } ?></h2>
                <h4>C. Confirmadas</h4>
              </div>
            </div>
            <div class="col-md-3">
              <div class="well dash-box">
                <h2><span class="glyphicon glyphicon-plus"></span>0</h2>
                <h4>Ventas Del Día</h4>
              </div>
            </div>
            <div class="col-md-3">
              <div class="well dash-box">
                <h2><span class="glyphicon glyphicon-minus"></span>0</h2>
                <h4>Gastos Del Día</h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-9 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading color-principal">
            <h3 class="panel-title">Top 10 De Clientes Con Mas Horas Reservadas En El Mes</h3>
          </div>
          <div class="panel-body">
            <?php

            require_once 'clases/clase_reserva.php';

            date_default_timezone_set('America/Bogota');

            $hoy=date('Y/m/d');
            $mes=date('m');
            $fechai=date('Y')."/".$mes."/".date('01');
            $fechaf=$hoy;
            $limit="LIMIT 10";
            $accion="";

            $busqueda = new Reserva();

            $busqueda->cantidadres($fechai, $fechaf, $limit, $accion);

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
