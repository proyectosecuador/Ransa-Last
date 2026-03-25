	<?php
// session_start();
require_once "../controladores/movi_R_D.controlador.php";
require_once "../modelos/movi_R_D.modelo.php";

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

require_once "../controladores/estibas.controlador.php";
require_once "../modelos/estibas.modelo.php";

require_once "../controladores/actividadE.controlador.php";
require_once "../modelos/actividadE.modelo.php";

require_once "../controladores/tipo_carga.controlador.php";
require_once "../modelos/tipo_carga.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/checklisttrans.controlador.php";
require_once "../modelos/checklisttrans.modelo.php";

require_once "../controladores/garita.controlador.php";
require_once "../modelos/garita.modelo.php";

require_once "../controladores/personal.controlador.php";
require_once "../modelos/personal.modelo.php";

class AjaxTablaMovVehiculos{
	public  $_idciudad;
	public $_idlocalizacion;
	/*=================================================
	=            CONSULTA DE EQUIPOS RANSA            =
	=================================================*/
	public function ajaxConsultarVehiculos(){
		/*======================================================================
		=            CONSULTAMOS LOS VEHICULOS QUE SON DE LA CIUDAD            =
		======================================================================*/
		$datos = array("idciudad" => $this->_idciudad,
						"idlocalizacion" => $this->_idlocalizacion);
		$rpta = ControladorMovRD::ctrConsultarMovRD($datos,"idciudad");
		if (isset($rpta) && !empty($rpta)) {
		
		$datosJson = '{
		  						"data": [';
		 for ($i=0; $i < count($rpta) ; $i++) {

			    /*==============================================
			    =            OBTENEMOS LA ACTIVIDAD            =
			    ==============================================*/
			    $rptaactividad = $rpta[$i]["idactividad"] == null ? array("descripcion"=> "POR DEFINIR") :  ControladorActividadE::ctrConsultarActividadE("idactividad_estiba",$rpta[$i]["idactividad"]);
			    

			    if ($rptaactividad["descripcion"] != "X_Hora" && $rptaactividad["descripcion"] != "REPALETIZADO" ) {
		    	
			    /*==============================================
			    =            CONSULTAMOS EL CLIENTE            =
			    ==============================================*/
			    $rptacliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta[$i]["idcliente"]);	
			    /*========================================
			    =            CONSULTAMOS EN LA TABLA DE GARITA FECHA DE LLEGADA            =
			    ========================================*/
			    $rptagarita  = ControladorGarita::ctrConsultarGarita("idmov_recep_desp",$rpta[$i]["idmov_recep_desp"]);
			    $personalNombre = "";
			    $estado = "POR ANUNCIARSE";
			    $guia_entrada = "";
			    $puerta = "";
			   	$acciones = "";
			   	$btnAsigPuerta = "";
			   	$btnSalVehiculo = "";
			    if (!$rptagarita) {
			    	$fecha_llegada = "<button idmov='".$rpta[$i]["idmov_recep_desp"]."' class='btn btn-info btnAnunciadoGarita'>Anunciar</button>";
			    	
			    }else{
			    	$fecha_llegada = !empty($rptagarita["fecha_llegada"]) ? $rptagarita["fecha_llegada"] : "";
			    	$guia_entrada = !empty($rptagarita["guia_entrada"]) ? $rptagarita["guia_entrada"] : "";
				    /*=================================================================
				    =            OBTENEMOS EL DATO DE QUIEN FUE AUTORIZADO            =
				    =================================================================*/
				    $personal = ControladorPersonal::ctrConsultarPersonal("idpersonal",$rptagarita["idpers_autoriza"]);

				    $personalNombre = $personal ? $personal["nombres_apellidos"] : "";

				    // if ($personal) {
				    // 	$personalNombre = $personal["nombres_apellidos"];
				    // }else{
				    // 	$personalNombre = "";
				    // }

				    $estado = $rptagarita["estado"] == 2 ? "EN PUERTA" : ($rptagarita["estado"] == 3 ? "SALE" : "ANUNCIADO");
				    $puerta = !$rptagarita["puerta_asignada"] ? "PENDIENTE" : $rptagarita["puerta_asignada"];

				    if (!$rptagarita["puerta_asignada"]) {
				   		$btnAsigPuerta = "<button  type='button' idgarita= '".$rptagarita["idgarita"]."' class=' btn btn-sm btn-info AsignarPuerta'><i class='fas fa-warehouse'></i></button>";
				    }
				    $btnSalVehiculo = "<button  type='button' idgarita= '".$rptagarita["idgarita"]."' class=' btn btn-sm btn-danger SalidaVehiculo'><i class='fas fa-sign-out-alt'></i></button>";
			    }
			    $acciones = "<div class='btn-group'>".$btnAsigPuerta.$btnSalVehiculo."</div>";
			    /*===================================================================================
			    =            OBTENERMOS LOS DATOS DEL TRANSPORTISTA EN CASO DE OBTENERLO            =
			    ===================================================================================*/
			    $rptaconductor = ControladorCheckTransporte::ctrConsultarCheckTransporte("idmov_recep_desp",$rpta[$i]["idmov_recep_desp"]);
			    
			    
			    $conductor = isset($rptaconductor['transportista']) ? $rptaconductor['transportista'] : "";
			    $placa = isset($rptaconductor['placa']) ? $rptaconductor['placa'] : "";
			    // var_dump($rptagarita);
				    if ($estado != "SALE") {
	  		$datosJson .= '
			    [';					    	
						$datosJson .= '"'.$rpta[$i]["idmov_recep_desp"].'",
							  "'.$rpta[$i]["fecha_programada"].'",
							  "'.$fecha_llegada.'",
						      "'.$conductor.'",
						      "'.$placa.'",
						      "'.$rptacliente["razonsocial"].'",
						      "'.$personalNombre.'",
						      "'.$puerta.'",
						      "'.$guia_entrada.'",
						      "'.$estado.'",
						      "'.$acciones.'"';
						$datosJson .= '],';	
				    }
		    	
			    }
		 }
		         	$datosJson = substr($datosJson,0,-1);

        	$datosJson .= ']
        	}';

        	echo $datosJson;
		}else{
			 echo $datosJson = '{
  						"data": []}';
		}
		
		










