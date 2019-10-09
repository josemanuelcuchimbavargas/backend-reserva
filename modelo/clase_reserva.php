<?php

require_once 'clase_conexion.php';
require_once 'clase_general.php';

class Reserva
{

    // Metodo para buscar reserva por id, fecha y horario

    public function busquedar($id_cancha, $fecha, $horario_id)
    {

        $cn = new Conexion();
        $id_cancha = $cn->real_escape_string($id_cancha);
        $fecha = $cn->real_escape_string($fecha);
        $horario_id = $cn->real_escape_string($horario_id);
    
        $sql = "SELECT * FROM reservas  WHERE cancha_id='$id_cancha' AND fecha='$fecha' AND horario_id='$horario_id'";

        $result = $cn->query($sql);

        return $result;

        $cn->close();        

    }

    // Metodo para buscar reserva por id_reserva

     public function busquedarid($id_reserva)
    {

        $cn = new Conexion();
        $id_reserva = $cn->real_escape_string($id_reserva);
     
        $sql = "SELECT r.id_reserva, r.n_documento, r.nombre_cliente, r.apellido_cliente, r.telefono_cliente, r.email_cliente, r.solicitud_adicional, c.nombre, c.imagen, r.fecha, r.horario_id, h.hora_inicio, h.hora_fin  FROM reservas r INNER JOIN canchas c ON r.cancha_id=c.id_cancha INNER JOIN horarios h ON r.horario_id=h.id_horario  WHERE id_reserva='$id_reserva'";

        $result = $cn->query($sql);

        return $result;

        $cn->close();        

    }

    // Metodo para buscar reserva por cancha_id  y estado, recibimos fecha de inicio y fecha de fin para busca entre fechas en la columna fecha

