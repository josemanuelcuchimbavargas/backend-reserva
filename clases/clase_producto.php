<?php 

require_once 'clase_conexion.php';
require_once 'clase_general.php';

class Producto
{
	
	public function insertarum($unidad, $abreviacion, $cod_usuario)
	{

		$cn=new Conexion();

		$unidad=$cn->real_escape_string($unidad);

		$abreviacion=$cn->real_escape_string($abreviacion);

		$sql="INSERT INTO unidades_medida (unidad, abreviacion, cod_usuario) VALUES ('$unidad', '$abreviacion', '$cod_usuario')";

		   if ($cn->query($sql)) {

                 echo "<script>alert('Unidad de Medida Creada...');
                    self.location='Formunimedida.php?accion=listarumc#listado';
                    
                </script>";

       		 } else {

                echo "<script>alert('Error, No se Pudo Crear la Unidad de Medida');
                window.history.back();
                </script>";
        	}
        
        $cn->close();	


	}

	public function consultaumid($id_umedida)
    {

        $cn=new Conexion();

        $sql="SELECT * FROM unidades_medida WHERE codigo='$id_umedida'";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

    public function consultarum()
    {

        $cn=new Conexion();

        $sql="SELECT * FROM unidades_medida";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

     public function consultarumo()
    {

        $cn=new Conexion();

        $sql="SELECT * FROM unidades_medida ORDER BY unidad";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

    public function consultarnum($umedida)
    {

        $cn=new Conexion();

        $sql="SELECT * FROM unidades_medida WHERE unidad='$umedida'";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }


	public function listarum()
	{

		$cn=new Conexion();

		$consulta=$this->consultarum();

		if ($fila=mysqli_fetch_assoc($consulta)!="") {
            
            echo "<hr><div class='container table-responsive col-md-8 col-md-offset-2'>

            <table class='table table-bordered table-hover'>
                
            <tr>";

            echo "<th>CODIGO</th>";     
            echo "<th>UNIDAD DE MEDIDA</th>";
            echo "<th>ABREVIACIÓN</th>";        
            echo "<th colspan='2'>OPCIONES</th>";
            echo "</tr>";

            $consulta=$this->consultarum();

            while ($fila=mysqli_fetch_assoc($consulta)) {

                echo "<tr>";
                echo "</td>";
                echo "<td>".$fila['codigo']."</td>";
                echo "<td>".$fila['unidad']."</td>";            
                echo "<td>".$fila['abreviacion']."</td>";
                echo "<td><a href='?accion=editarum&id_umedida=".$fila['codigo']."'><span class='glyphicon glyphicon-pencil'></span></a></td>";
                echo "<td><a href='acciones.php?accion=eliminarum&id_umedida=".$fila['codigo']."'><span class='glyphicon glyphicon-trash'></span></a></td>";
                echo "</tr>";

            }

            echo "</table></div>";

            echo "<a href='Formunimedida.php' class='btn btn-danger col-md-offset-5 col-xs-offset-3'>Cancelar Busqueda</a>";

            $cn->close();
        }  

	}

	 public function eliminarum($id_umedida)
    {

        $cn=new Conexion();

        $sql="DELETE FROM unidades_medida WHERE codigo='$id_umedida'";

         if ($cn->query($sql)) {

             echo "<script>alert('Unidad de Medida Eliminada...');
                self.location='Formunimedida.php?accion=listarum#listado';                
            </script>";

         	$general=new General();

            $general->devautoincremento("id_umedida", "unidades_medida" );

        } else {

            echo "<script>alert('Error, Unidad de Medida no Eliminada');
            window.history.back();
            </script>";
        }

        $cn->close();

    }

    public function actualizarum($id_umedida, $umedida, $abreviacion, $cod_usuario)
    {

        $cn=new Conexion();

        $umedida=$cn->real_escape_string($umedida);

        $abreviacion=$cn->real_escape_string($abreviacion);

        $sql="UPDATE unidades_medida SET unidad='$umedida', abreviacion='$abreviacion', cod_usuario='$cod_usuario' WHERE codigo='$id_umedida'";

        if ($cn->query($sql)) {

            echo "<script>alert('Unidad de Medida Actualizada...');
                    self.location='Formunimedida.php?accion=listarum#listado'
                    </script>";
            # code...
        } else {

            echo "<script>alert('Error, No se Pudo Actualizar la Unidad de Medida');
                window.history.back();
                </script>";
            # code...
        }

        $cn->close();

    }

    public function cargaum($accion, $id_producto)
    {

        $cn = new Conexion();

        $id_producto = $cn->real_escape_string($id_producto);

        if ($accion == "insertarp") {

            $result = $this->consultarumo();

            while ($lista = mysqli_fetch_assoc($result)) {

                echo "<option value=\"" . $lista['Codigo'] . "\">" . $lista['unidad'] . "</option>";

            }

        } elseif ($accion == "editarp") {

            $result = $this->consultaprodid($id_producto);

            $lista = mysqli_fetch_assoc($result);

            $result2 = $this->consultarumo();

            while ($lista2 = mysqli_fetch_assoc($result2)) {

                if ($lista2['codigo'] == $lista['unidad_medida_codigo']) {

                    echo "<option value=\"" . $lista2['codigo'] . "\" selected>" . $lista2['unidad'] . "</option>";

                } else {

                    echo "<option value=\"" . $lista2['codigo'] . "\">" . $lista2['unidad'] . "</option>";

                }

            }

        }

    }

    public function insertarcat($categoria, $cod_usuario)
    {

        $cn=new Conexion();

        $categoria=$cn->real_escape_string($categoria);

        $sql="INSERT INTO categorias (categoria, cod_usuario) VALUES ('$categoria', '$cod_usuario')";

           if ($cn->query($sql)) {

                 echo "<script>alert('Categoria Creada...');
                    self.location='Formcategorias.php?accion=listarcat#listado';
                    
                </script>";

             } else {

                echo "<script>alert('Error, No se Pudo Crear la Categoria');
                window.history.back();
                </script>";
            }
        
        $cn->close();   


    }

    public function consultacatid($id_categoria)
    {

        $cn=new Conexion();

        $sql="SELECT * FROM categorias WHERE codigo='$id_categoria'";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

    public function consultarcat()
    {

        $cn=new Conexion();

        $sql="SELECT * FROM categorias";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

     public function consultarcato()
    {

        $cn=new Conexion();

        $sql="SELECT * FROM categorias ORDER BY categoria";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

    public function consultarncat($categoria)
    {

        $cn=new Conexion();

        $sql="SELECT * FROM categorias WHERE categoria='$categoria'";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }


    public function listarcat()
    {

        $cn=new Conexion();

        $consulta=$this->consultarcat();

        if ($fila=mysqli_fetch_assoc($consulta)!="") {
            
            echo "<hr><div class='container table-responsive col-md-6 col-md-offset-3'>

            <table class='table table-bordered table-hover'>
                
            <tr>";

            echo "<th>CODIGO</th>";     
            echo "<th>CATEGORIA</th>";
            echo "<th colspan='2'>OPCIONES</th>";
            echo "</tr>";

            $consulta=$this->consultarcat();

            while ($fila=mysqli_fetch_assoc($consulta)) {

                echo "<tr>";
                echo "</td>";
                echo "<td>".$fila['codigo']."</td>";
                echo "<td>".$fila['categoria']."</td>";            
                echo "<td><a href='?accion=editarcat&id_categoria=".$fila['codigo']."' title='Editar'><span class='glyphicon glyphicon-pencil'></span></a></td>";
                echo "<td><a href='acciones.php?accion=eliminarcat&id_categoria=".$fila['codigo']."' title='Eliminar'><span class='glyphicon glyphicon-trash'></span></a></td>";
                echo "</tr>";

            }

            echo "</table></div>";

            echo "<a href='Formcategorias.php' class='btn btn-danger col-md-offset-5 col-xs-offset-3'>Cancelar Busqueda</a>";

            $cn->close();
        }  

    }

     public function eliminarcat($id_categoria)
    {

        $cn=new Conexion();

        $sql="DELETE FROM categorias WHERE codigo='$id_categoria'";

         if ($cn->query($sql)) {

             echo "<script>alert('Categoria Eliminada...');
                self.location='Formcategorias.php?accion=listarcat#listado';                
            </script>";

            $general=new General();

            $general->devautoincremento("id_categoria", "categorias" );

        } else {

            echo "<script>alert('Error, Categoria no Eliminada');
            window.history.back();
            </script>";
        }

        $cn->close();

    }

    public function actualizarcat($id_categoria, $categoria, $cod_usuario)
    {

        $cn=new Conexion();

        $categoria=$cn->real_escape_string($categoria);

        $sql="UPDATE categorias SET categoria='$categoria', cod_usuario='$cod_usuario' WHERE codigo='$id_categoria'";

        if ($cn->query($sql)) {

            echo "<script>alert('Categoria Actualizada...');
                    self.location='Formcategorias.php?accion=listarcat#listado'
                    </script>";
            # code...
        } else {

            echo "<script>alert('Error, No se Pudo Actualizar la Categoria');
                window.history.back();
                </script>";
            # code...
        }

        $cn->close();

    }

    public function cargacat($accion, $id_producto)
    {

        $cn = new Conexion();

        $id_producto = $cn->real_escape_string($id_producto);

        if ($accion == "insertarp") {

            $result = $this->consultarcato();

            while ($lista = mysqli_fetch_assoc($result)) {

                echo "<option value=\"" . $lista['Codigo'] . "\">" . $lista['categoria'] . "</option>";

            }

        } elseif ($accion == "editarp") {

            $result = $this->consultaprodid($id_producto);

            $lista = mysqli_fetch_assoc($result);

            $result2 = $this->consultarcato();

            while ($lista2 = mysqli_fetch_assoc($result2)) {

                if ($lista2['codigo'] == $lista['categoria_codigo']) {

                    echo "<option value=\"" . $lista2['codigo'] . "\" selected>" . $lista2['categoria'] . "</option>";

                } else {

                    echo "<option value=\"" . $lista2['codigo'] . "\">" . $lista2['categoria'] . "</option>";

                }

            }

        }

    }

    public function cargaest($accion, $id_producto){

        $cn=new Conexion();

        if ($accion == "insertarp") {

            echo "<option value='Activo'>Activo</option>";

            echo "<option value='Inactivo'>Inactivo</option>";

        } elseif ($accion== "editarp") {


        }

    }

}

 ?>