<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="UTF-8">



	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">



	<meta name="title" content="Ransa - Operador Logistico">



	<meta name="description" content="Ransa - Operador Logistico">



	<meta name="keyword" content="Ransa - Operador Logistico">

	<?php  

	



	$url = Ruta::ctrRuta();



	echo '<link rel="icon" href="'.$url.'vistas/img/iconos/icono.png">';



	



	?>

	

	<title>Ransa - Operador Logistico</title>







	<!--====================================

	=            PLUGINS DE CSS            =

	=====================================-->

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- NProgress -->

    <link href="<?php echo $url; ?>vistas/vendors/nprogress/nprogress.css" rel="stylesheet">	

		<!-- Bootstrap -->

    <!-- iCheck -->

    <link href="<?php echo $url; ?>vistas/vendors/iCheck/skins/flat/green.css" rel="stylesheet">		

    <link href="<?php echo $url; ?>vistas/vendors/iCheck/skins/flat/blue.css" rel="stylesheet">

    <link href="<?php echo $url; ?>vistas/vendors/iCheck/skins/line/green.css" rel="stylesheet">	

    <link href="<?php echo $url; ?>vistas/vendors/iCheck/skins/line/blue.css" rel="stylesheet">	

  	

  	<link rel="stylesheet" href="<?php echo $url; ?>vistas/vendors/bootstrap-3.4.1/css/bootstrap.min.css">

  	<link href="<?php echo $url; ?>vistas/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- Font Awesome local -->

	<link rel="stylesheet" href="<?php echo $url; ?>vistas/vendors/fontawesome-free-6.7.2-web/css/all.min.css">

    <!-- Mensaje de alerta estilo -->

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/sweetalert2.min.css">

    <!-- Animaciones de texto -->

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/vendors/animate.css/animate.min.css">

    <!-- slider de texto -->

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/flexslider.css">

	<!-- ESTILOS SELECT -->

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/chosen.css">

    	    <!-- Datatables -->

    <link href="<?php echo $url; ?>vistas/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">    

    <link href="<?php echo $url; ?>vistas/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo $url; ?>vistas/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo $url; ?>vistas/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">



    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>extensiones/alertifyjs/css/alertify.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>extensiones/alertifyjs/css/themes/default.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>extensiones/lou-multi-select/css/multi-select.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>extensiones/fullcalendar/main.min.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/dropzone.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/smart_wizard_theme_dots.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/smart_wizard_theme_circles.css">

	

	<!-- imagen zoom  -->

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/easyzoom.css">

	<!-- tag input  -->

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/bootstrap-tagsinput.css">

	

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plugins/typeahead.css">

	    <!-- bootstrap-daterangepicker -->

    <link href="<?php echo $url; ?>vistas/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- bootstrap-datetimepicker -->

    <!-- <link href="<?php //echo $url; ?>vistas/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet"> -->

        <!-- Bootstrap Colorpicker -->

    <link href="<?php echo $url; ?>vistas/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">

		<!-- rotar imagenes -->

    <link href="<?php echo $url; ?>extensiones/cropperjs-master/dist/cropper.css" rel="stylesheet">

    <link href="<?php echo $url; ?>extensiones/jqueryfiletree-master/dist/jQueryFileTree.min.css" rel="stylesheet">
    <!--====  DATETIMEPICKER  ====-->
    

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>extensiones/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">


    	<!-- BUSQUEDA EN DATATABLE -->

    <link href="https://cdn.datatables.net/searchpanes/1.2.0/css/searchPanes.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet">

        <link href="<?php echo $url; ?>vistas/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">

    <!-- bootstrap-daterangepicker -->

    <script src="<?php echo $url; ?>vistas/vendors/moment/min/moment.min.js"></script>

    <script src="<?php echo $url; ?>vistas/vendors/moment/locale/es.js"></script>










	<!--========================================

	=            CSS PERSONALIZADOS            =

	=========================================-->

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/plantilla.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/spool.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/usuarios.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/productos.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/document.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/equiposmc.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/calidadbpa.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/solqr.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>vistas/css/estibas.css">

	



 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 	
    <!-- Custom Theme Style -->

    <link href="<?php echo $url; ?>vistas/build/css/custom.min.css" rel="stylesheet">