    public function busquedares($id_cancha, $fechai, $fechaf, $estado, $cod_usuario)
    {

        $cn = new Conexion();

        $id_cancha = $cn->real_escape_string($id_cancha);
        $fechai = $cn->real_escape_string($fechai);
        $fechaf = $cn->real_escape_string($fechaf);
        $estado = $cn->real_escape_string($estado);

        if ($id_cancha!="Todo" && $estado!="Todo") {

            $sql = "SELECT r.id_reserva, r.n_documento, r.nombre_cliente, r.apellido_cliente, r.telefono_cliente, r.email_cliente, r.solicitud_adicional, c.nombre, c.imagen, r.fecha, h.hora_inicio, h.hora_fin, r.estado FROM reservas r INNER JOIN canchas c ON r.cancha_id=c.id_cancha INNER JOIN horarios h ON r.horario_id=h.id_horario WHERE r.cancha_id='$id_cancha' AND r.estado='$estado' AND fecha BETWEEN '$fechai' AND '$fechaf' ORDER BY fecha, cancha_id, hora_inicio ASC";

        }else{

            if ($id_cancha!="Todo") {

                $sql = "SELECT r.id_reserva, r.n_documento, r.nombre_cliente, r.apellido_cliente, r.telefono_cliente, r.email_cliente, r.solicitud_adicional, c.nombre, c.imagen, r.fecha, h.hora_inicio, h.hora_fin, r.estado FROM reservas r INNER JOIN canchas c ON r.cancha_id=c.id_cancha INNER JOIN horarios h ON r.horario_id=h.id_horario WHERE cancha_id='$id_cancha' AND fecha BETWEEN '$fechai' AND '$fechaf' ORDER BY fecha, cancha_id, hora_inicio ASC";
          
            }elseif ($estado!="Todo") {

                $sql = "SELECT r.id_reserva, r.n_documento, r.nombre_cliente, r.apellido_cliente, r.telefono_cliente, r.email_cliente, r.solicitud_adicional, c.nombre, c.imagen, r.fecha, h.hora_inicio, h.hora_fin, r.estado FROM reservas r INNER JOIN canchas c ON r.cancha_id=c.id_cancha INNER JOIN horarios h ON r.horario_id=h.id_horario WHERE r.estado='$estado' AND fecha BETWEEN '$fechai' AND '$fechaf' ORDER BY fecha, cancha_id, hora_inicio ASC";

            }else{

                 $sql = "SELECT r.id_reserva, r.n_documento, r.nombre_cliente, r.apellido_cliente, r.telefono_cliente, r.email_cliente, r.solicitud_adicional, c.nombre, c.imagen, r.fecha, h.hora_inicio, h.hora_fin, r.estado FROM reservas r INNER JOIN canchas c ON r.cancha_id=c.id_cancha INNER JOIN horarios h ON r.horario_id=h.id_horario WHERE fecha BETWEEN '$fechai' AND '$fechaf' ORDER BY fecha, cancha_id, hora_inicio ASC";
            }
        }        

        $result = $cn->query($sql);

        while ($fila=mysqli_fetch_assoc($result)) {

            $fecha2=date_create($fila['fecha']);

            $dias  = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $fecha2 = $dias[date_format($fecha2, "w")] . ", " . date_format($fecha2, 'd') . " de " . $meses[date_format($fecha2, "n") - 1] . " del " . date_format($fecha2, "Y");

            echo "<div class='well dash-box'>";

                if ($fila['imagen']!="") {
                    
                    echo "<h3 style='background:#ffffff; color:#000000; padding:10px'>".$fila['nombre']." <img src='".$fila['imagen']."' width=50 height=28></h3>";
                }else{

                    echo "<h3 style='background:#ffffff; color:#000000; padding:10px'>".$fila['nombre']."</h3>";
                }
                
                echo "<h4><b>Datos de Reserva</b></h4>
                <b><span class='glyphicon glyphicon-calendar'></span> Fecha: </b>".$fecha2."<br>
                <b><span class='glyphicon glyphicon-time'></span> Hora: </b>".$fila['hora_inicio']." a ".$fila['hora_fin']."<br>";
                if ($fila['estado']=="Reservada") {

                    echo "<b><span class='glyphicon glyphicon-asterisk'></span> Estado:</b> ".$fila['estado']."<a href='acciones.php?accion=confirmarr&id_reserva=".$fila['id_reserva']."&fechai=$fechai&fechaf=$fechaf&id_cancha=$id_cancha&estado=$estado&cod_usuario=$cod_usuario' style='margin-left:10px' class='btn btn-success btn-xs margen1'>Confirmar</a><hr>";
                    # code...
                }else{

                    echo "<b><span class='glyphicon glyphicon-asterisk'></span> Estado: </b>".$fila['estado']."<hr>";
                }
                
                echo "<h4><b>Datos del Cliente</b></h4>
                <b><span class='glyphicon glyphicon-credit-card'></span> No. Documento: </b>".$fila['n_documento']."<br>
                <b><span class='glyphicon glyphicon-user'></span> Nombre: </b>".$fila['nombre_cliente']." ".$fila['apellido_cliente']."<br>
                <b><span class='glyphicon glyphicon-phone'></span> Télefono: </b>".$fila['telefono_cliente']."<br>
                <b> <span class='glyphicon glyphicon-envelope'></span> Correo: </b>".$fila['email_cliente']."<br>
                <b><span class='glyphicon glyphicon-comment'></span> Solicitud Adicional: </b>".$fila['solicitud_adicional']."<br><hr>";
                               
                echo "<a href='Formreservas.php?accion=editarr&id_reserva=".$fila['id_reserva']."&fechai=$fechai&fechaf=$fechaf&id_cancha=$id_cancha&estado=$estado' style='margin-right:30px' class='btn btn-primary margen1'>Editar</a>";
                echo "<a href='acciones.php?accion=eliminarr&id_reserva=".$fila['id_reserva']."&fechai=$fechai&fechaf=$fechaf&id_cancha=$id_cancha&estado=$estado&cod_usuario=$cod_usuario' class='btn btn-danger'>Cancelar</a>";
                               
            echo "</div>";   
        }

         $cn->close();            

    } 

    //Metodo para buscar Total de Horas Reservadas Por Cliente, Fecha inicia y fecha final.

