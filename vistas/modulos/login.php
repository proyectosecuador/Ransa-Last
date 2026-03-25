<!--==============================
=            INICIO DE SESIÓN            =
===============================-->
<body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <img src="<?php echo $url?>vistas/img/plantilla/logotipo.png">
            <form method="POST">
              <h1>Iniciar Sesión</h1>
              <div>
                <input type="email" class="form-control" placeholder="Correo" name="email" required="" />
              </div>
              <div>
                <input type="password" autocomplete="off" class="form-control" placeholder="Contraseña" name="password" required="" />
              </div>
              <div style="padding-bottom: 20px;">
                <select class="form-control" required="" data-toggle="tooltip" data-placement="right" title="Si su usuario es corporativo RANSA omitir la selección" name="tipo_user">
                  <option value="Seleccionar tipo de Usuario">Seleccionar tipo de Usuario</option>
                  <option value="Proveedor">Proveedor</option>
                  <option value="Cliente">Cliente</option>
                </select>
              </div>
              <div>
                <button type="submit" class="btn btn-default btn-sm">Ingresar</button>
                <!--<a class="btn btn-default submit" href="">Ingresar</a>-->
                <a class="reset_pass" href="#">¿Olvidastes tu Contraseña?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <!--<p class="change_link">Nuevo Usuario?
                  <a href="#signup" class="to_register"> Crear una Cuenta </a>
                </p>-->

                <div class="clearfix"></div>
                <br />

                <div>
                  <!--<h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>-->
                  <p>Ransa © 2020 Todos los derechos reservados.</p>
                </div>
              </div>
              <?php
                $login = new ControladorUsuarios();
                $item = "email";
                $login -> ctrinicioUsuarios('verificar',$item,'');
              ?>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <img src="<?php echo $servidor?>vistas/img/plantilla/logotipo.png">
            <form>

              <h1>Crear Cuenta</h1>
              <div>
                <input type="text" class="form-control" placeholder="Usuario" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Contraseña" required="" />
              </div>
              <!--<div>
                <a  class="btn btn-default submit" href="">Crear</a>
              </div>-->

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Ya eres Usuario ?
                  <a href="#signin" class="to_register"> Iniciar Sesión </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <p>Ransa © 2020 Todos los derechos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
