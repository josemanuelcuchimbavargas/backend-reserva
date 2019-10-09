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

	require_once("clases/clase_empresa.php");

	$empresa=new Empresa();

	$consulta=mysqli_fetch_assoc($empresa->consultae());

	$nombre=$consulta['nombre'];

	?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
     <a class="navbar-brand" href="Administrador.php" style="margin-right: 10px"><img src="imagenes/logosac.png" width="60"></a>
      <?php if ($consulta['nombre']!=""): ?>
        <a class="navbar-brand" href="Administrador.php"><b><?php echo $nombre ?></b></a>
      <?php endif ?>
      
    </div>
   </div>
</nav>

<header id="header">  
  <div class="container">
    <h1 class="peq">Sistema de Administración de Canchas <?php if ($consulta['logo']!="") echo '<img src="'.$consulta['logo'].'" class="logo">'; ?></h1>
  </div>
</header>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="active">Login</li>
    </ol>
  </div>
</section>

<div class="container col-md-4 col-md-offset-4 centrar">

	<div class="panel panel-primary">

		<div class="panel-heading color-principal">	

		<h1 class="centrar">Login</h1>

		</div>

		 <div class="panel-body">
		
		<form action="valida_usuario.php" method="post" class="form-horizontal">

		<div class="form-group">
			
			<label for="usuario" class="control-label">Usuario</label>

			<div class="col-md-10 col-md-offset-1">
				
				<input type="text" name="usuario" id="usuario" class="form-control" autofocus required placeholder="No. Documento" pattern="[0-9]{1,20}">

			</div>

		</div>
		
		<div class="form-group">
			
			<label for="password" class="control-label">Contraseña</label>

			<div class="col-md-10 col-md-offset-1">
				
				<input type="password" name="password" id="password" class="form-control" required>

			</div>

		</div>

		<div class="form-group">
			
			<div>
			
				<input type="submit" class="btn btn-primary" name="enviar" value="Ingresar">

			</div>

		</div>
		
		</form>

		</div>

	</div>

</div>


<?php 

include("footer.php");

 ?>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
 
</body>
</html>