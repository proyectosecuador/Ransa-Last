<?php
/*=============================================
=            CONSULTAMOS EL CODIGO            =
=============================================*/
if (isset($rutas[1])) {
	$valor = $rutas[1];
	$item = "nombre_encriptado";
	$rpta =  ControladorArchivos::ctrMostrarInventExcel($valor,$item);
	if ($rpta) {
		/*===========================================================================
		=            ACTUALIZAMOS EL  ESTADO DEL INVENTARIO A CONFIRMADO            =
		===========================================================================*/
		$valorupdate = array("nombre_encriptado" => null,
							"estado_confirmacion" => 1,
							"nomarchivo" => $rpta["id"]);
		$itemupdate = "id";
		$updateestado = ControladorArchivos::ctrActualizarArchivo($valorupdate,$itemupdate);
		if ($updateestado) {
		?>
		<!DOCTYPE html>
			<html lang="en">
			  <body class="nav-md">
			    <div class="container body">
			      <div class="main_container">
			        <!-- page content -->
			        <div class="col-md-12">
			          <div class="col-middle">
			            <div class="text-center text-center">
			              <h1 class="error-number"><i class="fas fa-check-circle"> </i> Confirmado</h1>
			              <h2>Muchas Gracias</h2>
			              <p>Usted acaba de confirmar los valores reportados del Inventario con fecha </p><strong style="color: #44c444; font-size: 20px;"><?php echo $rpta["fechainvent"]; ?></strong><h1>
			              	<?php
								if (!isset($_SESSION["validarSession"])) {

									echo '<img width="200" src="'.$url.'vistas/img/plantilla/logo.png"></h1></a>';
								}else{
									echo '<img style="background: #e1e3e1; border-radius: 10px;" width="200" src="'.$url.'vistas/img/plantilla/logo.png"></h1></a>';
								}

			              	?>
			              	
			              
			            </div>
			            <?php 
			            if (!isset($_SESSION["validarSession"])) {
			            	echo '<div class="text-center">
			            			<a href="'.$url.'" class="btn btn-primary">Ingresar al Sistema</a>
		            				</div>';
			            }
			            ?>	        
			          </div>
			        </div>
			        <!-- /page content -->
			      </div>
			    </div>
			  </body>
			</html>
		<?php
		}
		
		
	}else{
		?>
		<!DOCTYPE html>
			<html lang="en">
			  <body class="nav-md">
			    <div class="container body">
			      <div class="main_container">
			        <!-- page content -->
			        <div class="col-md-12">
			          <div class="col-middle">
			            <div class="text-center text-center">
			              <h1 class="error-number"><i class="fas fa-exclamation-triangle"></i>  Advertencia</h1>
			              <h2>Codigo de Confirmación no encontrado..</h2>
			              <p>El inventario ya ha recibido la confirmación</p><h1>
			              	<?php
								if (!isset($_SESSION["validarSession"])) {

									echo '<img width="200" src="'.$url.'vistas/img/plantilla/logo.png"></h1></a>';
								}else{
									echo '<img style="background: #e1e3e1; border-radius: 10px;" width="200" src="'.$url.'vistas/img/plantilla/logo.png"></h1></a>';
								}

			              	?>
			              
			            </div>
			            <?php 
			            if (!isset($_SESSION["validarSession"])) {
			            	echo '<div class="text-center">
			            			<a href="'.$url.'" class="btn btn-primary">Ingresar al Sistema</a>
		            				</div>';
			            }
			            ?>	            
			          </div>
			        </div>
			        <!-- /page content -->
			      </div>
			    </div>
			  </body>
			</html>
	<?php
	}

}