</head>



	<?php

	/*====================================================

	=            VALIDAMOS SI EXISTE UNA RUTA            =

	====================================================*/


	if (isset($_GET['ruta']) || isset($_SESSION["validarSession"])) {



		if (isset($_GET['ruta'])) {

			$rutas = explode("/", $_GET['ruta']);


		}else{

			$rutas = array("");

		}

		/*===============================================================

		=            VALIDAMOS QUE HAYA UNA SESSION INICIADA            =

		===============================================================*/

		if (isset($_SESSION["validarSession"])) {

			/*================================

			=            CABECERA            =

			================================*/

			include "modulos/cabecera.php";

			/*===============================

			=            LATERAL            =

			===============================*/

			if (isset($_SESSION["cliente"])) {

				include "modulos/lateralC.php";

			}else if (isset($_SESSION["nombre_Proveedor"])) {
				include "modulos/lateralP.php";
				
			}else{

				include "modulos/lateralR.php";

			}

			/*=================================

			=            CONTENIDO            =

			=================================*/				

				?>

				<div class="right_col" role="main">

					<div class="">

				

				<?php

				if ($rutas[0] == "inicio" ||

					$rutas[0] == "salir" ||

					$rutas[0] == "spool" ||

					$rutas[0] == "ingresoproducto" ||

					$rutas[0] == "usuarios" ||

					$rutas[0] == "estadoproducto" ||

					$rutas[0] == "vistaproductos" ||

					$rutas[0] == "perfil" ||

					$rutas[0] == "equipo" ||

					$rutas[0] == "alimentacion" || 

					$rutas[0] == "registroDoc" ||

					$rutas[0] == "descargaDoc" ||

					$rutas[0] == "linkDesc" ||

					$rutas[0] == "recepcionDoc" ||

					$rutas[0] == "perfil" ||

					$rutas[0] == "RegGuia" ||

					$rutas[0] == "checklist" ||

					$rutas[0] == "novedades" ||

					$rutas[0] == "consultaequipos" ||

					$rutas[0] == "confirmar" ||

					$rutas[0] == "prestamo-mc" ||

					$rutas[0] == "ConsultCheck" ||

					$rutas[0] == "listInventario" ||

					$rutas[0] == "vistaInventarios" ||

					$rutas[0] == "confirmarInvent" ||

					$rutas[0] == "usomc" ||

					$rutas[0] == "usoequipos" ||

					$rutas[0] == "checkbpa" ||

					$rutas[0] == "checkbpaconsulta" ||

					$rutas[0] == "asignacioneq" ||
					
					$rutas[0] == "Consulta-Recepciones" ||

					$rutas[0] == "Control-Transporte" ||

					$rutas[0] == "Orden-Trabajo-Equipo" ||

					$rutas[0] == "Programar" || 

					$rutas[0] == "Proveedor-Estibas" ||

					$rutas[0] == "Mov-Programados" ||

					$rutas[0] == "List-Programacion" ||

					$rutas[0] == "Check-Transporte" ||

					$rutas[0] == "Mov-XConfirmar" ||

					$rutas[0] == "OT-Realizadas" ||

					$rutas[0] == "Informe" ||
					
					$rutas[0] == "Q-R" ||

					$rutas[0] == "No-Programados" 


					
					) {

					if (isset($_SESSION['cliente']) && $rutas[0] == "vistaproductos" || $rutas[0] == "vistaInventarios" ) {


						include "modulos/clientes/".$rutas[0].".php";



					}else if (isset($_SESSION["nombre_Proveedor"]) && $_SESSION["perfil"] == "Proveedor" && $rutas[0] == "OT-Realizadas") {

						include "modulos/estibas/".$rutas[0].".php";
						
					}else{

						include "modulos/".$rutas[0].".php";	

					}

				?>

					</div>

	        	</div>

	        <?php

				}else{

					include "modulos/inicio.php";

					?>

				</div>

				</div>

					<?php	

				}

		/*==============================

		=            FOOTER            =

		==============================*/

		include "modulos/footer.php";



		// }else if ($rutas[0] == "Gestion-Transporte") {
			// include "modulos/garita/".$rutas[0].".php";
		}else if ($rutas[0] == "Consultar-QR") {
			include "modulos/clientes/".$rutas[0].".php";
		}else if($rutas[0] == "estibas"){
			include "modulos/estibas/".$rutas[0].".php";

		}else if ($rutas[0] == "confirmar" && isset($rutas[1]) || $rutas[0] == "confirmarInvent") {
			include "modulos/".$rutas[0].".php";

		}else{

		/*=====================================

		=             LOGIN            =

		=====================================*/

		include "modulos/login.php";			



		}

	}else{



		/*=====================================

		=             LOGIN            =

		=====================================*/

		include "modulos/login.php";		

	}	

	?>


