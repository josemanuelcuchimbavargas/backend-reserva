<?php 

require_once('clase_conexion.php');

class General{
	
	public function devautoincremento($id, $tabla){

		$cn=new Conexion();

		$maximo="SELECT MAX($id) AS ultimo FROM $tabla";

		$resul=$cn->query($maximo);

		$fila=mysqli_fetch_assoc($resul);

		$max=$fila['ultimo'] + 1;

		$sql="ALTER TABLE $tabla AUTO_INCREMENT= $max";

		$cn->query($sql);

		$cn->close();
	}

	public function session(){

	//Iniciar Sesión
	session_start();

	//Validar si se está ingresando con sesión correctamente
		if (!$_SESSION){

		echo '<script language = javascript>
		alert("usuario no autenticado")
		self.location = "index.php"
		</script>';

		}

	}

	public function sessionad(){

	//Iniciar Sesión
	session_start();

	//Validar si se está ingresando con sesión correctamente
		if (!$_SESSION){

			echo '<script language = javascript>
			alert("Usuario no autenticado")
			self.location = "index.php"
			</script>';

		}elseif ($_SESSION['perfil']!="Administrador" && $_SESSION['perfil']!="SuperAdministrador") {

			echo '<script language = javascript>
			alert("Usuario no Tiene Permisos")
			self.location = "Administrador.php";
			</script>';

		}

	}

	public function sessionsuperad(){

	//Iniciar Sesión
	session_start();

	//Validar si se está ingresando con sesión correctamente
		if (!$_SESSION){

			echo '<script language = javascript>
			alert("Usuario no autenticado")
			self.location = "index.php"
			</script>';

		}elseif ($_SESSION['perfil']!="SuperAdministrador") {

			echo '<script language = javascript>
			alert("Usuario no Tiene Permisos")
			self.location = "Administrador.php";
			</script>';

		}

	}

	function encriptar($cadena){
	    $clave='SESEquipos';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
	    $encriptado = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($clave), $cadena, MCRYPT_MODE_CBC, md5(md5($clave))));
	    return  $encriptado; //Devuelve el string encriptado
 
	}
 
	function desencriptar($cadena){

	    $clave='SESEquipos';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
	    $desencriptado = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($clave), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($clave))), "\0");
	    return $desencriptado;  //Devuelve el string desencriptado

	}

	
}

 ?>