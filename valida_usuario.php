<?php

require_once 'clases/clase_conexion.php';
require_once 'clases/clase_general.php';

if (!isset($_SESSION)) {

    session_start();
}

$cn = new Conexion();

$usuario  = $cn->real_escape_string($_POST['usuario']);
$general = new General();
$password = $general->encriptar($cn->real_escape_string($_POST['password']));

$sql = "SELECT * FROM usuarios WHERE N_Documento='$usuario' AND Password='$password'";

$result = $cn->query($sql);

$fila = mysqli_fetch_array($result);

$sql2 = "SELECT * FROM usuarios WHERE N_Documento='$usuario'";

$result2 = $cn->query($sql2);

$fila2 = mysqli_fetch_array($result2);

if (!$fila2[0]) {

    echo "<script>alert('Usuario No Existe... Por favor Verifique');
    self.location='index.php';</script>";
    # code...
}elseif ($fila['Estado'] == "Inactivo") {

    echo "<script>alert('Usuario Inactivo... Por favor Comuniquese con el Adminstrador');
	self.location='index.php';</script>";

} elseif (!$fila[0]) {

    echo "<script>alert('Usuario o Password Errados... Por favor Verifique');
	self.location='index.php';</script>";

} else {

    $_SESSION['nombre'] = $fila['Nombre'];

    $_SESSION['identificacion'] = $fila['N_Documento'];

    $_SESSION['perfil'] = $fila['Perfil'];

    $_SESSION['estado'] = $fila['Estado'];

    $_SESSION['codigou'] = $fila['Codigo'];

    header("location:Administrador.php");
}

?>