		/*==============================================
		=            CONSULTAMOS EL USUARIO            =
		==============================================*/
		// if (substr_count($_SESSION["email"], 'ransa')) {
		// 	$tabla = "usuariosransa";

		// 	$item = "email";

		// 	$valor = $_SESSION["email"];
		// }else{
		// 	if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Cliente") {
		// 		$tabla = "usuariosclientes";

		// 		$item = "email";

		// 		$valor = $_SESSION["email"];
		// 	}
		// }
		// $rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$item,$valor);

		// if ($tabla == "usuariosransa") {
		// 	$cuentas = json_decode($rptaUsuario["cuentas"],true);	
		// }else{
		// 	$cuentas = array();
		// 	$idcliente = $rptaUsuario["idcliente"];
		// 	array_push($cuentas, array("idcliente" => $idcliente));
		// }

		// 	/*================================================
		// 	=            CONVERTIMOS A DATOS JSON            =
		// 	================================================*/
		// $finalFor = 0;
	 //        $datosJson = '{
	 //  						"data": [';
		// for ($j=0; $j < count($cuentas) ; $j++) {

		// 	$rpta = ControladorMovRD::ctrConsultarMovRD($cuentas[$j]["idcliente"],"idcliente");
		// 	$cantresultado = count($rpta);
		// 	// echo $cantresultado."<br>";
		// 	if (isset($rpta) && !empty($rpta)) {
		// 		// echo $cantresultado."<br>";
		//   		for ($i=0; $i < count($rpta) ; $i++) {
		//   			if ($rpta[$i]["estado"] != 0 && $rpta[$i]["estado"] != 6 && $rpta[$i]["estado"] != 7 && $rpta[$i]["estado"] != 8) { // VALIDAMOS SI NO ES ESTADO 0 - 6
		//   			/*==============================================
		//   			=            CONSULTAMOS EL CLIENTE            =
		//   			==============================================*/
		//   			$rptacliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta[$i]["idcliente"]);

