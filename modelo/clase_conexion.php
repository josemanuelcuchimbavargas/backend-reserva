<?php 

require_once('config.php');

class Conexion extends mysqli{

 public function __construct(){

	parent::__construct(SERVIDOR, USUARIO, CONTRASEÑA, BD);

	$this->query("SET NAMES 'utf8'");

	if ($this->connect_errno) {

		echo "Fallo la conexión... Error No. {$this->connect_errno}";
		# code...
	}else{

		//echo "Conexión exitosa...";
	}

}

}

?>