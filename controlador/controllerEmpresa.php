<?php

require_once('../modelo/clase_empresa.php');

if (isset($_SERVER['HTTP'])) {
    $instancia = new Empresa();
    $tipo = $_POST["tipo"]; /**Con esta variable sabremos si se va a obtener, guardar, actualizar o eliminar. */
    $mensaje = array("data"=>[], "mensaje"=>'',"estado"=>true);
    switch ($tipo) {
        case 'guardar':            

            /** Datos a guardar */
            $nit = $_POST["nit"];
            $nombre = $_POST["nombre"];
            $direccion = $_POST["direccion"];
            $telefono1 = $_POST["telefono1"];
            $telefono2 = $_POST["telefono2"];
            $telefono3 = $_POST["telefono3"];
            $logo = $_POST["logo"];
            $estado = $_POST["estado"];
            $logotemp = $_POST["logotemp"];

            try {
                $mensaje->mensaje = $instancia->creare($nit, $nombre, $direccion, $telefono1, $telefono2, $telefono3, $logo, $estado, $logotemp);
            } catch (\Throwable $th) {
                $mensaje->estado = false;
            }            

            echo json_encode($mensaje);
            break;
        case 'obtener':
            # code...
            break;        
        case 'eliminar':
            # code...
            break;        
        case 'actualizar':
            # code...
            break;        
        default:
            # code...
        break;
    }

    // Codigo a ejecutar si se navega bajo entorno seguro.
} else {
    // Codigo a ejecutar si NO se navega bajo entorno seguro.
}



?>