 <?php 

  require_once("clases/clase_empresa.php");

  $empresa=new Empresa();

  $consulta=mysqli_fetch_assoc($empresa->consultae());

  $nombre=$consulta['nombre'];

  $direccion=$consulta['direccion'];

  $telefonos=$consulta['telefono1'];

  if ($consulta['telefono2']!=NULL) {

  	$telefonos=$telefonos." - ".$consulta['telefono2'];
  	# code...
  }

  if ($consulta['telefono3']!=NULL) {

  	$telefonos=$telefonos." - ".$consulta['telefono3'];
  }

  ?>

<footer class="navbar navbar-fixed-bottom" id="pie">
    <?php 

    	if ($consulta!=NULL) {

    		if ($consulta['estado']=="Activo") {
    			
    			echo "<b>". $nombre. "</b><br>";    			
    			echo "<b>Télefonos: </b>" .$telefonos. "<br>";
    			echo "<b>Dirección: </b>" .$direccion. "<br>";

    		}    		
    	}
    ?>	
	Copyright &copy 2017 | Diseñado por: Jhony Alexander Gonzalez Cordoba - Celular: 3124543479
</footer>