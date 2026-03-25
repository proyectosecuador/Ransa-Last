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

require_once "../controladores/ciudad.controlador.php";
require_once "../modelos/ciudad.modelo.php";

class AjaxTablaMov_Cua_Asig
{
	public function ajaxConsultarCuadriAsig()
	{
		// Obtener clientes asociados al usuario
		if (substr_count($_SESSION["email"], 'ransa')) {
			$tabla = "usuariosransa";
			$item = "email";
			$valor = $_SESSION["email"];
		} else {
			$tabla = "usuariosclientes";
			$item = "email";
			$valor = $_SESSION["email"];
		}
		$rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla, $item, $valor);
		if ($tabla == "usuariosransa") {
			$cuentas = json_decode($rptaUsuario["cuentas"], true);
		} else {
			$cuentas = array();
			$idcliente = $rptaUsuario["idcliente"];
			array_push($cuentas, array("idcliente" => $idcliente));
		}
		$idclientes = array_column($cuentas, "idcliente");
		$idciudad = $_SESSION["ciudad"];

		// Consulta optimizada
		$movimientos = ModeloMovRD::mdlMovCuadrillaAsignadaOptimizado($idclientes, $idciudad);

		$datosJson = '{ "data": [';
		foreach ($movimientos as $mov) {
			// Botón principal
			$text = "";
			$icono = "";
			$estadobtn = "";
			$colorboton = "";
			$datatoggle = "";

			if ($mov["estado"] == 1) {
				$text = " Iniciar";
				$icono = "<i class='fas fa-play'></i>";
				$colorboton = "btn-warning btnIniciarMovRD";
				$estadobtn = "";
			} else if ($mov["estado"] == 3) {
				$text = " Reanudar";
				$icono = "<i class='fas fa-redo'></i>";
				$colorboton = "btn-warning btnIniciarMovRD";
				$estadobtn = "";
			} else if ($mov["estado"] == 2) {
				$text = " Iniciar";
				$icono = "<i class='fas fa-play'></i>";
				$colorboton = "btn-warning btnIniciarMovRD";
				$estadobtn = "";
			} else if ($mov["estado"] == 4) {
				$text = " Confirmar";
				$icono = "<i class='fas fa-play'></i>";
				$colorboton = "btn-info btnConfirmDatos";
				$estadobtn = "disabled";
			} else if ($mov["estado"] == 5) {
				$text = " Confirmar";
				$icono = "<i class='fas fa-play'></i>";
				$colorboton = "btn-primary btnConfirmDatos";
				$estadobtn = "";
			}

			// Estado de estiba
			if ($mov["idproveedor_estiba"] == null && $mov["cuadrilla"] == "NO") {
				$rptaestiba = "NO SOLICITADA";
				$buttoncheck = "<button $datatoggle $estadobtn type='button' soliCuadrilla='{$mov["cuadrilla"]}' cliente='{$mov["razonsocial"]}' actividad='{$mov["actividad"]}' idmov_recep_desp='{$mov["idmov_recep_desp"]}' class='btn btn-sm $colorboton'>$icono$text</button>";
			} else if ($mov["idproveedor_estiba"] == null && $mov["cuadrilla"] == "SI") {
				$rptaestiba = "PENDIENTE";
				$buttoncheck = "<button type='button' class='btn btn-sm btn-info aespera'>A Espera</button>";
			} else {
				$rptaestiba = $mov["nombre_estiba"];
				$buttoncheck = "<button $datatoggle $estadobtn type='button' soliCuadrilla='{$mov["cuadrilla"]}' cliente='{$mov["razonsocial"]}' actividad='{$mov["actividad"]}' idmov_recep_desp='{$mov["idmov_recep_desp"]}' class='btn btn-sm $colorboton'>$icono$text</button>";
			}

			$acciones = "<div class='btn-group'>$buttoncheck<button type='button' idmov_recep_desp='{$mov["idmov_recep_desp"]}' class='btn btn-sm btn-danger btnEliminarMov'><i class='fa fa-times'></i></button></div>";

			$datosJson .= '["' . $mov["idmov_recep_desp"] . '","' . $mov["fecha_programada"] . '","' . $mov["razonsocial"] . '","' . $mov["comentarios"] . '","' . $mov["actividad"] . '","' . $rptaestiba . '","' . $mov["codigo_generado"] . '","' . $acciones . '"],';
		}
		$datosJson = rtrim($datosJson, ',');
		$datosJson .= '] }';
		echo $datosJson;
	}
}
$consultaCuadriAsig = new AjaxTablaMov_Cua_Asig();
$consultaCuadriAsig->ajaxConsultarCuadriAsig();