<input type="hidden" value="<?php if(isset($_SESSION["ciudad"])){

echo $_SESSION["ciudad"];	

}else{

	echo null;

}  ?>" id="idciudad">
<input type="hidden" value="<?php echo $url; ?>" id="rutaOculta">

<input type="hidden" value="<?php if(isset($_SESSION["perfil"])){

echo $_SESSION["perfil"];	

}else{

	echo null;

}  ?>" id="perfiluser">

	<!--=====================================

	PLUGINS DE JAVASCRIPT

	======================================-->


	<!-- jQuery -->

    <script src="<?php echo $url; ?>vistas/vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap -->

        <script src="<?php echo $url; ?>vistas/vendors/bootstrap-3.4.1/js/bootstrap.min.js"></script>

    <!-- FastClick -->

    <script src="<?php echo $url; ?>vistas/vendors/fastclick/lib/fastclick.js"></script>

    <!-- NProgress -->

    <script src="<?php echo $url; ?>vistas/vendors/nprogress/nprogress.js"></script>

    <!-- jQuery custom content scroller -->

    <script src="<?php echo $url; ?>vistas/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>



    <!-- mensajes de alerta -->    

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <!-- iCheck -->

    <script src="<?php echo $url; ?>vistas/vendors/iCheck/icheck.min.js"></script>

        <!-- ESTILO A SELECT -->

    <script type="text/javascript" src="<?php echo $url; ?>vistas/js/plugins/chosen.jquery - copia.js"></script>

   	<!-- Data Table JS -->

   	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

   	<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>

   	    <!-- Datatables -->

    <script src="<?php echo $url; ?>vistas/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

        <!-- Datatables -->

        <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>



    <script src="<?php echo $url; ?>vistas/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>

    <script src="<?php echo $url; ?>vistas/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>

    <script src="<?php echo $url; ?>vistas/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>

    <script src="<?php echo $url; ?>vistas/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>



    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.colVis.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>



    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.flexslider-min.js"></script>



    <script type="text/javascript" src="<?php echo $url; ?>extensiones/alertifyjs/alertify.js"></script>

    <script type="text/javascript" src="<?php echo $url; ?>extensiones/lou-multi-select/js/jquery.multi-select.js"></script>

    <!-- DROPZONE -->

    <script type="text/javascript" src="<?php echo $url; ?>vistas/js/plugins/dropzone.js"></script>

    <!-- tag input  -->

    <script type="text/javascript" src="<?php echo $url; ?>vistas/js/plugins/typeahead.bundle.js"></script>

    <script type="text/javascript" src="<?php echo $url; ?>vistas/js/plugins/bloodhound.js"></script>

    <script type="text/javascript" src="<?php echo $url; ?>vistas/js/plugins/bootstrap-tagsinput.min.js"></script>

    <!-- bootstrap-datetimepicker -->    

    <!-- <script src="<?php //echo $url; ?>vistas/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script> -->

        <!-- Bootstrap Colorpicker -->

    <script src="<?php echo $url; ?>vistas/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

        <!-- Cropper -->

    <script src="<?php echo $url; ?>extensiones/cropperjs-master/dist/cropper.js"></script>



    <script type="text/javascript" src="<?php echo $url; ?>vistas/js/plugins/jquery.rotate.js"></script>

        <!-- jQuery Smart Wizard -->

    

    <!--<script src="<?php //echo $url; ?>vistas/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard_personalizado.js"></script>-->

    <script type="text/javascript" src="<?php echo $url; ?>vistas/js/plugins/jquery.smartWizard.js"></script>

    <!--====  PARA DESCARGAR ARCHIVOS POR JAVASCRIPT  ====-->

    

    <script type="text/javascript" src="<?php echo $url; ?>vistas/js/plugins/download.js"></script>

    <!--====  DATETIMEPICKER  ====-->
    

	<script src="<?php echo $url; ?>extensiones/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js" charset="UTF-8" ></script>
	
	<script src="<?php echo $url; ?>extensiones/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js"></script>

	<script src="<?php echo $url; ?>vistas/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>



    <!-- CHART PARA GRAFICOS

    <link rel="stylesheet" href="<?php //echo $url; ?>extensiones/anychart-package-8.7.1/css/anychart-ui.min.css"/>

    <script src="<?php //echo $url; ?>extensiones/anychart-package-8.7.1/js/anychart-bundle.min.js"></script>

    <script src="<?php //echo $url; ?>extensiones/anychart-package-8.7.1/js/anychart-base.min.js"></script>

	<script src="<?php //echo $url; ?>extensiones/anychart-package-8.7.1/js/anychart-exports.min.js"></script>

	<script src="<?php //echo $url; ?>extensiones/anychart-package-8.7.1/js/anychart-ui.min.js"></script>

	<script src="<?php //echo $url; ?>extensiones/anychart-package-8.7.1/js/anychart-core.min.js"></script>

	<script src="<?php //echo $url; ?>extensiones/anychart-package-8.7.1/js/anychart-cartesian.min.js"></script>-->

    <!--<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>-->



