<?php
class ControladorDNegociacionQR{
/*===========================================
=            INSERTAR NUEVA NEGOCIACION REALIZADA            =
===========================================*/
static public function ctrInsertarDNegociacionQR($datos){
	$tabla = "detalle_negociacion_qr";

	$rpta = ModeloDNegociacionQR::mdlInsertarDNegociacionQR($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR LAS NEGOCIACIONES            =
=======================================*/

	static public function ctrConsultarDNegociacionQR($item,$datos){
		$tabla = "detalle_negociacion_qr";

		$rpta = ModeloDNegociacionQR::mdlConsultarDNegociacionQR($tabla,$item,$datos);

		return $rpta;
	}

/*============================================================
=            ACTUALIZAR LA NEGOCIACION            =
============================================================*/
	static public function ctrActualizarDNegociacionQR($item,$datos){
		$tabla = "detalle_negociacion_qr";

		$rpta = ModeloDNegociacionQR::mdlActualizarDNegociacionQR($tabla,$item,$datos);

		return $rpta;
	}



}