		//   			/*===========================================
		//   			=            CONSULTAR ACTIVIDAD            =
		//   			===========================================*/
		//   			if ($rpta[$i]["idactividad"] == "" || $rpta[$i]["idactividad"] == 0) {
		//   				$rptaactividad = ""	;
		//   			}else{
		//   				$rptaactividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba",$rpta[$i]["idactividad"]);
		//   				$rptaactividad = $rptaactividad["descripcion"];

		//   			}	  			

		// 	  		/*====================================================
		// 	  		=            CONSULTAMOS EL TIPO DE CARGA            =
		// 	  		====================================================*/
		//   			if ($rpta[$i]["idtipo_carga"] == "" || $rpta[$i]["idtipo_carga"] == 0) {
		// 	  			$rptatcarga = ""	;
		// 	  		}else{
		// 	  			$rptatcarga = ControladorTCarga::ctrConsultarTCarga($rpta[$i]["idtipo_carga"],"idtipo_carga");		  			
		// 	  			$rptatcarga = $rptatcarga["descripcion"];
		// 	  		}


		//   			$text = "";
		//   			$icono = "";
		//   			$estadobtn = "";
		//   			$colorboton = "";
		//   			$datatoggle = "";

		//   			if ($rpta[$i]["estado"] == 1) {
		//   				$text = " Iniciar";
		//   				$icono = "<i class='fas fa-play'></i>";
		//   				$colorboton = "btn-warning btnIniciarMovRD";
		//   				$estadobtn = "";
		//   			}else if ($rpta[$i]["estado"] == 3){
		//   				$text = " Reanudar";
		//   				$icono = "<i class='fas fa-redo'></i>";
		//   				$colorboton = "btn-warning btnIniciarMovRD";
		//   				$estadobtn = "";
		//   			}else if ($rpta[$i]["estado"] == 2){
		// 				$text = " Iniciar";
		//   				$icono = "<i class='fas fa-play'></i>";
		//   				$colorboton = "btn-warning btnIniciarMovRD";			
		//   				$estadobtn = "";
		//   			}else if ($rpta[$i]["estado"] == 4) {
		// 				$text = " Confirmar";
		//   				$icono = "<i class='fas fa-play'></i>";
		//   				$colorboton = "btn-info btnConfirmDatos";
		//   				$estadobtn = "disabled";
		//   			}else if ($rpta[$i]["estado"] == 5) {
		// 				$text = " Confirmar";
		// 				$datatoggle = "data-toggle='modal' data-target='.modalConfirmSupervisor'";
		//   				$icono = "<i class='fas fa-play'></i>";
		//   				$colorboton = "btn-primary btnConfirmDatos";
		//   				$estadobtn = "";
		//   			}


