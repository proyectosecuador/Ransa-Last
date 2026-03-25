<!--====================================
=            HEADER-CLIENTE            =
=====================================-->
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <?php 
                  if (isset($_SESSION["foto"]) && !empty($_SESSION["foto"])) {
                    echo '<img src="'.$url.$_SESSION["foto"].'" alt="..." >';
                  }else{
                    echo '<img src="'.$url.'vistas/img/usuarios/default/user_default.png" alt="...">';
                  }
                ?>                    
                   <?php
                   if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Proveedor") {
                      echo '<span class="nomLargo">'.$_SESSION["apellido"].'</span>';
                   }else{
                    $nombre = explode(" ", $_SESSION["nombre"]);
                    $apellido = explode(" ", $_SESSION["apellido"]);
                    echo '<span class="nomLargo">'.$_SESSION["nombre"]." ".$_SESSION["apellido"].'</span>
                              <span class="nomCorto">'.$nombre[0]." ".$apellido[0].'</span>';
                   } ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!--<li><a href="perfil"> Perfil</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Configuraciones</span>
                      </a>
                    </li>-->
                    <?php 
                    if ($_SESSION["perfil"] != "Proveedor") {
                      echo '<li><a href="'.$url.'perfil">Editar Usuario<i class="fa fa-cog pull-right"></i></a></li>';  
                    }
                    ?>
                    
                    <li><a href="<?php echo $url?>salir"> Cerrar Sesión<i class="fas fa-sign-out-alt pull-right"></i></a></li>
                  </ul>
                </li>

                <!--<li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="<?php //echo $url; ?>vistas/img/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php //echo $url; ?>vistas/img/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php //echo $url; ?>vistas/img/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php //echo $url; ?>vistas/img/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>-->
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->