    public function cantidadres($fechai, $fechaf, $limit, $accion)
    {

        $cn=new Conexion();

        $fechai=$cn->real_escape_string($fechai);
        $fechaf=$cn->real_escape_string($fechaf);

        $sql="SELECT n_documento, nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, COUNT(*) AS Cantidad_Reservas FROM reservas WHERE fecha BETWEEN '$fechai' AND '$fechaf' GROUP BY n_documento ORDER BY Cantidad_Reservas DESC $limit";

       $result=$cn->query($sql);

       if ($fila=mysqli_fetch_assoc($result)!="") {         

            echo "<br><div class='container-fluid table-responsive'>

            <table class='table table-bordered table-hover'>
                
            <tr>";

            echo "<th class='th-top'>POSICIÓN</th>";
            echo "<th class='th-top'>CÉDULA</th>";     
            echo "<th class='th-top'>NOMBRE</th>";
            echo "<th class='th-top'>TÉLEFONO</th>";        
            echo "<th class='th-top'>EMAIL</th>";
            echo "<th class='th-top'>TOTAL HORAS</th>";
            echo "</tr>";

            $result=$cn->query($sql);

            $i=1;

            while ($fila=mysqli_fetch_assoc($result)) {

                echo "<tr>";
                echo "<td>".$i."</td>";
                echo "<td>".$fila['n_documento']."</td>";
                echo "<td>".$fila['nombre_cliente']." ".$fila['apellido_cliente']."</td>";            
                echo "<td>".$fila['telefono_cliente']."</td>";
                echo "<td>".$fila['email_cliente']."</td>";
                echo "<td>".$fila['Cantidad_Reservas']."</td>";
                echo "</tr>";

                $i++;

            }

            echo "</table></div>";

            if ($accion=="busqueda") {          

            echo "<a href='Formcantreservas.php' class='btn btn-danger col-md-offset-5 col-xs-offset-3'>Cancelar Busqueda</a>";

            }

        }

        $cn->close();

    }    

    // Metodo para insertar Reservas en la tabla reservas 

    public function insertarr($ndoc, $nom, $ape, $tel, $ema, $hor, $sol, $cid, $fec, $horario_id)
    {

        $cn= new Conexion();

        $ndoc = $cn->real_escape_string($ndoc);
        $nom = $cn->real_escape_string($nom);
        $ape = $cn->real_escape_string($ape);
        $tel = $cn->real_escape_string($tel);
        $ema = $cn->real_escape_string($ema);
        $hor = $cn->real_escape_string($hor);
        $sol = $cn->real_escape_string($sol);
        $cid = $cn->real_escape_string($cid);
        $fec = $cn->real_escape_string($fec);
        $horario_id = $cn->real_escape_string($horario_id); 

        $i=1;
        $horario_idn=$horario_id;
        while ($i<=$hor) {

            $consulta = mysqli_fetch_assoc($this->busquedar($cid, $fec, $horario_idn));

            if ($consulta) {

                 echo "<script>alert('Lo Sentimos... Alguna de las horas que ha Seleccionado ya no esta Disponible');
                    self.location='Formcalendario.php?fecha=$fec';
                    
                </script>";

                $reservar="Falso";

            }else{

                $reservar="Verdadero";
            }

            $consultah="SELECT * FROM horarios WHERE id_horario='$horario_idn'";

            $resulth=$cn->query($consultah);

            $fila=mysqli_fetch_assoc($resulth);

            $hora_i=$fila['hora_inicio'];

            $consultalh="SELECT * FROM horarios WHERE hora_inicio>'$hora_i' ORDER BY hora_inicio LIMIT 1 ";

            $resultlh=$cn->query($consultalh);

            $fila2=mysqli_fetch_assoc($resultlh);

            $horario_idn=$fila2['id_horario'];

            $i++;

        } 

         if ($reservar=="Verdadero") {

            $i=1;
            $horario_idn=$horario_id;
    
            while ($i<=$hor) {   

                $sql="INSERT INTO reservas (n_documento, nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, solicitud_adicional, cancha_id, fecha, horario_id, estado, cod_usuario) VALUES ('$ndoc', '$nom', '$ape', '$tel', '$ema', '$sol', '$cid', '$fec', '$horario_idn', 'Reservada', '2')";

                if ($cn->query($sql)) {

                     echo "<script>alert('Reserva Realizada... Mas Adelante sera Contactado Por Nosotros Para Confirmar... En Caso que no podamos Confirmar al Telefono del Contacto, se Cancelara y Quedara Disponible Nuevamente en el Calendario');
                        self.location='Formcalendario.php?fecha=$fec';
                        
                    </script>";

                } else {

                    echo "<script>alert('Error, No se Pudo Realizar la Reserva');
                    self.location='Formcalendario.php';
                    </script>";
                }

                $consultah="SELECT * FROM horarios WHERE id_horario='$horario_idn'";

                $resulth=$cn->query($consultah);

                $fila=mysqli_fetch_assoc($resulth);

                $hora_i=$fila['hora_inicio'];

                $consultalh="SELECT * FROM horarios WHERE hora_inicio>'$hora_i' ORDER BY hora_inicio LIMIT 1 ";

                $resultlh=$cn->query($consultalh);

                $fila2=mysqli_fetch_assoc($resultlh);

                $horario_idn=$fila2['id_horario'];

                $i++;

            }

         }
       
        $cn->close();

    } 

