<?php
class ControladorDClasificacionQR{
/*===========================================
=            INSERTAR NUEVA CLASIFICACION            =
===========================================*/
static public function ctrInsertarDClasificacionQR($datos){
	$tabla = "detalle_clasificacion_qr";

	$rpta = ModeloDClasificacionQR::mdlInsertarDClasificacionQR($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR LAS CLASIFICACIONES            =
=======================================*/

	static public function ctrConsultarDClasificacionQR($item,$datos){
		$tabla = "detalle_clasificacion_qr";

		$rpta = ModeloDClasificacionQR::mdlConsultarDClasificacionQR($tabla,$item,$datos);

		return $rpta;
	}

/*=========================================================
=            ACTUALIZACION DE LA CLASIFICAICON            =
=========================================================*/
	static public function ctrActualizarDClasificacionQR($item,$datos){
		$tabla = "detalle_clasificacion_qr";

		$rpta = ModeloDClasificacionQR::mdlActualizarDClasificacionQR($tabla,$item,$datos);

		return $rpta;
	}



}