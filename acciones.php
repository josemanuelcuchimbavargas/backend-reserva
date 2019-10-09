<?php

require_once 'clases/clase_reserva.php';
require_once 'clases/clase_usuario.php';
require_once 'clases/clase_empresa.php';
require_once 'clases/clase_producto.php';

if (isset($_GET['accion'])) {

    $accion = $_GET['accion'];

    extract($_POST);

    extract($_GET);

    if ($accion == "insertarr") {

        $reserva= new Reserva();

        $reserva->insertarr($ndocumento, $nombres, $apellidos, $telefono, $email, $horas, $solicitud, $id_cancha, $fecha, $horario_id);

    }

    if ($accion == "confirmarr") {

        $reserva=new Reserva();

        $reserva->confirmarr($id_reserva, $fechai, $fechaf, $id_cancha, $estado, $cod_usuario);
        
    }

    if ($accion == "eliminarr") {

        $reserva=new Reserva();

        $reserva->eliminarr($id_reserva, $fechai, $fechaf, $id_cancha, $estado, $cod_usuario);
        
    }

    if ($accion == "editarr") {


        $reserva= new Reserva();

        $reserva->actualizar($id_reserva, $ndocumento, $nombres, $apellidos, $telefono, $email, $solicitud, $fechai, $fechaf, $id_cancha, $estado, $cod_usuario);
       

    }

    if ($accion == "insertarc") {

        $reserva=new Reserva();

        $consulta=mysqli_fetch_assoc($reserva->consultarcann($nombrec));

        if ($nombrec!=$consulta['nombre']) {

            if ($_FILES['imagenc']['name']!="") {

                if (($_FILES["imagenc"]["type"] == "image/jpeg") || ($_FILES["imagenc"]["type"] == "image/jpg") || ($_FILES["imagenc"]["type"] == "image/png")){

                    $partnombre = explode(".", $_FILES['imagenc'] ['name']);

                    $extension  = end($partnombre);

                    $nombreca=$nombrec.".".$extension;

                    $ruta="imagenes/canchas/".$nombreca;

                    $imagentemp=$_FILES['imagenc']['tmp_name'];

                    $reserva= new Reserva();

                    $reserva->insertarc($nombrec, $precioc, $ruta, $estadoc, $imagentemp, $cod_usuario);

                }else{

                     echo "<script>alert('No es un Formato de Imagen...');
                            window.history.back();
                            
                        </script>";
                }
            
            }else{

                $ruta="";

                $imagentemp="";

                $reserva= new Reserva();

                $reserva->insertarc($nombrec, $precioc, $ruta, $estadoc, $imagentemp, $cod_usuario);
            }

        }else{

             echo "<script>alert('Ya existe una Cancha con el Mismo Nombre...');
                            window.history.back();
                            
                        </script>";
        }                

    }

    if ($accion=="editarc") {

        if ($nombrec!=$nombrecan) {

            $reserva=new Reserva();

            $consulta=mysqli_fetch_assoc($reserva->consultarcann($nombrec));

            if ($nombrec!=$consulta['nombre']) {

                if ($_FILES['imagenc'] ['name']!="") {

                    if (($_FILES["imagenc"]["type"] == "image/jpeg") || ($_FILES["imagenc"]["type"] == "image/jpg") || ($_FILES["imagenc"]["type"] == "image/png")){

                        $partnombre = explode(".", $_FILES['imagenc'] ['name']);

                        $extension  = end($partnombre);

                        $nombreca=$nombrec.".".$extension;

                        $ruta="imagenes/canchas/".$nombreca;

                        $imagentemp=$_FILES['imagenc'] ['tmp_name'];

                        $reserva= new Reserva();

                        $reserva->actualizarc($nombrec, $precioc, $ruta, $estadoc, $imagentemp, $id_cancha, $cod_usuario);

                    }else{

                         echo "<script>alert('No se Puede Subir una Imagen Con Ese Formato...');
                                window.history.back();
                                
                            </script>";
                    }
                
                }else{

                    $ruta="";

                    $imagentemp="";

                    $reserva= new Reserva();

                    $reserva->actualizarc($nombrec, $precioc, $ruta, $estadoc, $imagentemp, $id_cancha, $cod_usuario);
                }

            }else{

                 echo "<script>alert('Ya existe una Cancha con el Mismo Nombre...');
                                window.history.back();
                                
                            </script>";
            } 

        }else{

            if ($_FILES['imagenc'] ['name']!="") {

                if (($_FILES["imagenc"]["type"] == "image/jpeg") || ($_FILES["imagenc"]["type"] == "image/jpg") || ($_FILES["imagenc"]["type"] == "image/png")){

                    $partnombre = explode(".", $_FILES['imagenc'] ['name']);

                    $extension  = end($partnombre);

                    $nombreca=$nombrec.".".$extension;

                    $ruta="imagenes/canchas/".$nombreca;

                    $imagentemp=$_FILES['imagenc'] ['tmp_name'];

                    $reserva= new Reserva();

                    $reserva->actualizarc($nombrec, $precioc, $ruta, $estadoc, $imagentemp, $id_cancha, $cod_usuario);

                }else{

                     echo "<script>alert('No se Puede Subir una Imagen Con Ese Formato...');
                            window.history.back();
                            
                        </script>";
                }
            
            }else{

                $ruta="";

                $imagentemp="";

                $reserva= new Reserva();

                $reserva->actualizarc($nombrec, $precioc, $ruta, $estadoc, $imagentemp, $id_cancha, $cod_usuario);
            }

        }        

    }

    if ($accion=="eliminarc") {

        $reserva=new Reserva();

        $reserva->eliminarc($id_cancha, $imagen);
       
    }

    if ($accion=="insertarh") {

        $reserva=new Reserva();

        $consulta=mysqli_fetch_assoc($reserva->consultarhor());

        $horaini=$consulta['hora_inicio'];

        $horafin=$consulta['hora_fin'];

        if ($horai==$horaini && $horaf==$horafin) {
            
            echo "<script>alert('Ya existe ese Horario...');
                window.history.back();                                
                </script>";

        }else{

            $reserva->insertarh($horai, $horaf, $cod_usuario);

        }     

    }

    if ($accion=="editarh") {

        $reserva=new Reserva();

        $consulta=mysqli_fetch_assoc($reserva->consultarhor());

        $horaini=$consulta['hora_inicio'];

        $horafin=$consulta['hora_fin'];

        if ($horai==$horaini && $horaf==$horafin) {
            
            echo "<script>alert('Ya existe ese Horario...');
                window.history.back();                                
                </script>";

            }else{

                $reserva->actualizarh($id_horario, $horai, $horaf, $cod_usuario);

            } 
        # code...

    }

    if ($accion=="eliminarh") {

        $reserva=new Reserva();

        $reserva->eliminarh($id_horario);   
        # code...

    }

    if ($accion == "insertaru") {

        $general = new General();

        $password = $general->encriptar($password);

        $usuario = new Usuario();

        $consulta = mysqli_fetch_assoc($usuario->consultadoc($ndocumento));

        $id = $consulta['N_Documento'];
             
        if ($ndocumento != $id) {            

            $usuario = new Usuario();

            $usuario->insertar($ndocumento, $nombre, $direccion, $telefono, $cargo, $perfil, $password, $estado, $cod_usuario);      

       }else{
            
             echo "<script>alert('Ya Existe Ese N\u00FAmero de C\u00E9dula en la Base de Datos...');
                    window.history.back(-1);
                    </script>";
       }

    }

    if ($accion == "editaru") { 

        $general = new General();

        $password = $general->encriptar($password);

        $usuario = new Usuario();

        $usuario->actualizar($ndocumento, $nombre, $direccion, $telefono, $cargo, $perfil, $password, $estado, $cod_usuario);       

    }

    if($accion == "cambiocu") {

        $usuario=new Usuario();

        $consulta = mysqli_fetch_assoc($usuario->consultadoc($identificacion));

        $general=new General();

        $pass=$general->desencriptar($consulta['Password']);

        if ($passworda==$pass) {

            if ($passwordn==$passwordcn) {

                $passwordcn=$general->encriptar($passwordcn);

                $usuario->actualizarpass($identificacion, $codigou, $passwordcn);
            }else{

                echo "<script>alert('Las Contrase\u00f1as Nuevas no son Iguales...');
                       window.history.back();
                     </script>";

            }

        }else{

            echo "<script>alert('La Contrase\u00f1a Anterior no coincide con la Registrada en el Sistema...');
                    self.location = 'Administrador.php';
                  </script>";

        }

    }

    if ($accion=="insertare") {
        
        $empresa=new Empresa();

        if ($_FILES['logo']['name']!="") {

            if (($_FILES["logo"]["type"] == "image/jpeg") || ($_FILES["logo"]["type"] == "image/jpg") || ($_FILES["logo"]["type"] == "image/png")){

                $partnombre = explode(".", $_FILES['logo'] ['name']);

                $extension  = end($partnombre);

                $nombrel=$nombre.".".$extension;

                $ruta="imagenes/".$nombrel;

                $logotemp=$_FILES['logo']['tmp_name'];

                $empresa= new Empresa();

                $empresa->creare($nit, $nombre, $direccion, $telefono1, $telefono2, $telefono3, $ruta, $estado, $logotemp);

            }else{

                 echo "<script>alert('No es un Formato de Imagen...');
                        window.history.back();
                        
                    </script>";
            }
            
        }else{

            $ruta="";

            $logotemp="";

            $empresa= new Empresa();

            $empresa->creare($nit, $nombre, $direccion, $telefono1, $telefono2, $telefono3, $ruta, $estado, $logotemp);
        }
              
    }

    if ($accion=="editare") {
        
        $empresa=new Empresa();

        if ($_FILES['logo']['name']!="") {

            if (($_FILES["logo"]["type"] == "image/jpeg") || ($_FILES["logo"]["type"] == "image/jpg") || ($_FILES["logo"]["type"] == "image/png")){

                $partnombre = explode(".", $_FILES['logo']['name']);

                $extension  = end($partnombre);

                $nombrel=$nombre.".".$extension;

                $ruta="imagenes/".$nombrel;

                $logotemp=$_FILES['logo']['tmp_name'];

                $empresa= new Empresa();

                $empresa->actualizare($nombre, $direccion, $telefono1, $telefono2, $telefono3, $ruta, $estado, $logotemp, $id, $logoa);

            }else{

                 echo "<script>alert('No es un Formato de Imagen...');
                        window.history.back();
                        
                    </script>";
            }
            
        }else{

            $ruta="";

            $logotemp="";

            $empresa= new Empresa();

            $empresa->actualizare($nombre, $direccion, $telefono1, $telefono2, $telefono3, $ruta, $estado, $logotemp, $id, $logoa);
        }
              
    }

    if ($accion=="eliminare") {

        $empresa=new Empresa();

        $empresa->eliminare($id_empresa, $logo);
       
    } 

    if ($accion=="insertarum") {

        $producto=new Producto();

        $producto->insertarum($unidadm, $abreviacion, $cod_usuario);
       
    }

    if ($accion=="eliminarum") {

        $producto=new Producto();

        $producto->eliminarum($id_umedida);
       
    }


    if ($accion=="editarum") {

        $producto=new Producto();

        if ($umedida!=$unidadm) {

            $consulta=mysqli_fetch_assoc($producto->consultarnum($unidadm));

            $consultanum=$consulta['unidad'];

            if ($consultanum==$unidadm) {

                echo "<script>alert('Ya existe esa Unidad de Medida');
                        window.history.back();
                        </script>";

            } else {

                $producto->actualizarum($id_umedida, $unidadm, $abreviacion, $cod_usuario);
            }
            
            # code...
        } else {

            $producto->actualizarum($id_umedida, $unidadm, $abreviacion, $cod_usuario);
            # code...
        }
        
       
    }

    if ($accion=="insertarcat") {

        $producto=new Producto();

        $producto->insertarcat($categoria, $cod_usuario);
       
    }

    if ($accion=="eliminarcat") {

        $producto=new Producto();

        $producto->eliminarcat($id_categoria);
       
    }


    if ($accion=="editarcat") {

        $producto=new Producto();

        if ($categorianom!=$categoria) {

            $consulta=mysqli_fetch_assoc($producto->consultarncat($categoria));

            $consultancat=$consulta['categoria'];

            if ($consultancat==$categoria) {

                echo "<script>alert('Ya existe esa Categoria');
                        window.history.back();
                        </script>";

            } else {

                $producto->actualizarcat($id_categoria, $categoria, $cod_usuario);
            }
            
            # code...
        } else {

            $producto->actualizarcat($id_categoria, $categoria, $cod_usuario);
            # code...
        }
        
       
    }

} 