    // Metodo para Actualizar Reserva

    public function actualizar($id_reserva, $doc, $nom, $ape, $tel, $ema, $sol, $fechai, $fechaf, $id_cancha, $estado, $cod_usuario)
    {

        $cn= new Conexion();

        $doc = $cn->real_escape_string($doc);
        $nom = $cn->real_escape_string($nom);
        $ape = $cn->real_escape_string($ape);
        $tel = $cn->real_escape_string($tel);
        $ema = $cn->real_escape_string($ema);
        $sol = $cn->real_escape_string($sol);

              $sql="UPDATE reservas SET n_documento='$doc', nombre_cliente='$nom', apellido_cliente='$ape', telefono_cliente='$tel', email_cliente='$ema', solicitud_adicional='$sol', cod_usuario='$cod_usuario' WHERE id_reserva='$id_reserva'";

            if ($cn->query($sql)) {

                 echo "<script>alert('Reserva Actualizada...');
                    self.location='Admreservas.php?fechai=$fechai&fechaf=$fechaf&id_cancha=$id_cancha&estado=$estado&cod_usuario=$cod_usuario#listado';
                    
                </script>";

            } else {

                echo "<script>alert('Error, No se Pudo Actualizar la Reserva');
                window.history.back(-1);
                </script>";
            }

        $cn->close();

    } 

    // Metodo que cambia el estado de Reservada a Confirmada en las reservas

    public function confirmarr($id_reserva, $fechai, $fechaf, $id_cancha, $estado, $cod_usuario)
    {

        $cn=new Conexion();

        $sql="UPDATE reservas SET estado='Confirmada', cod_usuario='$cod_usuario' WHERE id_reserva='$id_reserva'";

        $result=$cn->query($sql);

         if ($cn->query($sql)) {

             echo "<script>alert('Reserva Confirmada');
                self.location='Admreservas.php?fechai=$fechai&fechaf=$fechaf&id_cancha=$id_cancha&estado=$estado&cod_usuario=$cod_usuario#listado';                
            </script>";

        } else {

            echo "<script>alert('Error, Reserva no Confirmada');
            self.location='Admreservas.php?fechai=$fechai&fechaf=$fechaf&id_cancha=$id_cancha&estado=$estado&cod_usuario=$cod_usuario';
            </script>";
        }

        $cn->close();
    
    }

    // Metodo Para Eliminar una Reserva

    public function eliminarr($id_reserva, $fechai, $fechaf, $id_cancha, $estado, $cod_usuario)
    {

        $cn=new Conexion();

        $sql="DELETE FROM reservas WHERE id_reserva='$id_reserva'";

         if ($cn->query($sql)) {

             echo "<script>alert('Reserva Eliminada, Se Habilitara Nuevamente el Horario Para que se Pueda Reservar');
                self.location='Admreservas.php?fechai=$fechai&fechaf=$fechaf&id_cancha=$id_cancha&estado=$estado&cod_usuario=$cod_usuario#listado';                
            </script>";

            $general=new General();

            $general->devautoincremento("id_reserva", "reservas" );

        } else {

            echo "<script>alert('Error, Reserva no Eliminada');
            self.location='Admreservas.php?fechai=$fechai&fechaf=$fechaf&id_cancha=$id_cancha&estado=$estado&cod_usuario=$cod_usuario';
            </script>";
        }

        $cn->close();
    
    }

    // Metodo para obtener cantidad de reservas

    public function cantidadr($estado, $fecha)
    {

        $cn=new Conexion();

        $fecha=$cn->real_escape_string($fecha);

        $sql="SELECT * FROM reservas WHERE estado='$estado' AND fecha='$fecha'";

        $result=$cn->query($sql);

        return $result;

    }

    // Metodo para Insertar Canchas

