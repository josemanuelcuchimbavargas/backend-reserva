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
      <li class="active">Horarios</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">

      <?php 

      $mantenimiento="active";

      $horarios="active";

      include 'menu.php';

      $accion="insertarh";

      $id_horario="";

      if (isset($_GET['accion']) && $_GET['accion']=="editarh") {

        extract($_GET);

        $accion="editarh";
        $id_horario=$_GET['id_horario'];
      }

      ?>

      <input type="hidden" name="cod_usuario" form="form" value="<?php echo $_SESSION['codigou'];  ?>">

      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading color-principal">
            <h3 class="panel-title">Horarios</h3>
          </div>
          <div class="panel-body">
            <div class="row">            
              <form id="form" action="acciones.php?accion=<?php echo $accion ?>&id_horario=<?php echo $id_horario ?>" method="post" class="col-md-6 col-md-offset-3">
                <div class="form-group col-md-6">
                  <label>Desde</label>
                 <select class="form-control" name="horai">
                   <?php 

                      require_once('clases/clase_reserva.php');

                      $reserva=new Reserva();

                      $reserva->cargahi($accion, $id_horario);                      

                    ?>
                  
                 </select>          
                </div>
                <div class="form-group col-md-6">
                  <label>Hasta</label>
                  <select class="form-control" name="horaf">
                   <?php 

                      require_once('clases/clase_reserva.php');

                      $reserva=new Reserva();

                      $reserva->cargahf($accion, $id_horario);                      

                    ?>
                  
                 </select>                               
                </div>
                  
                  <?php 

                  if (isset($_GET['accion']) && $_GET['accion'] == "editarh") {

                    echo "<button class='btn btn-primary col-md-offset-2 col-xs-offset-1' type='submit' name='ahorario' style='margin-right:10px'>Actualizar Horario</button>"; 

                    echo "<a href='Formhorarios.php' class='btn btn-danger' name='cancelar'>Cancelar</a>";
              
                 }else{
                  
                  echo "<button class='btn btn-primary col-md-offset-2 col-xs-offset-1' type='submit' name='chorario' style='margin-right:10px'>Crear Horario</button>"; 

                  echo "<a href='Formhorarios.php?accion=listar#listado' class='btn btn-info' name='listar'>Listar Horarios</a>";
                  
                  }

                  ?>

              </form> 
              <a name="listado"></a>
            </div>

            <br>
           
            <div class="row col-md-10 col-md-offset-1">

            <?php

            require_once 'clases/clase_reserva.php';  

            if (isset($_GET['accion'])=="listar") {

              $listar = new Reserva();

              $listar->listarh();

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
