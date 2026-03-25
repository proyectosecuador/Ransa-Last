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

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxTablaMov_Cua_Asig
{
	/*=================================================
	=            CONSULTA DE EQUIPOS RANSA            =
	=================================================*/
	public function ajaxConsultarCuadriAsig()
	{
		$rpta = ControladorMovRD::ctrConsultarMovRD($_SESSION["ciudad"], "idConfSupMaq");

		if (isset($rpta) && !empty($rpta)) {

			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			================================================*/
			$datosJson = '{
	  						"data": [';
			$idsVistos = [];
			for ($i = 0; $i < count($rpta); $i++) {
				if (in_array($rpta[$i]['idmov_recep_desp'], $idsVistos)) {
					continue;
				}
				$idsVistos[] = $rpta[$i]['idmov_recep_desp'];
				/*==============================================
	  			=            CONSULTAMOS EL CLIENTE            =
	  			==============================================*/
				// $rptacliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta[$i]["idcliente"]);

				/*=======================================================================
	  			=            CONSULTAMOS EL USUARIO QUE REALIZA LA SOLICITUD            =
	  			=======================================================================*/
				// $idciudad = 1;
				// if  ($rptacliente["razonsocial"] == "NEGOCIOS Y LOGISTICA NEGOLOGIC SA"){
				//     $rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosclientes","id",$rpta[$i]["idusuario"]);
				// }else{
				//     $rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rpta[$i]["idusuario"]);    
				//     $idciudad = $rptaUsuario["idciudad"];
				// }

				// if($idciudad == $_SESSION["ciudad"]){

				/*===========================================
	  			=            CONSULTAR ACTIVIDAD            =
	  			===========================================*/
				// if ($rpta[$i]["idactividad"] == "" || $rpta[$i]["idactividad"] == 0) {
				// 	$rptaactividad = ""	;
				// }else{
				// 	$rptaactividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba",$rpta[$i]["idactividad"]);
				// 	$rptaactividad = $rptaactividad["descripcion"];

				// }	  			

				/*=========================================================
	  			=            CONSULTAMOS LA CUADRILLA ASIGNADA            =
	  			=========================================================*/
				// if ($rpta[$i]["idproveedor_estiba"] == "" || $rpta[$i]["idproveedor_estiba"] == 0) {
				// 	$rptaestiba = ""	;
				// }else{
				// 	$rptaestiba = ControladorEstibas::ctrConsultarEstibas($rpta[$i]["idproveedor_estiba"],"idproveedor_estiba");		  			
				// 	$rptaestiba = $rptaestiba["nombre_proveedor"];
				// }

				$mensbutton = $rpta[$i]["estado"];

				switch ($rpta[$i]["estado"]) {
					case 'Visualizar':
						$colorboton = "btn-default btnConfirmDatosSupEst";
						$datatoggle = "data-toggle='modal' data-target='.modalConfirmSupervisorEst'";
						$icono = "<i class='fas fa-eye'></i>";

						$mensbutton = "<div class='btn-group'><button  " . $datatoggle . " type='button' idmov_recep_desp='" . $rpta[$i]['idmov_recep_desp'] . "' class='btn btn-sm " . $colorboton . "'>" . $icono . $rpta[$i]["estado"] . "</button></div>";
						break;
					case 'X Confirmar Sup. Estibas':
						if ($_SESSION['perfil'] != "GERENCIA") {
							$colorboton = "btn-info btnConfirmDatosSupEst";
							$datatoggle = "data-toggle='modal' data-target='.modalConfirmSupervisorEst'";
							$icono = "<i class='fas fa-play'></i>";
							$mensbutton = "<div class='btn-group'><button  " . $datatoggle . " type='button' idmov_recep_desp='" . $rpta[$i]['idmov_recep_desp'] . "' class='btn btn-sm " . $colorboton . "'>" . $icono.' '. $rpta[$i]["estado"] . "</button></div>";
						}
						break;
						// case 5:
						// 	$mensbutton = "X APROBAR SUP.";
						// 	break;
						// case 4:
						// 	$mensbutton = "PENDIENTE INGRESAR DATOS";
						// 	break;
						// case 3:
						// 	$mensbutton = "PROCESO INICIADO";
						// 	break;
						// case 2:
						// 	$mensbutton = "CUADRILLA ASIGNADA";
						// 	break;
				}



				$datosJson .= '
	        				    [';
				$datosJson .= '"' . $rpta[$i]['idmov_recep_desp'] . '",
								 "' . $rpta[$i]["fecha_programada"] . '",
								 "' . $rpta[$i]["usuario_cliente"] . '",
	  							 "' . $rpta[$i]["razonsocial"] . '",
	  							 "' . $rpta[$i]['codigo_generado'] . '",
	  							 "' . $rpta[$i]["actividad"] . '",
	  							 "' . $rpta[$i]["nombre_proveedor"] . '",
								   "' . $rpta[$i][trim("comentarios")] . '",
	  							  "' . $mensbutton . '"';
				$datosJson .= '],';
				$valorexistente = true;
				// }
			}

			$datosJson = substr($datosJson, 0, -1);
			if (!isset($valorexistente)) {
				$datosJson .= '[';
			}

			$datosJson .= ']
        	}';
			echo $datosJson;
		} else {
			echo $datosJson = '{
  					"data": []}';
		}
	}
}
$consultaCuadriAsig = new AjaxTablaMov_Cua_Asig();
$consultaCuadriAsig->ajaxConsultarCuadriAsig();
