<?php

require_once 'clase_conexion.php';
require_once 'clase_general.php';

class Usuario
{

    public function insertar($ndocumento, $nombre, $direccion, $telefono, $cargo, $perfil, $password, $estado, $cod_usuario)
    {

        $cn = new Conexion();

        $ndocumento = $cn->real_escape_string($ndocumento);
        $nombre     = $cn->real_escape_string($nombre);
        $direccion  = $cn->real_escape_string($direccion);
        $telefono   = $cn->real_escape_string($telefono);
        $cargo   	= $cn->real_escape_string($cargo);
        $perfil     = $cn->real_escape_string($perfil);
        $password 	= $cn->real_escape_string($password);
        $estado 	= $cn->real_escape_string($estado);
        $codigou    = $cn->real_escape_string($cod_usuario);
                
        $sql = "INSERT INTO usuarios (N_Documento, Nombre, Direccion, Telefono, Cargo, Perfil, Password, Estado, Cod_Usuario) VALUES  ('$ndocumento', '$nombre', '$direccion', '$telefono', '$cargo', '$perfil', '$password', '$estado', '$codigou')";

        if ($cn->query($sql)) {

           	echo "<script>alert('Usuario Creado');
			self.location='Formusuarios.php';
			</script>";            

        } else {

            echo "<script>alert('Error... No se Creo el Usuario');
			window.history.back();
			</script>";
        }

        $cn->close();

    }

    public function consultadoc($ndocumento)
    {

        $cn = new conexion();

        $ndocumento = $cn->real_escape_string($ndocumento);

        $sql = "SELECT * FROM usuarios WHERE N_Documento='$ndocumento' ORDER BY nombre";

        $result = $cn->query($sql);

        return $result;

        $cn->close();
        # code...

    }

    public function actualizar($ndocumento, $nombre, $direccion, $telefono, $cargo, $perfil, $password, $estado, $cod_usuario)
    {

        $cn = new Conexion();

        $ndocumento = $cn->real_escape_string($ndocumento);
        $nombre     = $cn->real_escape_string($nombre);
        $direccion  = $cn->real_escape_string($direccion);
        $telefono   = $cn->real_escape_string($telefono);
        $cargo   	= $cn->real_escape_string($cargo);
        $perfil     = $cn->real_escape_string($perfil);
        $password 	= $cn->real_escape_string($password);
        $estado 	= $cn->real_escape_string($estado);
        $codigou    = $cn->real_escape_string($cod_usuario);
        
        $sql = "UPDATE usuarios SET Nombre='$nombre', Direccion='$direccion', Telefono='$telefono', Cargo='$cargo', Perfil='$perfil', Password='$password', Estado='$estado', Cod_Usuario='$codigou' WHERE N_Documento='$ndocumento'";

        if ($cn->query($sql)) {

            echo "<script>alert('Datos Actualizados');
			self.location='Formusuarios.php?accion=listaru#listado';
			</script>";
        } else {

            echo "<script>alert('Error');
			window.history.back();
			</script>";
        }

        $cn->close();

    }

    public function listar()
    {

       $cn= new Conexion();        

         echo "<br><div class='container table-responsive col-md-12 col-xs-12'>

            <table class='table table-bordered table-hover'>
                
            <tr>";

        echo "<th style='vertical-align:middle;'>Identificación</th>";     
        echo "<th style='vertical-align:middle;'>Nombre</th>";
        echo "<th style='vertical-align:middle;'>Dirección</th>";
        echo "<th style='vertical-align:middle;'>Télefono</th>";
        echo "<th style='vertical-align:middle;'>Cargo</th>";        
        echo "<th style='vertical-align:middle;'>Perfil</th>";
        echo "<th style='vertical-align:middle;'>Estado</th>";
        echo "<th style='vertical-align:middle;' colspan='2'>Editar</th>";
        echo "</tr>";
        
        if ($_SESSION['perfil']=="Administrador") {

            $sql="SELECT * FROM usuarios WHERE Perfil='Usuario' ORDER BY Nombre";
                    # code...
        }else{

            $sql="SELECT * FROM usuarios ORDER BY Nombre";

        }

        $result=$cn->query($sql);

        while ($fila=mysqli_fetch_assoc($result)) {

            echo "<tr>";
            echo "<td style='vertical-align:middle;'>".$fila['N_Documento']."</td>";
            echo "<td style='vertical-align:middle;'>".$fila['Nombre']."</td>";
            echo "<td style='vertical-align:middle;'>".$fila['Direccion']."</td>";
            echo "<td style='vertical-align:middle;'>".$fila['Telefono']."</td>";
            echo "<td style='vertical-align:middle;'>".$fila['Cargo']."</td>";            
            echo "<td style='vertical-align:middle;'>".$fila['Perfil']."</td>";
            echo "<td style='vertical-align:middle;'>".$fila['Estado']."</td>";
            echo "<td style='vertical-align:middle;'><a href='?accion=editaru&ndocumento=".$fila['N_Documento']."'><span class='glyphicon glyphicon-pencil'></span></a></td>";
            echo "</tr>";
        }

        echo "</table></div>";

        echo "<a href='Formusuarios.php' class='btn btn-danger col-md-offset-5 col-xs-offset-3'>Cancelar Busqueda</a>";
    }

    public function cargap($id)
    {

        $cn = new Conexion();

        $sql = "SELECT * FROM usuarios WHERE N_documento='$id'";

        $result = $cn->query($sql);

        $lista = mysqli_fetch_assoc($result);

        if ($lista['Perfil'] == "Usuario") {

            echo "<option value='Usuario'>Usuario</option>";
            echo "<option value='Administrador'"; if($_SESSION['perfil']=="Administrador") {echo "disabled";} echo ">Administrador</option>";
            echo "<option value='SuperAdministrador'"; if($_SESSION['perfil']=="Administrador") {echo "disabled";} echo ">SuperAdministrador</option>";
        } elseif ($lista['Perfil'] == "Administrador") {

            echo "<option value='Usuario'>Usuario</option>";
            echo "<option value='Administrador' selected>Administrador</option>";
            echo "<option value='SuperAdministrador'>SuperAdministrador</option>";

        }else{

        	echo "<option value='Usuario'>Usuario</option>";
            echo "<option value='Administrador'>Administrador</option>";
            echo "<option value='SuperAdministrador' selected>SuperAdministrador</option>";

        }

    }

    public function cargae($id)
    {

        $cn = new Conexion();

        $sql = "SELECT * FROM usuarios WHERE N_documento='$id'";

        $result = $cn->query($sql);

        $lista = mysqli_fetch_assoc($result);

        if ($lista['Estado'] == "Activo") {

            echo "<option value='Activo' selected>Activo</option>";
            echo "<option value='Inactivo'>Inactivo</option>";
            
        }else{

        	echo "<option value='Activo'>Activo</option>";
            echo "<option value='Inactivo' selected>Inactivo</option>";

        }

    }

    public function actualizarpass($identificacion, $codigou, $password){

    	$cn=new Conexion();

    	$pass     = $cn->real_escape_string($password);

        $sql = "UPDATE usuarios SET  Password='$pass', Cod_Usuario='$codigou' WHERE N_Documento='$identificacion'";

        if ($cn->query($sql)) {

            echo "<script>alert('Contrase\u00f1a Actualizada');
			self.location='cerrar_session.php';
			</script>";
        } else {

            echo "<script>alert('Error');
			self.location = 'ISActivos.php';
			</script>";
        }

        $cn->close();

    }

}

?>


