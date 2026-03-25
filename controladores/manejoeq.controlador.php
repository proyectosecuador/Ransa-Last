<?php

class ControladorManejoeq{

	/*============================================
	=            INSERTAR USO DE EQUIPOS            =
	============================================*/
	static public function ctrInsertarManejoeq($datos){
		$tabla = "manejoeq";

		$rpta = ModeloManejoeq::mdlInsertarManejoeq($tabla,$datos);

		return $rpta;
	}
	
	
	/*=============================================
	=            CONSULTAR USO DE EQUIPOS            =
	=============================================*/
	
	static public function ctrConsultarManejoeq($item,$datos){
		
		$tabla = "manejoeq";

		$rpta = ModeloManejoeq::mdlConsultarManejoeq($tabla,$item,$datos);
		
		return $rpta;

	}

	/*==========================================================================
	=            ACTUALIZAR EL USO DEL EQUIPO AL TERMINAR DE USARLO            =
	==========================================================================*/
	static public function ctrActualizarManejoeq($item,$datos){
		
		$tabla = "manejoeq";

		$rpta = ModeloManejoeq::mdlActualizarManejoeq($tabla,$item,$datos);
		
		return $rpta;		
	}
	/*==========================================================================
	=            NOTIFICAR LA NO ENTREGA DE EQUIPOS             =
	==========================================================================*/
	static public function ctrNotificarNoEntrega($item,$datos){
		
		$tabla = "manejoeq";

		$rpta = ModeloManejoeq::mdlNotificarNoEntrega($tabla,$item,$datos);

		return $rpta;		
	}	
	
	
	
}

