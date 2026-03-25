<?php
session_start();
require_once "../controladores/solqr.controlador.php";
require_once "../modelos/solqr.modelo.php";

require_once "../controladores/areas.controlador.php";
require_once "../modelos/areas.modelo.php";

require_once "../controladores/detalle_clasificacion_qr.controlador.php";
require_once "../modelos/detalle_clasificacion_qr.modelo.php";

require_once "../controladores/detalle_investigacion_qr.controlador.php";
require_once "../modelos/detalle_investigacion_qr.modelo.php";

require_once "../controladores/detalle_seguimiento_qr.controlador.php";
require_once "../modelos/detalle_seguimiento_qr.modelo.php";

require_once "../controladores/detalle_negociacion_qr.controlador.php";
require_once "../modelos/detalle_negociacion_qr.modelo.php";

require_once "../controladores/servicioransa.controlador.php";
require_once "../modelos/servicioransa.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../modelos/rutas.php";

class AjaxTablaSolQR{
	/*=================================================
	=            CONSULTA DE SOLICITUDES            =
	=================================================*/
	public function ajaxConsultarSolQRxArea(){

		$urlQR = Ruta::ctrRutaSQR();
		$urlransa = Ruta::ctrRuta();
		$rpta = ControladorSolQR::ctrConsultarSolQR("","");

		if (isset($rpta) && !empty($rpta)) {
			
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			 ================================================*/
	        $datosJson = '{
	  						"data": [';

	  		for ($i=0; $i < count($rpta) ; $i++) {
	  			$btn = "";


	  			if ($rpta[$i]["estado"] == 1) {
	  					$btn = "<button type='button' class=' btn btn-sm btn-primary btnAsignarResponsable' data-toggle='modal' data-target='#modalNegocioResponsable' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' ><i class='fas fa-user-cog'></i></button>";
					//  var_dump($btn);
	  			}else if ($rpta[$i]["estado"] == 2) {
	  					$btn = "<button type='button' class=' btn btn-sm btn-default'>A Espera de Análisis</button>";	
	  			}else if ($rpta[$i]["estado"] == 3) {
	  				/*=================================================================
	  				=            CONSULTAMOS EL ESTADO DE LA INVESTIGACION            =
	  				=================================================================*/
	  				$rptaInves = ControladorDInvestigacionQR::ctrConsultarDInvestigacionQR("idsolicitudes_qr",$rpta[$i]["idsolicitudes_qr"]);
	  				$rptaInvestigacion = end($rptaInves);

	  				/*=====   SE CONSULTA EL USUARIO QUE ENVIO LA RESPUESTA  ======*/
	  				if ($rptaInvestigacion["idusuario"] != null) {
		  				$rptaUserRespuesta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaInvestigacion["idusuario"]);
						$nombres = explode(" ", $rptaUserRespuesta["primernombre"]);
			  			$apellidos = explode(" ", $rptaUserRespuesta["primerapellido"]);	  				

		  				$nombrevisual = $nombres[0]." ".$apellidos[0];
	  				}else{
	  					$nombrevisual = null;
	  				}
  					if ($rptaInvestigacion["tipo_analisis"] == "REVISAR") {
  						$btn = "<button type='button' class=' btn btn-sm btn-success'>Análisis x Revisar</button>";	
  					}else if ($rptaInvestigacion["tipo_analisis"] == "RE-CLASIFICAR") {
						$btn = "<button type='button' class=' btn btn-sm btn-primary btnAsignarResponsable' data-toggle='modal' data-target='#modalNegocioResponsable' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' ><i class='fas fa-user-cog'></i></button>";
  					}else{
  						$btn = "<button type='button' class=' btn btn-sm btn-primary btnAprobarCR' data-toggle='modal' data-target='#modalAprobarCR' rutaAnalisis='".$urlransa.$rptaInvestigacion['archivo']."' userRespuesta='".$nombrevisual."' estadoAnali='".$rptaInvestigacion["tipo_analisis"]."' coment-analisis='".$rptaInvestigacion["observaciones"]."' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' >Análisis Cargado</button>";	  						
  					}
	  			}else if ($rpta[$i]["estado"] == 4) {
	  				$btn = "<button type='button' class=' btn btn-sm btn-default'>P. Respuesta Cliente</button>";	  						
	  			}
	  			else if ($rpta[$i]["estado"] == 5) {
	  				if ($rpta[$i]["tipo_novedad"] == "Queja") {
	  					$rptaSeguimi = ControladorDSeguimientoQR::ctrConsultarDSeguimientoQR("idsolicitudes_qr",$rpta[$i]["idsolicitudes_qr"]);
	  					$areas = array();
	  					// var_dump($rpta[$i]["idsolicitudes_qr"]);
	  					if (count($rptaSeguimi) > 0) {//Si existe algun registro identificar el area
		  					for ($j=0; $j < count($rptaSeguimi) ; $j++) {
			  					$usuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaSeguimi[$j]["idusuario"]);
			  					$area = ControladorAreas::ctrConsultarAreas("idarea",$usuario["idareas"]);
			  					array_push($areas, $area["nombre"]);
		  					}

		  					if (array_search('NEGOCIO', $areas) != "" && array_search('CALIDAD', $areas) != ""){
		  						$btn = "<button type='button' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."'  class=' btn btn-sm btn-success btnCierreQR'>Confirmar Estado</button>";
		  					}else if(array_search('CALIDAD', $areas) === false && array_search('NEGOCIO', $areas) === false){
								$btn = "<button data-toggle='modal' data-target='#modalSeguimiento' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnSeguimientoCalidad'><i class='fas fa-check-double'></i> Seguimiento </button>";
		  					}else if (array_search('NEGOCIO', $areas) === false && array_search('CALIDAD', $areas) != ""  ) {
		  						$btn = "<button type='button' class=' btn btn-sm btn-default'>A Espera Comentarios Cliente</button>";
		  					}
	  					}else{
			  				$btn = "<button data-toggle='modal' data-target='#modalSeguimiento' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnSeguimientoCalidad'><i class='fas fa-check-double'></i> Seguimiento </button>";	  						

	  					} 					


	  				}else{
	  						$btn = "<button data-toggle='modal' data-target='#modalNegociacion' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnNegociacion'><i class='fas fa-handshake'></i> Negociación</button>";
						
	  				}
	  				
	  			}else if ($rpta[$i]["estado"] == 6 && $rpta[$i]["tipo_novedad"] == "Reclamo") {

	  					$areas = array();
	  					$rptaSeguimi = ControladorDSeguimientoQR::ctrConsultarDSeguimientoQR("idsolicitudes_qr",$rpta[$i]["idsolicitudes_qr"]);
	  					// var_dump($rptaSeguimi);
	  					if ($rptaSeguimi) {
		  					for ($j=0; $j < count($rptaSeguimi) ; $j++) {
			  					$usuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaSeguimi[$j]["idusuario"]);
			  					$area = ControladorAreas::ctrConsultarAreas("idarea",$usuario["idareas"]);
			  					array_push($areas, $area["nombre"]);
		  					}

		  					if (array_search('NEGOCIO', $areas) != "" && array_search('CALIDAD', $areas) != ""){
		  						$btn = "<button type='button' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."'  class=' btn btn-sm btn-success btnCierreQR'>Confirmar Estado</button>";
		  					}else if(array_search('CALIDAD', $areas) === false && array_search('NEGOCIO', $areas) === false){
								$btn = "<button data-toggle='modal' data-target='#modalSeguimiento' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnSeguimientoCalidad'><i class='fas fa-check-double'></i> Seguimiento </button>";
		  					}else if (array_search('NEGOCIO', $areas) === false && array_search('CALIDAD', $areas) != ""  ) {
		  						$btn = "<button type='button' class=' btn btn-sm btn-default'>A Espera Comentarios Cliente</button>";
		  					}
	  					}else{
	  						$btn = "<button data-toggle='modal' data-target='#modalSeguimiento' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnSeguimientoCalidad'><i class='fas fa-check-double'></i> Seguimiento </button>";

	  					}
	  				
	  				
	  			}
	  			
        // "<div class='btn-group'><button type='button' data-toggle='modal' data-target='#modalDocEdit' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' class='btn btn-sm btn-warning btnEditQR'><i class='fas fa-pencil-alt'></i></button>
			$acciones = $btn."<button type='button' idequipoE='".$rpta[$i]['idsolicitudes_qr']."' class=' btn btn-sm btn-danger btnEliminarEquipo'><i class='fa fa-times'></i></button></div>";
	  			if ($rpta[$i]['archivo'] != "") {
	  				$btnDocAdjunto = "<form method='POST' target='_blank' action='".$urlQR.$rpta[$i]["archivo"]."'><button class='btn-sm btn' type='submit'>Descargar</button></form>";
	  			}else{
	  				$btnDocAdjunto = "Sin Adjuntos";
	  			}

	  			/*==============================================================
	  			=            CONSULTAMOS LOS SERVICIOS INVOLUCRADOS            =
	  			==============================================================*/
	  			$text = "";
	  			$arrayServicios = json_decode($rpta[$i]['idservicioransa'],true);
	  			for ($j=0; $j < count($arrayServicios) ; $j++) { 
	  				$rptaServicios = ControladorServiciosRansa::ctrConsultarServiciosRansa("idservicioransa",$arrayServicios[$j]);
	  				$text .="<span style='margin: 2px 0 2px 0;' class='bg-primary badge'>".$rptaServicios["nombre"]."</span><br>" ;

	  			}	
	  			
	  			
	  			
	  			$viewServicios = "<div class=''>".$text."</div>";

			if ($rpta[$i]["estado"] != 0 && $rpta[$i]["estado"] != 7) {	
	  			$datosJson .= '
        				    [';
  				$datosJson .= '"'.$rpta[$i]['codigoSolicitud'].'",
  							  "'.date("d-m-Y",strtotime($rpta[$i]['fecha_registro'])).'",
  							  "'.$rpta[$i]['tipo_novedad'].'",';
  				$datosJson .= '"'.date("d-m-Y",strtotime($rpta[$i]['fecha_novedad'])).'",
						      "'.$rpta[$i]['nombre_regist'].'",
						      "'.$rpta[$i]['num_telefono'].'",
						      "'.$rpta[$i]['organizacion'].'",
						      "'.$rpta[$i]['detalle_novedad'].'",
						      "'.$viewServicios.'",
						      "'.$btnDocAdjunto.'",
						      
						      "'.$acciones.'",
						      "'.$rpta[$i]['estado'].'"';

								
		    	$datosJson .= '],';
		    	$valorexistente = true;				
			}
	  			
	  		}


        	$datosJson = substr($datosJson,0,-1);
        	if (!isset($valorexistente)) {
        		$datosJson .= '[';
        	}

        	$datosJson .= ']
        	}';
        	echo $datosJson;
		}else{
			echo $datosJson = '{
  					"data": []}';
		}
	}
	/*===============================================================================================
	=            CONSULTA POR USUARIO QUE HA SIDO ASIGNADO COMO USUARIO RESPONSABLE SGQR            =
	===============================================================================================*/
	public function ajaxConsultarSolQRxAsignacion(){
		$urlQR = Ruta::ctrRutaSQR();

		$tipoUser = "";
		$datos = '%"'.$_SESSION["id"].'"%';
		$rpta = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idusuarios_responsables",$datos);

		if (isset($rpta) && !empty($rpta)) {
			
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			 ================================================*/
	        $datosJson = '{
	  						"data": [';

	  		for ($i=0; $i < count($rpta) ; $i++) {
	  			/*===========================================================================================
	  			=            CONSULTAMOS LA SOLICITUDES ASIGNADAS AL USUARIO            =
	  			===========================================================================================*/
	  			$rptaSolicitud = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$rpta[$i]["idsolicitudes_qr"]);
	  			$btn = "";

	  			if ($rptaSolicitud["estado"] == 2) {
	  				$btn = "<button type='button' class=' btn btn-sm btn-primary btnInvestigacion' data-toggle='modal' data-target='#modalDocACausas' idsolicitudes_qr='".$rptaSolicitud['idsolicitudes_qr']."' ><i class='fas fa-tasks'></i></button>";

	  			}
	  			else if ($rptaSolicitud["estado"] == 3) {
	  				/*=================================================================
	  				=            CONSULTAMOS EL ESTADO DE LA INVESTIGACION            =
	  				=================================================================*/
	  				$rptaInves = ControladorDInvestigacionQR::ctrConsultarDInvestigacionQR("idsolicitudes_qr",$rptaSolicitud["idsolicitudes_qr"]);
	  				$rptaInvestigacion = end($rptaInves);

	  				/*=====   SE CONSULTA EL USUARIO QUE ENVIO LA RESPUESTA  ======*/
	  				if ($rptaInvestigacion["idusuario"] != null) {
		  				$rptaUserRespuesta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaInvestigacion["idusuario"]);
						$nombres = explode(" ", $rptaUserRespuesta["primernombre"]);
			  			$apellidos = explode(" ", $rptaUserRespuesta["primerapellido"]);	  				

		  				$nombrevisual = $nombres[0]." ".$apellidos[0];
	  				}else{
	  					$nombrevisual = null;
	  				}
	  				// var_dump($rptaInvestigacion["tipo_analisis"]);
					if ($rptaInvestigacion["tipo_analisis"] == "REVISAR") {
	  						$btn = "<button type='button' class=' btn btn-sm btn-primary btnInvestigacion' data-toggle='modal' data-target='#modalDocACausas' estadoAnalisis='".$rptaInvestigacion["tipo_analisis"]."' idsolicitudes_qr='".$rptaSolicitud['idsolicitudes_qr']."' ><i class='fas fa-tasks'></i></button>";
	  				}

	  			}else if ($rptaSolicitud["estado"] == 4) {
	  				$btn = "<button id='compose' type='button' class=' btn btn-sm btn-primary btnRespuestaCliente' idsolicitudes_qr='".$rptaSolicitud['idsolicitudes_qr']."' ><i class='fas fa-paper-plane'></i></button>";
	  			}	  			

			$acciones = "<div class='btn-group'>".$btn."</div>";
	  			if ($rptaSolicitud['archivo'] != "") {
	  				$btnDocAdjunto = "<form method='POST' target='_blank' action='".$urlQR.$rptaSolicitud["archivo"]."'><button class='btn-sm btn' type='submit'>Descargar</button></form>";
	  			}else{
	  				$btnDocAdjunto = "Sin Adjuntos";
	  			}

	  			/*==============================================================
	  			=            CONSULTAMOS LOS SERVICIOS INVOLUCRADOS            =
	  			==============================================================*/
	  			$text = "";
	  			$arrayServicios = json_decode($rptaSolicitud['idservicioransa'],true);
	  			for ($j=0; $j < count($arrayServicios) ; $j++) {
	  				$rptaServicios = ControladorServiciosRansa::ctrConsultarServiciosRansa("idservicioransa",$arrayServicios[$j]);
	  				$text .="<span style='margin: 2px 0 2px 0;' class='bg-primary badge'>".$rptaServicios["nombre"]."</span><br>" ;

	  			}	  			
	  			
	  			$viewServicios = "<div class=''>".$text."</div>";
	  			// $viewResponsables = "<div class=''>".$textNego."</div>";
	  		// $viewResponsables.'",
			if ($rptaSolicitud["estado"] != 0 && $rptaSolicitud["estado"] != 7) {	
	  			$datosJson .= '
        				    [';
  				$datosJson .= '"'.$rptaSolicitud['codigoSolicitud'].'",
  							  "'.date("d-m-Y",strtotime($rptaSolicitud['fecha_registro'])).'",
  							  "'.$rptaSolicitud['tipo_novedad'].'",';
  				$datosJson .= '"'.date("d-m-Y",strtotime($rptaSolicitud['fecha_novedad'])).'",
						      "'.$rptaSolicitud['nombre_regist'].'",
						      "'.$rptaSolicitud['num_telefono'].'",
						      "'.$rptaSolicitud['organizacion'].'",
						      "'.$rptaSolicitud['detalle_novedad'].'",
						      "'.$viewServicios.'",
						      "'.$btnDocAdjunto.'",
						      
						      "'.$acciones.'",
						      "'.$rptaSolicitud['estado'].'"';

								
		    	$datosJson .= '],';
		    	$valorexistente = true;				
			}
	  			
	  		}


        	$datosJson = substr($datosJson,0,-1);
        	if (!isset($valorexistente)) {
        		$datosJson .= '[';
        	}

        	$datosJson .= ']
        	}';
        	echo $datosJson;
		}else{
			echo $datosJson = '{
  					"data": []}';
		}		

	}
	/*==================================================================================================
	=            CONSULTA DE LAS SOLICITUDES QUE SON POR NEGOCIO RESPONSABLE DE SEGUIMIENTO            =
	==================================================================================================*/
	public function ajaxConsultarSolQRxNegocioSeguimiento(){
		$urlQR = Ruta::ctrRutaSQR();

		$tipoUser = "";
		$rpta = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idusuario_negocio",$_SESSION["id"]);

		if (isset($rpta) && !empty($rpta)) {
			
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			 ================================================*/
	        $datosJson = '{
	  						"data": [';

	  		for ($i=0; $i < count($rpta) ; $i++) {
	  			/*===========================================================================================
	  			=            CONSULTAMOS LA SOLICITUDES ASIGNADAS AL USUARIO            =
	  			===========================================================================================*/
	  			$rptaSolicitud = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$rpta[$i]["idsolicitudes_qr"]);
	  			$btn = "";
  				/*=================================================================
  				=            CONSULTAMOS EL ESTADO DE LA INVESTIGACION            =
  				=================================================================*/
  				$rptaInves = ControladorDInvestigacionQR::ctrConsultarDInvestigacionQR("idsolicitudes_qr",$rptaSolicitud["idsolicitudes_qr"]);
  				$rptaInvestigacion = end($rptaInves);

  				if ($rptaSolicitud["estado"] == 2) {
  					$btn = "<span class='badge'> En proceso de Investigación </span>";
  				}

	  			else if ($rptaSolicitud["estado"] == 5) {
	  				if ($rptaSolicitud["tipo_novedad"] == "Queja") {
	  					$rptaSeguimi = ControladorDSeguimientoQR::ctrConsultarDSeguimientoQR("idsolicitudes_qr",$rpta[$i]["idsolicitudes_qr"]);
	  					$areas = array();
	  					// var_dump($rpta[$i]["idsolicitudes_qr"]);
	  					if (count($rptaSeguimi) > 0) {//Si existe algun registro identificar el area
		  					for ($j=0; $j < count($rptaSeguimi) ; $j++) {
			  					$usuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaSeguimi[$j]["idusuario"]);
			  					$area = ControladorAreas::ctrConsultarAreas("idarea",$usuario["idareas"]);
			  					array_push($areas, $area["nombre"]);
		  					}

		  					if (array_search('NEGOCIO', $areas) != "" && array_search('CALIDAD', $areas) != ""){
		  						// $btn = "<button type='button' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."'  class=' btn btn-sm btn-success btnCierreQR'>Confirmar Estado</button>";
		  					}else if(array_search('CALIDAD', $areas) === false && array_search('NEGOCIO', $areas) === false){
								// $btn = "<button data-toggle='modal' data-target='#modalSeguimiento' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnSeguimientoCalidad'><i class='fas fa-check-double'></i> Seguimiento </button>";
		  					}else if (array_search('NEGOCIO', $areas) === false && array_search('CALIDAD', $areas) != ""  ) {
	  						$btn = "<button data-toggle='modal' data-target='#modalSeguimientoNegocio' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnSeguimientoNegocio'><i class='fas fa-check-double'></i> Seguimiento </button>";
		  					}
	  					}else{
			  				$btn = "<button type='button' class=' btn btn-sm btn-default'><i class='fas fa-check-double'></i> A espera de Seguimiento </button>";						

	  					}

	  				}else{
						$btn = "<button data-toggle='modal' data-target='#modalNegociacion' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnNegociacion'><i class='fas fa-handshake'></i> Negociación</button>";
	  				}


					// $btn = "<button data-toggle='modal' data-target='#modalSeguimientoNegocio' type='button' class=' btn btn-sm btn-primary'><i class='fas fa-check-double'></i> Seguimiento </button>";	  				
	  			}else if ($rptaSolicitud["estado"] == 6) {
  					$rptaSeguimi = ControladorDSeguimientoQR::ctrConsultarDSeguimientoQR("idsolicitudes_qr",$rpta[$i]["idsolicitudes_qr"]);
  					for ($j=0; $j < count($rptaSeguimi) ; $j++) {
	  					$usuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaSeguimi[$j]["idusuario"]);
	  					$area = ControladorAreas::ctrConsultarAreas("idarea",$usuario["idareas"]);
	  					if ($area["nombre"] != "NEGOCIO") {
	  						$btn = "<button data-toggle='modal' data-target='#modalSeguimientoNegocio' idsolicitudes_qr='".$rpta[$i]['idsolicitudes_qr']."' type='button' class=' btn btn-sm btn-primary btnSeguimientoNegocio'><i class='fas fa-check-double'></i> Seguimiento </button>";
	  					}
  					}
	  			}
	  			

			$acciones = "<div class='btn-group'>".$btn."</div>";
	  			if ($rptaSolicitud['archivo'] != "") {
	  				$btnDocAdjunto = "<form method='POST' target='_blank' action='".$urlQR.$rptaSolicitud["archivo"]."'><button class='btn-sm btn' type='submit'>Descargar</button></form>";
	  			}else{
	  				$btnDocAdjunto = "Sin Adjuntos";
	  			}

	  			/*==============================================================
	  			=            CONSULTAMOS LOS SERVICIOS INVOLUCRADOS            =
	  			==============================================================*/
	  			$text = "";
	  			$arrayServicios = json_decode($rptaSolicitud['idservicioransa'],true);
	  			for ($j=0; $j < count($arrayServicios) ; $j++) { 
	  				$rptaServicios = ControladorServiciosRansa::ctrConsultarServiciosRansa("idservicioransa",$arrayServicios[$j]);
	  				$text .="<span style='margin: 2px 0 2px 0;' class='bg-primary badge'>".$rptaServicios["nombre"]."</span><br>" ;

	  			}
	  			
	  			$viewServicios = "<div class=''>".$text."</div>";
			if ($rptaSolicitud["estado"] != 0 && $rptaSolicitud["estado"] != 7) {	
	  			$datosJson .= '
        				    [';
  				$datosJson .= '"'.$rptaSolicitud['codigoSolicitud'].'",
  							  "'.date("d-m-Y",strtotime($rptaSolicitud['fecha_registro'])).'",
  							  "'.$rptaSolicitud['tipo_novedad'].'",';
  				$datosJson .= '"'.date("d-m-Y",strtotime($rptaSolicitud['fecha_novedad'])).'",
						      "'.$rptaSolicitud['nombre_regist'].'",
						      "'.$rptaSolicitud['num_telefono'].'",
						      "'.$rptaSolicitud['organizacion'].'",
						      "'.$rptaSolicitud['detalle_novedad'].'",
						      "'.$viewServicios.'",
						      "'.$btnDocAdjunto.'",
						      
						      "'.$acciones.'",
						      "'.$rptaSolicitud['estado'].'"';

								
		    	$datosJson .= '],';
		    	$valorexistente = true;				
			}
	  			
	  		}


        	$datosJson = substr($datosJson,0,-1);
        	if (!isset($valorexistente)) {
        		$datosJson .= '[';
        	}

        	$datosJson .= ']
        	}';
        	echo $datosJson;
		}else{
			echo $datosJson = '{
  					"data": []}';
		}		

	}
	
	
	
}
$rptaArea = ControladorAreas::ctrConsultarAreas("idarea",$_SESSION["area"]);
$datos = '%"'.$_SESSION["id"].'"%';
$rpta = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idusuarios_responsables",$datos);
$rptaNegocio = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idusuario_negocio",$_SESSION["id"]);
/*===========================================
=            CONSULTAMOS POR AREA            =
===========================================*/


if ( isset($rptaArea["idarea"]) && $rptaArea["idarea"] == 6) {
	$consultSGQRxArea = new AjaxTablaSolQR();
	$consultSGQRxArea -> ajaxConsultarSolQRxArea();	
}
/*========================================================
=            CONSULTAMOS POR USUARIO ASIGNADO            =
========================================================*/
else if ($rpta["perfil"] = "COORDINADOR" || $rpta["perfil"] ="OPERATIVO") {
	$consultSGQRxAsignacion = new AjaxTablaSolQR();
	$consultSGQRxAsignacion -> ajaxConsultarSolQRxAsignacion();
}else if($rptaNegocio){
	$ConsultarSolQRxNegocioSeguimiento = new AjaxTablaSolQR();
	$ConsultarSolQRxNegocioSeguimiento -> ajaxConsultarSolQRxNegocioSeguimiento();	

}else{
	echo $datosJson = '{"data": []}';
}

 