		//   			/*=========================================================
		//   			=            CONSULTAMOS LA CUADRILLA ASIGNADA            =
		//   			=========================================================*/
		//   			$buttoncheck = "";
		//   			if ($rpta[$i]["idproveedor_estiba"] == null && $rpta[$i]["cuadrilla"] == "NO") {
		// 	  			$rptaestiba = "NO SOLICITADA";
		// 	  			$buttoncheck = "<button  ".$datatoggle.$estadobtn." type='button' soliCuadrilla='".$rpta[$i]["cuadrilla"]."' cliente='".$rptacliente["razonsocial"]."' actividad='".$rptaactividad."' idmov_recep_desp='".$rpta[$i]['idmov_recep_desp']."' class='btn btn-sm ".$colorboton."'>".$icono.$text."</button>";
		// 	  		}else{
		// 	  			if ($rpta[$i]["idproveedor_estiba"] == null && $rpta[$i]["cuadrilla"] == "SI") {
		// 	  				$rptaestiba = "PENDIENTE";
		// 	  				$buttoncheck = "<button type='button' class='btn btn-sm btn-info'>A Espera</button>";
		// 	  			}else{
		// 		  			$rptaestiba = ControladorEstibas::ctrConsultarEstibas($rpta[$i]["idproveedor_estiba"],"idproveedor_estiba");
		// 		  			$rptaestiba = $rptaestiba["nombre_proveedor"];
		// 	  			$buttoncheck = "<button  ".$datatoggle.$estadobtn." type='button' soliCuadrilla='".$rpta[$i]["cuadrilla"]."' cliente='".$rptacliente["razonsocial"]."' actividad='".$rptaactividad."' idmov_recep_desp='".$rpta[$i]['idmov_recep_desp']."' class='btn btn-sm ".$colorboton."'>".$icono.$text."</button>";			  			
		// 	  			}

		// 	  		}			

		// 		$acciones = "<div class='btn-group'>".$buttoncheck."<button type='button' idmov_recep_desp='".$rpta[$i]['idmov_recep_desp']."' class=' btn btn-sm btn-danger btnEliminarMov'><i class='fa fa-times'></i></button></div>";
		// 		// echo $rpta[$i]["idmov_recep_desp"]."<br>";

				
		// 			// if ($rpta[$i]['idproveedor_estiba'] != null) {

		// 	  			$datosJson .= '
		//         				    [';
		//   				$datosJson .= '"'.$rpta[$i]['fecha_programada'].'",
		//   							 "'.$rptacliente["razonsocial"].'",
		//   							 "'.$rpta[$i]['comentarios'].'",
		//   							 "'.$rptaactividad.'",
		//   							 "'.$rptaestiba.'",
		//   							 "'.$rpta[$i]['codigo_generado'].'",
		//   							  "'.$acciones.'"';								
		// 		    	$datosJson .= '],';
		// 		    	$valorexistente = true;
		// 			// }			
					
		// 		}
		  			
		//   		}

		//   		if (($finalFor+1) == count($cuentas) && !isset($valorexistente)) {
		//         	$datosJson = substr($datosJson,0,-1);
		//         		$datosJson .= '[';	

		//         	$datosJson .= ']
		//         	}';
		//         	echo $datosJson;
		//   		}

		// 	  		if (isset($valorexistente) && $valorexistente == true && ($finalFor+1) == count($cuentas)){
		// 	  			// echo $finalFor;
		// 	  			$datosJson = substr($datosJson,0,-1);
		// 	        	$datosJson .= ']
		// 	        	}';
		// 	  			echo $datosJson;		  			
			  			
		// 	  		}


	        	
		// 	}else{
		// 		if (($finalFor+1) == count($cuentas) && !$valorexistente) {
		// 			echo $datosJson = '{
	 //  					"data": []}';
		// 		}
		//   		if (isset($valorexistente) && $valorexistente == true && ($finalFor+1) == count($cuentas)) {
		  			
		//   			$datosJson = substr($datosJson,0,-1);
		//         	$datosJson .= ']
		//         	}';
		//   			echo $datosJson;
		  			
		//   		}
		// 		// echo "nada";

		// 	}			

		// 	// if ($rpta) {
		// 	// 	for ($i=0; $i < count($rpta) ; $i++) {

					
		// 	// 	}
				
		// 	// }
		// 	$finalFor++;
			
		// }
		

		// $rpta = ControladorMovRD::ctrConsultarMovRD($_SESSION["id"],"idusuario");
		
	}
}

if (isset($_POST["ciudad"])) {
	$consultarVehiculos = new AjaxTablaMovVehiculos();
	$consultarVehiculos -> _idciudad = $_POST["ciudad"];
	$consultarVehiculos -> _idlocalizacion = $_POST["localizacion"];
	$consultarVehiculos -> ajaxConsultarVehiculos();
	
}