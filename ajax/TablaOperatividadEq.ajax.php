<?php
session_start();
require_once "../controladores/manejoeq.controlador.php";
require_once "../modelos/manejoeq.modelo.php";

require_once "../controladores/personal.controlador.php";
require_once "../modelos/personal.modelo.php";

require_once "../controladores/equipos.controlador.php";
require_once "../modelos/equipos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class AjaxTablaEquiposUso
{
	/*=================================================
	=            CONSULTA DE EQUIPOS RANSA            =
	=================================================*/
	public function ajaxConsultarEquiposUso()
	{
		/*=========================================================================================================
		=            CONSULTAMOS EL USO DE LOS EQUIPOS DONDE EL ESTADO INDIQUE QUE SE ENCUENTRA EN USO            =
		=========================================================================================================*/

		$rpta = ControladorManejoeq::ctrConsultarManejoeq("idciudad", $_SESSION["ciudad"]);

		if (isset($rpta) && !empty($rpta)) {
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			================================================*/
			$datosJson = '{
	  						"data": [';

			for ($i = 0; $i < count($rpta); $i++) {

				$acciones = $rpta[$i]["fecha_fin"] == null ? "<div class='btn-group'><button type='button' data-toggle='modal' data-target='.modalTerminoUso' idmanejo='" . $rpta[$i]['idmanejoeq'] . "' class='btn btn-sm btn-primary btnNoEntrega'><i class='fas fa-bell'></i></button></div>" : "";
             		
				// $valor1 = $rpta[$i]["e.codigo_bateria"];
				// $valor2 = $rpta[$i]["codigo_bateria"];
				// var_dump($valor2);
				// if (!in_array($valor2, $valor1, true)) {
				// 	 $resultado = "Coinciden";
				// 	}else {
				// 	 $resultado = "No coinciden";
				// 	}

				//  3 ==> NO ENTREGADO
				//  2 ==> EN USO
				//  1 ==> TERMINADO SU USO

				$datosJson .= '
	        				    [';
				$datosJson .= '"' . $rpta[$i]['idmanejoeq'] . '",
	  							  "' . $rpta[$i]["codigo"] . '",';
				$datosJson .= '"' . $rpta[$i]['solicitante'] . '",';
				$datosJson .= '"' . $rpta[$i]["nombres_apellidos"] . '",
				               "' . $rpta[$i]["codigo_bateria"] .'",
							   "' . $rpta[$i]["Bateria"] .'",
								  "' . $rpta[$i]["fecha_inicio"] . '",
								  "' . $rpta[$i]["fecha_fin"] . '",
							      "' . $rpta[$i]["horometroinicial"] . '",';
				$datosJson .= '"' . $rpta[$i]["horometrotermino"] . '",
							      "' . $rpta[$i]["horoinicioproximo"] . '",
								  "' . $rpta[$i]["h_trabajada"] . ' Horas",';
				$datosJson .= '"' . $rpta[$i]["porcentcargainicio"] . ' %",';
				$datosJson .= '"' . $rpta[$i]["porcentcargatermino"] . ' %",
								 "' . $rpta[$i]["semana"] . '",
								 "' . strtoupper($rpta[$i]["mes"]) . '",
								  "' . $rpta[$i]["ubicacionfinal"] . '",
								  "' . $acciones . '"';
				$datosJson .= '],';

				$valorexistente = true;
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
/*===========================================
=            CONSULTA DE EQUIPOS            =
===========================================*/
if (isset($_SESSION['id'])) {
	$consultaEquipouso = new AjaxTablaEquiposUso();
	$consultaEquipouso->ajaxConsultarEquiposUso();
}
