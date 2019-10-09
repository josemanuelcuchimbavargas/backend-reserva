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
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="Administrador.php" style="margin-right: 10px"><img src="imagenes/logosac.png" width="60"></a>
      <?php if ($consulta['nombre']!=""): ?>
        <a class="navbar-brand" href="Administrador.php"><b><?php echo $nombre ?></b></a>
      <?php endif ?>
      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="<?php if(isset($home)) echo $home ?>"><a href="Administrador.php"><span class="glyphicon glyphicon-home"></span></a></li>

        <li style="color: #fff; padding:14px 10px" class="centrar">Bienvenido (<?php echo $_SESSION['perfil']; ?>)</li>                 
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['nombre'] ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#myModal" data-toggle="modal">Cambiar Contraseña</a></li>
            <li><a href="cerrar_session.php">Cerrar Sesión</a></li>
          </ul>
        </li>
        <li><a href="cerrar_session.php"><span class="glyphicon glyphicon-log-out"></span></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<header id="header">  
  <div class="container">
    <h1 class="peq"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Configuración<small> Sistema de Administración de Canchas</small><?php if ($consulta['logo']!="") echo '<img src="'.$consulta['logo'].'" class="logo">'; ?></h1>
  </div>
</header>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title centrar" id="myModalLabel">CAMBIO DE CONTRASEÑA</h4>

      </div>

      <div class="modal-body">

        <h4 class='centrar'>Señor(a): <?php echo $_SESSION['nombre']; ?> - Usuario <?php echo $_SESSION['identificacion']; ?></h4>  

        <form id="formcu" class="form-horizontal" action="acciones.php?accion=cambiocu" method="post">

          <input type="hidden" name="identificacion" value="<?php echo $_SESSION['identificacion'];  ?>">
          <input type="hidden" name="codigou" value="<?php echo $_SESSION['codigou'];  ?>"><hr>

          <div class="form-group col-md-12">
            <label class="col-md-5 col-md-offset-1 control-label">Contreaseña Anterior *</label>
            <div class="col-md-4">
              <input type="password" class="form-control" name="passworda" required autofocus></td>
            </div>                               
          </div>

          <div class="form-group col-md-12">
            <label class="col-md-5 col-md-offset-1 control-label">Contreaseña Nueva *</label>
            <div class="col-md-4">
              <input type="password" class="form-control" name="passwordn" required></td>
            </div>                               
          </div>
            
          <div class="form-group col-md-12">
            <label class="col-md-5 col-md-offset-1 control-label">Contreaseña Nueva *</label>
            <div class="col-md-4">
              <input type="password" class="form-control" name="passwordcn" required>
            </div>                               
          </div>      

        </form>

      </div>

      <div class="modal-footer" style="margin-top: 140px">

        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" type="submit" form="formcu">Cambiar <span class="glyphicon glyphicon-refresh"></span></button>

      </div>

    </div>

  </div>

</div>