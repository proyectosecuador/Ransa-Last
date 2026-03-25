<?php

class ControladorSolQR{

	/*=============================================
	=            CONSULTAR SOLICITUDES REPORTADAS            =
	=============================================*/
	
	static public function ctrConsultarSolQR($item,$datos){
	
		$tabla = "solicitudes_qr";

		$rpta = ModeloSolQR::mdlConsultarSolQR($tabla,$item,$datos);
		
		return $rpta;

	}

	/*=====================================
	=            ACTUALIZACION            =
	=====================================*/
	static public function ctrActualizarSolQR($item,$datos){
		
		$tabla = "solicitudes_qr";

		$rpta = ModeloSolQR::mdlActualizarSolQR($tabla,$item,$datos);
		
		return $rpta;

	}
	/*======================================================================================
	=            ACTUALIZAR LA RUTA DE ARCHIVO CAUSA RAIZ - COMENTARIO - ESTADO            =
	======================================================================================*/
	static public function ctrActualizarSolQRNivel($item,$datos){
		
		$tabla = "solicitudes_qr";

		$rpta = ModeloSolQR::mdlActualizarSolQRNivel($tabla,$item,$datos);
		
		return $rpta;

	}
	
	
	
	
	
	
	
	
}