    public function insertarc($nombre, $precio, $imagen, $estado, $imagentemp, $cod_usuario)
    {

        $cn=new Conexion();

        $nombre = $cn->real_escape_string($nombre);
        $precio = $cn->real_escape_string($precio);
        $imagen = $cn->real_escape_string($imagen);
        $estado = $cn->real_escape_string($estado);

        $sql="INSERT INTO canchas (nombre, precio_hora, imagen, estado, cod_usuario) VALUES ('$nombre', '$precio', '$imagen', '$estado', $cod_usuario)";

         if ($cn->query($sql)) {

                 echo "<script>alert('Cancha Creada...');
                    self.location='Formcanchas.php?accion=listarc#listado';
                    
                </script>";

                move_uploaded_file($imagentemp, $imagen);

        } else {

                echo "<script>alert('Error, No se Pudo Crear la Cancha');
                window.history.back();
                </script>";
        }
        
        $cn->close();

    }

    //Metodo para eliminar Cancha

    public function eliminarc($id_cancha, $imagen)
    {

        $cn=new Conexion();

        $sql="DELETE FROM canchas WHERE id_cancha='$id_cancha'";

         if ($cn->query($sql)) {

             echo "<script>alert('Cancha Eliminada...');
                self.location='Formcanchas.php?accion=listarc#listado';                
            </script>";

            unlink($imagen);

            $general=new General();

            $general->devautoincremento("id_cancha", "canchas" );

        } else {

            echo "<script>alert('Error, Cancha no Eliminada');
            window.history.back();
            </script>";
        }

        $cn->close();

    }

    // Metodo para consultar canchas

