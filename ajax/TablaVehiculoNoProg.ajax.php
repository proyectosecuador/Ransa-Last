<?php
session_start();
require_once "../controladores/movi_R_D.controlador.php";
require_once "../modelos/movi_R_D.modelo.php";

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

require_once "../controladores/estibas.controlador.php";
require_once "../modelos/estibas.modelo.php";

require_once "../controladores/actividadE.controlador.php";
require_once "../modelos/actividadE.modelo.php";

require_once "../controladores/estibas.controlador.php";
require_once "../modelos/estibas.modelo.php";

require_once "../controladores/tipo_carga.controlador.php";
require_once "../modelos/tipo_carga.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/garita.controlador.php";
require_once "../modelos/garita.modelo.php";

require_once "../controladores/checklisttrans.controlador.php";
require_once "../modelos/checklisttrans.modelo.php";

class AjaxTablaMov_Cua_Asig{
	/*=================================================
	=            CONSULTA DE EQUIPOS RANSA            =
	=================================================*/
	public function ajaxConsultarCuadriAsig(){
		/*==============================================
		=            CONSULTAMOS EL USUARIO            =
		==============================================*/
		if (substr_count($_SESSION["email"], 'ransa')) {
			$tabla = "usuariosransa";

			$item = "email";

			$valor = $_SESSION["email"];
		}else{
			if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Cliente") {
				$tabla = "usuariosclientes";

				$item = "email";

				$valor = $_SESSION["email"];
			}
		}
		$rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$item,$valor);

		if ($tabla == "usuariosransa") {
			$cuentas = json_decode($rptaUsuario["cuentas"],true);//obtenemos el array de las cuentas o clientes que tiene el usuario
		}else{
			$cuentas = array();
			$idcliente = $rptaUsuario["idcliente"];
			array_push($cuentas, array("idcliente" => $idcliente));
		}

			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			================================================*/
		$finalFor = 0;
	        $datosJson = '{
	  						"data": [';
		for ($j=0; $j < count($cuentas) ; $j++) {

			$rpta = ControladorMovRD::ctrConsultarMovRD($cuentas[$j]["idcliente"],"idcliente");
			$cantresultado = count($rpta);
			// echo $cantresultado."<br>";
			if (isset($rpta) && !empty($rpta)) {
				// echo $cantresultado."<br>";
		  		for ($i=0; $i < count($rpta) ; $i++) {
		  			if ($rpta[$i]["estado"] != 0 && $rpta[$i]["estado"] != 6 && $rpta[$i]["estado"] != 7 && $rpta[$i]["estado"] != 8 && $rpta[$i]["estado"] != 9 && $rpta[$i]["idciudad"] == $_SESSION['ciudad'] && $rpta[$i]["idlocalizacion"] == $_SESSION['idlocalizacion'] ) { // VALIDAMOS SI NO ES ESTADO 0 - 6
			  			/*===========================================
			  			=            CONSULTAR ACTIVIDAD            =
			  			===========================================*/
			  			if ($rpta[$i]["idactividad"] == "" || $rpta[$i]["idactividad"] == 0 || $rpta[$i]["idactividad"] == null ) {
			  				$rptaactividad = ""	;
			  			}else{
			  				$rptaactividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba",$rpta[$i]["idactividad"]);
			  				$rptaactividad = $rptaactividad["descripcion"];

			  			}
			  			/*==============================================
			  			=            CONSULTAMOS EL CLIENTE            =
			  			==============================================*/
			  			$rptacliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta[$i]["idcliente"]);
				  		/*====================================================
				  		=            CONSULTAMOS EL TIPO DE CARGA            =
				  		====================================================*/
			  			if ($rpta[$i]["idtipo_carga"] == "" || $rpta[$i]["idtipo_carga"] == 0 || $rpta[$i]["idtipo_carga"] == null) {
				  			$rptatcarga = ""	;
				  		}else{
				  			$rptatcarga = ControladorTCarga::ctrConsultarTCarga($rpta[$i]["idtipo_carga"],"idtipo_carga");		  			
				  			$rptatcarga = $rptatcarga["descripcion"];
				  		}
				  		/*=======================================================
				  		=            CONSULTAMOS DATOS DE CHECK LIST            =
				  		=======================================================*/
				  		$rptaCheckTrans = ControladorCheckTransporte::ctrConsultarCheckTransporte("idmov_recep_desp",$rpta[$i]["idmov_recep_desp"]);
				  		if ($rptaCheckTrans != null) {
				  			$resultplaca = $rptaCheckTrans["placa"];
				  			$resulttransportista = $rptaCheckTrans["transportista"];
				  		}else{
				  			$resultplaca = "";
				  			$resulttransportista = "";
				  		}



		  				$rptaGarita = ControladorGarita::ctrConsultarGarita("idmov_recep_desp",$rpta[$i]["idmov_recep_desp"]);	
		  				if ($rptaGarita) {
			  				if ($rpta[$i]["idactividad"] == null) {

						  		/*====================================================================
						  		=            CONSULTAMOS EL VEHICULO ANUNCIADO POR GARITA            =
						  		====================================================================*/
						  		$numpuerta =  isset($rptaGarita["puerta_asignada"]) ? "<span class ='badge' >".$rptaGarita["puerta_asignada"]."</span>" : "PENDIENTE";

						  		$fecha_llegada = $rptaGarita['fecha_llegada'];
				  		if ($_SESSION["perfil"] == "COORDINADOR" || $_SESSION['perfil'] == "ADMINISTRADOR") {
				  			$boton1 = "<button  type='button' idmov_recep_desp='".$rpta[$i]['idmov_recep_desp']."' class=' btn btn-sm btn-warning btnEditClient'><i class='fas fa-pen'></i></button>";
				  		}else{
				  			if ($numpuerta == "PENDIENTE" && $rptaactividad != "" && $rptatcarga != "") {
				  				$boton1 = "<button  type='button' class=' btn btn-sm btn-default'>Pendiente Puerta</button>";	
				  			}else{
				  				$boton1 = "<button  type='button' idmov_recep_desp='".$rpta[$i]['idmov_recep_desp']."' class=' btn btn-sm btn-info btnCompleteDatos'><i class='fas fa-plus-square'></i></button>";
				  			}

				  		}

					$acciones = "<div class='btn-group'>".$boton1."</div>";

				  			$datosJson .= '
			        				    [';
			  				$datosJson .= '"'.$rpta[$i]["idmov_recep_desp"].'",
			  							 "'.$fecha_llegada.'",
			  							 "'.$rptacliente["razonsocial"].'",
			  							 "'.$resultplaca.'",
			  							 "'.$resulttransportista.'",
			  							 "'.$numpuerta.'",
			  							 "'."".'",
			  							  "'.$acciones.'"';								
					    	$datosJson .= '],';
					    	$valorexistente = true;						  		
			  				}
		  				}else{
		  					$numpuerta ="POR ANUNCIARSE";
		  					$fecha_llegada = "";
					  		if ($_SESSION["perfil"] == "COORDINADOR" || $_SESSION['perfil'] == "ADMINISTRADOR") {
					  			$boton1 = "<button  type='button' idmov_recep_desp='".$rpta[$i]['idmov_recep_desp']."' class=' btn btn-sm btn-warning btnEditClient'><i class='fas fa-pen'></i></button>";
					  		}else{
					  			if ($numpuerta == "POR ANUNCIARSE" && $rptaactividad != "" && $rptatcarga != "") {
					  				$boton1 = "<button  type='button' class=' btn btn-sm btn-default'>POR ANUNCIARSE</button>";	
					  			}else{
					  				$boton1 = "<button  type='button' idmov_recep_desp='".$rpta[$i]['idmov_recep_desp']."' class=' btn btn-sm btn-info btnCompleteDatos'><i class='fas fa-plus-square'></i></button>";
					  			}
					  		}

						$acciones = "<div class='btn-group'>".$boton1."</div>";
						
							if ($rptaactividad != "X_Hora" && $rptaactividad != "REPALETIZADO") {

					  			$datosJson .= '
				        				    [';
				  				$datosJson .= '"'.$rpta[$i]["idmov_recep_desp"].'",
				  							 "'.$fecha_llegada.'",
				  							 "'.$rptacliente["razonsocial"].'",
				  							 "'.$resultplaca.'",
				  							 "'.$resulttransportista.'",
				  							 "'.$numpuerta.'",
				  							 "'."".'",
				  							  "'.$acciones.'"';								
						    	$datosJson .= '],';
						    	$valorexistente = true;
						    }  					
		  				}
					
				}
		  			
		  		}

		  		if (($finalFor+1) == count($cuentas) && !isset($valorexistente)) {
		        	$datosJson = substr($datosJson,0,-1);
		        		$datosJson .= '[';	

		        	$datosJson .= ']
		        	}';
		        	echo $datosJson;
		  		}

			  		if (isset($valorexistente) && $valorexistente == true && ($finalFor+1) == count($cuentas)){
			  			// echo $finalFor;
			  			$datosJson = substr($datosJson,0,-1);
			        	$datosJson .= ']
			        	}';
			  			echo $datosJson;		  			
			  			
			  		}


	        	
			}else{
				if (($finalFor+1) == count($cuentas) && !$valorexistente) {
					echo $datosJson = '{
	  					"data": []}';
				}
		  		if (isset($valorexistente) && $valorexistente == true && ($finalFor+1) == count($cuentas)) {
		  			
		  			$datosJson = substr($datosJson,0,-1);
		        	$datosJson .= ']
		        	}';
		  			echo $datosJson;
		  			
		  		}
				// echo "nada";

			}			

			// if ($rpta) {
			// 	for ($i=0; $i < count($rpta) ; $i++) {

					
			// 	}
				
			// }
			$finalFor++;
			
		}
		

		// $rpta = ControladorMovRD::ctrConsultarMovRD($_SESSION["id"],"idusuario");
		
	}
}
$consultaCuadriAsig = new AjaxTablaMov_Cua_Asig();
$consultaCuadriAsig -> ajaxConsultarCuadriAsig();




