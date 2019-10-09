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

    include("header.php")

  ?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Listado de Reservas</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      
      <?php 

        $reservas="active";

        $lreservas="active";
        
        include('menu.php');

        require_once('clases/clase_reserva.php');

        date_default_timezone_set('America/Bogota');

        if (isset($_GET['fechai']) && isset($_GET['fechaf']) && isset($_GET['id_cancha']) && isset($_GET['estado'])) {
          
          extract($_GET);

          $accion="busqueda";

          if ($estado=="Todo") {

            $todo="selected";
            $reservada="";
            $confirmada="";
            # code...
          } elseif ($estado=="Reservada") {

            $todo="";
            $reservada="selected";
            $confirmada="";

          }elseif ($estado=="Confirmada") {

            $todo="";
            $reservada="";
            $confirmada="selected";
          }          

        }elseif (isset($_GET['accion']) == "busqueda") {

          extract($_POST);

          extract($_GET);

          if ($estado=="Todo") {

            $todo="selected";
            $reservada="";
            $confirmada="";
            
          } elseif ($estado=="Reservada") {

            $todo="";
            $reservada="selected";
            $confirmada="";

          }elseif ($estado=="Confirmada") {

            $todo="";
            $reservada="";
            $confirmada="selected";

          }

        }else{

        $hoy=date('Y/m/d');
        $fechai=$hoy;
        $fechaf=$hoy;
        $todo="selected";         
        $reservada="";         
        $confirmada="";

        }        

        ?>
      
      <input type="hidden" name="cod_usuario" form="form" value="<?php echo $_SESSION['codigou'];  ?>">
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading color-principal">
            <h3 class="panel-title">Buscar Reservas</h3>
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
              <div class="form-group col-md-6">
                <label>Cancha</label>
                <select class="form-control" name="id_cancha">

                  <option value="Todo">Todo</option>
                  <?php 
                    $reserva=new Reserva();
                    $reserva->cargacan($accion, $id_cancha);
                  ?>
                </select>                
              </div>
              <div class="form-group col-md-6">
                <label>Estado</label>
                  <select class="form-control" name="estado">
                  <option value="Todo" <?php echo "$todo"; ?>>Todo</option>
                  <option value="Reservada" <?php echo "$reservada"; ?>>Reservada</option>
                  <option value="Confirmada" <?php echo "$confirmada"; ?>>Confirmada</option>
                </select>                 
              </div>
              <button class="btn btn-primary btn-group-justified" type="submit" name="reserva">Buscar</button>              
            </form> 
            <a name="listado"></a>
            </div>

            <br>
            <br>

            <div class="row col-md-10 col-md-offset-1">

            <?php

            require_once 'clases/clase_reserva.php';

            if (isset($_GET['accion']) == "busqueda") {

              extract($_POST);

              $busqueda = new Reserva();

              $busqueda->busquedares($id_cancha, $fechai, $fechaf, $estado, $cod_usuario);

            } 

            if (isset($_GET['fechai']) && isset($_GET['fechaf']) && isset($_GET['id_cancha']) && isset($_GET['estado'])) {

              extract($_GET);

              $busqueda = new Reserva();

              $busqueda->busquedares($id_cancha, $fechai, $fechaf, $estado, $cod_usuario);
         
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