    public function consultarcan()
    {

        $cn=new Conexion();

        $sql="SELECT * FROM canchas";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

    //Metodo para consultar cancha por Nombre

    public function consultarcann($nombrec)
    {

        $cn=new Conexion();

        $nombrec=$cn->real_escape_string($nombrec);

        $sql="SELECT * FROM canchas WHERE nombre='$nombrec'";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

    // Metodo para consultar cancha por el campo id_cancha en la tabla canchas

    public function consultacanid($id_cancha)
    {

        $cn=new Conexion();

        $sql="SELECT * FROM canchas WHERE id_cancha='$id_cancha'";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

    // Metodo para cargar las canchas existentes en el campo select

    public function cargacan($accion, $id_cancha)
    {

        if ($accion=="") {

            $cn = new Conexion();

            $sql = "SELECT * FROM canchas";

            $result = $cn->query($sql);

            while ($lista = mysqli_fetch_assoc($result)) {

                echo "<option value=\"" . $lista['id_cancha'] . "\">" . $lista['nombre'] . "</option>";

            }

        } elseif ($accion == "busqueda") {

            $consulta = new Conexion();

            $result = $this->consultarcan();

            while ($lista = mysqli_fetch_assoc($result)) {

                if ($lista['id_cancha'] == $id_cancha) {

                    echo "<option value=\"" . $lista['id_cancha'] . "\" selected>" . $lista['nombre'] . "</option>";

                } else {

                    echo "<option value=\"" . $lista['id_cancha'] . "\">" . $lista['nombre'] . "</option>";

                }

            }

        }       
    
    }

    public function cargaest($id_cancha)
    {

        $cn = new Conexion();

        $sql = "SELECT * FROM canchas WHERE id_cancha='$id_cancha'";

        $result = $cn->query($sql);

        $lista = mysqli_fetch_assoc($result);

        if ($lista['estado'] == "Activa") {

            echo "<option value='Activa' selected>Activa</option>";
            echo "<option value='Inactiva'>Inactiva</option>";

        } else {

            echo "<option value='Activa'>Activa</option>";
            echo "<option value='Inactiva' selected>Inactiva</option>";

        }

    }

    //Metodo para listar Canchas

    public function listarcan()
    {

        $cn= new Conexion();        

        $consultarcan=$this->consultarcan();

        if ($fila=mysqli_fetch_assoc($consultarcan)!="") {
            
            echo "<br><div class='container table-responsive col-md-10 col-md-offset-1 col-xs-1'>

            <table class='table table-bordered table-hover'>
                
            <tr>";

            echo "<th style='vertical-align:middle;'>IMAGEN</th>";     
            echo "<th style='vertical-align:middle;'>NOMBRE</th>";
            echo "<th style='vertical-align:middle;'>PRECIO / HORA</th>";        
            echo "<th style='vertical-align:middle;'>ESTADO</th>";
            echo "<th style='vertical-align:middle;' colspan='2'>OPCIONES</th>";
            echo "</tr>";

            $consultarcan=$this->consultarcan();    

            while ($fila=mysqli_fetch_assoc($consultarcan)) {

                echo "<tr>";
                echo "<td>"; 
                if ($fila['imagen']!="") {
                    
                    echo "<img src='".$fila['imagen']."' width=50 height=28>";

                }
                echo "</td>";
                echo "<td>".$fila['nombre']."</td>";
                echo "<td>".$fila['precio_hora']."</td>";            
                echo "<td>".$fila['estado']."</td>";
                echo "<td><a href='?accion=editarc&id_cancha=".$fila['id_cancha']."'><span class='glyphicon glyphicon-pencil'></span></a></td>";
                echo "<td><a href='acciones.php?accion=eliminarc&id_cancha=".$fila['id_cancha']."&imagen=".$fila['imagen']."'><span class='glyphicon glyphicon-trash'></span></a></td>";
                echo "</tr>";

            }

            echo "</table></div>";

            echo "<a href='Formcanchas.php' class='btn btn-danger col-md-offset-5 col-xs-offset-3'>Cancelar Busqueda</a>";
        }  
    
    }

    // Metodo para Actualizar Canchas

    public function actualizarc($nombre, $precio, $imagen, $estado, $imagentemp, $id_cancha, $cod_usuario)
    {

        $cn= new Conexion();

        $nombre = $cn->real_escape_string($nombre);
        $precio = $cn->real_escape_string($precio);
        $imagen = $cn->real_escape_string($imagen);
        $estado = $cn->real_escape_string($estado);

        if ($imagen!="") {

            $sql="UPDATE canchas SET nombre='$nombre', precio_hora='$precio', imagen='$imagen', estado='$estado', cod_usuario='$cod_usuario' WHERE id_cancha='$id_cancha'";

        }else{

            $sql="UPDATE canchas SET nombre='$nombre', precio_hora='$precio', estado='$estado', cod_usuario='$cod_usuario' WHERE id_cancha='$id_cancha'";

        }           

            if ($cn->query($sql)) {

                 echo "<script>alert('Cancha Actualizada...');
                    self.location='Formcanchas.php?accion=listarc#listado';
                    
                </script>";

                if ($imagen!="") {

                    move_uploaded_file($imagentemp, $imagen);
                }                

            } else {

                echo "<script>alert('Error, No se Pudo Actualizar la Cancha');
                window.history.back(-1);
                </script>";
            }

        $cn->close();

    } 

    // Metodo que crea y lista el calendario de reservas

    public function listarcal($fecha, $hoy)
    {

        $cn=new Conexion();    

        $consultacan=$this->consultarcan();    

        $consultahor=$this->consultarhor();

        $catidadhor=mysqli_num_rows($this->consultarhor());

        $hora_actual=date("H:i");

        echo "<div class='container table-responsive col-md-10 col-md-offset-1 col-xs-12'>

                <table class='table table-bordered table-hover'>
                    
                    <tr>";

                    while ($fila=mysqli_fetch_assoc($consultacan)) {

                        if ($fila['estado']=="Activa") {

                            echo "<th>".$fila['nombre'];

                            if ($fila['imagen']!="") {
                                echo " <img src='".$fila['imagen']."' class='imagencan'>";
                            }

                            echo "</th>";
                            # code...
                        }                       
                       
                    }                         

                    echo "</tr>";

                    while ($fila=mysqli_fetch_assoc($consultahor)) {  

                    $consultacan=$this->consultarcan();                     

                     echo "<tr>";

                         while ($columna=mysqli_fetch_assoc($consultacan)){

                            if ($columna['estado']=="Activa") {
                            
                                $consulta = mysqli_fetch_assoc($this->busquedar($columna['id_cancha'], $fecha, $fila['id_horario']));

                                $estado=$consulta['estado'];

                                $nombre=$consulta['nombre_cliente']." ".$consulta['apellido_cliente'];

                                if ($estado=="Reservada") {

                                    echo "<td  style='background: #DBEC1B; color:black;'>";

                                    echo "<b>Hora: ".$fila['hora_inicio']." a ".$fila['hora_fin']."<br>Precio: ".$columna['precio_hora']."<br><img src='imagenes/reservada.png'><br><p style='font-size: xx-small'>Por: ".$nombre."</b></p>";

                                    echo "</td>";

                                }elseif ($estado=="Confirmada") {
                                    
                                    echo "<td  style='background: #339403; color:black'>";

                                    echo "<b>Hora: ".$fila['hora_inicio']." a ".$fila['hora_fin']."<br>Precio: ".$columna['precio_hora']."<br><img src='imagenes/confirmada.png'><br><p style='font-size: xx-small'>Por: ".$nombre."</b></p>"; 

                                }else{

                                    if ($hora_actual<=$fila['hora_inicio']) {

                                        echo "<td style='color:black'>";

                                        echo "<b>Hora: ".$fila['hora_inicio']." a ".$fila['hora_fin']."<br>Precio: ".$columna['precio_hora']."</b><br><a href='Formreservas.php?id_cancha=".$columna['id_cancha']."&horario_id=".$fila['id_horario']."&hora_inicio=".$fila['hora_inicio']."&hora_fin=".$fila['hora_fin']."&fecha=$fecha'><img src='imagenes/reservar.png'></a>";

                                        echo "</td>";                                           

                                    }elseif ($hoy<$fecha) {
                                        # code...
                                        echo "<td style='color:black;'>";

                                        echo "<b>Hora: ".$fila['hora_inicio']." a ".$fila['hora_fin']."<br>Precio: ".$columna['precio_hora']."</b><br><a href='Formreservas.php?id_cancha=".$columna['id_cancha']."&horario_id=".$fila['id_horario']."&hora_inicio=".$fila['hora_inicio']."&hora_fin=".$fila['hora_fin']."&fecha=$fecha'><img src='imagenes/reservar.png'></a>";

                                        echo "</td>";

                                    }else{

                                        echo "<td style='color:black'>";

                                        echo "<b>Hora: ".$fila['hora_inicio']." a ".$fila['hora_fin']."<br>Precio: ".$columna['precio_hora']."</b><br><a href='#modal' data-toggle='modal'><img src='imagenes/reservar.png'></a>";

                                        echo "</td>";

                                    }

                                }

                            }
                        }                                  

                        echo "</tr>";
                        # code...
                    }
                    
            echo "</table>

        </div>";

    }

    // Metodo para consultar y listar los horarios que hay en la tabla horarios

    public function consultarhor()
    {

        $cn=new Conexion();

        $sql="SELECT * FROM horarios ORDER BY hora_inicio ASC";

        $result=$cn->query($sql);

        return $result;

        $cn->close();

    }

    // Metodo para insertar horarios

    public function insertarh($horai, $horaf, $cod_usuario)
    {

        $cn=new Conexion();

        $horai=$cn->real_escape_string($horai);
        $horaf=$cn->real_escape_string($horaf);

        $sql="INSERT INTO horarios (hora_inicio, hora_fin, cod_usuario) VALUES ('$horai', '$horaf', '$cod_usuario')";

        if ($cn->query($sql)) {

             echo "<script>alert('Horario Creado...');
                self.location='Formhorarios.php?accion=listar#listado';
                
            </script>";

        } else {

            echo "<script>alert('Error, No se Pudo Crear el horario');
            window.history.back();
            </script>";
        }
                    
        $cn->close();

    }

    // Metodo para Actualizar Horarios

     public function actualizarh($id_horario, $horai, $horaf, $cod_usuario)
    {

        $cn=new Conexion();

        $horai=$cn->real_escape_string($horai);
        $horaf=$cn->real_escape_string($horaf);
        $id_horario=$cn->real_escape_string($id_horario);

        $sql="UPDATE horarios SET hora_inicio='$horai', hora_fin='$horaf', cod_usuario='$cod_usuario' WHERE id_horario='$id_horario'";

        if ($cn->query($sql)) {

             echo "<script>alert('Horario Actualizado...');
                self.location='Formhorarios.php?accion=listar#listado';
                
            </script>";

        } else {

            echo "<script>alert('Error, No se Pudo Actualizar el horario');
            window.history.back();
            </script>";
        }
                    
        $cn->close();

    }

    // Metodo para eliminar Horario

    public function eliminarh($id_horario)
    {

        $cn=new Conexion();

        $sql="DELETE FROM horarios WHERE id_horario='$id_horario'";

        if ($cn->query($sql)) {

            echo "<script>alert('Horario Eliminado...');
            self.location='formhorarios.php#listado';
            </script>";

            $general=new General();

            $general->devautoincremento("id_horario", "horarios" );
            # code...
        }else {

            echo "<script>alert('Error, No se Pudo Eliminar el horario');
            window.history.back();
            </script>";
        }
                    
        $cn->close();

    }

    // Metodo para listar Hora

    public function listarh()
    {

        $consulta=$this->consultarhor();

        if ($fila=mysqli_fetch_assoc($consulta)!="") {
                  
          echo " <hr><br>";

          echo "<div class='container table-responsive col-md-10 col-md-offset-1 col-xs-1'>

          <table class='table table-bordered table-hover'>
            
          <tr>";

          echo "<th>ID</th>";     
          echo "<th>HORA</th>";
          echo "<th colspan='2'>OPCIONES</th>";

          $consulta=$this->consultarhor();
      
          while ($fila=mysqli_fetch_assoc($consulta)) {

            echo "<tr><td>";
            echo $fila['id_horario'];
            echo "</td><td>";
            echo $fila['hora_inicio']." a ".$fila['hora_fin'];
            echo "</td><td>";
            echo "<a href='?accion=editarh&id_horario=".$fila['id_horario']."'><span class='glyphicon glyphicon-pencil'></span></a>"; 
            echo "</td><td>";
            echo "<a href='acciones.php?accion=eliminarh&id_horario=".$fila['id_horario']."'><span class='glyphicon glyphicon-trash'></span></a>";
            echo "</td></tr>";
            
          }

          echo "</table></div>";

          echo "<a href='Formhorarios.php' class='btn btn-danger col-md-offset-5 col-xs-offset-3' name='cancelarb'>Cancelar Busqueda</a>";
        } 

    }

    public function cargahi($accion, $id_horario)
    {

        if ($accion=="insertarh") {

            $horario=array("00:00:00", "01:00:00", "02:00:00", "03:00:00", "04:00:00", "05:00:00", "06:00:00", "07:00:00", "08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00", "18:00:00", "19:00:00", "20:00:00", "21:00:00", "22:00:00", "23:00:00", );
 
            $cantidad=count($horario);

            $contador=0;

            while ( $contador< $cantidad) {

                echo "<option value='".$horario[$contador]."'>".$horario[$contador]."</option>";

                $contador++;
            }        

        }elseif ($accion=="editarh") {

            $horario=array("00:00:00", "01:00:00", "02:00:00", "03:00:00", "04:00:00", "05:00:00", "06:00:00", "07:00:00", "08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00", "18:00:00", "19:00:00", "20:00:00", "21:00:00", "22:00:00", "23:00:00", );

            $cantidad=count($horario);

            $contador=0;

            $cn= new Conexion();

            $sql="SELECT * FROM horarios WHERE id_horario='$id_horario'";

            $result=$cn->query($sql);

            $lista=mysqli_fetch_assoc($result);            

            while ( $contador< $cantidad) {

                if ($lista['hora_inicio']==$horario[$contador]) {

                echo "<option value='".$horario[$contador]."' selected>".$horario[$contador]."</option>";      

                }else{

                    echo "<option value='".$horario[$contador]."'>".$horario[$contador]."</option>";
                }

            $contador++;

            }
             
        }

    }

    public function cargahf($accion, $id_horario)
    {

        if ($accion=="insertarh") {

            $horario=array("00:00:00", "01:00:00", "02:00:00", "03:00:00", "04:00:00", "05:00:00", "06:00:00", "07:00:00", "08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00", "18:00:00", "19:00:00", "20:00:00", "21:00:00", "22:00:00", "23:00:00", );
 
            $cantidad=count($horario);

            $contador=0;

            while ( $contador< $cantidad) {

                echo "<option value='".$horario[$contador]."'>".$horario[$contador]."</option>";

                $contador++;
            }        

        }elseif ($accion=="editarh") {

            $horario=array("00:00:00", "01:00:00", "02:00:00", "03:00:00", "04:00:00", "05:00:00", "06:00:00", "07:00:00", "08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00", "18:00:00", "19:00:00", "20:00:00", "21:00:00", "22:00:00", "23:00:00", );

            $cantidad=count($horario);

            $contador=0;

            $cn= new Conexion();

            $sql="SELECT * FROM horarios WHERE id_horario='$id_horario'";

            $result=$cn->query($sql);

            $lista=mysqli_fetch_assoc($result);            

            while ( $contador< $cantidad) {

                if ($lista['hora_fin']==$horario[$contador]) {

                echo "<option value='".$horario[$contador]."' selected>".$horario[$contador]."</option>";              

                }else{

                    echo "<option value='".$horario[$contador]."'>".$horario[$contador]."</option>";
                }

            $contador++;

            }
             
        }

    }

}

?>


