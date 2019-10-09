<?php 

require_once("clase_conexion.php");

/**
* 
*/
class Empresa{
	
	public function creare($nit, $nombre, $direccion, $telefono1, $telefono2, $telefono3, $logo, $estado, $logotemp){

		$cn=new Conexion();

		$nit=$cn->real_escape_string($nit);
		$nombre=$cn->real_escape_string($nombre);
		$direccion=$cn->real_escape_string($direccion);
		$telefono1=$cn->real_escape_string($telefono1);
		$telefono2=$cn->real_escape_string($telefono2);
		$telefono3=$cn->real_escape_string($telefono3);
		$logo=$cn->real_escape_string($logo);
		$estado=$cn->real_escape_string($estado);

		$sql="INSERT INTO empresa (nit, nombre, direccion, telefono1, telefono2, telefono3, logo, estado) VALUES ('$nit', '$nombre', '$direccion', '$telefono1', '$telefono2', '$telefono3', '$logo', '$estado')";

		if ($cn->query($sql)) {

			echo "<script>alert('Empresa Creada...');
			self.location='Formempresa.php?accion=listare#listado';
			</script>";

			move_uploaded_file($logotemp, $logo);
		
		}else{

			echo "<script>alert('Error, No se Creo la Empresa...');
			window.history.back();
			</script>";

		}

        $cn->close();

	}

	public function consultaid($id){

        $cn=new Conexion();

        $sql="SELECT *FROM empresa WHERE id_empresa='$id'";

        $result=$cn->query($sql);

        return $result;

        $cn->close();
    }

    public function consultae(){

        $cn=new Conexion();

        $sql="SELECT *FROM empresa";

        $result=$cn->query($sql);

        return $result;

        $cn->close();
    }

    public function actualizare($nombre, $direccion, $telefono1, $telefono2, $telefono3, $logo, $estado, $logotemp, $id, $logoa)
    {

        $cn=new Conexion();

        $nombre=$cn->real_escape_string($nombre);
        $direccion=$cn->real_escape_string($direccion);
        $telefono1=$cn->real_escape_string($telefono1);
        $telefono2=$cn->real_escape_string($telefono2);
        $telefono3=$cn->real_escape_string($telefono3);
        $logo=$cn->real_escape_string($logo);
        $estado=$cn->real_escape_string($estado);
        $id_empresa=$cn->real_escape_string($id);

        if ($logo!="") {
            
            $sql="UPDATE empresa SET nombre='$nombre', direccion='$direccion', telefono1='$telefono1', telefono2='$telefono2', telefono3='$telefono3', logo='$logo', estado='$estado' WHERE id_empresa='$id_empresa'";
        }else{

            $sql="UPDATE empresa SET nombre='$nombre', direccion='$direccion', telefono1='$telefono1', telefono2='$telefono2', telefono3='$telefono3', estado='$estado' WHERE id_empresa='$id_empresa'";
        }

        if ($cn->query($sql)) {

            echo "<script>alert('Empresa Actualizada...');
            self.location='Formempresa.php?accion=listare#listado';
            </script>";

            if ($logo!="") {

                unlink($logoa);
                
                move_uploaded_file($logotemp, $logo);

            }            
        
        }else{

            echo "<script>alert('Error, No se Actualizo la Empresa...');
            window.history.back();
            </script>";

        }

        $cn->close();

    }

    public function eliminare($id_empresa, $logo)
    {

        $cn=new Conexion();

        $sql="DELETE FROM empresa WHERE id_empresa='$id_empresa'";

         if ($cn->query($sql)) {

             echo "<script>alert('Empresa Eliminada...');
                self.location='Formempresa.php';                
            </script>";

            unlink($logo);

            $general=new General();

            $general->devautoincremento("id_empresa", "empresa" );

        } else {

            echo "<script>alert('Error, Empresa no Eliminada');
            window.history.back();
            </script>";
        }

        $cn->close();

    }


	public function listare()
    {

       $cn= new Conexion();        

        $sql="SELECT * FROM empresa";

        $result=$cn->query($sql);

        if ($result) {
            
            echo "<br><div class='container table-responsive col-md-10 col-md-offset-1 col-xs-12'>

            <table class='table table-bordered table-hover'>
                
            <tr>";

            echo "<th style='vertical-align:middle;'>Logo</th>";
            echo "<th style='vertical-align:middle;'>Nit</th>";     
            echo "<th style='vertical-align:middle;'>Nombre</th>";
            echo "<th style='vertical-align:middle;'>Dirección</th>";        
            echo "<th style='vertical-align:middle;'>Télefonos</th>";
            echo "<th style='vertical-align:middle;'>Estado</th>";
            echo "<th style='vertical-align:middle;' colspan='2'>Opciones</th>";
            echo "</tr>";
        
            $fila=mysqli_fetch_assoc($result);

            $telefonos=$fila['telefono1'];
  
            if ($fila['telefono2']!="") {

                $telefonos=$telefonos." - ".$fila['telefono2'];
            # code...
            }

            if ($fila['telefono3']!="") {

                $telefonos=$telefonos." - ".$fila['telefono3'];
            }

            echo "<tr>";
            echo "<td style='vertical-align:middle'>"; 
            if ($fila['logo']!="") {
                echo "<img src='".$fila['logo']."' width='70'></td>";
            }
            echo "<td style='vertical-align:middle'>".$fila['nit']."</td>";
            echo "<td style='vertical-align:middle'>".$fila['nombre']."</td>";            
            echo "<td style='vertical-align:middle'>".$fila['direccion']."</td>";
            echo "<td style='vertical-align:middle'>".$telefonos."</td>";
            echo "<td style='vertical-align:middle'>".$fila['estado']."</td>";
            echo "<td style='vertical-align:middle'><a href='?accion=editare&id=".$fila['id_empresa']."'><span class='glyphicon glyphicon-pencil'></span></a></td>";
            echo "<td style='vertical-align:middle'><a href='acciones.php?accion=eliminare&id_empresa=".$fila['id_empresa']."&logo=".$fila['logo']."'><span class='glyphicon glyphicon-trash'></span></a></td>";
            echo "</tr>";

            echo "</table></div>";

            echo "<a href='Formempresa.php' class='btn btn-danger col-md-offset-5 col-xs-offset-3'>Cancelar Busqueda</a>";
        }        

        $cn->close();

    }

    public function cargae($id)
    {

        $cn = new Conexion();

        $lista = mysqli_fetch_assoc($this->consultaid($id));

        if ($lista['estado'] == "Activo") {

            echo "<option value='Activo' selected>Activo</option>";
            echo "<option value='Inactivo'>Inactivo</option>";
            
        }else{

            echo "<option value='Activo'>Activo</option>";
            echo "<option value='Inactivo' selected>Inactivo</option>";

        }

        $cn->close();

    }

}

 ?>