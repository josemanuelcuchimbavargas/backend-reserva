<?php 
require_once('clases/clase_conexion.php');

session_start();

if ($_SESSION['nombre']) {

	session_destroy();

	echo "<script>
	alert('Su sessi\u00f3n se ha cerrado correctamente');
	self.location='index.php'
	</script>";
	
}

 ?>