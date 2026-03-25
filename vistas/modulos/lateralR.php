<!--======================================
=            MENU DE OPCIONES            =
=======================================-->
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
				<a href="inicio" class="site_title"><img style="width: 150px;" src="<?php echo $url?>vistas/img/plantilla/logo.png"></a>
            	<!--<a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>-->
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <?php 
                  if (isset($_SESSION["foto"]) && !empty($_SESSION["foto"])) {
                    echo '<img src="'.$url.$_SESSION["foto"].'" alt="..." class="img-circle profile_img">';
                  }else{
                    echo '<img src="'.$url.'vistas/img/usuarios/default/user_default.png" alt="..." class="img-circle profile_img">';
                  }

                ?>
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"] ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                      <?php
                      $opciones= "";//variable para guardar las opciones de la barra de navegación
                      $consulta = ""; //variable que se añade al final de navegación
                      $navconsult = ""; //variable para el item de consulta general
                      $modulos = json_decode($_SESSION["modulos"],true);
                      $rptamodulos = ControladorModulosPortal::ctrConsultarModulosPortal("","");
                      $cant = 0;
                      /*============================================================================
                      =            RECORREMOS LOS MODULOS QUE TIENE ASIGNADO EL USUARIO  ADMINISTRADOR          =
                      ============================================================================*/
                      for ($i=0; $i < count($modulos) ; $i++) {
                        for ($j=0; $j < count($rptamodulos); $j++) {
                            /*==================================================
                            =            MODULO EQUIPOS MONTACARGAS            =
                            ==================================================*/
                            if ($modulos[$i]["idmodulos_portal"] == $rptamodulos[$j]["idmodulos_portal"] ){
                              switch ($rptamodulos[$j]["nombremodulo"]) {
                                case 'NOVEDADES DE EQUIPOS':
                                  $opciones .= '<li><a><i class="fas fa-toolbox"></i> Gestión Equipos <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">';
                                    if ($_SESSION["perfil"] == "ADMINISTRADOR") {
                                      $opciones .= '<li><a href="'.$url.'equipo">Ingreso de Equipo</a></li>';
                                    }
                                  $opciones .= '<li><a href="'.$url.'checklist">Novedades - Check List</a></li>';
                                  if ($_SESSION["ciudad"] == 1 && $_SESSION["perfil"] == "ROOT" || $_SESSION["perfil"] == "OPERATIVO" || $_SESSION["perfil"] == "ADMINISTRADOR") {
                                     $opciones .= '<li><a href="'.$url.'usomc">Uso de Equipos</a></li>';
                                  }
                                  $opciones .= '</ul></li>';
                                  /*========================================================
                                  =            ITEMS QUE SE NAVEGACION CONSULTA            =
                                  ========================================================*/
                                  $consulta .= '<li><a href="'.$url.'ConsultCheck">Check List</a></li>
                                                <li><a href="'.$url.'novedades">Listado de Novedades</a></li>
                                                <li><a href="'.$url.'Orden-Trabajo-Equipo">Ordenes de Trabajo (MC)</a></li>';                                                
                                  if ($_SESSION["ciudad"] == 1 && $_SESSION["perfil"] == "ROOT" || $_SESSION["perfil"] == "OPERATIVO" || $_SESSION["perfil"] == "ADMINISTRADOR") {

                                    $consulta .= '<li><a href="'.$url.'usoequipos">Uso de Equipos</a></li>';
                                    
                                  }
                                  if ($_SESSION["ciudad"] == 1 && $_SESSION["perfil"] == "ADMINISTRADOR") {
                                    $consulta .= '<li><a href="'.$url.'asignacioneq">Asignación LLaves</a></li>';
                                  }
                                  if ($_SESSION["perfil"] == "OPERATIVO") {
                                    $consulta .= '<li><a href="'.$url.'equipo">Equipos Montacargas</a></li>';
                                  }
                                  break;
                                  /*==================================================
                                   =   MODULO EQUIPOS MONTACARGAS operativo           =
                                   ==================================================*/
                                 case 'OPERACION-EQUIPOS':
                                  $opciones .= '<li><a><i class="fas fa-toolbox"></i> Gestión Equipos <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">';
                                  $opciones .= '<li><a href="'.$url.'checklist">Novedades - Check List</a></li>';
                                  if ($_SESSION["ciudad"] == 1 && $_SESSION["perfil"] == "ROOT" || $_SESSION["perfil"] == "OPERATIVO" || $_SESSION["perfil"] == "ADMINISTRADOR") {
                                     $opciones .= '<li><a href="'.$url.'usomc">Uso de Equipos</a></li>';
                                  }
                                  $opciones .= '</ul></li>';
                                   break;
                                /*========================================
                                =            SECCION CATALOGO            =
                                ========================================*/
                                case 'CATALOGO':
                                  $opciones .= '<li><a><i class="fa fa-edit"></i>Mantenimiento Catálogo <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                  <li><a href="'.$url.'ingresoproducto">Registro de Productos</a></li></ul></li>';
                                  /*========================================================
                                  =            ITEMS QUE SE NAVEGACION CONSULTA            =
                                  ========================================================*/
                                  $consulta .= '<li><a href="'.$url.'estadoproducto">Estado de Productos</a></li>';                                  

                              /*=============================================
                              =            SECCION DE INVENTARIO            =
                              =============================================*/                                  
                                break;
                                case 'INVENTARIO':
                                  $opciones .= '<li><a><i class="fa"><span class="glyphicon glyphicon-list-alt"></span></i> Inventario <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                  <li><a href="'.$url.'spool">Cargar Inventario</a></li>
                                  <li><a href="'.$url.'listInventario">Listado de Inventarios</a></li>
                                  </ul></li>';
                                break;
                              /*==========================================
                              =            SECCION DE CALIDAD            =
                              ==========================================*/                                
                                case 'CALIDAD':
                                  $opciones .= '<li><a><i class="fas fa-spell-check"></i> Check Calidad <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                  <li><a href="'.$url.'checkbpa">Buenas Prácticas de Almacenamiento (BPA)</a></li>
                                  </ul></li>';
                                  /*========================================================
                                  =            ITEMS QUE SE NAVEGACION CONSULTA            =
                                  ========================================================*/
                                  $consulta .= '<li><a href="'.$url.'checkbpaconsulta">Resultados</a></li>';
                                  $consulta .= '<li><a href="'.$url.'Consulta-Recepciones">Check List Transporte</a></li>';
                                break;
                                /*============================================
                                =            SECCION DE RECEPCION DE CONTENEDOR            =
                                ============================================*/
                                case 'RECEPCION_CONTENEDOR':
                                  $opciones .= '<li><a><i class="fas fa-truck"></i>Transporte<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">';
                                  if ($_SESSION["perfil"] == "OPERATIVO" || $_SESSION["perfil"] == "ROOT" || $_SESSION["perfil"] == "ADMINISTRADOR" || $_SESSION["perfil"] == "COORDINADOR") {
                                    // echo $_SESSION["perfil"];
                                    $opciones .= '<li><a href="'.$url.'Programar">Generar Programación</a></li>';
                                    $opciones .= '<li><a href="'.$url.'List-Programacion">Listado Programación</a></li>';
                                    /* CONOCER CUANTOS VEHICULOS TIENE PENDIENTE */
                                    // $rptaPendientes = ControladorGarita::ctrConsultarGarita("cantList",1);  

                                    // for ($k=0; $k < count($rptaPendientes) ; $k++) { 
                                    //   $clientes = json_decode($_SESSION['cuentas'],true);
                                    //   $idcliente = array_column($clientes,"idcliente");
                                    //   if (in_array($rptaPendientes[$k]["idcliente"], $idcliente)) {
                                        

                                    //     $cant = $cant + 1;
                                    //   }
                                    // }
                                    // $opciones .= '<li><a href="'.$url.'No-Programados">Vehiculos Pendientes';
                                    // if ($cant > 0) {
                                    //   $opciones .= '<span style="float:right;" class="badge" id="cantNOProg"> '.$cant.'</span>';
                                    // }
                                    $opciones .= '</a></li>';
                                  }

                                  $opciones .= '</ul></li>';
                                  /*========================================================
                                  =            ITEMS QUE SE NAVEGACION CONSULTA            =
                                  ========================================================*/
                                  $consulta .= '<li><a href="'.$url.'Consulta-Recepciones">Check List Transporte</a></li>';
                                break;
                                /*========================================================
                                =            SECCION DE CONTROL DE ESTIBA            =
                                ========================================================*/
                                case 'GESTION-ESTIBAS':
                                  $opciones .= '<li><a><i class="fas fa-people-carry"></i></i>Gestión Estibas<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                  <li><a href="'.$url.'Proveedor-Estibas">Registrar Proveedor</a></li>
                                  <li><a>Movimientos<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                      <li class="sub_menu"><a href="'.$url.'Mov-Programados">Asignar Estibas</a>
                                      </li>
                                      <li><a href="'.$url.'Mov-XConfirmar">Por Confirmar</a>
                                      </li>
                                    </ul>
                                  </li>                                  
                                  </ul></li>';
                                  /*========================================================
                                  =            ITEMS QUE SE NAVEGACION CONSULTA            =
                                  ========================================================*/
                                $consulta .= '<li><a href="'.$url.'Consulta-Recepciones">Recepciones</a></li>';
                                break;

                                /*=================================================================
                                  =   ASIGNACION DE ESTIBAS POR EL SUPERVISOR A PARTIR DE LAS 6   =
                                  =================================================================*/
                                  case 'ASIGNACION-ESTIBAS':

                                // if (now()->toTimeString()>="9:00") {
                                    $opciones .= '<li><a><i class="fas fa-people-carry"></i></i>Gestión Estibas<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a id="horalaboral" href="'.$url.'Mov-Programados">Asignar Estibas</a>
                                        </li>                                 
                                    </ul></li>'
                                    ;
                                    
                                // }else {
                                  
                                // }
                                break;
                  
                                /*====================================================
                                =            SECCION DE QUEJAS Y RECLAMOS            =
                                ====================================================*/
                                case 'GESTION_Q-R':
                                //   $opciones .= '<li><a><i class="fas fa-truck"></i>Quejas y Reclamos<span class="fa fa-chevron-down"></span></a>
                                //    <ul class="nav child_menu">';
                                //   $opciones .= '<li><a href="'.$url.'Q-R">Solicitudes Quejas - Reclamos</a></li>';
                                //  /* $opciones .= '<li><a href="'.$url.'List-Programacion">Listado Programación</a></li>';*/
                                //   $opciones .= '</ul></li>';

                                  // $navconsult .= '</ul></li>';
                                  break;
                              }
                            }
                        }
                      }
                      if ($consulta != "") {
                        $navconsult .= '<li><a><i class="fa fa-desktop"></i> Consultas <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">';
                        $navconsult .= $consulta;
                        $navconsult .= '</ul></li>';
                        
                      }
                      echo $opciones;
                      echo $navconsult;
                      ?>
          	</ul>
          </li>
        </ul>
      </div>

      <script>
        const horalaboral = document.getElementById('horalaboral');
        const time = new Date();
        const hora = time.getHours();
        if (hora >= 15 && hora < 3) {
          horalaboral.href="#";
        }
        </script>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>