<!--    <script type="text/javascript" src="<?php //echo $url; ?>extensiones/PowerBI/node_modules/powerbi-client/dist/powerbi.js"></script>
	<script src="<?php //echo $url; ?>extensiones/powerbi-report-authoring/node_modules/window-post-message-proxy/powerbi-report-authoring/dist/powerbi-report-authoring.js"></script> -->


   <!-- CHART PARA GRAFICOS-->

 	<script type="text/javascript" src="https://cdn.datatables.net/searchpanes/1.2.0/js/dataTables.searchPanes.min.js"></script>   

 	<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

 	<script type="text/javascript" src="<?php echo $url; ?>extensiones/fullcalendar/main.min.js"></script>
 	<script type="text/javascript" src="<?php echo $url; ?>extensiones/jqueryfiletree-master/dist/jQueryFileTree.min.js"></script>

	<script type="text/javascript" src="<?php echo $url; ?>extensiones/jquery.easing-master/jquery.easing.min.js"></script>

	<script src="<?php echo $url; ?>vistas//vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>

	<script src="<?php echo $url; ?>vistas/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>

	<script src="<?php echo $url; ?>vistas/vendors/google-code-prettify/src/prettify.js"></script>
	







	<!--=====================================

	JAVASCRIPT PERSONALIZADOS

	======================================-->



	<script src="<?php echo $url; ?>vistas/js/scriptarchivo.js"></script>

	<script src="<?php echo $url; ?>vistas/js/usuarios.js"></script>

	<script src="<?php echo $url; ?>vistas/js/producto1.js"></script>

	<!-- <script src="<?php echo $url; ?>vistas/js/producto2.js"></script> -->

	<script src="<?php echo $url; ?>vistas/js/equipo.js"></script>

	<script src="<?php echo $url; ?>vistas/js/descargadoc.js"></script>

	<script src="<?php echo $url; ?>vistas/js/checkbpa.js"></script>
	
	<script src="<?php echo $url; ?>vistas/js/checktransporte.js"></script>

	<script src="<?php echo $url; ?>vistas/js/guia.js"></script>

	<script src="<?php echo $url; ?>vistas/js/estibas2.js"></script>
	<script src="<?php echo $url; ?>vistas/js/solqr.js"></script>
	<script src="<?php echo $url; ?>vistas/js/garita.js"></script>



	<!-- <script src="<?php //echo $url; ?>vistas/js/chartEquipos.js"></script> -->



	



</html>

    <!-- Custom Theme Scripts -->

    <script src="<?php echo $url; ?>vistas/build/js/custom.min.js"></script>



