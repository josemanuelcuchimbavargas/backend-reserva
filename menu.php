<div class="col-md-3">
  <div class="nav-side-menu">
    <div class="brand">
      <span class="glyphicon glyphicon-cog"></span> Panel de Control
    </div>

    <div class="menu-list">    
      <ul id="menu-content" class="menu-content collapse out">
        <li  data-toggle="collapse" data-target="#reservas" class="collapsed <?php if (isset($reservas)) echo $reservas ?>">
          <a href="#"> Reservas <span class="glyphicon glyphicon-chevron-down ubi"></span></a>
        </li>
          <ul class="sub-menu collapse" id="reservas">
            <li><a href="Formcalendario.php" target="_blanck">Reservar</a></li>
            <li <?php if (isset($lreservas)) echo "class='".$lreservas."'" ?>><a href="Admreservas.php">Listado Reservas</a></li>
            <li <?php if (isset($creservas)) echo "class='".$creservas."'" ?>><a href="Formcantreservas.php">Total Horas Por Cliente</a></li>
          </ul>

        <li  data-toggle="collapse" data-target="#inventario" class="collapsed <?php if (isset($inventario)) echo $inventario ?>">
          <a href="#"> Inventario <span class="glyphicon glyphicon-chevron-down ubi"></span></a>
        </li>
          <ul class="sub-menu collapse" id="inventario">
            <li <?php if (isset($productos)) echo "class='".$productos."'" ?>><a href="Formproductos.php">Productos</a></li>
            <li <?php if (isset($categorias)) echo "class='".$categorias."'" ?>><a href="Formcategorias.php">Categorias</a></li>
            <li <?php if (isset($unimedida)) echo "class='".$unimedida."'" ?>><a href="Formunimedida.php">Unidades de Medida</a></li>
            <li <?php if (isset($istock)) echo "class='".$istock."'" ?>><a href="#">Ingresos Stock</a></li>
          </ul>

        <li  data-toggle="collapse" data-target="#ventas" class="collapsed <?php if (isset($ventas)) echo $ventas ?>">
          <a href="#"> Ventas <span class="glyphicon glyphicon-chevron-down ubi"></span></a>
        </li>
          <ul class="sub-menu collapse" id="ventas">
            <li <?php if (isset($rventa)) echo "class='".$rventa."'" ?>><a href="#">Registrar Venta</a></li>
            <li <?php if (isset($cventas)) echo "class='".$cventas."'" ?>><a href="#">Consultar Ventas</a></li>
          </ul>

        <li  data-toggle="collapse" data-target="#gastos" class="collapsed <?php if (isset($gastos)) echo $gastos ?>">
          <a href="#"> Gastos <span class="glyphicon glyphicon-chevron-down ubi"></span></a>
        </li>
          <ul class="sub-menu collapse" id="gastos">
            <li <?php if (isset($rgasto)) echo "class='".$rgasto."'" ?>><a href="#">Registrar Gasto</a></li>
            <li <?php if (isset($cgastos)) echo "class='".$cgastos."'" ?>><a href="#">Consultar Gastos</a></li>
            <li <?php if (isset($tgasto)) echo "class='".$tgasto."'" ?>><a href="#">Tipo de Gasto</a></li>
          </ul>

        <?php if ($_SESSION['perfil']=="SuperAdministrador" OR $_SESSION['perfil']=="Administrador" ) {?>
           
        <li  data-toggle="collapse" data-target="#mantenimiento" class="collapsed <?php if (isset($mantenimiento)) echo $mantenimiento ?>">
          <a href="#"> Mantenimiento <span class="glyphicon glyphicon-chevron-down ubi"></span></a>
        </li>
          <ul class="sub-menu collapse" id="mantenimiento">
           <?php if ($_SESSION['perfil']=="SuperAdministrador"){?>

            <li <?php if (isset($empressa)) echo "class='".$empressa."'"?>><a href='Formempresa.php'>Empresa</a></li>

          <?php }?>

            <li <?php if (isset($usuarios)) echo "class='".$usuarios."'" ?>><a href="Formusuarios.php">Usuarios</a></li>
            <li <?php if (isset($canchas)) echo "class='".$canchas."'" ?>><a href="Formcanchas.php">Canchas</a></li>
            <li <?php if (isset($horarios)) echo "class='".$horarios."'" ?>><a href="Formhorarios.php">Horarios</a></li>
          </ul>

          <?php } ?>

      </ul>
    </div>
  </div>
</div>