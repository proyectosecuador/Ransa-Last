<?php
class ControladorDRespuestaClienteQR{
/*===========================================
=            INSERTAR NUEVA RESPUESTA CLIENTE            =
===========================================*/
static public function ctrInsertarDRespuestaClienteQR($datos){
	$tabla = "detalle_respcliente_qr ";

	$rpta = ModeloDRespuestaClienteQR::mdlInsertarDRespuestaClienteQR($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR LAS RESPUESTA CLIENTES            =
=======================================*/

	static public function ctrConsultarDRespuestaClienteQR($item,$datos){
		$tabla = "detalle_respcliente_qr ";

		$rpta = ModeloDRespuestaClienteQR::mdlConsultarDRespuestaClienteQR($tabla,$item,$datos);

		return $rpta;
	}

/*============================================================
=            ACTUALIZAR LA RESPUESTA CLIENTE            =
============================================================*/
	static public function ctrActualizarDRespuestaClienteQR($item,$datos){
		$tabla = "detalle_respcliente_qr ";

		$rpta = ModeloDRespuestaClienteQR::mdlActualizarDRespuestaClienteQR($tabla,$item,$datos);

		return $rpta;
	}



}