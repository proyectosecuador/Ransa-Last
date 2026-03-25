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
                    echo '<img src="vistas/img/usuarios/default/user_default.png" alt="..." class="img-circle profile_img">';
                  }

                ?>
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>

                <h2><?php 
                if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Proveedor") {
                  echo $_SESSION["nombre_Proveedor"]." ".$_SESSION["apellido"];
                }else{
                  echo $_SESSION["nombre"]." ".$_SESSION["apellido"];
                }
                
                ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fas fa-toolbox"></i> Gestión Estibas <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php echo $url.'OT-Realizadas' ?>">Trabajos Realizados</a></li>
                        <!-- <li><a href="'.$url.'novedades">Listado de Novedades</a></li> -->
                      </ul>
                    </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
          </div>
        </div>